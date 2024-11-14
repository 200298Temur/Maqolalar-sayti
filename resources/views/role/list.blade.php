<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Role
            </h2>
            <a href="{{route('roles.create')}}" 
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
                        <th class="px-6 py-3 text-left">name</th>
                        <th class="px-6 py-3 text-left">permission</th>
                        <th class="px-6 py-3 text-center" width="250">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if ($roles->count() > 0)
                        @foreach ($roles as $role)
                        <tr class="border-b">
                            <td class="px-6 py-4 text-left">{{ $role->id }}</td>
                            <td class="px-6 py-4 text-left">{{ $role->name }}</td>
                            <td class="px-6 py-3 text-left">
                                {{$role->permissions->pluck('name')->implode(',')}}
                            </td>
                            <td class="px-6 py-4 text-center"> 
                                <a href="{{ route('roles.edit',[$role->id]) }}" 
                                   class="bg-indigo-700	 text-sm rounded-md text-white px-3 py-2 hover:bg-indigo-500">@lang('message.edit')</a>                                 
                                <a href="{{ route('roles.destroy', [$role->id]) }}" class="bg-red-600 text-sm rounded-md text-white px-3 py-2 hover:bg-red-500">@lang('message.delete')</a>   
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No role found.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{-- <div class="my-3">
                {{ $roles->links() }}
            </div> --}}
        </div>
    </div>
</x-app-layout>
