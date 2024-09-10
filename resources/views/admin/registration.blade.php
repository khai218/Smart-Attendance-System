<x-adminapp-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Smart Attendance System Admin Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Flexbox container for form and table, arranged horizontally -->
            <div class="flex flex-row gap-6">

                <!-- Admin Registration Form -->
                <div class="w-2/5 bg-white shadow-lg sm:rounded-lg p-6">
                    <div class="kotak">
                        <form method="POST" action="{{ route('admin.register') }}" class="space-y-6">
                            @csrf

                            <!-- Form Title -->
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Admin Registration Form') }}</h3>

                            <!-- Name -->
                            <fieldset>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="Enter your full name" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </fieldset>

                            <!-- Email Address -->
                            <fieldset class="mt-4">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="Enter your email address" required autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </fieldset>

                            <!-- Matrix Number -->
                            <fieldset class="mt-4">
                                <x-input-label for="matrixno" :value="__('Matrix Number')" />
                                <x-text-input id="matrixno" class="block mt-1 w-full" type="text" name="matrixno" :value="old('matrixno')" placeholder="Enter your matrix number" required autocomplete="matrixno" />
                                <x-input-error :messages="$errors->get('matrixno')" class="mt-2" />
                            </fieldset>

                            <!-- Registration Button -->
                            <div class="flex items-center justify-between mt-6">
                                <x-primary-button class="ml-4">
                                    {{ __('Add') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Registered Users Table (With Filter and without Role Column) -->
                <div class="w-3/5 bg-white shadow-lg sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Registered Users') }}</h3>
                    <div class="overflow-y-auto max-h-96">
                        <table class="table-auto w-full mt-4 border-collapse border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-200 px-4 py-2 text-left min-w-[150px]">{{ __('Name') }}</th>
                                    <th class="border border-gray-200 px-4 py-2 text-left min-w-[120px]">{{ __('Matrix Number') }}</th>
                                    <th class="border border-gray-200 px-4 py-2 text-left min-w-[180px]">{{ __('Email') }}</th>
                                    <th class="border border-gray-200 px-4 py-2 text-left min-w-[160px]">{{ __('Email Verified At') }}</th>
                                    <th class="border border-gray-200 px-4 py-2 text-left min-w-[130px]">{{ __('Fingerprint ID') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $nonAdminUsers = $users->filter(function ($user) {
                                        return $user->role !== 'admin';
                                    });
                                @endphp
                                @if ($nonAdminUsers->isEmpty())
                                    <tr>
                                        <td colspan="5" class="border border-gray-200 px-4 py-2 text-center">{{ __('No users found.') }}</td>
                                    </tr>
                                @else
                                    @foreach ($nonAdminUsers as $user)
                                        <tr class="bg-white hover:bg-gray-50 h-12">
                                            <td class="border border-gray-200 px-4 py-2">{{ $user->name }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $user->matrixno }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $user->email }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $user->email_verified_at }}</td>
                                            <td class="border border-gray-200 px-4 py-2">{{ $user->fingerprint_id }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-adminapp-layout>
