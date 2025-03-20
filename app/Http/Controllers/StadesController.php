<?php

namespace App\Http\Controllers;

use App\Models\Stades;
use App\Http\Requests\StoreStadesRequest;
use App\Http\Requests\UpdateStadesRequest;
use Illuminate\Support\Facades\DB;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStadesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Stades $stades)
    {
        $stade = Stades::where('id', $stades->id)->first();
        return response()->json(data: $stade);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stades $stades)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStadesRequest $request, Stades $stades)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stades $stades)
    {
        //
    }
}
