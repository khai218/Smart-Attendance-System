<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>User Image Viewer</title>
</head>
<body class="bg-gray-100">
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden p-6"> <!-- Added padding for the box -->
                <img src="{{ $imageUrl }}" alt="User Image" class="w-1/2 h-auto mx-auto my-4 rounded-lg shadow-lg object-cover" />
                <div class="flex justify-center mb-4">
                    <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 text-white rounded-lg shadow hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H3m0 0l6 6m-6-6l6-6" />
                        </svg>
                        {{ __('Back') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
