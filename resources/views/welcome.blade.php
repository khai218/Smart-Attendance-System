<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Smart Attendance System</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('logo/icon-poli-removebg.png') }}" type="image/png" sizes="16x16">

    <!-- Include the Inter font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: 'Inter', sans-serif;
            position: relative;
            background-color: #f0f0f0;
            overflow: hidden;
            overflow-x: hidden;
        }
        .background-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('background/gunung.jpg') }}');
            background-size: cover;
            background-position: center;
            opacity: 0.4;
            z-index: -1;
            transition: opacity 0.5s;
        }
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 4rem;
            width: 100%;
            max-width: 400px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            text-align: center;
            position: relative;
            z-index: 1;
        }
        .logo img {
            height: 130px;
            width: auto;
            margin-bottom: 1.5rem;
            transition: transform 0.5s;
        }
        hr {
            width: 100%;
            border: none;
            border-top: 1px solid #ccc;
            margin: 1rem 0;
        }
        .button-group {
            display: flex;
            justify-content: center;
            gap: 1rem; /* Space between buttons */
            margin-top: 1.5rem;
        }
        .button-custom {
            display: inline-block;
            padding: 0.75rem 2rem;
            font-size: 1rem;
            color: white;
            background-color: rgba(31, 41, 55, 1);
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.3s;
        }
        .button-custom:hover {
            background-color: rgba(31, 41, 55, 0.8);
            transform: translateY(-5px);
        }
        .button-custom:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(31, 41, 55, 0.3);
        }
    </style>
</head>
<body>
    <div class="background-image"></div>
    @if (Route::has('login'))
        <div class="container">
            <div class="logo">
                <img src="{{ asset('logo/icon-poli.png') }}" alt="Logo">
            </div>
            <hr>
            <div class="button-group">
                @auth
                    <a href="{{ url('/dashboard') }}" class="button-custom">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="button-custom">Log in</a>
                @endauth
            </div>
        </div>
    @endif

    <script>
        // Parallax effect for background
        window.addEventListener('scroll', function() {
            const backgroundImage = document.querySelector('.background-image');
            let scrollPosition = window.scrollY;
            backgroundImage.style.transform = `translateY(${scrollPosition * 0.5}px)`;
        });

        // Logo bounce effect on load
        window.addEventListener('load', function() {
            const logo = document.querySelector('.logo img');
            logo.style.transform = 'scale(1.1)';
            setTimeout(() => {
                logo.style.transform = 'scale(1)';
            }, 1000);
        });
    </script>
</body>
</html>



