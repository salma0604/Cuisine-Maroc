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

        <form action="{{ route('cuisiniers.store') }}" method="POST" enctype="multipart/form-data" id="chefProfileForm">
            @csrf
            <div class="back-icons">
                <a href="javascript:history.go(-1);" class="retour-page"><i class="fas fa-arrow-left" style="color: #bb2337; margin-top:60px;"></i></a>
            </div>   
        <h2>Créer votre Profile</h2>
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
                    <td><input type="text" name="nom" value="{{old('nom')}}" placeholder="entrez votre nom"></td>
                </tr>
                <tr>
                    <td><label for="specialites">Spécialités :</label></td>
                    <td><input type="text" name="specialites" value="{{old('specialites')}}" placeholder="entrez votre Spécialités les Séparez par des virgules"></td>
                </tr>
                <tr>
                    <td><label for="disponibilite">Disponibilité :</label></td>
                    <td><input type="text"  name="disponibilite" value="{{old('disponibilite')}}" placeholder="entrez votre Disponibilité"></td>
                </tr>
                <tr>
                    <td><label for="ville">Ville :</label></td>
                    <td><input type="text" name="ville" value="{{old('lieuTravail')}}" placeholder="entrez votre Ville"></td>
                </tr>
                
                <tr>
                    <td><label for="lieuTravail">Lieu de travail :</label></td>
                    <td><input type="text" name="lieuTravail" value="{{old('lieuTravail')}}" placeholder="entrez votre Lieu de travail"></td>
                </tr>
                <tr>
                    <td><label for="prix">prix :</label></td>
                    <td><input type="text"  name="prix" value="{{old('prix')}}"  placeholder="entrez votre prix"></td>
                </tr>
                <tr>
                    <td><label for="tele">N de telephone:</label></td>
                    <td><input type="text" name="tele" value="{{old('tele')}}"  placeholder="entrez votre N de telephone"></td>
                </tr>
                <tr>
                    <td><label for="email">Email :</label></td>
                    <td><input type="text"  name="email" value="{{old('email')}}"  placeholder="entrez votre Email"></td>
                </tr>

                <!-- Photos -->
                <tr>
                    <td>Photos de votre plats :</td>

                    <td colspan="">
                        <table id="photosTable">
                            <!-- Initial photo entry -->
                            <tr class="photo-entry">
                                <td><input type="file" id="photo1" name="photo[]" accept="image/*" ></td>
                                <td><input type="text" id="description1" name="description[]" placeholder="Description de la photo" ></td>
                                <td><span class="remove-photo" style="cursor: pointer; float: right;">&times;</span></td>
                            </tr>
                        </table>
                        <button type="button" id="ajouterPhoto" style="background-color: transparent; border: none;"><i class="fa-solid fa-plus" style="color: #bb2337;"></i>Ajouter Photo</button>

                        <div id="messageMaxPhotos" style="display: none; color: red;">
                            Le nombre maximum de photos a été atteint. Veuillez supprimer une photo pour en ajouter une nouvelle, ou effectuer le paiement.
                        </div>
                    </td>
                </tr>
                <!-- Vidéos -->
                {{-- <tr>
                    <td>Vidéos de votre plats:</td>

                    <td colspan="2">
                        <table id="videosTable">
                            <!-- Initial video entry -->
                            <tr class="video-entry">
                                <td><input type="file" id="video1" name="video[]" accept="video/*" multiple></td>
                                <td><input type="text" id="videoDescription1" name="videoDescription[]" placeholder="Description de la vidéo" ></td>
                                <td><span class="remove-video" style="cursor: pointer; float: right;">&times;</span></td>
                            </tr>
                        </table>
                        <button type="button" id="ajouterVideo" style="background-color: transparent; border: none;"><i class="fa-solid fa-plus" style="color: #bb2337;"></i>Ajouter Vidéo</button>

                        <div id="messageMaxVideos" style="display: none; color: red;">
                            Le nombre maximum de vidéos a été atteint. Veuillez supprimer une vidéo pour en ajouter une nouvelle, ou effectuer le paiement.
                        </div>
                    </td>
                </tr> --}}
                <!-- Paiement -->
                
                <tr>
                    <td></td>
                    <td><button type="submit">Créer Profil</button></td>
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
        const ajouterPhotoBtn = document.getElementById('ajouterPhoto');
        const ajouterVideoBtn = document.getElementById('ajouterVideo');
        const photosTable = document.getElementById('photosTable');
        const videosTable = document.getElementById('videosTable');
        const messageMaxPhotos = document.getElementById('messageMaxPhotos');
        const messageMaxVideos = document.getElementById('messageMaxVideos');
        
        let photoCount = 1;
        let videoCount = 1;
    
 

        ajouterPhotoBtn.addEventListener('click', () => {
            if (photoCount >= 3 && !{{ json_encode($user->can_add_photo) }}) {
                const blocPaiement = document.getElementById('bloc-paiement');
                messageMaxPhotos.style.display = 'block';
                blocPaiement.style.display = 'block';
                fermerPaiement.addEventListener('click', () => {
                blocPaiement.style.display = 'none';
                });
                return;
            }
            
            photoCount++;
            const newRow = photosTable.insertRow();
            newRow.className = 'photo-entry';
            newRow.innerHTML = `
                <td><input type="file" id="photo${photoCount}" name="photo[]" accept="image/*" ></td>
                <td><input type="text" id="description${photoCount}" name="description[]" placeholder="Description de la photo" ></td>
                <td><span class="remove-photo" style="cursor: pointer; float: right;">&times;</span></td>
            `;
        });
    
        photosTable.addEventListener('click', (event) => {
            if (event.target.classList.contains('remove-photo')) {
                event.target.closest('tr').remove();
                photoCount--;
                messageMaxPhotos.style.display = 'none';
            }
        });

        ajouterVideoBtn.addEventListener('click', () => {
            if (videoCount >= 3) {
                const blocPaiement = document.getElementById('bloc-paiement');
                messageMaxVideos.style.display = 'block';
                blocPaiement.style.display = 'block';
                fermerPaiement.addEventListener('click', () => {
                blocPaiement.style.display = 'none';
                });
                return;
            }
            
            videoCount++;
            const newRow = videosTable.insertRow();
            newRow.className = 'video-entry';
            newRow.innerHTML = `
                <td><input type="file" id="video${videoCount}" name="video[]" accept="video/*" ></td>
                <td><input type="text" id="videoDescription${videoCount}" name="videoDescription[]" placeholder="Description de la vidéo" ></td>
                <td><span class="remove-video" style="cursor: pointer; float: right;">&times;</span></td>
            `;
        });

        videosTable.addEventListener('click', (event) => {
            if (event.target.classList.contains('remove-video')) {
                event.target.closest('tr').remove();
                videoCount--;
                messageMaxVideos.style.display = 'none';
            }
        });
    </script>
    
</body>
</html>
