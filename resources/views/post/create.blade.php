<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Post / Create
            </h2>
            <a href="{{ route('posts.index') }}" 
               class="bg-gray-600 hover:bg-gray-500 text-sm rounded-md text-white px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <!-- Title Field -->
                        <label for="title" class="text-lg font-medium">Title</label>
                        <div class="my-3">
                            <input value="{{ old('title') }}" name="title" placeholder="Title" type="text"
                                   class="border-gray-300 shadow-sm w-full rounded-lg">
                            @error('title')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Categories Selection -->
                        <div class="grid grid-cols-4 mb-4">
                            @if ($categories->isNotEmpty())
                                @foreach ($categories as $category)
                                    <div class="mt-3">
                                        <input type="checkbox" id="category-{{ $category->id }}"
                                               class="rounded" name="categories[]" value="{{ $category->id }}">
                                        <label for="category-{{ $category->id }}">{{ $category->name }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!-- Subtitle Field -->
                        <label for="subtitle" class="text-lg font-medium">Subtitle</label>
                        <div class="my-3">
                            <input value="{{ old('subtitle') }}" name="subtitle" placeholder="Subtitle" type="text"
                                   class="border-gray-300 shadow-sm w-full rounded-lg">
                            @error('subtitle')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image Upload -->
                        <div class="my-3">
                            <label for="image" class="text-lg font-medium">Upload Image</label>
                            <input type="file" name="image" class="form-control" />
                            {{-- @error('image')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror --}}
                        </div>
     
                        <div class="my-3">
                            <label for="lang" class="text-lg font-medium">Language</label>
                            <select class="form-control" name="lang">
                                <option value="en" {{ old('lang') === 'en' ? 'selected' : '' }}>English</option>
                                <option value="uz" {{ old('lang') === 'uz' ? 'selected' : '' }}>Uzbek</option>
                            </select>
                        </div>
                        
                        <!-- Content Field -->
                        <label for="content" class="text-lg font-medium">Content</label>
                        <div class="my-3">
                            <textarea name="content" placeholder="Content" id="editor" cols="30" rows="10" 
                                      class="border-gray-300 shadow-sm w-full rounded-lg">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Publish and Date Fields -->
                        <div class="flex items-center gap-4 mb-3">
                            <select name="publish" class="form-control">
                                <option value="draft" {{ old('publish') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="publish" {{ old('publish') === 'publish' ? 'selected' : '' }}>Publish</option>
                            </select>
                            <input type="date" value="{{ old('Attime') }}" name="Attime" class="ml-4 rounded-lg border-gray-300">
                        </div>

                        <!-- Author Display -->
                        <p class="text-lg font-medium">Author: {{ Auth::user()->name }}</p>

                        <!-- Submit Button -->
                        <button type="submit" class="bg-gray-500 hover:bg-gray-400 text-md rounded-md text-white px-5 py-2">
                            Submit
                        </button>                                               
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- CKEditor Initialization -->
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                ckfinder: {
                    uploadUrl: '{{ route('posts.uploadMedia') . '?_token=' . csrf_token() }}',
                }
            })
            .then(editor => {
                console.log('Editor was initialized', editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
</x-app-layout>
