<!DOCTYPE html>
<html>
<head>
    <title>Test View</title>
</head>
<body>
    <h1>Fingerprint IDs</h1>
    <ul>
        @foreach ($fingerprintIds as $id)
            <li>{{ $id }}</li>
        @endforeach
    </ul>
</body>
</html>
