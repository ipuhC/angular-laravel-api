<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para la foto de perfil
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $customErrors = [];

            if ($errors->has('name')) {
                $customErrors['name'] = $errors->first('name') === 'The name field is required.'
                    ? 'El campo de nombre es obligatorio.'
                    : $errors->first('name');
            }

            if ($errors->has('email')) {
                $customErrors['email'] = $errors->first('email') === 'The email has already been taken.'
                    ? 'El correo electrónico ya está en uso.'
                    : $errors->first('email');
            }

            if ($errors->has('password')) {
                $customErrors['password'] = $errors->first('password') === 'The password field is required.'
                    ? 'El campo de contraseña es obligatorio.'
                    : ($errors->first('password') === 'The password confirmation does not match.'
                        ? 'La confirmación de la contraseña no coincide.'
                        : $errors->first('password'));
            }

            if ($errors->has('profile_photo')) {
                $customErrors['profile_photo'] = 'La foto de perfil debe ser una imagen válida y no puede superar los 2MB.';
            }

            return response()->json(['errors' => $customErrors], 422);
        }

        try {
            $profilePhotoPath = null;
            if ($request->hasFile('profile_photo')) {
                $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'profile_photo' => $profilePhotoPath,
            ]);

            return response()->json(['message' => 'Usuario registrado exitosamente', 'user' => $user], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Hubo un problema al registrar el usuario. Inténtelo de nuevo más tarde.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'role' => $user->role, 'name' => $user->name, 'userId' => $user->id], 200);
    }

    

    public function getUserDetails($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json(['user' => $user], 200);
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            if ($request->hasFile('profile_photo')) {
                $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
                $user->profile_photo = $profilePhotoPath;
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            return response()->json(['message' => 'Perfil actualizado exitosamente', 'user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Hubo un problema al actualizar el perfil. Inténtelo de nuevo más tarde.',
                'error' => $e->getMessage(),
            ], 500);
        }

    }


}

