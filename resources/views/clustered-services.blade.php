<x-app-layout>
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <x-slot name="header">
                        <center><h1>Clustered Services</h1></center>
                    </x-slot>
                    <center>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Normalized Rating</th>
                                <th>Normalized Interactions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <td>{{ $service['name'] }}</td>
                                    <td>{{ $service['category'] }}</td>
                                    <td><center>{{ $service['normalized_rating'] }}</center></td>
                                    <td><center>{{ $service['normalized_interactions'] }}</center></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    <h2>Most Popular Categories</h2>
                        <table class="border-collapse border border-green-800">
                            <thead>
                                <tr>
                                    <th class="border border-green-600 px-4 py-2">Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mostPopularCategories as $category)
                                        <tr>
                                            <td class="border border-green-600 px-4 py-2">{{ $category }}</td>
                                @endforeach
                            </tbody>
                        </table>

                        <h2>Popular Categories</h2>
                        <table class="border-collapse border border-blue-800">
                            <thead>
                                <tr>
                                    <th class="border border-blue-600 px-4 py-2">Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($popularCategories as $category)
                                    <tr>
                                        <td class="border border-blue-600 px-4 py-2">{{ $category }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <h2>Less Popular Categories</h2>
                        <table class="border-collapse border border-yellow-800">
                            <thead>
                                <tr>
                                    <th class="border border-yellow-600 px-4 py-2">Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lessPopularCategories as $category)
                                    <tr>
                                        <td class="border border-yellow-600 px-4 py-2">{{ $category }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <h2>Least Popular Categories</h2>
                        <table class="border-collapse border border-red-800">
                            <thead>
                                <tr>
                                    <th class="border border-red-600 px-4 py-2">Category</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leastPopularCategories as $category)
                                    <tr>
                                        <td class="border border-red-600 px-4 py-2">{{ $category }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </center>
                </div>
            </div>
        </div>
</div>
</x-app-layout>
