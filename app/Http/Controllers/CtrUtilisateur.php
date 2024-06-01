<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CtrUtilisateur extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("authentification.singup");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $formFiels=$request->validate([
            'nom'=>'required|min:3',
            'password'=>'required|min:8|confirmed',
            'email'=>'required|email|unique:Utilisateurs',


        ]);

        $formFiels['password']=Hash::make($request->password);


        Utilisateur::create($formFiels);


        return redirect()->route('Acceuil.index')->with("success","  Votre compte a été créé avec succès. Connectez-vous maintenant pour accéder à votre profil et profiter de nos services.");

    }
    public function logout(){
        Session::flush();
        Auth::logout();

        return to_route("Acceuil.index")->with("success","vous etes bien déconnecté");
        // return('bye bye');
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
    public function showLoginForm()
    {
        return view('authentification.singin');
    }
    public function login(Request $request){

        $email=$request->input('email');
        $password=$request->input('password');

        $credentials=["email"=>$email,"password"=>$password];

        // dd(Auth::attempt($credentials));

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();
            return to_route('Acceuil.index');

        }else{
            return back()->withErrors(['email'=>"Email ou mot de passe incorrecte"])
            // ->onlyInput('email')
            ;


        }

    }


}
