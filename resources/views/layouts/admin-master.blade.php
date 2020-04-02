<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{env('APP_NAME')}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/img/icon-freshbox.png')}}">
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css')}}">
    <link rel="stylesheet" href="{{ asset('css/custom.css')}}">
    @stack('css')
</head>

<body>
<div id="app">
    <div class="main-wrapper">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            @include('admin.partials.topnav')
        </nav>
        <div class="main-sidebar">
            @include('admin.partials.sidebar')
        </div>

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
        <footer class="main-footer">
            @include('admin.partials.footer')
        </footer>
    </div>
</div>

<script src="{{ route('js.dynamic') }}"></script>
<script src="{{ asset('js/app.js') }}?{{ uniqid() }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/nicesrcoll.min.js') }}"></script>
<script src="{{ asset('assets/js/stisla.js') }}"></script>
<script src="{{ asset('assets/js/scripts.js') }}"></script>
{{--
<script type="text/javascript">
    $("#select_all").change(function(){
        var status = this.checked;
        $('.checkbox').each(function(){
            this.checked = status;
            if(this.checked = status){
                $("#printcheckbox").show();
             }
             else{
                $("#printcheckbox").hide();

             }
        });

    });
    $('.checkbox').change(function(){
        if(this.checked == false){
            $("#select_all")[0].checked = false;
        }
        if ($('.checkbox:checked').length == $('.checkbox').length ){
            $("#select_all")[0].checked = true;

            $("#printcheckbox").hide();

        }
       $count = document.querySelectorAll("input:checked").length;

       if($count>0){
         $("#printcheckbox").show();
       }
       else{
         $("#printcheckbox").hide();
       }
    });
</script> --}}

@stack('js')
</body>

</html>
