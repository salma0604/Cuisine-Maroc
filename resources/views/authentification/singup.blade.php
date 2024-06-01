<x-sign>
    <form action="{{route('login.store')}}" method="POST" class="signup-form">
        @csrf

        <h2>Inscription</h2>
       


        @error('nom')
        <div  style="color: red ;  ">{{$message}}</div>
        @enderror
        <div class="input-bx">
            
            <input type="text" id="signupUsername"  placeholder="Nom d'utilisateur" name="nom">
            <i class="fa-solid fa-user"></i>
        </div>
        @error('email')
            <div style="color: red ; ">{{$message}}</div>
            @enderror
        <div class="input-bx">
            
            <input type="text" id="signupEmail"  placeholder="Email" name="email">
            <i class="fa-solid fa-envelope"></i>
        </div>
        @error('password')
            <div  style="color: red ; ">{{$message}}</div>
            @enderror
        <div class="input-bx">
            
            <input type="password" id="signupPassword"  placeholder="Mot de passe" name="password">
            <i class="fa-solid fa-key"></i>
            
        </div>
        <div class="input-bx">
           
            <input type="password" id="signupPassword"  placeholder="Confirmer le Mot de passe" name="password_confirmation">
            <i class="fa-solid fa-key"></i>
            
        </div>

        <button class="btn-signin" type="submit"> S'inscrire <i class="fa-solid fa-user-plus"> </i></button>

        <div class="option-text"><hr><p> ou s'inscrire </p></div>

        <div class="button-group">
              <a href="/auth/google" class="btn-google"><img src="/images/google.png" alt="" class="img" ><p> avec Google</p></a>
            {{-- <a href="/auth/facebook"><img src="/images/facebook.png" alt="" class="img"></a> --}}
        </div>

        <p class="message"><a href="{{ route('loginpage') }}">Déjà un compte ? Cliquez ici</a></p>
    </form>
</x-sign>