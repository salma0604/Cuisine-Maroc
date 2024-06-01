
<x-sign>
    <form action="{{route('loginpage.process')}}" method="POST" class="signin-form">
        @csrf
        <h2>Connexion</h2>
        @error('email')
        <div style="color: red">{{$message}}</div>
        @enderror
        <div class="input-bx">
            
            <input type="text"   placeholder="Email" name="email">
            <i class="fa-solid fa-envelope"></i>
        </div>
        
        <div class="input-bx">
            <input type="password"   placeholder="Mot de passe" name="password">
            <i class="fa-solid fa-key"></i>
            <p>Mot de passe oublié ?</p>
        </div>

        <button class="btn-signin" type="submit"> Se connecter <i class="fa-solid fa-right-to-bracket"></i></button>

        <div class="option-text"><hr><p>ou connectez-vous</p></div>

        <div class="button-group">
             <a href="/auth/google" class="btn-google"><img src="/images/google.png" alt="" class="img"><p> avec Google</p></a>
            {{-- <a href="/auth/facebook"><img src="/images/facebook.png" alt="" class="img"></a>  --}}
        </div>

        <p class="message"><a href="{{ route('login.create') }}">Pas encore un compte ? Cliquez ici</a></p>
    </form>
</x-sign>
