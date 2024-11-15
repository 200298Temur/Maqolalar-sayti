<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User
            </h2>
            <a href="{{Route('user.create')}}" 
               class="bg-gray-500 hover:bg-gray-400 text-sm rounded-md text-white px-3 py-2">
               @lang('message.create')
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left" width="60">#</th>
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Role</th>
                        <th class="px-6 py-3 text-center" width="250">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if ($users->count() > 0)
                        @foreach ($users as $user)
                        <tr class="border-b">
                            <td class="px-6 py-4 text-left">{{ $user->id }}</td>
                            <td class="px-6 py-4 text-left">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-left">{{ $user->email }}</td>
                            <td class="px-6 py-3 text-left">
                                {{$user->roles->pluck('name')->implode(',')}}
                            </td>
                            <td class="px-6 py-4 text-center"> 
                                <a href="{{ route('user.edit',[$user->id]) }}" 
                                   class="bg-indigo-700	 text-sm rounded-md text-white px-3 py-2 hover:bg-indigo-500">@lang('message.edit')</a>                                 
                                <a href="{{ route('user.destroy', [$user->id]) }}" class="bg-red-600 text-sm rounded-md text-white px-3 py-2 hover:bg-red-500">@lang('message.delete')</a>   
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No user found.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{-- <div class="my-3">
                {{ $users->links() }}
            </div> --}}
        </div>
    </div>
</x-app-layout>
