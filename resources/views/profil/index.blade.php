<x-master>
    <section class="Cuisiniers">
        <div class="back-icons" style="margin-top: 100px; margin-left: 80px">
            <a href="javascript:history.go(-1);"><i class="fas fa-arrow-left" style="color: #bb2337;"></i></a>
        </div>
        <h2 style="">Tous les Cuisiniers</h2>

        {{-- <div class="add">
            <a href="/cuisiniers.create">
                <i class="fa-solid fa-user-plus" style="color: #bb2337;"></i>ajouter votre profil</a>
         </div> --}}
       
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
    @if ($Cuisiniers->total() > 20)
    <div class="pagination">
        {{ $Cuisiniers->links() }}
    </div>
@endif


</x-master>