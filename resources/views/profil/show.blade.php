
<@php
             use App\Models\Utilisateur;

if (Auth::user()) {
    # code...
    $user = Utilisateur::find(auth()->id());

    $contacter_chef=$user->contacter_chef;

}else{
    $contacter_chef=false;
}
@endphp
<x-master>
    
    <div class="profil">

      <div class="back-icons">
        <a href="javascript:history.go(-1);" class="retour-page"><i class="fas fa-arrow-left" style="color: #bb2337;"></i></a>
    </div>
    <div class="" style="z-index: 200">
        @include('partials.success')

    </div>
    @if (Auth::check() && Auth::user()->id === $cuisinier->IdUtilisateur)
    <div class="button-container">
        <div>
            <a href="{{ route('cuisiniers.edit', ['cuisinier' => $cuisinier->id]) }}" class="edit-button"><i class="fas fa-edit"></i> Modifier</a>
        </div>
        
        <div>
            <form action="{{ route('cuisiniers.destroy', ['cuisinier' => $cuisinier->id]) }}" method="POST" class="form-delete" style="font-weight: bolder">
            @method('DELETE')
            @csrf
            <button type="submit" class="delete-button" style="text-transform: capitalize "><i class="fas fa-trash-alt"></i>{{' '}} supprimer</button>
            </form>
        </div>
    </div>
    
    <div id="confirmation-suppression" style="display: none;">
        Êtes-vous sûr de vouloir supprimer ce profil ?
        <div style=" display:flex;margin:5px">
        <button id="confirmer-suppression" style="margin-right:10px">Confirmer</button>
        <button id="annuler-suppression">Annuler</button>
    </div>
    </div>
@endif

    
        <div class="info-profil">
            <div class="img-plats">
              @if ($cuisinier->Images->isNotEmpty())
              <img src="{{ asset('/images/' . $cuisinier->Images->first()->Pathphoto) }}" alt="cuisinier {{ $cuisinier->id }}" style="height:220px">
          @else
              <img src="{{ asset('/images/default.jpg') }}" alt="Pas d'image disponible">
          @endif             


            </div>
            <div class="info">
                <table >
                    <tr>
                        <th > <p>Nom du Chef :  </p>
                        </th>
                        <td > <p>{{$cuisinier->nom}} </p>
                        </td>
                    </tr>
                    <tr>
                        <th> <p>Spécialités :</p></th>
                        <td>
                          <p>{{ implode(', ', $cuisinier->specialite()->pluck('nomSpecialite')->toArray()) }}</p>
                      </td>
                      
                    </tr>
                    <tr>
                        <th><p>Disponibilité :</p></th>
                        <td><p> {{$cuisinier->disponibilite}}</p></td>
                    </tr>
                    <tr>
                        <th><p>Ville : </p></th>
                        <td><p> {{$cuisinier->ville}}</p></td>
                    </tr>
                   
                    <tr>
                      
                        <th><p>Lieu de travail :</p></th>
                        <td><p>  {{$cuisinier->lieuTravail}}</p></td>
                    </tr>
                    
                          @if ($cuisinier->prix)
                              <tr>
                      
                                <th><p>Prix :</p></th>
                                <td><p> {{ $cuisinier->prix }}</p></td>
                            </tr>
                          
                          @endif
                          @auth
                          @if ($user->contacter_chef)
                          <tr>
                            <th><h5>tele :</h5></th>
                                <td><h5> {{ $cuisinier->tele }}</h5></td>
                          </tr>
                          <tr>
                            <th><h5>email :</h5></th>
                                <td><h5> {{ $cuisinier->email }}</h5></td>
                          </tr>
                        @endauth  
                          @endif
                          
                     

                   
                </table>

                @unless (Auth::check() && Auth::user()->id === $cuisinier->IdUtilisateur )
                @if (!$contacter_chef)
                <button  id="afficher-paiement">    
                  Contacter-Moi</button>
                @endif
                @endunless
                
                
                  <!-- Bloc de paiement -->
                  <div id="bloc-paiement" style="display: none;position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border: 1px solid black;">
                    <span id="fermer-paiement" style="cursor: pointer; float: right;">&times;</span><br>
                    <!-- Contenu du bloc de paiement -->
                    <h3 id="titre-paiement">Paiement requis pour contacter le chef</h3>
                    <p id="message-paiement">Veuillez effectuer un paiement de <b>50dh </b>pour accéder aux informations détaillées du chef.</p>
                    <!-- Bouton de paiement -->
                    <form action="{{ route('stripe') }}" method="POST">
                        @csrf
                        <input type="hidden" name="price" value="50">
                        <input type="hidden" name="service_type" value="Contacter_chef">
                        <input type="hidden" name="quantity" value="0">
        
                    <button id="bouton-paiement" type="submit">Payer maintenant</button>
                    </form>
                </div>

            </div>
        </div>
       
        <h2>Mes plats</h2>

        <div class="photos">
          @if ($cuisinier->Images && $cuisinier->Images->count() > 0)
          @foreach ($cuisinier->Images as $image)
            <div class="responsive">
                <div class="gallery">
                  
                    <img src="{{ asset('/images/' . $image->Pathphoto) }}" alt="Forest" width="600" height="400" onclick="openModal('{{ '/images/' . $image->Pathphoto }}')">
                    
                  <div class="desc">{{ $image->Descphoto }}</div>
                </div>
              </div>
              @endforeach
            @else
                <p>Aucune image trouvée pour ce chef.</p>
            @endif
                     

        </div>

         

            
        <div id="myModal" class="modal">
          <span class="close" onclick="closeModal()">&times;</span>
          <img class="modal-content" id="modalImg" src="">
          <div class="btn-container">
              <button class="btn btn-prev" onclick="prevImage()">&#10094;</button>
              <button class="btn btn-next" onclick="nextImage()">&#10095;</button>
          </div>
      </div>
        
        
           

    </div>

</x-master>
<script>
      let currentImageIndex = 0;
      const images = [];

@foreach ($cuisinier->Images as $image)
    images.push("{{ asset('/images/' . $image->Pathphoto) }}");
@endforeach


        function openModal(imageUrl) {
            const modal = document.getElementById("myModal");
            const modalImg = document.getElementById("modalImg");
            modal.style.display = "flex";
            modalImg.src = imageUrl;
            currentImageIndex = images.indexOf(imageUrl);
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        function nextImage() {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            const modalImg = document.getElementById("modalImg");
            modalImg.src = images[currentImageIndex];
        }

        function prevImage() {
            currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
            const modalImg = document.getElementById("modalImg");
            modalImg.src = images[currentImageIndex];
        }

        // Close the modal when clicking outside the image
        window.onclick = function(event) {
            const modal = document.getElementById("myModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };

            // Affiche la confirmation de suppression lorsqu'on clique sur le bouton supprimer
            const formDelete = document.querySelector('.form-delete');
    const confirmationSuppression = document.getElementById('confirmation-suppression');
    const confirmerSuppression = document.getElementById('confirmer-suppression');
    const annulerSuppression = document.getElementById('annuler-suppression');

    formDelete.addEventListener('submit', (event) => {
        event.preventDefault(); // Empêche l'envoi du formulaire par défaut
        confirmationSuppression.style.display = 'block';
    });

    confirmerSuppression.addEventListener('click', () => {
        formDelete.submit(); // Soumet le formulaire de suppression
    });

    annulerSuppression.addEventListener('click', () => {
        confirmationSuppression.style.display = 'none'; // Cache la confirmation de suppression
    });
    /////////////////////////////////

</script>