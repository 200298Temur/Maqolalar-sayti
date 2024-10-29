<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Maqolalar') }}
            </h2>
            
              <a href="#" class="bg-slate-700 hover:bg-slate-600 text-sm rounded-md text-white px-3 py-2">Create</a>
            
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- <x-message></x-message> --}}
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left" width='60'>#</th>
                        <th class="px-6 py-3 text-left" >Name</th>
                        <th class="px-6 py-3 text-left" >Author</th>
                        <th class="px-6 py-3 text-left" width='180'>Created</th>
                        <th class="px-6 py-3 text-center" width='180'>Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                   
                </tbody>
            </table>
            {{-- <div class="my-3">
                {{ $posts->links() }}
            </div> --}}
        </div>
    </div>
</x-app-layout>