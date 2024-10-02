<x-adminapp-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Smart Attendance System Admin Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6">

                @if($events->isNotEmpty())
                <div class="lg:w-2/3">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($events as $event)
                        <div class="bg-white shadow-lg sm:rounded-lg p-6 border border-gray-200 flex flex-col">
                            <!-- Event Heading -->
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Current Events:') }}</h3>
                            <hr>
                            <br>
                            <!-- Event Details -->
                            <div>
                                <h4 class="font-semibold text-xl text-gray-800">{{ $event->name }}</h4>
                                <p class="mt-2">Location: {{ $event->location }}</p>
                                <p class="mt-1">Date/Time: {{ \Carbon\Carbon::parse($event->time_held)->format('d M Y, H:i') }}</p>
                            </div>
                
                            <!-- Buttons -->
                            <div class="flex flex-col mt-4">
                                <!-- End Button -->
                                <form method="POST" action="{{ route('admin.event-end', $event->id) }}" class="mb-2">
                                    @csrf
                                    @method('PUT')
                                    <x-primary-button class="bg-blue-500 hover:bg-blue-700">
                                        {{ __('End') }}
                                    </x-primary-button>
                                </form>
                
                                <!-- Terminate Button -->
                                <form method="POST" action="{{ route('admin.event-terminate', $event->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button class="bg-red-500 hover:bg-red-700">
                                        {{ __('Terminate') }}
                                    </x-danger-button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Show Event Management Section if no events are registered -->
                @if($events->isEmpty())
                <div class="lg:w-1/3 bg-white shadow-lg sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Event Management') }}</h3>
                    <form method="POST" action="{{ route('admin.event-register') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Event Name -->
                        <fieldset>
                            <x-input-label for="event" :value="__('Event')" />
                            <x-text-input id="event" class="block mt-1 w-full" type="text" name="event" :value="old('event')" placeholder="Enter the name of the event" required autofocus autocomplete="event" />
                            <x-input-error :messages="$errors->get('event')" class="mt-2" />
                        </fieldset>

                        <!-- Event Location -->
                        <fieldset>
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" placeholder="Enter the event's location" required autocomplete="location" />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </fieldset>

                        <!-- Event Timestamp -->
                        <fieldset>
                            <x-input-label for="time_held" :value="__('Event Timestamp')" />
                            <x-text-input id="time_held" class="block mt-1 w-full" type="datetime-local" name="time_held" :value="old('time_held')" required autocomplete="time_held" />
                            <x-input-error :messages="$errors->get('time_held')" class="mt-2" />
                        </fieldset>

                        <!-- Add Event Button -->
                        <div class="flex items-center justify-between mt-6">
                            <x-primary-button class="ml-4">
                                {{ __('Add') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
                @endif
            </div>

            <br>

            <!-- Event History Section -->
            <div class="mt-12 bg-white shadow-lg sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Event History') }}</h3>

                <!-- Search Bar -->
                <div class="mb-4">
                    <input id="search" type="text" placeholder="Search..." class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" onkeyup="searchTable()">
                </div>
                <!-- Event History Table -->
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border-collapse border border-gray-300 rounded-lg shadow-lg" id="historyTable">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Activity') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Location') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Date/Time') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @if ($event_historys->isEmpty())
                                <tr>
                                    <td colspan="3" class="border border-gray-300 px-6 py-4 text-center">{{ __('No events found.') }}</td>
                                </tr>
                            @else
                                @foreach ($event_historys as $event)
                                    <tr class="bg-white hover:bg-gray-100 border-b border-gray-200">
                                        <td class="border border-gray-300 px-6 py-4">{{ $event->name }}</td>
                                        <td class="border border-gray-300 px-6 py-4">{{ $event->location }}</td>
                                        <td class="border border-gray-300 px-6 py-4">{{ \Carbon\Carbon::parse($event->time_held)->format('d M Y, H:i') }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Search -->
    <script>
        function searchTable() {
            const input = document.getElementById("search");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("historyTable");
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

                row.style.display = found ? "" : "none"; // Show or hide row based on search
            }
        }
    </script>
</x-adminapp-layout>
