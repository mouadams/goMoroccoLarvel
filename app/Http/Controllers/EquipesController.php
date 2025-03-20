<?php

namespace App\Http\Controllers;

use App\Models\Equipes;
use App\Http\Requests\StoreEquipesRequest;
use App\Http\Requests\UpdateEquipesRequest;

class EquipesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipes = Equipes::all();
        
        return response()->json(data: $equipes);
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
    public function store(StoreEquipesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipes $equipes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipes $equipes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipesRequest $request, Equipes $equipes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipes $equipes)
    {
        //
    }
}
