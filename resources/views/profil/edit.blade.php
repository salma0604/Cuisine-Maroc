@php

             use App\Models\Utilisateur;
        $user = Utilisateur::find(auth()->id());


@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <x-master>
        
        <form action="{{ route('cuisiniers.update',['cuisinier' => $cuisinier->id]) }}" method="POST" enctype="multipart/form-data" id="chefProfileForm">
            @method("PUT")

            @csrf
            <div class="back-icons">
                <a href="javascript:history.go(-1);" class="retour-page"><i class="fas fa-arrow-left" style="color: #bb2337; margin-top:60px;"></i></a>
            </div>   
        <h3>Modifier votre Profile</h3>
        <div class="" style="z-index: 200">
            @include('partials.success')

        </div>
        
            <table>
                <tr>
                    @if ($errors->any())
                  <div class="alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
                  @endif
                </tr>
                <tr>
                    <td><label for="nom">Nom du Chef :</label></td>
                    <td><input type="text" name="nom" value="{{$cuisinier->nom}}" placeholder="entrez votre nom"></td>
                </tr>
                <tr>
                    <td><label for="specialites">Spécialités :</label></td>
                    <td><input type="text" name="specialites" value="{{implode(', ', $cuisinier->specialite()->pluck('nomSpecialite')->toArray()) }}" placeholder="entrez votre Spécialités les Séparez par des virgules"></td>
                </tr>
                <tr>
                    <td><label for="disponibilite">Disponibilité :</label></td>
                    <td><input type="text"  name="disponibilite" value="{{$cuisinier->disponibilite}}" placeholder="entrez votre Disponibilité"></td>
                </tr>
                <tr>
                    <td><label for="ville">Ville :</label></td>
                    <td><input type="text" name="ville" value="{{$cuisinier->ville}}" placeholder="entrez votre Ville"></td>
                </tr>
                
                <tr>
                    <td><label for="lieuTravail">Lieu de travail :</label></td>
                    <td><input type="text" name="lieuTravail" value="{{$cuisinier->lieuTravail}}" placeholder="entrez votre Lieu de travail"></td>
                </tr>
                <tr>
                    <td><label for="prix">prix :</label></td>
                    <td><input type="text"  name="prix" value="{{$cuisinier->prix}}"  placeholder="entrez votre prix"></td>
                </tr>
                <tr>
                    <td><label for="tele">N de telephone:</label></td>
                    <td><input type="text" name="tele" value="{{$cuisinier->tele}}"  placeholder="entrez votre N de telephone"></td>
                </tr>
                <tr>
                    <td><label for="email">Email :</label></td>
                    <td><input type="text"  name="email" value="{{$cuisinier->email}}"  placeholder="entrez votre Email"></td>
                </tr>

                <!-- Photos -->
                <tr>
                    <td>Photos de vos plats :</td>
                    <td colspan="">
                        <table id="photosTable">
                            <tr>
                                <!-- Afficher les photos existantes avec leur description -->
                                @foreach($cuisinier->images as $image)
                                <tr class="photo-entry" data-photo-id="{{ $image->id }}">
                                    <td>
                                        <img src="{{ asset('images/' . $image->Pathphoto) }}" alt="{{ $image->Descphoto }}" style="width: 100px; height: auto;">
                                    </td>
                                    <td>
                                       <p>{{ $image->Descphoto }}</p>
                                    </td>
                                    <td>
                                        <span class="remove-photo" style="cursor: pointer;">&times;</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tr>
                        </table>
                        <button type="button" id="ajouterPhoto" style="background-color: transparent; border: none; ">
                            <i class="fa-solid fa-plus" style="color: #bb2337;"></i>Ajouter Photo
                        </button>
                        <input type="hidden" name="photos_to_delete[]" id="photosToDelete" value="">
                        
                    </td>
                </tr>
                
                
                <tr>
                    <td></td>
                    <td><button type="submit">Mdifier Profil</button></td>
                </tr>

                

                            
                        </table>
                       
                
                        <div id="messageMaxPhotos" style="display: none; color: red;">
                            Le nombre maximum de photos a été atteint. Veuillez supprimer une photo pour en ajouter une nouvelle, ou effectuer le paiement.
                        </div>
                    </td>
                </tr>
            </table>
        </form>
        <div id="bloc-paiement" style="display: none;">
            <span id="fermer-paiement" style="cursor: pointer; float: right;">&times;</span><br>
            <!-- Contenu du bloc de paiement -->
            <h3 id="titre-paiement">Paiement requis pour accéder à plus de fonctionnalités</h3>
            <p id="message-paiement">Veuillez effectuer un paiement de <b>20dh</b> pour ajouter plus de photos.</p>

            <!-- Bouton de paiement -->
            <form action="{{ route('stripe') }}" method="POST">
                @csrf
                <input type="hidden" name="price" value="20">
                <input type="hidden" name="service_type" value="ajouter des photos">
                <input type="hidden" name="quantity" value="plusieur photos">

            <button id="bouton-paiement" type="submit">Payer maintenant</button>
            </form>
        </div>
    </x-master>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
                const ajouterPhotoBtn = document.getElementById('ajouterPhoto');
                const photosTable = document.getElementById('photosTable');
                const messageMaxPhotos = document.getElementById('messageMaxPhotos');
                const photosToDeleteInput = document.getElementById('photosToDelete');

                let photoCount = document.querySelectorAll('.photo-entry').length;
                const blocPaiement = document.getElementById('bloc-paiement');

               
                

            
               

                    ajouterPhotoBtn.addEventListener('click', () => {
                if (photoCount >= 3 && !{{ json_encode($user->can_add_photo) }}) {
                    messageMaxPhotos.style.display = 'block';
                    blocPaiement.style.display = 'block';
                    return;
                }

                    photoCount++;
                    const newRow = photosTable.insertRow();
                    newRow.className = 'photo-entry';
                    newRow.innerHTML = `
                        <td><input type="file" id="photo${photoCount}" name="photo[]" accept="image/*"></td>
                        <td><input type="text" id="description${photoCount}" name="description[]" placeholder="Description de la photo"></td>
                        <td><span class="remove-photo" style="cursor: pointer;">&times;</span></td>
                    `;    
                    updateRequiredAttribute();
                });

                photosTable.addEventListener('click', (event) => {
                    if (event.target.classList.contains('remove-photo')) {
                        const photoId = event.target.closest('.photo-entry').dataset.photoId;
                        if (photoId) {
                            photosToDeleteInput.value += photoId + ',';
                        }
                        event.target.closest('tr').remove();
                        photoCount--;
                        // ajouterPhotoBtn.style.display = (photoCount < 3) ? 'block' : 'none';
                        blocPaiement.style.display = (photoCount >= 3) ? 'block' : 'none';
                        messageMaxPhotos.style.display = 'none';
                        
                        updateRequiredAttribute();

                    }
                });
                fermerPaiement.addEventListener('click', () => {
                blocPaiement.style.display = 'none';
                });

                function updateRequiredAttribute() {
        const photoInputs = chefProfileForm.querySelectorAll('input[type="file"]');
        if (photoCount === 0) {
            photoInputs.forEach(input => input.setAttribute('required', true));
        } else {
            photoInputs.forEach(input => input.removeAttribute('required'));
        }
    }
            });

    </script>
    
</body>
</html>
