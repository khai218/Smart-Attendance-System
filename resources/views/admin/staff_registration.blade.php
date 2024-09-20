<x-adminapp-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Registration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6">

                <!-- Staff Registration Form -->
                <div class="lg:w-1/3 bg-white shadow-lg sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Register New Staff') }}</h3>
                    <form method="POST" action="{{ route('staff.register') }}" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <fieldset>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="Enter staff's name" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </fieldset>

                        <!-- Email Address -->
                        <fieldset>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="Enter staff's email address" required autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </fieldset>

                        <!-- Registration Button -->
                        <div class="flex items-center justify-between mt-6">
                            <x-primary-button>
                                {{ __('Add') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                <!-- Registered Staff List -->
                <div class="lg:w-2/3 bg-white shadow-lg sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Registered Staff') }}</h3>

                    <!-- Search Bar -->
                    <div class="mb-4">
                        <input id="search" type="text" placeholder="Search..." class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" onkeyup="searchTable()">
                    </div>

                    <!-- Staff Table -->
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full border-collapse border border-gray-200" id="staffTable">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-200 px-4 py-2 text-left">{{ __('Name') }}</th>
                                    <th class="border border-gray-200 px-4 py-2 text-left">{{ __('Email') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users->isEmpty())
                                    <tr>
                                        <td colspan="2" class="border border-gray-200 px-4 py-2 text-center">{{ __('No staff found.') }}</td>
                                    </tr>
                                @else
                                    @foreach ($users as $user)
                                        @if ($user->role === 'agent')
                                            <tr class="bg-white hover:bg-gray-50 h-12">
                                                <td class="border border-gray-200 px-4 py-2">{{ $user->name }}</td>
                                                <td class="border border-gray-200 px-4 py-2">{{ $user->email }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Real-Time Search -->
    <script>
        function searchTable() {
            const input = document.getElementById("search");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("staffTable");
            const rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) { // Start from 1 to skip the header row
                const row = rows[i];
                const cells = row.getElementsByTagName("td");
                let found = false;

                for (let j = 0; j < cells.length; j++) {
                    const cell = cells[j];
                    if (cell) {
                        const textValue = cell.textContent || cell.innerText;
                        if (textValue.toLowerCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }

                if (found) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        }
    </script>
</x-adminapp-layout>
