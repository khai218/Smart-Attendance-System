<x-app-layout>
    <style>
        h1 {
        padding: 24px; /* Equivalent to p-6 */
        color: #1a202c; /* Equivalent to text-gray-900 */
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        display: flex;
        }
        ul{
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            padding: 24px;
        }
        .gambar{
            padding: 20px;
            width: 150px;
            height: 150px;
            border-radius: 20%;
        }
        p{
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            padding-left: 20px;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Coming Soon") }}
                </div>
            </div>
            <br>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="display: flex;">
                <div>
                    <img class=gambar src="{{(asset('image/kuching.jpg'))}}">
                </div>
                <br>
                <div class=name>
                    <h1>Noor Ilham Bin Abdullah</h1>
                    <p>A student from Kuching, Sarawak, currently in the fifth semester at Politeknik Kuching Sarawak. He is studying in class DDT5C, pursuing a Diploma</p>
                    <p>in Information and Communication Technology (Digital Technology) under the Department of Information Technology and Communication.</p>
                </div>
            </div>
            <br>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="display: flex;">
                <div>
                    <img class=gambar src="{{(asset('image/kuching.jpg'))}}">
                </div>
                <div class=name>
                    <h1>Kho Jia Sen</h1>
                    <p>A student from Kuching, Sarawak, currently in the fifth semester at Politeknik Kuching Sarawak. He is studying in class DDT5C, pursuing a Diploma</p>
                    <p>in Information and Communication Technology (Digital Technology) under the Department of Information Technology and Communication.</p>
                </div>
            </div>
            <br>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="display: flex;">
                <div>
                    <img class=gambar src="{{(asset('image/sigma.jpeg'))}}">
                </div>
                <div class=name>
                    <h1>Muhammad Khairulazhar Bin Kahar</h1>
                    <p>A student from Tawau, Sabah, currently in the fifth semester at Politeknik Kuching Sarawak. He is studying in class DDT5C, pursuing a Diploma</p>
                    <p>in Information and Communication Technology (Digital Technology) under the Department of Information Technology and Communication.</p>
                </div>
            </div>
            <br>
        </div>
    </div>
</x-app-layout>