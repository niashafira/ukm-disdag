<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link href="{{asset('template/vendors/mdi/css/materialdesignicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendors/base/vendor.bundle.base.css')}}" rel="stylesheet">
    <link href="{{asset('template/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('template/images/favicon.png')}}" rel="shortcut icon">
    <link href="{{asset('template/vendors/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    @yield('style')
  </head>
  <body>
    <div class="container-scroller">
				
    @include('template.navbar')
    <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
            <div class="content-wrapper">
                
                @yield('content')
                
                @include('template.footer')

            </div>
        </div>
    </div>

    <script src="{{asset('template/vendors/base/vendor.bundle.base.js')}}"></script>
    
    <script src="{{asset('template/js/template.js')}}"></script>

    <script src="{{asset('template/vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('template/vendors/progressbar.js/progressbar.min.js')}}"></script>
    <script src="{{asset('template/vendors/chartjs-plugin-datalabels/chartjs-plugin-datalabels.js')}}"></script>
    <script src="{{asset('template/vendors/justgage/raphael-2.1.4.min.js')}}"></script>
    <script src="{{asset('template/vendors/justgage/justgage.js')}}"></script>
    <script src="{{asset('template/js/dashboard.js')}}"></script>
    <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    @yield('script')
  </body>
</html>