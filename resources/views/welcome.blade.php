<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Attendance System</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            position: relative;
            background-color: #f0f0f0;
            overflow: hidden; /* Prevent scrollbars */
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
            z-index: -1; /* Send background behind the content */
        }
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 4rem; /* Increased padding */
            width: 100%;
            max-width: 400px; /* Adjust container width */
            background: white;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); /* Slightly larger shadow */
            text-align: center;
        }
        .logo img {
            height: 130px; /* Adjusted logo size */
            width: auto;
            margin-bottom: 1.5rem; /* Space between logo and divider */
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
            transform: translateY(-2px); /* Lift effect */
        }
        .button-custom:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(31, 41, 55, 0.3); /* Focus ring */
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
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="button-custom">Register</a>
                    @endif
                @endauth
            </div>
        </div>
    @endif
</body>
</html>



