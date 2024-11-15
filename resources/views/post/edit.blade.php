<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @lang('message.post') / @lang('message.edit')
            </h2>
            <a href="{{ route('post.index') }}" 
               class="bg-gray-600 hover:bg-gray-500 text-sm rounded-md text-white px-3 py-2">
               @lang('message.back')
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('post.update',$post->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <!-- Title Field -->
                        <label for="title" class="text-lg font-medium">@lang('message.title')</label>
                        <div class="my-3">
                            <input value="{{ old('title',$post->title) }}" name="title" placeholder="Title" type="text"
                                   class="border-gray-300 shadow-sm w-full rounded-lg">
                            @error('title')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-4 mb-4">
                            @if ($categories->isNotEmpty())
                                @foreach ($categories as $category)
                                    <div class="mt-3">
                                        <input {{(($hasCategories->contains($category->name))?'checked':'')}}
                                         type="checkbox" id="category-{{ $category->id }}"
                                               class="rounded" name="categories[]" value="{{ $category->id }}">
                                        <label for="category-{{ $category->id }}">{{ $category->name }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <!-- Subtitle Field -->
                        <label for="subtitle" class="text-lg font-medium">@lang('message.subtitle')</label>
                        <div class="my-3">
                            <input value="{{ old('subtitle',$post->subtitle) }}" name="subtitle" placeholder="Subtitle" type="text"
                                   class="border-gray-300 shadow-sm w-full rounded-lg">
                            @error('subtitle')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <label for="image" class="text-lg font-medium">@lang('message.uploadImage')</label>
                        <div class="my-3">
                            <input type="file" name="image" class="form-control" /> 
                        </div>

                        <label for="exampleFormControlSelect1" class="text-lg font-medium">@lang('message.language')</label>
                                                   
                        <class="my-3">
                            <select class="form-control" name="lang" id="exampleFormControlSelect2">
                                <option value="en" {{ old('lang') == 'en' ? 'selected' : '' }}>English</option>
                                <option value="uz" {{ old('lang') == 'uz' ? 'selected' : '' }}>Uzbek</option>
                            </select>                            
                        </div> 
                        <!-- Content Field -->
                        <label for="text" class="text-lg font-medium">@lang('message.content')</label>
                        <div class="my-3">
                            <textarea name="content" placeholder="Content" id="editor" cols="30" rows="10" 
                                      class="border-gray-300 shadow-sm w-1/2 rounded-lg">{{ old('content',$post->content) }}</textarea>
                        </div>
                        
                        <div>
                            <select name="publish" class="form-control" id="exampleFormControlSelect2">
                                <option value="draft" {{ old('publish', $post->publish) === '0' ? 'selected' : '' }}>@lang('message.draft')</option>
                                <option value="publish" {{ old('publish', $post->publish) === '1' ? 'selected' : '' }}>@lang('message.publish')</option>
                            </select>
                            
                            <input type="date" value="{{ old('Attime', $post->Attime) }}" name="Attime" class="ml-10 rounded-lg border-gray-300">
                        </div>                            
                        <!-- Author Display -->
                        <p class="text-lg font-medium">@lang('message.author') : {{ Auth::user()->name }}</p>
                        
                        <!-- Submit Button -->
                        <button class="bg-gray-500 hover:bg-gray-400 text-xs rounded-md text-white px-3 py-2">
                            Submit
                        </button>                                               
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- CKEditor Script Setup -->
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
    <script>
        
        ClassicEditor
            .create( document.querySelector( '#editor' ),{
                    ckfinder: {
                        uploadUrl: '{{route('post.uploadMedia').'?_token='.csrf_token()}}',
            } })
            .then( editor => {
                console.log( 'Editor was initialized', editor );
                question_editor = editor;
                } )
            .catch( error => {
                console.error( error );
            } );

    </script>
</x-app-layout>
