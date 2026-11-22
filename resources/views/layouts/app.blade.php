<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>Client App</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            font-family:'Inter',sans-serif;
            background:#f4f6f9;
        }

        .navbar{
            background:#0f172a;
            padding:12px 25px;
            box-shadow:0 3px 12px rgba(0,0,0,.15);
        }

        .navbar-title{
            color:white;
            font-size:28px;
            font-weight:700;
            text-decoration:none;
        }

        .logo{
            height:80px;
            width:auto;
        }

        .container-box{
            max-width:3000px;
            margin:30px auto;
        }

        .card{
            border:none;
            border-radius:15px;
            box-shadow:0 5px 20px rgba(0,0,0,0.05);
        }
    </style>

    @stack('styles')
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar">

    <div class="container-fluid d-flex align-items-center">

        <!-- Logo gauche -->
        <div style="width:120px;">
       <img src="{{ asset('images/logo1.jpg') }}" class="logo">
     </div>

        <!-- Titre centre -->
        <div class="flex-grow-1 text-center">
            <a href="{{ route('services.index') }}" class="navbar-title">
                  CHILCOM SERVICE  
            </a>
        </div>

        <!-- Logo droite -->
        <div style="width:120px;" class="text-end">
                    <img src="{{ asset('images/logo1.jpg') }}" class="logo" alt="Logo">
                </div>

    </div>

</nav>

<!-- CONTENT -->
<div class="container-box">
    @yield('content')
</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@stack('scripts')

</body>
</html>