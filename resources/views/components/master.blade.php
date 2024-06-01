

@php
             use App\Models\Utilisateur;

if (Auth::user()) {

        $user = Utilisateur::find(auth()->id());
        $contacter_chef=$user->contacter_chef;


    }else{

        $contacter_chef=false;
    
}
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuisine Maroc</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo asset('css/style.css')?>" >
    <script src="https://kit.fontawesome.com/9669377fba.js" crossorigin="anonymous"></script>

    
</head>
<body>
@include('partials.menu')

{{$slot}}

@include('partials.footer')
<script>
    const menuIcons = document.querySelector('.menu_icons');
    const menuList = document.querySelector('.menu ul');

    menuIcons.addEventListener('click', () => {
        menuList.classList.toggle('active');
    });

// ------------------------------

    document.addEventListener('DOMContentLoaded', function() {
        const retourBtn = document.querySelector('.retour-page');
        if (retourBtn) {
            retourBtn.addEventListener('click', function(e) {
                e.preventDefault();
                history.back(); // Retourne à la page précédente
            });
        }
    });


// -----------------------------------

    const afficherpaiement = document.getElementById('afficher-paiement');
    const blocPaiement = document.getElementById('bloc-paiement');
    const fermerPaiement = document.getElementById('fermer-paiement');

    afficherpaiement.addEventListener('click', () => {
        if (!{{ json_encode($contacter_chef) }}) {
        blocPaiement.style.display = 'block';
            
        }
    });

    fermerPaiement.addEventListener('click', () => {
        blocPaiement.style.display = 'none';
    });
// ----------------------------------


        ;
        // document.getElementById('ajouterPhotooo').addEventListener('click', () => {
        //     console.log('Button clicked!'); // Check if this log appears in the console
        //     // alert('Maximum de photos atteint. Veuillez supprimer une photo pour en ajouter une nouvelle.');
        // });

        



</script>

</body>
</html>