<x-adminapp-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Smart Attendance System Admin Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Admin Registration Form -->
            <section class="bg-white shadow-lg sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('User Registration') }}</h3>
                <form method="POST" action="{{ route('admin.register') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Name -->
                    <fieldset>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="Enter user's full name" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </fieldset>

                    <!-- Email -->
                    <fieldset>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="Enter user's email address" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </fieldset>

                    <!-- Matrix Number -->
                    <fieldset>
                        <x-input-label for="matrixno" :value="__('Matrix Number')" />
                        <x-text-input id="matrixno" class="block mt-1 w-full" type="text" name="matrixno" :value="old('matrixno')" placeholder="Enter user's matrix number" required autocomplete="matrixno" />
                        <x-input-error :messages="$errors->get('matrixno')" class="mt-2" />
                    </fieldset>

                    <!-- Fingerprint ID Selection -->
                    <fieldset>
                        <x-input-label for="fingerprint_id" :value="__('Fingerprint ID')" />
                        <select id="fingerprint_id" name="fingerprint_id" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                            <option value="">{{ __('Select Fingerprint ID') }}</option>
                            @foreach ($fingerprintIds as $fingerprintId)
                                <option value="{{ $fingerprintId }}">{{ $fingerprintId }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('fingerprint_id')" class="mt-2" />
                    </fieldset>

                    <!-- Face ID Selection -->
                    <fieldset>
                        <x-input-label for="new_face_id" :value="__('Face ID')" />
                        <select id="new_face_id" name="new_face_id" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                            <option value="">{{ __('Select Face ID') }}</option>
                            @foreach ($faceids as $faceid)
                                <option value="{{ $faceid }}">{{ $faceid }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('new_face_id')" class="mt-2" />
                    </fieldset>

                    <!-- Registration Button -->
                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            {{ __('Add') }}
                        </x-primary-button>
                    </div>
                </form>
            </section>

            <!-- Registered Users Table -->
            <section class="bg-white shadow-lg sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Registered Users') }}</h3>

                <!-- Search Bar -->
                <div class="mb-4">
                    <input id="search" type="text" placeholder="Search..." class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500" onkeyup="searchTable()">
                </div>

                <!-- Users Table -->
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border-collapse border border-gray-300 rounded-lg shadow-lg" id="usersTable">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Name') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Matrix Number') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Email') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Fingerprint ID') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Face ID') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @if ($users->isEmpty())
                                <tr>
                                    <td colspan="6" class="border border-gray-300 px-6 py-4 text-center">{{ __('No users found.') }}</td>
                                </tr>
                            @else
                                @foreach ($users as $user)
                                    @if ($user->role !== 'admin' && $user->role !== 'agent')
                                        <tr class="bg-white hover:bg-gray-100 border-b border-gray-200">
                                            <td class="border border-gray-300 px-6 py-4">{{ $user->name }}</td>
                                            <td class="border border-gray-300 px-6 py-4">{{ $user->matrixno }}</td>
                                            <td class="border border-gray-300 px-6 py-4">{{ $user->email }}</td>
                                            <td class="border border-gray-300 px-6 py-4">
                                                @if ($user->fingerprint_id)
                                                    <div class="bg-green-100 text-green-600 px-3 py-1 rounded-lg"> 
                                                        {{ __('Updated') }}
                                                    </div>
                                                @else
                                                    <div class="bg-red-100 text-red-600 px-3 py-1 rounded-lg">
                                                        {{ __('No Fingerprint') }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-6 py-4">
                                                @if ($user->new_face_id)
                                                    <div class="bg-green-100 text-green-600 px-3 py-1 rounded-lg"> 
                                                        {{ __('Updated') }}
                                                    </div>
                                                @else
                                                    <div class="bg-red-100 text-red-600 px-3 py-1 rounded-lg">
                                                        {{ __('No Face ID') }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-6 py-4">
                                                <div class="flex space-x-4">
                                                    <!-- Edit Button -->
                                                    <form method="GET" action="{{ route('admin.users.edit', $user->id) }}">
                                                        <x-primary-button>
                                                            <img src="{{ asset('logo/pen-putih.png') }}" alt="Edit Icon" class="h-6 w-6">
                                                        </x-primary-button>
                                                    </form>
                                        
                                                    <!-- Delete Button -->
                                                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this user?') }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <x-danger-button>
                                                            <img src="{{ asset('logo/tong-sampah.png') }}" alt="Delete Icon" class="h-6 w-6">
                                                        </x-danger-button>
                                                    </form>
                                                </div>
                                            </td>   
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </div>

    <!-- JavaScript for Search and Redirect -->
    <script>
        function searchTable() {
            const input = document.getElementById("search").value.toLowerCase();
            const table = document.getElementById("usersTable");
            const rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName("td");
                let found = false;

                for (let j = 0; j < cells.length; j++) {
                    const cell = cells[j];
                    if (cell) {
                        const text = cell.textContent || cell.innerText;
                        if (text.toLowerCase().indexOf(input) > -1) {
                            found = true;
                            break;
                        }
                    }
                }

                rows[i].style.display = found ? "" : "none";
            }
        }
    </script>

</x-adminapp-layout>
