@if (session()->has('success'))
        <x-alert type="success">
                <i class='fas fa-check-circle check-icon'  style ='color:#008cff' ></i> {{session("success")}}
        </x-alert>
@endif