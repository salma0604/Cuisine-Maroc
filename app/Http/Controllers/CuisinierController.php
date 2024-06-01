<?php

namespace App\Http\Controllers;

use App\Models\Cuisinier;
use App\Models\Image;
use App\Models\Specialite;
use App\Models\Utilisateur;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CuisinierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $Cuisiniers=Cuisinier::paginate(20);

        return view('profil.index',["Cuisiniers"=>$Cuisiniers]);
    }



    public function search(Request $request)

{
    $specialites = Specialite::distinct()->pluck('nomSpecialite');
    // Get the search values

    $ville = $request->input('ville');
    $specialite = $request->input('specialite');

    // Build the search query
    $query = Cuisinier::query();

    if ($ville) {
        $query->where('ville', 'like', "%$ville%");
    }

    if ($specialite) {
        // $query->where('specialite', 'like', "%$specialite%");
        $query->whereHas('Specialite', function ($q) use ($specialite) {
            $q->where('nomSpecialite', $specialite);
        });
    }

    if ($specialite && $ville) {
        $query->where('ville', 'like', "%$ville%")
              ->whereHas('Specialite', function ($q) use ($specialite) {
            $q->where('nomSpecialite', $specialite);
        });;
    }

    // Execute the search query
    $result = $query->paginate(20);

    // Return the results to the view
    return view('profil.search', ["cuisiniers" => $result,"specialites" => $specialites]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        $user = Utilisateur::find(auth()->id());

            // $user->can_add_photo = true;
            $canAddPhoto =$user->can_add_photo;  // Mise à jour du champ can_add_photo
            $user->save();


        return view('profil.create', compact('canAddPhoto'));

    }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // }
    public function store(Request $request)
{
    $request->validate([
        'nom'=>'required',
        'ville'=>'required',
        'tele'=>'required',
        'email'=>'required|email',

        'disponibilite'=>'required',
        'prix'=>'nullable',
        'specialites'=>'required',
        'lieuTravail'=>'required',
        'photo' => 'required|array|min:1',
        'photo.*' => 'image|mimes:png,jpg,jpeg,svg|max:10240',
        'description' => 'required',



    ]);

    $cuisinier=new Cuisinier();
    $cuisinier->nom=$request->input('nom');
    $cuisinier->ville=$request->input('ville');
    $cuisinier->tele=$request->input('tele');

    $cuisinier->email=$request->input('email');
    $cuisinier->disponibilite=$request->input('disponibilite');



    $cuisinier->prix=$request->input('prix');
    $cuisinier->lieuTravail=$request->input('lieuTravail');
    $cuisinier->IdUtilisateur = Auth::id();
    $cuisinier->save();

    $specialitesInput = $request->input('specialites');
    $specialitesArray = explode(',', $specialitesInput);

    foreach ($specialitesArray as $specialite) {
        // Insérez chaque spécialité dans la base de données
        $nouvelleSpecialite = new Specialite();
        $nouvelleSpecialite->nomSpecialite = trim($specialite); // Supprime les espaces blancs
        $nouvelleSpecialite->IdCuisinier = $cuisinier->id;

        $nouvelleSpecialite->save();
    }

        // Enregistrement des photos
        foreach ($request->file('photo') as $key => $photo) {
            $imageName = uniqid() . '-'. now()->format('YmdHis') . '.' .$photo->extension();
            $photo->move(public_path('images'), $imageName);

            $image = new Image();
            $image->Pathphoto = $imageName;
            $image->Descphoto = $request->input('description')[$key];
            $image->IdCuisinier = $cuisinier->id;
            $image->save();
        }

        // // Enregistrement des vidéos
        // dd($request->hasFile('video'));
        // if ($request->hasFile('video')) {
        //     foreach ($request->file('video') as $key => $video) {
        //         $videoName = uniqid() . '.' . $video->extension();
        //         $video->move(public_path('videos'), $videoName);

        //         $videoModel = new Video();
        //         $videoModel->Pathvideo = $videoName;
        //         $videoModel->Descvideo = $request->input('videoDescription')[$key];
        //         $videoModel->IdCuisinier = $cuisinier->id;
        //         $videoModel->save();
        //     }
        // }
    return redirect()->route('Acceuil.index')
     ->with('success', 'Votre profil a été ajouté avec succès.')
    ;
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $cuisinier = Cuisinier::findorfail($id); // Récupérer le produit correspondant à l'ID

        return view('profil.show', ['cuisinier' => $cuisinier]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $cuisinier = Cuisinier::findorfail($id); // Récupérer le produit correspondant à l'ID

        return view('profil.edit', ['cuisinier' => $cuisinier]);




    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required',
            'ville' => 'required',
            'tele' => 'required',
            'email'=>'required|email',
            'disponibilite' => 'required',
            'prix' => 'nullable',
            'specialites' => 'required',
            'lieuTravail' => 'required',
            'photo' => 'array|min:1',
            'photo.*' => 'image|mimes:png,jpg,jpeg,svg|max:10240',
        ]);

        // Récupération du cuisinier à mettre à jour
        $cuisinier = Cuisinier::findOrFail($id);

        // Mise à jour des informations du cuisinier
        $cuisinier->nom = $request->input('nom');
        $cuisinier->ville = $request->input('ville');
        $cuisinier->tele = $request->input('tele');
        $cuisinier->email=$request->input('email');

        $cuisinier->disponibilite = $request->input('disponibilite');
        $cuisinier->prix = $request->input('prix');
        $cuisinier->lieuTravail = $request->input('lieuTravail');
        $cuisinier->save();



        $cuisinier->specialite()->delete();
        $specialitesInput = $request->input('specialites');
        $specialitesArray = explode(',', $specialitesInput);
        foreach ($specialitesArray as $specialite) {
            // Insérez chaque spécialité dans la base de données
            $nouvelleSpecialite = new Specialite();
            $nouvelleSpecialite->nomSpecialite = trim($specialite); // Supprime les espaces blancs
            $nouvelleSpecialite->IdCuisinier = $cuisinier->id;

            $nouvelleSpecialite->save();
        }



        // Suppression des photos sélectionnées

        if ($request->has('photos_to_delete')) {
            // Convertir les identifiants en tableau d'entiers
            $photoIds = array_map('intval', explode(',', $request->input('photos_to_delete')[0]));

            foreach ($photoIds as $photoId) {
                $photo = Image::find($photoId);
                if ($photo) {
                    // Supprimer le fichier de l'image du dossier public
                    $imagePath = public_path('images/' . $photo->Pathphoto);
                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }
                    // Supprimer l'entrée de la base de données
                    $photo->delete();
                }
            }
}


        // Enregistrement des nouvelles photos
        if ($request->hasFile('photo') ) {
            foreach ($request->file('photo') as $key => $photo) {
                $imageName = uniqid() . '-' . now()->format('YmdHis') . '.' . $photo->extension();
                $photo->move(public_path('images'), $imageName);

                $image = new Image();
                $image->Pathphoto = $imageName;
                $image->IdCuisinier = $cuisinier->id;
                $image->Descphoto = $request->input('description')[$key];
                $image->save();
            }
        }

        return redirect()->route('Acceuil.index')
            ->with('success', 'Votre profil a été modifié avec succès.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $CuisinierAsupprimer = Cuisinier::findOrFail($id);
        $CuisinierAsupprimer->specialite()->delete();
        $CuisinierAsupprimer->images()->delete();
        $CuisinierAsupprimer->delete();
        return redirect()->route('Acceuil.index',[Auth::id()])->with("success","Votre profil a été supprimé avec succès");
    }

}
