<x-app-layout>
    <div class="mx-10">
        <a href="/add-user"><x-button>Add User</x-button></a>
    </div>

    <x-page-comment>
        <x-slot name="title">
            Page Description
        </x-slot>
        <x-slot name="data">
            Admin is able to create, edit, and delete users on this page.       
        </x-slot>
    </x-page-comment>

    <div class="grid grid-cols-3 gap-12 mx-10 my-6">
        <div class="col-span-3">
            <div class="flex justify-between items-center w-auto">
                <p class="font-bold text-md">User Lists</p>
                <a class="font-bold text-sm text-primary-700">Search</a>
            </div>
            <x-show-table :headers="['Name', 'User ID', 'Role', 'Email','Action']">
                <tbody class="flex flex-col overflow-y-auto w-full" style="height: 40vh;">
                    @foreach ($users as $i => $user)
                        <tr class="flex px-8 py-2 {{ ($loop->index % 2 == 0)? 'bg-primary-50' : '';}}">
                            <td class="mx-4 py-2 text-gray text-sm font-semibold w-4">{{ $loop->iteration }}.</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $user->name }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $user->id }}</td>     
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $user->role }}</td>     
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $user->email }}</td>       
                            </td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">
                                <a href="{{ route('edit.user', $user->id) }}" class="rounded-full py-2 px-3 bg-green-100 border border-green-200 justify-center items-center hover:bg-green-200 ml-2">
                                    <i class="fa-regular fa-pen text-green-500 fa-sm"></i>
                                </a>
                                <button type="button" data-modal-target="popup-modal-[{{ $i }}]" data-modal-toggle="popup-modal-[{{ $i }}]" class="rounded-full py-2 px-3 bg-red-50 border border-red-200 justify-center items-center hover:bg-red-100 ml-2"><i class="fa-regular fa-trash-can text-red-500 fa-sm"></i></button>
                            </td>
                        </tr>
                        <x-delete-confirmation-modal route="/delete-user/{{ $user->id }}" title="Delete User" description="Are you sure to delete '{{ $user->name }}' ?" id="{{ $i }}"/>
                    @endforeach
                </tbody>
            </x-show-table>
        </div>
    </div>
</x-app-layout>
