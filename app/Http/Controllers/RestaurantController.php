<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('restaurants', 'public');
            $validated['image'] = $imagePath;
        }
    
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
    public function update(UpdateRestaurantRequest $request, string $restaurantId)
    {
        try {
            $instance = Restaurant::findOrFail($restaurantId);
            $validated = $request->validated();
    
            // 1. Is a new image file actually present and recognized by Laravel?
            if ($request->hasFile('image')) {
                // Log to confirm we enter this block
                Log::info('Update: Request has an image file.');
    
                // 2. Is there an old image associated with the instance, and does it exist on disk?
                if ($instance->image && Storage::disk('public')->exists($instance->image)) {
                    // Log the path of the image we're about to delete
                    Log::info('Update: Old image exists at: ' . $instance->image . '. Attempting deletion.');
                    // 3. Is the deletion actually working?
                    Storage::disk('public')->delete($instance->image);
                    // Confirm deletion attempt
                    Log::info('Update: Old image deletion attempted for: ' . $instance->image);
                } else {
                    Log::info('Update: No old image found or it does not exist on disk.');
                }
    
                // 4. Is the new image being stored correctly?
                $imagePath = $request->file('image')->store('restaurants', 'public');
                // Log the newly stored path
                Log::info('Update: New image stored at: ' . $imagePath);
                // 5. Is the new path correctly assigned to $validated?
                $validated['image'] = $imagePath;
                Log::info('Update: $validated[\'image\'] set to: ' . $validated['image']);
    
            } else {
                // This block handles removing an image or keeping the existing one
                // if 'image' is not a file upload.
                Log::info('Update: Request does NOT have a file for image.');
    
                if (array_key_exists('image', $request->all()) && ($request->input('image') === null || $request->input('image') === '')) {
                    // Scenario 1: User explicitly sent 'image' as null or an empty string
                    Log::info('Update: Explicit request to remove image.');
                    if ($instance->image && Storage::disk('public')->exists($instance->image)) {
                        Log::info('Update: Deleting old image for explicit removal: ' . $instance->image);
                        Storage::disk('public')->delete($instance->image);
                    }
                    $validated['image'] = null; // Set the database field to null
                    Log::info('Update: $validated[\'image\'] set to null.');
                } else {
                    // Scenario 2: User did not send the 'image' field at all.
                    // In this case, we don't want to change the existing image.
                    Log::info('Update: Image field not sent; keeping existing image.');
                    unset($validated['image']);
                }
            }
    
            // 6. Is the update method actually receiving the correct 'image' value?
            // Add a dd() here to see the final $validated array before update
            // dd($validated);
    
            $instance->update($validated);
            Log::info('Update: Restaurant ' . $restaurantId . ' updated successfully.');
    
            return response()->json([
                'success' => true,
                'data' => $instance->fresh(),
                'message' => 'Restaurant updated successfully'
            ], 200);
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Update: Restaurant not found with ID: ' . $restaurantId);
            return response()->json([
                'success' => false,
                'message' => 'Restaurant not found.',
            ], 404);
        } catch (\Exception $e) {
            Log::error("Failed to update restaurant: " . $e->getMessage(), ['exception' => $e, 'restaurantId' => $restaurantId]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update restaurant.',
                'error' => $e->getMessage()
            ], 500);
        }
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
