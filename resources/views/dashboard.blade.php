<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Smart Attendance System') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="kotak">
                    <!--{{ __("You're logged in!") }} -->
                     <br>
                    <div class="image flex justify-center p-4"> <!-- Added padding here -->
                        <img src="{{ asset('background/abstrak.jpg') }}" alt="Gunung Serapi" style="height: 170px; width: 1100px;">
                    </div>
                    <br>
                    <h1 class="pt-2 pb-2 px-6 text-gray-900 font-bold">Introduction</h1>
                    <p class="p-6 text-gray-900">The "Internet of Things" (IoT) connects everyday objects to the internet, improving efficiency across many industries. In education, IoT can enhance attendance tracking, which is often done manually and is prone to errors and dishonesty. The JTMK Smart Attendance System aims to solve these issues by using IoT technology like fingerprint scanning and facial recognition. This system will automatically record attendance, update it in real-time, and send alerts if a student's attendance falls below 80%. By replacing manual methods, this solution makes attendance tracking more accurate, secure, and efficient.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

