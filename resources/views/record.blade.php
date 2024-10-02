<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Smart Attendance System') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg p-6">

                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Your Activity Records') }}</h3>

                <!-- Search Bar -->
                <div class="mb-4">
                    <input id="search" type="text" placeholder="Search..." class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500" onkeyup="searchTable()">
                </div>

                <!-- Events Table -->
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border-collapse border border-gray-300 rounded-lg shadow-lg" id="eventsTable">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Activity') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Location') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Date/Time') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @if ($events->isEmpty())
                                <tr>
                                    <td colspan="3" class="border border-gray-300 px-6 py-4 text-center text-gray-500">
                                        {{ __('No record, guess it’s time to be productive?') }}
                                    </td>
                                </tr>
                            @else
                                @foreach ($events as $event)
                                    <tr class="bg-white hover:bg-gray-100 border-b border-gray-200">
                                        <td class="border border-gray-300 px-6 py-4">{{ $event->event_name }}</td>
                                        <td class="border border-gray-300 px-6 py-4">{{ $event->location }}</td>
                                        <td class="border border-gray-300 px-6 py-4">{{ $event->created_at }}</td>
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
            const table = document.getElementById("eventsTable");
            const rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
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

                row.style.display = found ? "" : "none";
            }
        }
    </script>
</x-app-layout>
