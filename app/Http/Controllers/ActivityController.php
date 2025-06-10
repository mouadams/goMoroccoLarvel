<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Stades; // Assuming Stades model is in App\Models
use App\Http\Requests\StoreActivityRequest; // You'll need to create this
use App\Http\Requests\UpdateActivityRequest; // You'll need to create this
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = Activity::all();

        return response()->json(data: $activities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActivityRequest $request)
    {
        try {
            $validated = $request->validated();
            
            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('activities', 'public');
                $validated['image'] = $imagePath;
            }
            
            // Create activity with validated data
            $activity = Activity::create($validated);
            
            return response()->json([
                'success' => true,
                'data' => $activity,
                'message' => 'Activity created successfully'
            ], 201); // Use 201 for created resources
            
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Database Query Error: ' . $e->getMessage());
            Log::error('SQL: ' . $e->getSql());
            
            return response()->json([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ], 500);
            
        } catch (\Exception $e) {
            Log::error('General Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create activity: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $activity = Activity::find($id);

        if (!$activity) {
            return response()->json([
                'success' => false,
                'message' => 'Activity not found.'
            ], 404);
        }

        return response()->json(data: $activity);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActivityRequest $request, string $activityId)
    {
        try {
            $instance = Activity::findOrFail($activityId);
            $validated = $request->validated();
    
            if ($request->hasFile('image')) {
                Log::info('Update: Request has an image file for activity.');
    
                if ($instance->image && Storage::disk('public')->exists($instance->image)) {
                    Log::info('Update: Old activity image exists at: ' . $instance->image . '. Attempting deletion.');
                    Storage::disk('public')->delete($instance->image);
                    Log::info('Update: Old activity image deletion attempted for: ' . $instance->image);
                } else {
                    Log::info('Update: No old activity image found or it does not exist on disk.');
                }
    
                $imagePath = $request->file('image')->store('activities', 'public');
                Log::info('Update: New activity image stored at: ' . $imagePath);
                $validated['image'] = $imagePath;
                Log::info('Update: $validated[\'image\'] set to: ' . $validated['image']);
    
            } else {
                Log::info('Update: Request does NOT have a file for activity image.');
    
                if (array_key_exists('image', $request->all()) && ($request->input('image') === null || $request->input('image') === '')) {
                    Log::info('Update: Explicit request to remove activity image.');
                    if ($instance->image && Storage::disk('public')->exists($instance->image)) {
                        Log::info('Update: Deleting old image for explicit removal: ' . $instance->image);
                        Storage::disk('public')->delete($instance->image);
                    }
                    $validated['image'] = null;
                    Log::info('Update: $validated[\'image\'] set to null.');
                } else {
                    Log::info('Update: Activity image field not sent; keeping existing image.');
                    unset($validated['image']);
                }
            }
    
            $instance->update($validated);
            Log::info('Update: Activity ' . $activityId . ' updated successfully.');
    
            return response()->json([
                'success' => true,
                'data' => $instance->fresh(),
                'message' => 'Activity updated successfully'
            ], 200);
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Update: Activity not found with ID: ' . $activityId);
            return response()->json([
                'success' => false,
                'message' => 'Activity not found.',
            ], 404);
        } catch (\Exception $e) {
            Log::error("Failed to update activity: " . $e->getMessage(), ['exception' => $e, 'activityId' => $activityId]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update activity.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $activity = Activity::findOrFail($id);

            // Delete associated image if it exists
            if ($activity->image && Storage::disk('public')->exists($activity->image)) {
                Storage::disk('public')->delete($activity->image);
            }
            
            $activity->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Activity deleted successfully'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Activity not found.',
            ], 404);
        } catch (\Exception $e) {
            Log::error("Failed to delete activity: " . $e->getMessage(), ['exception' => $e, 'activityId' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete activity.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}