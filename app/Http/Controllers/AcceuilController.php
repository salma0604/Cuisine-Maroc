<?php

namespace App\Http\Controllers;

use App\Models\Cuisinier;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class AcceuilController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $Cuisiniers = Cuisinier::paginate(20);

            return view('Acceuil', [ "Cuisiniers" => $Cuisiniers]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function envoyerLesDonneesAuMenu()
    {
        //
        $user = Utilisateur::find(auth()->id());
        $estCuisinier =$user->estCuisinier;
        $IdCuisinier= $estCuisinier->IdUtilisateur;
        // dd($IdCuisinier);
        $Cuisiniers = Cuisinier::paginate(20);
        // if ($user) {
            // L'utilisateur a un profil cuisinier
            // dd($user);

            return view('partials.menu', ["user"=>$IdCuisinier]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
