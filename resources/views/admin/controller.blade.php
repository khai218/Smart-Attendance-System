<x-adminapp-layout>
    <div class="flex justify-center items-center min-h-screen bg-gray-50">
        <!-- Adjusted Box Size -->
        <div class="bg-white p-10 rounded-xl shadow-lg w-3/4 max-w-lg">
            <br>
            <h1 class="text-2xl font-semibold text-center text-gray-800 mb-8">Fingerprint Management</h1>
            <br>
            
            <!-- Register Fingerprint Button -->
            <div class="flex justify-center mb-6">
                <x-primary-button id="register-button" class="w-50 py-4 bg-blue-600 hover:bg-blue-700 text-white">
                    Register Fingerprint
                </x-primary-button>
            </div>

            <!-- Verify Fingerprint Button -->
            <div class="flex justify-center">
                <x-primary-button id="verify-button" class="w-50 py-4 bg-green-600 hover:bg-green-700 text-white">
                    Verify Fingerprint
                </x-primary-button>
            </div>
            <br>
        </div>
    </div>

    <script>
        document.getElementById('register-button').addEventListener('click', function() {
            fetch('/register-fingerprint', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                }
            })
            .then(response => response.text())
            .then(data => {
                alert(data); // Show the response message
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred: ' + error);
            });
        });

        document.getElementById('verify-button').addEventListener('click', function() {
            fetch('/verify-fingerprint', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                }
            })
            .then(response => response.text())
            .then(data => {
                alert(data); // Show the response message
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred: ' + error);
            });
        });
    </script>
</x-adminapp-layout>
