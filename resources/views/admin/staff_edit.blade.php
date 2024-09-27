<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Edit Staff</title>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Edit User</h2>
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data" class="space-y-6">
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

                    <!-- Back, Save, and Delete Buttons -->
                    <div class="flex items-center justify-between">
                        <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                            {{ __('Back') }}
                        </a>

                        <div class="flex space-x-3">
                            <!-- Delete Button -->
                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this user?')" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 transition ease-in-out duration-150">
                                    {{ __('Delete') }}
                                </button>
                            </form>

                            <!-- Save Button -->
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                                {{ __('Save Changes') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
