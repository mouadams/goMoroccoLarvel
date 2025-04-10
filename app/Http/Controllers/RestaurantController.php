<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurants = Restaurant::all();

        return response()->json(data: $restaurants);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRestaurantRequest $request)
    {
        $validated = $request->validated();
    
    $restaurant = Restaurant::create([
        'nom' => $validated['nom'],
        'cuisine' => $validated['cuisine'],
        'description' => $validated['description'],
        'adresse' => $validated['adresse'],
        'note' => $validated['note'],
        'distance' => $validated['distance'],
        'prixMoyen' => $validated['prixMoyen'], // database column name
        'horaires' => $validated['horaires'] ?? null,
        'telephone' => $validated['telephone'] ?? null,
        'image' => $validated['image'],
        'stadeId' => $validated['stadeId'] // database column name
    ]);

    return response()->json([
        'success' => true,
        'data' => $restaurant,
        'message' => 'Restaurant created successfully'
    ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $restaurant = Restaurant::find($id);
        return response()->json(data: $restaurant);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRestaurantRequest $request, string $restaurant)
    {
        $instance = Restaurant::find($restaurant);
        
        $validated = $request->validated();
        

        // Update the restaurant instance
        $instance->update([
            'nom' => $validated['nom'],
            'cuisine' => $validated['cuisine'],
            'description' => $validated['description'],
            'adresse' => $validated['adresse'],
            'note' => $validated['note'],
            'distance' => $validated['distance'],
            'prixMoyen' => $validated['prixMoyen'],
            'horaires' => $validated['horaires'] ?? null,
            'telephone' => $validated['telephone'] ?? null,
            'image' => $validated['image'],
            'stadeId' => $validated['stadeId'] 
        ]);
    
        return response()->json([
            'success' => true,
            'data' => $instance->fresh(), // Get refreshed data from database
            'message' => 'Restaurant updated successfully'
        ], 200); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Restaurant deleted successfully'
        ]);
    }
}
