<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" value="{{ csrf_token() }}">
    <title>MiniPOS 8</title>
    @vite('resources/css/app.css')

    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Icons. Uncomment required icon fonts -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css">
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css">
    <link rel="stylesheet" href="assets/css/demo.css">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
    
    <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css">

    <link rel="stylesheet" href="assets/css/font_lao.css">

</head>
<body>

  @if(Auth::check())
      @php 
        $user_auth_data = [
          'isLoggin'=> true,
          'user'=> Auth::user()
          ];
      @endphp

    @else
    @php 
    $user_auth_data = [
          'isLoggin'=> false,
          'user'=> Auth::user()
          ];
      @endphp
    @endif

    <script>
          window.Laravel = JSON.parse(atob('{{ base64_encode(json_encode($user_auth_data)) }}'));
    </script>

    <div id="app-vue"></div>

    <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="assets/vendor/libs/jquery/jquery.js"></script>
  <script src="assets/vendor/libs/popper/popper.js"></script>
  <script src="assets/vendor/js/bootstrap.js"></script>
  <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  
  <script src="assets/vendor/js/menu.js"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>

  <!-- Main JS -->
  <script src="assets/js/main.js"></script>

  <!-- Page JS -->
  <script src="assets/js/dashboards-analytics.js"></script>


    @vite('resources/js/app.js')
</body>
</html>