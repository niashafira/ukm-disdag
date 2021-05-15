<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <style>
        .footer {
           position: fixed;
           bottom: 0;
           width: 100%;
        }
    </style>
    <link rel="canonical" href="https://keenthemes.com/metronic" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{asset('template-metronics/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('template-metronics/assets/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('template-metronics/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('lib/sweetalert2/sweetalert2.min.css') }}" />

    {{-- <link href="{{asset('css/jquery-ui.css')}}" rel="stylesheet" type="text/css" /> --}}


</head>
<body style="background: url({{ asset('images/bg-login.png') }}); background-repeat: no-repeat; background-size: cover;">
    <div class="container" id="app">
        <div class="row">
            <div class="col-md-12" style="margin-top: 1%; margin-left: 0">
                <img src="{{ asset('images/pemkot-logo.png') }}" width="70px">
            </div>
        </div>
        <div class="col-md-4 offset-md-4" style="margin-top: 2rem">
            <div class="card" style="background-color: #eceaea; box-shadow: 2px 2px #888888;">
                <div class="card-header">
                    <h5 class="text-center">SISTEM MANAJEMEN UMKM</h5>
                </div>
                <form id="loginForm">
                <div class="card-body">
                    <div class="form-group">
                        <input v-on:keyup.enter="submitLogin()" v-model="username" name="username" style="border-radius: 20px" type="text" class="form-control form-control-sm" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input v-on:keyup.enter="submitLogin()" v-model="password" name="password" style="border-radius: 20px" type="password" class="form-control form-control-sm" placeholder="Password">
                    </div>
                    <button v-on:click="submitLogin()" style="border-radius: 20px; height: 35px; background-color: #003179; color: white;" type="button" class="btn btn-primary btn-sm btn-block"><span class="fa fa-door-open"></span> Login</button>
                </div>
                </form>
            </div>
        </div>
        <div class="footer">
            <p>2021 © Dinas Perdagangan Surabaya</p>
        </div>
    </div>

    <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#663259", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#F4E1F0", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
    <script src="{{asset('template-metronics/assets/plugins/global/plugins.bundle.js')}}"></script>
    <script src="{{asset('template-metronics/assets/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
    <script src="{{asset('template-metronics/assets/js/scripts.bundle.js')}}"></script>
    <script src="{{asset('lib/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous"></script>

    @include('loginJs')


</body>
</html>
