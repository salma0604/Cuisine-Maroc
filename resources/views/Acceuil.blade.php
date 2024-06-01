<x-master >


    <section class="home">

        <div class="" style="z-index: 200">
            @include('partials.success')

        </div>
        <h1>Bienvenue sur Cuisine Maroc</h1>
        <p>Trouvez les meilleurs chefs et spécialités</p>
        @guest
            <div class="AuthBtn">
                <a href="{{ route('login.create') }}" class="btn-login" style="color: white ; margin:0px ;margin-left:20px">s'inscrire <i class="fa-solid fa-user-plus"> </i></a>
            </div>
            
        @endguest
       
    </section>

    <section class="Cuisiniers" style="margin-bottom: 20px">
        <h3>les Cuisiniers</h3>
       

       
        
        <div class="cuisiniers-list">
           
            @foreach ($Cuisiniers as $Cuisinier)
            
            
            <div class="card">
                <a href="{{ route('cuisiniers.show', ['cuisinier' => $Cuisinier->id])}}" class="stretched-link">

                    @if ($Cuisinier->Images->isNotEmpty())
                    <img src="{{ asset('/images/' . $Cuisinier->Images->first()->Pathphoto) }}" alt="Cuisinier {{ $Cuisinier->id }}">
                @else
                    <img src="{{ asset('/images/default.jpg') }}" alt="Pas d'image disponible">
                @endif
                <h4>{{$Cuisinier->nom}}</h4>
                <p>
                    <i class="fa-solid fa-map-marker-alt " style="color: #c0bebe;"></i>  {{$Cuisinier->ville}}
                </p>
            </a>

            </div>
    
            @endforeach
            

            

           

        </div>

    </section>
    <div class="pagination">
        {{ $Cuisiniers->links() }}
    </div>

    
    {{-- <h2>Rechercher par spécialités</h2>

    <section class="specialite">
    
        <div class="card-sp">
            <img src="images/poisson.jpeg" alt="Cuisinier 1">            
            <h4>Poissonier</h4>           
        </div>

        <div class="card-sp">
            <img src="images/macarons.jpg" alt="Cuisinier 2">
            <h4>Pâtissier</h4>            
        </div>

        <div class="card-sp">
            <img src="images/Couscous_royal.jpg" alt="Cuisinier 3">
            <h4>Saucier</h4>               
        </div>

        <div class="card-sp">
            <img src="images/Harira.jpeg" alt="Cuisinier 3">            
            <h4>Friturier</h4>
        
        </div> <div class="card-sp">
            <img src="images/Pastilla.jpg" alt="Cuisinier 3">            
            <h4>Entremetier</h4>               
        </div>
    
</section> --}}

</x-master>
