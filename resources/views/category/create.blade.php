<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Category / Create
            </h2>
            <a href="{{ route('posts.index') }}" 
               class="bg-gray-600 hover:bg-gray-500 text-sm rounded-md text-white px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('categories.store') }}" method="post">
                        @csrf
                        <!-- Title Field -->
                        <label for="title" class="text-lg font-medium">Name</label>
                        <div class="my-3">
                            <input value="{{ old('name') }}" name="name" placeholder="Name" type="text"
                                   class="border-gray-300 shadow-sm w-full rounded-lg">
                            @error('name')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div> 
                        <div class="my-3">
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option value="eng" {{ old('lang') }} >eng</option>
                                <option value="uz" {{ old('lang')}} >uz</option>
                            </select>
                        </div>            
                        <!-- Submit Button -->
                        <button class="bg-gray-500 hover:bg-gray-400 text-xs rounded-md text-white px-3 py-2">
                            Submit
                        </button>                                               
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
