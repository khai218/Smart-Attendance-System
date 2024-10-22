<x-bland-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Participant to ') . $event->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Add Participant Form -->
            <div class="bg-white shadow-lg sm:rounded-lg p-6 mb-6">
                <form method="POST" action="{{ route('admin.store-participant', $event->id) }}" class="space-y-6">
                    @csrf

                    <fieldset>
                        <x-input-label for="users" :value="old(__('users'))" />
                        <select id="users" name="users" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                            <option value="">{{ __('Select Users') }}</option>
                            @foreach ($availableUsers as $user)
                                <option value="{{ $user->matrixno }}">{{ $user->name }} ({{ $user->matrixno }})</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('users')" class="mt-2" />
                    </fieldset>

                    <div class="flex items-center justify-between mt-6">
                        <x-primary-button class="ml-4">
                            {{ __('Add Participant') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Participants Table -->
            <div class="bg-white shadow-lg sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Current Participants') }}</h3>

                <div class="overflow-x-auto">
                    <table class="table-auto w-full border-collapse border border-gray-300 rounded-lg shadow-lg" id="usersTable">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="border border-gray-300 px-6 py-3 text-left min-w-[150px]">{{ __('Name') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left min-w-[120px]">{{ __('Matrix Number') }}</th>
                                <th class="border border-gray-300 px-6 py-3 text-left min-w-[120px]">{{ __('Attendance') }}</th> <!-- New Attendance Column -->
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">                
                            @if ($participants->isEmpty())
                                <tr>
                                    <td colspan="3" class="border border-gray-300 px-6 py-4 text-center">{{ __('No users found.') }}</td>
                                </tr>
                            @else
                                @foreach ($participants as $user)
                                    <tr class="bg-white hover:bg-gray-100 border-b border-gray-200">
                                        <td class="border border-gray-300 px-6 py-4">{{ $user->name }}</td>
                                        <td class="border border-gray-300 px-6 py-4">{{ $user->matrixno }}</td>                                          
                                        <td class="border border-gray-300 px-6 py-4 text-center">
                                            @if ($attendingMatrixNos->contains($user->matrixno))
                                                <div class="flex items-center justify-center">
                                                    <span class="bg-green-100 text-green-600 px-3 py-1 rounded-lg" title="{{ __('Present') }}">{{ __('Present') }}</span>
                                                </div>
                                            @else
                                                <div class="flex items-center justify-center">
                                                    <span class="bg-red-100 text-red-600 px-3 py-1 rounded-lg" title="{{ __('Absent') }}">{{ __('Absent') }}</span>
                                                </div>
                                            @endif
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
        
        .attendance-status {
            transition: transform 0.2s;
        }

        .attendance-status:hover {
            transform: scale(1.05);
        }
    </style>

    <script>
        // JavaScript functions can be added here if necessary
    </script>

</x-bland-layout>
