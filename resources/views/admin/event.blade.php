<x-adminapp-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Smart Attendance System Admin Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Event Management Form (Full Width) -->
            <div class="bg-white shadow-lg sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Event Management') }}</h3>
                <form method="POST" action="{{ route('admin.event-register') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <fieldset>
                        <x-input-label for="event" :value="__('Event')" />
                        <x-text-input id="event" class="block mt-1 w-full" type="text" name="event" :value="old('event')" placeholder="{{ __('Enter the name of the event') }}" required autofocus autocomplete="event" />
                        <x-input-error :messages="$errors->get('event')" class="mt-2" />
                    </fieldset>
                    <fieldset>
                        <x-input-label for="location" :value="__('Location')" />
                        <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" placeholder="{{ __('Enter the event\'s location') }}" required autocomplete="location" />
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </fieldset>
                    <fieldset>
                        <x-input-label for="time_start" :value="__('Start')" />
                        <x-text-input id="time_start" class="block mt-1 w-full" type="datetime-local" name="time_start" :value="old('time_start')" required autocomplete="time_start" />
                        <x-input-error :messages="$errors->get('time_start')" class="mt-2" />
                    </fieldset>
                    <fieldset>
                        <x-input-label for="time_end" :value="__('End')" />
                        <x-text-input id="time_end" class="block mt-1 w-full" type="datetime-local" name="time_end" :value="old('time_end')" required autocomplete="time_end" />
                        <x-input-error :messages="$errors->get('time_end')" class="mt-2" />
                    </fieldset>
                    <div class="flex items-center justify-between mt-6">
                        <x-primary-button class="ml-4">
                            {{ __('Add') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-lg sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Current Events') }}</h3>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border-collapse border border-gray-300 rounded-lg shadow-lg">
                        <caption class="sr-only">{{ __('Current Events') }}</caption>
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Event Name') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Location') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Start') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('End') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Actions') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Participant') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @forelse($events as $event)
                            <tr class="bg-white hover:bg-gray-100 border-b border-gray-200">
                                <td class="border border-gray-300 px-6 py-4">{{ $event->name }}</td>
                                <td class="border border-gray-300 px-6 py-4">{{ $event->location }}</td>
                                <td class="border border-gray-300 px-6 py-4">{{ \Carbon\Carbon::parse($event->time_start)->format('d M Y, H:i') }}</td>
                                <td class="border border-gray-300 px-6 py-4">{{ \Carbon\Carbon::parse($event->time_end)->format('d M Y, H:i') }}</td>
                                <td class="border border-gray-300 px-6 py-4">
                                    <div class="flex">
                                        <form method="POST" action="{{ route('admin.event-end', $event->id) }}" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <x-primary-button aria-label="Edit Event">
                                                <img src="{{ asset('logo/racing-flag.png') }}" alt="Edit Icon" class="h-6 w-6">
                                            </x-primary-button>
                                        </form>
            
                                        <div class="px-2">
                                            <div class="vl"></div>
                                        </div>
            
                                        <form method="POST" action="{{ route('admin.event-terminate', $event->id) }}" class="inline ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button aria-label="Delete Event">
                                                <img src="{{ asset('logo/icons8-stop-gesture-50.png') }}" alt="Delete Icon" class="h-6 w-6">
                                            </x-danger-button>
                                        </form>
                                    </div>
                                </td>
                                <td class="border border-gray-300 px-6 py-4">
                                    <div class="flex">
                                        <a href="{{ route('admin.add-participant', $event->id) }}">
                                            <x-primary-button aria-label="Add Participant">
                                                <img src="{{ asset('logo/icons8-queue-50.png') }}" alt="Participant Icon" class="h-6 w-6">
                                            </x-primary-button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="border border-gray-300 px-6 py-4 text-center">{{ __('No events found.') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Event History Section -->
            <div class="bg-white shadow-lg sm:rounded-lg p-6 mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Event History') }}</h3>
                <div class="mb-4">
                    <input id="search" type="text" placeholder="{{ __('Search...') }}" class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" onkeyup="searchTable()">
                </div>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border-collapse border border-gray-300 rounded-lg shadow-lg" id="historyTable">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Activity') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Location') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Start') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('End') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Participant') }}</th> <!-- Add this -->
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @if ($event_historys->isEmpty())
                                <tr>
                                    <td colspan="4" class="border border-gray-300 px-6 py-4 text-center">{{ __('No events found.') }}</td>
                                </tr>
                            @else
                                @foreach ($event_historys as $event)
                                    <tr class="bg-white hover:bg-gray-100 border-b border-gray-200">
                                        <td class="border border-gray-300 px-6 py-4">{{ $event->name }}</td>
                                        <td class="border border-gray-300 px-6 py-4">{{ $event->location }}</td>
                                        <td class="border border-gray-300 px-6 py-4">{{ \Carbon\Carbon::parse($event->time_start)->format('d M Y H:i') }}</td>
                                        <td class="border border-gray-300 px-6 py-4">{{ \Carbon\Carbon::parse($event->time_end)->format('d M Y H:i') }}</td>
                                        <td class="border border-gray-300 px-6 py-4">
                                            <a href="{{ route('admin.event-participants', $event->event_id) }}">
                                                <x-primary-button aria-label="View Participants">
                                                    <img src="{{ asset('logo/mata-putih.png') }}" alt="Participant Icon" class="h-6 w-6">
                                                </x-primary-button>
                                            </a>
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

    <!-- JavaScript for Search -->
    <script>
        function searchTable() {
            const input = document.getElementById("search");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("historyTable");
            const rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName("td");
                let found = false;

                for (let j = 0; j < cells.length; j++) {
                    const cell = cells[j];
                    if (cell) {
                        const text = cell.textContent || cell.innerText;
                        if (text.toLowerCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }

                row.style.display = found ? "" : "none";
            }
        }
    </script>
</x-adminapp-layout>
