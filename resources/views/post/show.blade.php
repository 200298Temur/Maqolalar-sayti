<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Post / Show
            </h2>
            <a href="{{ route('post.index') }}" 
               class="bg-gray-600 hover:bg-gray-500 text-sm rounded-md text-white px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold">{{ $post->title }}</h1>
                    <div class="font-semibold text-lg my-2">{{ $post->subtitle }}</div>
                    <div class="grid grid-cols-4 mb-4">
                        <strong>Categories:</strong> {{$post->categories->pluck('name')->implode(',') }}
                    </div>
                    <div class="my-3 text-gray-800">
                        {!! $post->content !!}
                    </div>
                    <p class="text-lg font-medium">Author: {{ Auth::user()->name }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
