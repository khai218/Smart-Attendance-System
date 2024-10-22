<x-bland-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Participants') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white shadow-lg sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Participants List') }}</h3>
            <table class="table-auto w-full border-collapse border border-gray-300 rounded-lg shadow-lg">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Name') }}</th>
                        <th class="border border-gray-300 px-6 py-3 text-left">{{ __('Matrix Number') }}</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @forelse ($participants as $participant)
                        <tr class="bg-white hover:bg-gray-100 border-b border-gray-200">
                            <td class="border border-gray-300 px-6 py-4">{{ $participant->name }}</td>
                            <td class="border border-gray-300 px-6 py-4">{{ $participant->matrixno }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="border border-gray-300 px-6 py-4 text-center">{{ __('No participants found.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-bland-layout>
