<x-app-layout>
    <div class="mx-10">
        <a href="/add-recycle-activity"><x-button>Add Recycle Activity</x-button></a>
    </div>

    <x-page-comment>
        <x-slot name="title">
            Page Description
        </x-slot>
        <x-slot name="data">
            {{ auth()->user()->hasRole('admin') ? 
            'Admin able to create, edit, and delete recycle activitity on this page.' : 
            'You can create and edit your recycle activitity on this page.' 
           }}        
        </x-slot>
    </x-page-comment>

    <div class="grid grid-cols-3 gap-12 mx-10 my-6">
        <div class="col-span-3">
            <div class="flex justify-between items-center w-auto">
                <p class="font-bold text-md">Recycle Activity Lists</p>
                <a class="font-bold text-sm text-primary-700">Search</a>
            </div>
            <x-show-table :headers="['Date', 'Plastic Category', 'Recycle Rate Price (RM)', 'Weight (KG)', 'Recycle Price (RM)','Reward Point Earned', 'Status', 'User ', 'Action']">
                <tbody class="flex flex-col overflow-y-auto w-full" style="height: 40vh;">
                    @foreach ($recycleActivities as $i => $recycleActivity)
                        <tr class="flex px-8 py-2 {{ ($loop->index % 2 == 0)? 'bg-primary-50' : '';}}">
                            <td class="mx-4 py-2 text-gray text-sm font-semibold w-4">{{ $loop->iteration }}.</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $recycleActivity->recycle_datetime }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $recycleActivity->recycle_category }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $recycleActivity->recycle_rate }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $recycleActivity->recycle_weight }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $recycleActivity->recycle_price }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $recycleActivity->reward_point_earned }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $recycleActivity->recycle_status }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $recycleActivity->user->name }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">
                                @if ($recycleActivity->recycle_status == 'Completed')
                                    <a href="{{ route('view.recycle.activity', $recycleActivity->id) }}" class="rounded-full py-2 px-3 bg-blue-100 border border-blue-200 justify-center items-center hover:bg-blue-200 ml-2">
                                        <i class="fa-regular fa-eye text-blue-500 fa-sm"></i>
                                    </a>
                                @else
                                <a href="{{ route('edit.recycle.activity', $recycleActivity->id) }}" class="rounded-full py-2 px-3 bg-green-100 border border-green-200 justify-center items-center hover:bg-green-200 ml-2">
                                    <i class="fa-regular fa-pen text-green-500 fa-sm"></i>
                                </a>
                                @if(auth()->user()->hasRole('admin'))
                                        <button type="button" data-modal-target="popup-modal-[{{ $i }}]" data-modal-toggle="popup-modal-[{{ $i }}]" class="rounded-full py-2 px-3 bg-red-50 border border-red-200 justify-center items-center hover:bg-red-100 ml-2"><i class="fa-regular fa-trash-can text-red-500 fa-sm"></i></button>
                                    @endif
                                @endif
                            </td>        
                        </tr>
                        <x-delete-confirmation-modal route="/delete-recycle-activity/{{ $recycleActivity->id }}" title="Delete Recycle Activity" description="Are you sure to delete '{{ $recycleActivity->recycle_category }}' ?" id="{{ $i }}"/>
                    @endforeach
                </tbody>
            </x-show-table>
        </div>
    </div>
</x-app-layout>
