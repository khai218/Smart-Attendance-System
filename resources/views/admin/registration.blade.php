<x-adminapp-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Smart Attendance System Admin Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- User Registration Form -->
            <div class="bg-white shadow-lg sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('User Registration') }}</h3>
                <form method="POST" action="{{ route('admin.register') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <fieldset>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="Enter user's full name" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </fieldset>

                    <!-- Email Address -->
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
                        <x-input-label for="fingerprint_id" :value="old(__('Fingerprint ID'))" />
                        <select id="fingerprint_id" name="fingerprint_id" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                            <option value="">{{ __('Select Fingerprint ID') }}</option>
                            @foreach ($fingerprintIds as $fingerprintId)
                                <option value="{{ $fingerprintId }}">{{ $fingerprintId }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('fingerprint_id')" class="mt-2" />
                    </fieldset>

                    <!-- Image Upload -->
                    <fieldset>
                        <x-input-label for="image" :value="old(__('Upload Image'))" />
                        <input id="image" class="block mt-1 w-full" type="file" name="image" accept="image/*" />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </fieldset>

                    <!-- Registration Button -->
                    <div class="flex items-center justify-between mt-6">
                        <x-primary-button class="ml-4">
                            {{ __('Add') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Registered Users Table -->
            <div class="bg-white shadow-lg sm:rounded-lg p-6">
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
                                <th class="border border-gray-300 px-6 py-3 text-left min-w-[150px]">{{ __('Name') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left min-w-[120px]">{{ __('Matrix Number') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left min-w-[180px]">{{ __('Email') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left min-w-[160px]">{{ __('Fingerprint ID') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left min-w-[130px]">{{ __('Image') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left min-w-[130px]">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @php
                                $nonAdminUsers = $users->filter(function ($user) {
                                    return $user->role !== 'admin' && $user->role !== 'agent';
                                });
                            @endphp

                            @if ($nonAdminUsers->isEmpty())
                                <tr>
                                    <td colspan="6" class="border border-gray-300 px-6 py-4 text-center">{{ __('No users found.') }}</td>
                                </tr>
                            @else
                                @foreach ($nonAdminUsers as $user)
                                    <tr class="bg-white hover:bg-gray-100 border-b border-gray-200">
                                        <td class="border border-gray-300 px-6 py-4">{{ $user->name }}</td>
                                        <td class="border border-gray-300 px-6 py-4">{{ $user->matrixno }}</td>
                                        <td class="border border-gray-300 px-6 py-4">{{ $user->email }}</td>
                                        <td class="border border-gray-300 px-6 py-4">
                                            @if($user->fingerprint_id)
                                                <div class="bg-green-100 text-green-600 px-3 py-1 rounded-lg"> 
                                                    <span>Updated</span>
                                                </div>
                                            @else
                                                <div class="bg-red-100 text-red-600 px-3 py-1 rounded-lg">
                                                    <span>No Fingerprint</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 px-6 py-4">
                                            @if($user->image)
                                                <x-primary-button onclick="openModal('{{ asset('storage/'.$user->image) }}')">
                                                    <img src="{{ asset('logo/mata-putih.png') }}" alt="View Icon" class="h-6 w-6">
                                                </x-primary-button>
                                            @else
                                                <div class="bg-red-100 text-red-600 px-3 py-1 rounded-lg">
                                                    <span>No Image</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 px-6 py-4">
                                            <div class="flex">
                                                <form method="GET" action="{{ route('admin.users.edit', $user->id) }}">
                                                    <x-primary-button>
                                                        <img src="{{ asset('logo/pen-putih.png') }}" alt="Edit Icon" class="h-6 w-6">
                                                    </x-primary-button>
                                                </form>

                                                <div class="px-2"> <!-- Padding on the left and right of the vertical line -->
                                                    <div class="vl"></div> <!-- Vertical line -->
                                                </div>

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
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <style>
        .vl {
            border-left: 3px solid white;
            height: 1rem;
        }
    </style>

    <!-- JavaScript for Search and Redirect -->
    <script>
        function openModal(imageUrl) {
            window.location.href = `/image-viewer?imageUrl=${encodeURIComponent(imageUrl)}`;
        }

        function searchTable() {
            const input = document.getElementById("search");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("usersTable");
            const tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {
                let tdName = tr[i].getElementsByTagName("td")[0];
                let tdMatrix = tr[i].getElementsByTagName("td")[1];
                let tdEmail = tr[i].getElementsByTagName("td")[2];

                if (tdName || tdMatrix || tdEmail) {
                    const txtValueName = tdName.textContent || tdName.innerText;
                    const txtValueMatrix = tdMatrix.textContent || tdMatrix.innerText;
                    const txtValueEmail = tdEmail.textContent || tdEmail.innerText;

                    if (txtValueName.toLowerCase().indexOf(filter) > -1 || txtValueMatrix.toLowerCase().indexOf(filter) > -1 || txtValueEmail.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }       
            }
        }
    </script>

</x-adminapp-layout>
