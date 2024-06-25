<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request)
{
    // Validación de los datos de entrada
    $validator = Validator::make($request->all(), [
        'video_id' => 'required|exists:videos,id',
        'user_id' => 'required|exists:users,id',
        'body' => 'required|string|max:5000',
    ]);

    // Si la validación falla, devolver un mensaje de error
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Error en la validación de los datos de entrada',
            'errors' => $validator->errors()
        ], 422);
    }

    // Crear el comentario
    try {
        $comment = Comment::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Comentario creado exitosamente',
            'comment' => $comment
        ], 201);
    } catch (\Exception $e) {
        // Si ocurre un error durante la creación, devolver un mensaje de error
        return response()->json([
            'success' => false,
            'message' => 'Error al crear el comentario',
            'error' => $e->getMessage()
        ], 500);
    }
}
    public function update(Request $request, Comment $comment)
    {
        $validatedData = $request->validate([
            'body' => 'required|string|max:5000',
        ]);

        $comment->update($validatedData);

        return response()->json($comment, 200);
    }

    public function destroy(Comment $comment)
    {
       
        $comment->delete();

        return response()->json(null, 204);
    }
}