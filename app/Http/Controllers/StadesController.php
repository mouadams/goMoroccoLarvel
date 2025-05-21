<?php

namespace App\Http\Controllers;

use App\Models\Stades;
use App\Http\Requests\StoreStadesRequest;
use App\Http\Requests\UpdateStadesRequest;
use Illuminate\Support\Facades\Storage;

class StadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stades = Stades::all();
        

        return response()->json(data: $stades);

      


    }

  

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStadesRequest $request)
    {
        $validated = $request->validated();
    
        // Handle image upload if present
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('stades', 'public');
            $validated['image'] = $imagePath;
        }

        $hotel = Stades::create($validated);

        return response()->json([
            'success' => true,
            'data' => $hotel,
            'message' => __('Stade created successfully') // For localization
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $stade = Stades::find($id);

        if (!$stade) {
            return response()->json(['message' => 'Stade not found'], 404);
        }
    
        return response()->json($stade);
        // $stade = Stades::where('id', $stades->id)->first();
        // return response()->json(data: $stade);
    }

  

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStadesRequest $request, Stades $stades)
    {
        // Get ALL input data including the unchanged fields
        $validated = $request->validated();
        
        // Handle file upload if present
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($stades->image) {
                Storage::disk('public')->delete($stades->image);
            }
            
            $imagePath = $request->file('image')->store('stades', 'public');
            $validated['image'] = $imagePath;
        }
    
        $stades->update($validated);
    
        return response()->json([
            'success' => true,
            'data' => $stades,
            'message' => 'Stade updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $stade = Stades::findOrFail($id);
        $stade->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'stade deleted successfully'
        ]);

    }
}
