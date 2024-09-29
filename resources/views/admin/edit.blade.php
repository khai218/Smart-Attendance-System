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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Edit User</h2>
                
                <!-- Main Form for Editing User -->
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data" class="space-y-6" id="editUserForm">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <fieldset>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-500 sm:text-sm" type="text" name="name" :value="old('name', $user->name)" placeholder="Enter user's full name" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </fieldset>

                    <!-- Email Address -->
                    <fieldset>
                        <x-input-label for="email" :value="__('Email')" />
                        <input id="email" class="block mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-500 sm:text-sm" type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Enter user's email" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </fieldset>

                    <!-- Matrix Number -->
                    <fieldset>
                        <x-input-label for="matrixno" :value="__('Matrix Number')" />
                        <input id="matrixno" class="block mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-indigo-600 focus:ring-indigo-500 sm:text-sm" type="text" name="matrixno" value="{{ old('matrixno', $user->matrixno) }}" placeholder="Enter matrix number" required />
                        <x-input-error :messages="$errors->get('matrixno')" class="mt-2" />
                    </fieldset>

                    <!-- Fingerprint ID Selection -->
                    <fieldset>
                        <x-input-label for="fingerprint_id" :value="__('Fingerprint ID')" />
                        <select id="fingerprint_id" name="fingerprint_id" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                            <option value="" disabled>{{ __('Select Fingerprint ID') }}</option>
                            <option value="">{{ __('None') }}</option> <!-- Optional None option -->
                            @foreach ($fingerprintIds as $fingerprintId)
                                <option value="{{ $fingerprintId }}" {{ old('fingerprint_id', $user->fingerprint_id) == $fingerprintId ? 'selected' : '' }}>
                                    {{ $fingerprintId }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('fingerprint_id')" class="mt-2" />
                    </fieldset>

                    <!-- Current Image Display -->
                    <fieldset>
                        <x-input-label for="current_image" :value="__('Current Image')" />
                        @if($user->image) <!-- Check if the user has an image -->
                            <img src="{{ asset('path/to/images/' . $user->image) }}" alt="Current Image" class="mt-4 rounded-lg shadow-lg max-w-xs" />
                        @else
                            <p class="mt-2 text-gray-600">{{ __('No image uploaded') }}</p>
                        @endif
                        <x-input-label for="image" :value="__('Upload New Image (if any)')" />
                        <input id="image" class="block mt-1 w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 focus:border-indigo-600" type="file" name="image" accept="image/*" onchange="previewImage(event)" />
                        <img id="preview" class="mt-4 rounded-lg shadow-lg max-w-xs" />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </fieldset>

                    <!-- Back, Save, and Delete Buttons -->
                    <div class="flex items-center justify-between">
                        <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                            {{ __('Back') }}
                        </a>

                        <div class="flex space-x-3">
                            <!-- Save Button -->
                            <button type="submit" form="editUserForm" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                                {{ __('Save Changes') }}
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
