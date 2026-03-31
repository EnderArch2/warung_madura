<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('layout/assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="https://img1.picmix.com/output/stamp/normal/1/6/0/4/2544061_df45b.png">
  <title>Warung Madura - Authentication</title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="{{ asset('layout/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('layout/assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="{{ asset('layout/assets/css/soft-ui-dashboard.css?v=1.0.7') }}" rel="stylesheet" />
</head>

<body class="bg-gray-100">
  <div class="min-vh-100 d-flex align-items-center justify-content-center py-4">
    @yield('auth')
  </div>
</body>

</html>
