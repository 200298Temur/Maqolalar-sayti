<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @lang('message.posts')
            </h2>
            @if (auth()->user()->permissionsKey()->contains('post_create'))
                <a href="{{ route('post.create') }}" 
                class="bg-gray-500 hover:bg-gray-400 text-sm rounded-md text-white px-3 py-2">
                @lang('message.create')
                </a>             
            @endif
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('post.search') }}" method="GET">
                <input value="{{ request('search', $post->search ?? '') }}" type="text" name="search" placeholder="Search Products">
                <button type="submit" class="bg-gray-500 hover:bg-gray-400 text-sm rounded-md text-white px-3 py-2"
                >@lang('message.search')</button>
            </form>            
            <x-message></x-message>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left" width="60">#</th>
                        <th class="px-6 py-3 text-left"> @lang('message.title')</th>
                        <th class="px-6 py-3 text-left"> @lang('message.category')</th>
                        <th class="px-6 py-3 text-left">@lang('message.subtitle')</th>
                        <th class="px-6 py-3 text-left">@lang('message.author')</th>
                        <th class="px-6 py-3 text-left" width="180">@lang('message.created')</th>
                        <th class="px-6 py-3 text-left">@lang('message.language')</th>
                        <th class="px-6 py-3 text-left">@lang('message.condition')</th>
                        <th class="px-6 py-3 text-center" width="250">@lang('message.action')</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if ($posts->count() > 0)
                        @foreach ($posts as $post)
                        <tr class="border-b">
                            <td class="px-6 py-4 text-left">{{ $post->id }}</td>
                            <td class="px-6 py-4 text-left">
                                <a href="{{ route('post.show', ['id' => $post->id]) }}">
                                    {{ $post->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-left">{{ $post->categories->pluck('name')->implode(',') }}</td>
                            <td class="px-6 py-4 text-left">{{ $post->subtitle }}</td>
                            <td class="px-6 py-4 text-left">{{ $post->author->name }}</td>
                            <td class="px-6 py-4 text-left">
                                {{ \Carbon\Carbon::parse($post->Attime)->format('d M, Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <p>{{ $post->lang === 'uz' ? 'Uzbek' : 'English' }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <p>{{ $post->publish === '0' ? 'Draft' : 'Publish' }}</p>
                            </td>
                            <td class="px-6 py-4 text-center"> 
                                @if (auth()->user()->permissionsKey()->contains('post_edit'))
                                    <a href="{{ route('post.edit', ['id' => $post->id]) }}" class="bg-indigo-700 text-sm rounded-md text-white px-3 py-2 hover:bg-indigo-500">@lang('message.edit')</a>                                
                                @endif
                                @if(auth()->user()->permissionsKey()->contains('post_delete'))
                                    <a href="{{ route('post.destroy', [$post->id]) }}" class="bg-red-600 text-sm rounded-md text-white px-3 py-2 hover:bg-red-500">@lang('message.delete')</a>   
                                @endif
                                    
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                @lang('message.no posts found')
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            @if ($posts->count() > 0)
                <div class="my-3">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
