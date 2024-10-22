<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Edit User</title>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit User</h2>

                <!-- Main Form for Editing User -->
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6" id="editUserForm">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <fieldset>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <div class="mt-1 relative">
                            <input id="name" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-500 sm:text-sm" type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Enter user's full name" required autofocus autocomplete="name">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </fieldset>

                    <!-- Email Address -->
                    <fieldset>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <div class="mt-1 relative">
                            <input id="email" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-500 sm:text-sm" type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Enter user's email" required>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </fieldset>

                    <!-- Matrix Number -->
                    <fieldset>
                        <label for="matrixno" class="block text-sm font-medium text-gray-700">Matrix Number</label>
                        <input id="matrixno" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-500 sm:text-sm" type="text" name="matrixno" value="{{ old('matrixno', $user->matrixno) }}" placeholder="Enter matrix number" required>
                        <x-input-error :messages="$errors->get('matrixno')" class="mt-2" />
                    </fieldset>

                    <!-- Fingerprint ID Selection -->
                    <fieldset>
                        <label for="fingerprint_id" class="block text-sm font-medium text-gray-700">Fingerprint ID</label>
                        <select id="fingerprint_id" name="fingerprint_id" class="block w-full mt-1 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                            <option value="" disabled>Select Fingerprint ID</option>
                            <option value="">None</option> <!-- Optional None option -->
                            @foreach ($availableFingerprintIds as $fingerprintId)
                                <option value="{{ $fingerprintId }}" {{ old('fingerprint_id', $user->fingerprint_id) == $fingerprintId ? 'selected' : '' }}>
                                    {{ $fingerprintId }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('fingerprint_id')" class="mt-2" />
                    </fieldset>

                    <!-- Face ID Selection -->
                    <fieldset>
                        <label for="new_face_id" class="block text-sm font-medium text-gray-700">Face ID</label>
                        <select id="new_face_id" name="new_face_id" class="block w-full mt-1 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                            <option value="" disabled>Select Face ID</option>
                            <option value="">None</option> <!-- Optional None option -->
                            @foreach ($availablefaceids as $faceid)
                                <option value="{{ $faceid }}" {{ old('new_face_id', $user->new_face_id) == $faceid ? 'selected' : '' }}>
                                    {{ $faceid }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('new_face_id')" class="mt-2" />
                    </fieldset>

                    <!-- Action Buttons -->
                    <div class="col-span-full flex items-center justify-between mt-6">
                        <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                            Back
                        </a>

                        <div class="flex space-x-3">
                            <!-- Save Button -->
                            <button type="submit" form="editUserForm" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('preview');
                preview.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>
