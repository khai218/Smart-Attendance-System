<x-adminapp-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Smart Attendance System Admin Page') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="kotak">
                    <div class="flex justify-center p-4">
                        <img src="{{ asset('background/abstrak.jpg') }}" alt="Gunung Serapi" style="height: 170px; width: 1100px;">
                    </div>
                    <h1 class="pt-2 pb-2 px-6 text-gray-900 font-bold">Introduction</h1>
                    <p class="p-6 text-gray-900">
                        The "Internet of Things" (IoT) connects everyday objects to the internet, improving efficiency across many industries. 
                        In education, IoT can enhance attendance tracking, which is often done manually and is prone to errors and dishonesty. 
                        The JTMK Smart Attendance System aims to solve these issues by using IoT technology like fingerprint scanning and facial recognition. 
                        This system will automatically record attendance, update it in real-time, and send alerts if a student's attendance falls below 80%. 
                        By replacing manual methods, this solution makes attendance tracking more accurate, secure, and efficient.
                    </p>
                </div>
            </div>
            <br>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8"> <!-- Adjusted gap for better spacing -->
                <!-- Total Users Box -->
                <div class="bg-white shadow-md rounded-lg p-2 flex items-center">
                    <div class="flex items-center justify-center bg-gray-100 p-4 rounded-full"> <!-- Icon box -->
                        <img src="{{ asset('logo/pngegg (1).png') }}" alt="Total Users Icon" class="h-6 w-6"> <!-- Icon size -->
                    </div>
                    <div class="px-2"> <!-- Padding on the left and right of the vertical line -->
                        <div class="vl"></div> <!-- Vertical line -->
                    </div>
                    <div class="ml-4"> <!-- Separate div for text with left margin -->
                        <h2 class="text-xl font-semibold">Total Users:</h2>
                        <p class="text-2xl font-bold">{{ $userCount }}</p> <!-- Increased font size for emphasis -->
                    </div>
                </div>
                
                <!-- Total Events Box -->
                <div class="bg-white shadow-md rounded-lg p-2 flex items-center">
                    <div class="flex items-center justify-center bg-gray-100 p-4 rounded-full"> <!-- Icon box -->
                        <img src="{{ asset('logo/pngegg (2).png') }}" alt="Total Events Icon" class="h-6 w-6"> <!-- Icon size -->
                    </div>
                    <div class="px-2"> <!-- Padding on the left and right of the vertical line -->
                        <div class="vl"></div> <!-- Vertical line -->
                    </div>
                    <div class="ml-4"> <!-- Separate div for text with left margin -->
                        <h2 class="text-xl font-semibold">Current Events:</h2>
                        <p class="text-2xl font-bold">{{ $eventCount }}</p> <!-- Increased font size for emphasis -->
                    </div>
                </div>

                <!-- Total Event History Box -->
                <div class="bg-white shadow-md rounded-lg p-2 flex items-center">
                    <div class="flex items-center justify-center bg-gray-100 p-4 rounded-full"> <!-- Icon box -->
                        <img src="{{ asset('logo/pngegg (3).png') }}" alt="Total Event History Icon" class="h-6 w-6"> <!-- Icon size -->
                    </div>
                    <div class="px-2"> <!-- Padding on the left and right of the vertical line -->
                        <div class="vl"></div> <!-- Vertical line -->
                    </div>
                    <div class="ml-4"> <!-- Separate div for text with left margin -->
                        <h2 class="text-xl font-semibold">Event History:</h2>
                        <p class="text-2xl font-bold">{{ $event_historyCount }}</p> <!-- Increased font size for emphasis -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .vl {
            border-left: 3px solid white;
            height: 3rem;
        }
    </style>
</x-adminapp-layout>
