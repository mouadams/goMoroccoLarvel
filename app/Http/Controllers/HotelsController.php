<?php

namespace App\Http\Controllers;

use App\Models\Hotels;
use App\Http\Requests\StoreHotelsRequest;
use App\Http\Requests\UpdateHotelsRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


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
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('hotels', 'public');
            $validated['image'] = $imagePath;
        }
    
        // Transform fields
        $hotelData = [
            'nom' => $validated['nom'] ?? $validated['name'] ?? null, // Handle both cases
            'description' => $validated['description'],
            'etoiles' => $validated['etoiles'],
            'image' => $validated['image'],
            'prix' => $validated['prix'],
            'distance' => $validated['distance'],
            'adresse' => $validated['adresse'] ?? $validated['address'] ?? null,
            'phone' => $validated['phone'], 
            'wifi' => filter_var($validated['wifi'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'piscine' => filter_var($validated['piscine'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'stadeId' => $validated['stadeId'],
        ];
    
        // Validate required fields are present
        if (in_array(null, $hotelData, true)) {
            return response()->json([
                'success' => false,
                'message' => __('Missing required fields')
            ], 400);
        }
    
        $hotel = Hotels::create($hotelData);
    
        return response()->json([
            'success' => true,
            'data' => $hotel,
            'message' => __('Hotel created successfully')
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

    // Manually map incoming fields (including typos)
    $validatedData = [];
    
    // Text fields with fallback for typos
    $validatedData['nom'] = $request->input('nom', $request->input('nom', $hotel->nom));
    $validatedData['description'] = $request->input('description', $hotel->description);
    $validatedData['prix'] = $request->input('prix', $hotel->prix);
    $validatedData['distance'] = $request->input('distance', $hotel->distance);
    $validatedData['adresse'] = $request->input('adresse', $hotel->adresse);
    $validatedData['phone'] = $request->input('phone', $hotel->phone);
    
    // Handle typo in "etoiles"
    $validatedData['etoiles'] = (int)($request->input('etoiles', $request->input('etolles', $hotel->etoiles)));
    
    // Handle typo in "stadeId"
    $validatedData['stadeId'] = (int)($request->input('stadeId', $request->input('stadelid', $hotel->stadeId)));
    
    // Boolean fields
    $validatedData['wifi'] = (bool)$request->input('wifi', $hotel->wifi);
    $validatedData['piscine'] = (bool)$request->input('piscine', $hotel->piscine);

    // File upload
    if ($request->hasFile('image')) {
        $validatedData['image'] = $request->file('image')->store('hotels', 'public');
    }

    // Update the hotel
    $hotel->update($validatedData);

    return response()->json([
        'success' => true,
        'data' => $hotel->fresh(),
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
