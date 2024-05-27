<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavePersonaRequest;
use App\Models\Persona;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $personas = Persona::latest()->get();

        return response()->json($personas, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SavePersonaRequest $request): JsonResponse
    {
       try {
        $persona = Persona::create($request->validated());
        return response()->json($persona, Response::HTTP_CREATED);
    } catch (Throwable $e) {
        // Log the error or handle it as needed
        return response()->json(['error' => 'Error al crear la persona', 'details' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $persona = Persona::findOrFail($id);

        return response()->json($persona, Response::HTTP_OK);    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SavePersonaRequest $request, string $id): JsonResponse
    {
        $persona = Persona::findOrFail($id);
        $persona->update($request->validated());

        return response()->json($persona, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $persona = Persona::findOrFail($id);
        $persona->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    
    
        //
    }
}
