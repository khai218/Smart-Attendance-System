<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Smart Attendance System</title>
    <style>
        /* Add general email styling here if needed */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body style="background-color: #edf2f7;">
    <br>
    <br>
    <div style="max-width: 300px; margin: auto; padding: 20px; background: #ffffff; border-radius: 2%; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        <header style="text-align: center; margin-bottom: 20px;">
            <img src="{{ $message->embed(public_path().'/logo/icon-poli.png') }}" alt="Politeknik Kuching Sarawak's Logo" width="200" height="70" style="display: block; margin: 0 auto;">
        </header>

        <p style="color: #555; font-size: 16px; line-height: 1.5;">Hi, {{$user->name}}</p>
        <p style="color: #555; font-size: 16px; line-height: 1.5;">Thank you for registering with Smart Attendance System! Please verify your email address by clicking the button below.</p>

        <div style="text-align: center; margin: 20px 0;">
            <a href="{{$url}}" style="display: inline-block; background-color: #007bff; color: #ffffff; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold;">Verify Your Email Address</a>
        </div>
        <hr>
        <p style="color: #686D76; font-size: 14px; line-height: 1.5;">If you have any questions, please feel free to contact us at <a href="mailto:khairukazhar2004@gmail.com" style="color: #007bff; text-decoration: none;">khairukazhar2004@gmail.com</a> or visit our FAQ page: <a href="http://www.poliku.edu.my" style="color: #007bff; text-decoration: none;">http://www.poliku.edu.my</a></p>
    </div>
    <footer style="text-align: center; margin-top: 20px; color: #777; font-size: 14px;">
        <p>&copy; Politeknik Kuching Sarawak {{ date('Y') }}</p>
        <br>
    </footer>
</body>

</html>

