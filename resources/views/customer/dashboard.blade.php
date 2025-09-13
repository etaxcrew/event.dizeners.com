<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">
                                {{ config('app.name') }}
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="ml-3 relative">
                            <div class="flex items-center space-x-4">
                                <span class="text-gray-700">{{ auth()->guard('customer')->user()->name }}</span>
                                <form method="POST" action="{{ route('customer.logout') }}">
                                    @csrf
                                    <button type="submit" class="text-sm text-gray-700 hover:text-indigo-600">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Dashboard Content -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Dashboard</h2>

                        <!-- Welcome Message -->
                        <div class="mb-8">
                            <p class="text-gray-600">
                                Welcome back, {{ auth()->guard('customer')->user()->name }}!
                            </p>
                        </div>

                        <!-- Quick Stats -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="bg-indigo-50 p-6 rounded-lg">
                                <h3 class="text-lg font-medium text-indigo-700">My Events</h3>
                                <p class="text-3xl font-bold text-indigo-900">0</p>
                            </div>

                            <div class="bg-green-50 p-6 rounded-lg">
                                <h3 class="text-lg font-medium text-green-700">Upcoming Events</h3>
                                <p class="text-3xl font-bold text-green-900">0</p>
                            </div>

                            <div class="bg-purple-50 p-6 rounded-lg">
                                <h3 class="text-lg font-medium text-purple-700">Past Events</h3>
                                <p class="text-3xl font-bold text-purple-900">0</p>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
                            <div class="border rounded-lg">
                                <div class="p-4 text-gray-500 text-center">
                                    No recent activity
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @livewireScripts
</body>
</html>
