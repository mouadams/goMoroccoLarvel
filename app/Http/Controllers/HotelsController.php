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
        // Get only the validated data
        $validated = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('hotels', 'public');
            $validated['image'] = $imagePath; // Update the validated array with the image path
        }

        
        $hotelData = [
            'nom' => $validated['nom'] ?? $validated['name'] ?? null,
            'description' => $validated['description'],
            'etoiles' => $validated['etoiles'],
            'ville' => $validated['ville'] ?? $validated['city'] ?? null,
            'image' => $validated['image'],
            'prix' => $validated['prix'],
            'distance' => $validated['distance'],
            'adresse' => $validated['adresse'] ?? $validated['address'] ?? null,
            'phone' => $validated['phone'],
            'wifi' => filter_var($validated['wifi'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'piscine' => filter_var($validated['piscine'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'stadeId' => $validated['stadeId'],
            'parking' => filter_var($validated['parking'] ?? false, FILTER_VALIDATE_BOOLEAN), // Added parking field from previous context
        ];

        try {
            // Create the hotel record in the database
            $hotel = Hotels::create($hotelData);

            return response()->json([
                'success' => true,
                'data' => $hotel,
                'message' => __('Hotel created successfully')
            ], 201);

        } catch (\Exception $e) {
            // Catch any potential database or other exceptions
            // Log the error for debugging purposes (e.g., using Log::error($e->getMessage()))
            return response()->json([
                'success' => false,
                'message' => __('Failed to create hotel.'),
                'error' => $e->getMessage() // Good for debugging, but consider removing in production
            ], 500);
        }
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
        try {
            // Use findOrFail for robust ID lookup
            $hotel = Hotels::findOrFail($id);

            // Get only the validated data.
            // Fields that are 'sometimes' and not sent by the frontend will NOT be in $validatedData.
            $validatedData = $request->validated();
            
            // --- Image Handling ---
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($hotel->image && Storage::disk('public')->exists($hotel->image)) {
                    Storage::disk('public')->delete($hotel->image);
                }
                // Store the new image and get its path
                $imagePath = $request->file('image')->store('hotels', 'public');
                $validatedData['image'] = $imagePath; // Add the new image path to the validated data
            } else {
               
                unset($validatedData['image']);
            }

          
            $hotel->update($validatedData);

            return response()->json([
                'success' => true,
                'data' => $hotel->fresh(), // Get refreshed data from database
                'message' => 'Hotel updated successfully'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // If findOrFail doesn't find the hotel
            return response()->json([
                'success' => false,
                'message' => 'Hotel not found.'
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            
            Log::error("Validation error during hotel update: " . $e->getMessage(), ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Catch any other general exceptions
            Log::error("Failed to update hotel: " . $e->getMessage(), ['exception' => $e, 'request_data' => $request->all()]);
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred while updating the hotel.',
                'error' => $e->getMessage()
            ], 500);
        }
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
