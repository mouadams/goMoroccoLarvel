<?php

namespace App\Http\Controllers;

use App\Models\Equipes;
use App\Http\Requests\StoreEquipesRequest;
use App\Http\Requests\UpdateEquipesRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;


class EquipesController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $equipes = Equipes::all();
        
        return response()->json(data: $equipes);
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(): JsonResponse
    {
        // For API, this method is typically not used
        return response()->json(['message' => 'Method not applicable for API']);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param \App\Http\Requests\StoreEquipesRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreEquipesRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            
            // Clean and format data
            $equipeData = [
                'nom' => trim($validated['nom']),
                'drapeau' => filter_var($validated['drapeau'], FILTER_VALIDATE_URL),
                'groupe' => strtoupper(trim($validated['groupe'])),
                'abreviation' => strtoupper(trim($validated['abreviation'])),
                'confederation' => trim($validated['confederation']),
                'entraineur' => isset($validated['entraineur']) ? trim($validated['entraineur']) : null,
                'rang' => (int)$validated['rang'],
            ];
    
            $equipe = Equipes::create($equipeData);
            
            return response()->json([
                'success' => true,
                'data' => $equipe,
                'message' => 'Équipe créée avec succès'
            ], 201);
            
        } catch (\Exception $e) {
            Log::error('Failed to create equipe: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de l\'équipe',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Display the specified resource.
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $equipe = Equipes::find($id);

        if (!$equipe) {
            return response()->json(['message' => 'Équipe non trouvée'], 404);
        }
    
        return response()->json($equipe);
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param \App\Models\Equipes $equipes
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Equipes $equipes): JsonResponse
    {
        // For API, this method is typically not used
        return response()->json(['message' => 'Method not applicable for API']);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param \App\Http\Requests\UpdateEquipesRequest $request
     * @param \App\Models\Equipes $equipes
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateEquipesRequest $request, $id): JsonResponse
    {
        try {
            $equipe = Equipes::findOrFail($id);
            $validated = $request->validated();
           
            // Only update fields that were provided
            $updateData = [];
            foreach ($validated as $key => $value) {
                switch ($key) {
                    case 'nom':
                    case 'confederation':
                    case 'entraineur':
                        $updateData[$key] = trim($value);
                        break;
                    case 'drapeau':
                        $updateData[$key] = filter_var($value, FILTER_VALIDATE_URL);
                        break;
                    case 'groupe':
                        $updateData[$key] = strtoupper(trim($value));
                        break;
                    case 'abreviation':
                        $updateData[$key] = strtoupper(trim($value));
                        break;
                    case 'rang':
                        $updateData[$key] = (int)$value;
                        break;
                }
            }
    
            $equipe->update($updateData);
           
            return response()->json([
                'success' => true,
                'message' => 'Équipe mise à jour avec succès',
                'data' => $equipe->fresh()
            ], 200);
           
        } catch (\Exception $e) {
            Log::error('Failed to update equipe: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param \App\Models\Equipes $equipes
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Equipes $id): JsonResponse
    {
        $id->delete();
        
        return response()->json([
            'message' => 'Équipe supprimée avec succès'
        ]);
    }
}