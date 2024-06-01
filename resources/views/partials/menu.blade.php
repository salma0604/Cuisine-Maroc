@php

             use App\Models\Utilisateur;

@endphp
<header>

    <img src="/images/LOGO.png" alt="" class="logo">
    <div class="menu">
        <img src="/images/Pictogrammers-Material-Light-Menu.512.png" alt="" class="menu_icons">
        {{-- @auth
    

    <!-- Insérer ici le code HTML ou les éléments Blade que vous souhaitez afficher en fonction de l'utilisateur -->

@endauth --}}

        <ul>
            <li><a href="/Acceuil">Acceuil</a></li>
            {{-- <li><a href="/cuisiniers">Cuisiniers</a></li> --}}
            <li><a href="/search"><i class="fas fa-search" ></i> Rechercher</a></li>
            {{-- @auth
            <li><a href="/cuisiniers/create">Ajouter votre profile</a></li>
            <li><a href={{route('login.logout')}} class="btn-logout" style="color: white; margin:0px ; margin-left:20px">Deconnexion</a></li>
                
            @endauth --}}
            
            @auth

            {{-- {{dd($cuisiniers)}} --}}

            @php
            // use App\Models\Utilisateur;
            $user = Utilisateur::with('estCuisinier')->find(auth()->id());
            $cuisinier = $user->estCuisinier;
            // Si un cuisinier est trouvé, obtenir son ID
            $idCuisinier = $cuisinier ? $cuisinier->id : null;
            @endphp
            @if($user->estCuisinier)
            
                <!-- Afficher le contenu pour un utilisateur avec un profil cuisinier -->
                <li><a href="{{ route('cuisiniers.edit', ['cuisinier' => $cuisinier->id])}}">Modifier votre profil</a></li>
                <li></li>
                <div class="dropdown" style="float:left">
                    <button class="dropbtn">{{$cuisinier->nom}}</button>
                    <div class="dropdown-content" style="left:0">
                    <a href="{{ route('cuisiniers.show', ['cuisinier' => $cuisinier->id])}}">Votre Profile</a>
                   
                    <a href={{route('login.logout')}} class="btn-logout" style=" margin:0px ; margin-left:20px">
                        Deconnexion
                    </a>
                    </div>
                </div>
            @else
                <!-- Afficher le contenu pour un utilisateur sans profil cuisinier -->
                <li><a href="/cuisiniers/create">Ajouter votre profil</a></li>
                <div class="dropdown" style="float:left">
                    <button class="dropbtn">{{$user->nom}}</button>
                    <div class="dropdown-content" style="left:0">
                    <a href="/cuisiniers/create">Ajouter votre profil</a>
                    <a href={{route('login.logout')}} class="btn-logout" style=" margin:0px ; margin-left:20px">
                        Deconnexion
                    </a>
                    </div>
                </div>
            @endif
           

            @endauth


            {{-- <li><a href="">À propos</a></li> --}}
           @guest
          
           <li><a href="{{ route('loginpage') }}" class="btn-login" style="color: white ; margin:0px ;margin-left:20px">se connecter <i class="fa-solid fa-right-to-bracket"></i></a></li>
           @endguest


        </ul>
    </div>
   
</header>

