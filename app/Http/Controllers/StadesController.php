<?php

namespace App\Http\Controllers;

use App\Models\Stades;
use App\Http\Requests\StoreStadesRequest;
use App\Http\Requests\UpdateStadesRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

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
  
     public function update(UpdateStadesRequest $request, string $id)
     {
         // Initialize variables for debug output
         $hadImageFile = false;
         $oldImage = null;
         $newImage = null;
 
         try {
             // Use findOrFail for robust ID lookup. Throws ModelNotFoundException if not found.
             $stades = Stades::findOrFail($id);
 
             // Store the current image path before any potential update
             $oldImage = $stades->image;
 
             // --- Comprehensive Debug Logging (Crucial for Postman issues) ---
             Log::info('Stade Update Request Received:', [
                 'stade_id' => $id,
                 'HTTP_Method' => $request->method(), // Will likely be POST due to spoofing
                 'Content-Type_Header' => $request->header('Content-Type'), // SHOULD be multipart/form-data
                 'hasFile("image")' => $request->hasFile('image'), // SHOULD be true if file is sent correctly
                 'allFiles()' => $request->allFiles(), // Shows all files Laravel detected
                 'request_all_data' => $request->all(), // Shows all form fields (including _method)
             ]);
 
             // Get only the validated data from the form request
             $validatedData = $request->validated();
 
             Log::info('Validated Data before image handling:', $validatedData);
 
             // --- Image Handling Logic ---
             if ($request->hasFile('image')) {
                 $hadImageFile = true; // Set for debug output
                 $imageFile = $request->file('image');
 
                 Log::info('Image File Detected:', [
                     'original_name' => $imageFile->getClientOriginalName(),
                     'mime_type' => $imageFile->getMimeType(),
                     'size_bytes' => $imageFile->getSize(),
                     'is_valid' => $imageFile->isValid(),
                     'extension' => $imageFile->getClientOriginalExtension()
                 ]);
 
                 // Delete the old image if it exists and is not the default/placeholder
                 if ($stades->image && Storage::disk('public')->exists($stades->image)) {
                     Log::info('Attempting to delete old image:', ['path' => $stades->image]);
                     Storage::disk('public')->delete($stades->image);
                     Log::info('Old image deletion result: ' . (Storage::disk('public')->exists($stades->image) ? 'FAILED' : 'SUCCESS'));
                 } else {
                     Log::info('No old image to delete or path invalid:', ['current_image_field' => $stades->image]);
                 }
 
                 // Store the new image and get its path
                 $imagePath = $imageFile->store('stades', 'public');
                 $validatedData['image'] = $imagePath; // Add new image path to validated data
                 $newImage = $imagePath; // Set for debug output
 
                 Log::info('New image stored successfully:', ['path' => $imagePath]);
             } else {
                 // If no new image is uploaded, we should NOT send the 'image' key to update
                 // unless you specifically want to set it to NULL.
                 // Your current UpdateStadesRequest has 'sometimes' on 'image',
                 // so if it's not present, it won't be in $validatedData initially.
                 // However, this `unset` ensures no old 'image' value persists from the request.
                 if (isset($validatedData['image'])) {
                      unset($validatedData['image']);
                 }
                 Log::info('No new image file found in the request. Image path in database will remain unchanged unless explicitly set to null.');
             }
 
             Log::info('Final data to update:', $validatedData);
 
             // Update the stadium model with the validated data
             $stades->update($validatedData);
 
             // Refresh the model instance to get the very latest data from the database
             $updatedStades = $stades->fresh(); // Using fresh() is slightly more explicit than refresh()
 
             // For comparison in logs
             $imageChanged = ($oldImage !== $updatedStades->image);
             Log::info('Image field update status:', [
                 'old_image_path_in_db' => $oldImage,
                 'new_image_path_in_db' => $updatedStades->image,
                 'image_field_was_changed' => $imageChanged
             ]);
 
             // Return success response
             return response()->json([
                 'success' => true,
                 'data' => $updatedStades,
                 'message' => 'Stade updated successfully',
                 'debug' => [
                     'had_image_file' => $hadImageFile, // Reflects if hasFile() was true
                     'old_image_path_sent_to_db' => $oldImage, // The path before update
                     'new_image_path_in_db' => $updatedStades->image // The path after update (from fresh model)
                 ]
             ], 200);
 
         } catch (ModelNotFoundException $e) {
             Log::warning('Stade not found for update:', ['id' => $id]);
             return response()->json([
                 'success' => false,
                 'message' => 'Stade not found.'
             ], 404);
         } catch (ValidationException $e) {
             // Handles validation errors from UpdateStadesRequest
             Log::error("Validation error during stade update: " . $e->getMessage(), ['errors' => $e->errors()]);
             return response()->json([
                 'success' => false,
                 'message' => 'Validation failed',
                 'errors' => $e->errors()
             ], 422);
         } catch (\Exception $e) {
             // Catches any other unexpected errors
             Log::critical("An unexpected error occurred during stade update: " . $e->getMessage(), [
                 'exception_trace' => $e->getTraceAsString(),
                 'request_data_all' => $request->all(),
                 'file_upload_status' => $request->hasFile('image'),
                 'detected_files' => $request->allFiles()
             ]);
             return response()->json([
                 'success' => false,
                 'message' => 'An unexpected error occurred while updating the stade.',
                 'error' => $e->getMessage()
             ], 500);
         }
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
