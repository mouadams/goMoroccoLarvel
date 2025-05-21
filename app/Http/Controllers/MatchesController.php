<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Http\Requests\StoreMatchesRequest;
use App\Http\Requests\UpdateMatchesRequest;

class MatchesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $matches = Matches::all();
        
        return response()->json(data: $matches);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // This method is not typically used in API controllers
        // as form rendering is handled by the frontend
        return response()->json(['message' => 'Form creation handled by frontend']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMatchesRequest $request)
    {
        try {
            $validatedData = $request->validated();
            
            // Convert termine to integer (0 or 1)
            if (isset($validatedData['termine'])) {
                $validatedData['termine'] = $validatedData['termine'] ? 1 : 0;
            }
            
            $match = Matches::create($validatedData);
            
            return response()->json([
                'message' => 'Match created successfully',
                'data' => $match
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create match',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $match = Matches::find($id);

        if (!$match) {
            return response()->json(['message' => 'Match not found'], 404);
        }
    
        return response()->json($match);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matches $matches)
    {
        // This method is not typically used in API controllers
        // as form rendering is handled by the frontend
        return response()->json(['message' => 'Form editing handled by frontend']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMatchesRequest $request, $id)
    {
        try {
            // Find the match by ID
            $match = Matches::findOrFail($id);
            
            $validatedData = $request->validated();
            
            // Convert termine to integer (0 or 1)
            if (isset($validatedData['termine'])) {
                $validatedData['termine'] = $validatedData['termine'] ? 1 : 0;
            }
            
            // Update the match
            $match->update($validatedData);
            
            // Refresh the model to get the updated data
            $match = $match->fresh();
            
            return response()->json([
                'message' => 'Match updated successfully',
                'data' => $match
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Match not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update match',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matches $id)
    {
        $id->delete();
        
        return response()->json([
            'message' => 'Match deleted successfully'
        ]);
    }
}