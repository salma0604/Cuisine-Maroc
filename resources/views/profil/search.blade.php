


<x-master>
    <main>
        <section id="services">
            <div class="back-icons" style="margin-top: 100px; margin-left: 120px">
                <a href="javascript:history.go(-1);" class="retour-page"><i class="fas fa-arrow-left" style="color: #bb2337;"></i></a>
            </div>
            <h2 >Rechercher</h2>
            <!-- Form for service request -->
            <form action="{{ route('cuisiniers.search') }}" method="GET" id="search">
                @csrf
                <label for="specialite">Spécialités:</label>
                <select id="specialite" name="specialite">
                    <option value="" disabled selected>choisir</option>
                    @foreach($specialites as $specialite)
                    <option value="{{ $specialite }}">{{ $specialite }}</option>
                    @endforeach
                </select>
                <label for="ville">Ville:</label>
                <input type="text" id="ville" name="ville" placeholder="Entrez une ville">
                <button type="submit" class="btn"> <i class="fas fa-search" ></i></button>
            </form>
            

            <section class="cuisiniers-list" style="margin-top: 40px; margin-bottom: 40px">
                <div class="cuisiniers-list">
                    @if ($cuisiniers->isEmpty())
                    <div class="no-results" style="margin-bottom: 120px">
                        <p>Aucun résultat trouvé pour votre recherche.</p>
                    </div>
                    @else
                        @foreach ($cuisiniers as $cuisinier)
                        <div class="card">
                            <a href="{{ route('cuisiniers.show', ['cuisinier' => $cuisinier->id])}}" class="stretched-link">

                                @if ($cuisinier->Images->isNotEmpty())
                                <img src="{{ asset('/images/' . $cuisinier->Images->first()->Pathphoto) }}" alt="Cuisinier {{ $cuisinier->id }}">
                            @else
                                <img src="{{ asset('/images/default.jpg') }}" alt="Pas d'image disponible">
                            @endif
                                <h4>{{ $cuisinier->nom }}</h4>
                                <p><i class="fa-solid fa-map-marker-alt " style="color: #c0bebe;"></i> {{ $cuisinier->ville }}</p>
                                {{-- Ajoutez d'autres informations du cuisinier ici --}}
                            </a>
                        </div>
                        @endforeach
                    @endif
                    
            </section>

        </section>
        
        @if ($cuisiniers->total() > 20)
        <div class="pagination">
            {{ $cuisiniers->links() }}
        </div>
        @endif
    
    </main>

</x-master>