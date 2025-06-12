<!-- resources/views/dashboard.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            대시보드
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="text-lg font-semibold text-gray-700 mb-2">You're logged in! ✅</p>
                    <p><strong>이름:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>이메일:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>가입일:</strong> {{ Auth::user()->created_at->format('Y-m-d') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
