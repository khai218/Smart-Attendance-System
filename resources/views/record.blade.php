<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Smart Attendance System') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Your Activity Records') }}</h3>

                    <table class="table-auto w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2">{{ __('Activity') }}</th>
                                <th class="border px-4 py-2">{{ __('Place') }}</th>
                                <th class="border px-4 py-2">{{ __('Time') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($activities->isEmpty())
                                <tr>
                                    <td colspan="3" class="border px-4 py-2 text-center text-gray-500">
                                        {{ __('No record, guess it’s time to be productive?') }}
                                    </td>
                                </tr>
                            @else
                                @foreach ($activities as $activity)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border px-4 py-2">{{ $activity->activity }}</td>
                                        <td class="border px-4 py-2">{{ $activity->place }}</td>
                                        <td class="border px-4 py-2">{{ $activity->created_at }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
