<?php

namespace App\Http\Controllers;

use App\Models\Hotels;
use App\Http\Requests\StoreHotelsRequest;
use App\Http\Requests\UpdateHotelsRequest;


class HotelsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $hotels = Hotels::all();
        
        return response()->json(data: $hotels);
    }

    /**
     * Show the form for creating a new resource.
     */
   

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHotelsRequest $request)
    {
        $validated = $request->validated();

        $hotel = Hotels::create([
            'nom' => $validated['nom'],
            'description' => $validated['description'],
            'etoiles' => $validated['etoiles'],
            'image' => $validated['image'],
            'prix' => $validated['prix'],
            'distance' => $validated['distance'],
            'stadeId' => $validated['stadeId'], // Convert to database column name
            'adresse' => $validated['adresse'] ?? null, // Optional field
            'telephone' => $validated['telephone'] ?? null // Optional field
        ]);

        return response()->json([
            'success' => true,
            'data' => $hotel,
            'message' => 'Hotel created successfully'
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //

        $hotel = Hotels::find($id);

        if (!$hotel) {
            return response()->json(['message' => 'Stade not found'], 404);
        }
    
        return response()->json($hotel);
    }

    /**
     * Show the form for editing the specified resource.
     */
  

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHotelsRequest $request, string $id)
    {

        $hotel = Hotels::findOrFail($id);
        
        $validated = $request->validated();

        // Update the instance
        $hotel->update([
            'nom' => $validated['nom'],
            'description' => $validated['description'],
            'etoiles' => $validated['etoiles'],
            'image' => $validated['image'],
            'prix' => $validated['prix'],
            'distance' => $validated['distance'],
            'stadeId' => $validated['stadeId'], 
           
        ]);

      

        return response()->json([
            'success' => true,
            'data' => $hotel->fresh(), // Get refreshed data
            'message' => 'Hotel updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $hotel = Hotels::findOrFail($id);
        $hotel->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'hotel deleted successfully'
        ]);
        
    }
}
