<x-app-layout>
    @if(auth()->user()->hasRole('admin'))
    <div class="mx-10">
        <a href="/add-order"><x-button>Add Order</x-button></a>
    </div>
    @endif 

    <x-page-comment>
        <x-slot name="title">
            Page Description
        </x-slot>
        <x-slot name="data">
            {{ auth()->user()->hasRole('admin') ? 
            'Admin able to create, edit, and delete orders on this page.' : 
            'You can view the orders on this page.' 
           }}        
        </x-slot>
    </x-page-comment>

    <div class="grid grid-cols-3 gap-12 mx-10 my-6">
        <div class="col-span-3">
            <div class="flex justify-between items-center w-auto">
                <p class="font-bold text-md">Order List</p>
                <a class="font-bold text-sm text-primary-700">Search</a>
            </div>
            <x-show-table :headers="['Order ID', 'Customer Name', 'Total (RM)', 'Date', 'Status', 'Action']">
                <tbody class="flex flex-col overflow-y-auto w-full" style="height: 40vh;">
                    @foreach ($orders as $i => $order)
                    <tr class="flex px-8 py-2 {{ ($loop->index % 2 == 0)? 'bg-primary-50' : '';}}">
                        <td class="mx-4 py-2 text-gray text-sm font-semibold w-4">{{ $loop->iteration }}.</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $order->id }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $order->user->name ?? 'N/A' }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $order->order_total_price }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $order->order_datetime }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ ucfirst($order->order_status) }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">
                                <a href="{{ route('view.order', $order->id) }}" class="rounded-full py-2 px-3 bg-blue-100 border border-blue-200 hover:bg-blue-200 ml-2">
                                    <i class="fa-regular fa-eye text-blue-500 fa-sm"></i>
                                </a>
                                @if(auth()->user()->hasRole('admin'))
                                    <a href="{{ route('edit.order', $order->id) }}" class="rounded-full py-2 px-3 bg-green-100 border border-green-200 hover:bg-green-200 ml-2">
                                        <i class="fa-regular fa-pen text-green-500 fa-sm"></i>
                                    </a>
                                    <button type="button" data-modal-target="popup-modal-[{{ $i }}]" data-modal-toggle="popup-modal-[{{ $i }}]" class="rounded-full py-2 px-3 bg-red-50 border border-red-200 justify-center items-center hover:bg-red-100 ml-2"><i class="fa-regular fa-trash-can text-red-500 fa-sm"></i></button>                                 
                                @endif
                            </td>
                        </tr>
                        <x-delete-confirmation-modal route="/delete-order/{{ $order->id }}" title="Delete Order" description="Are you sure you want to delete order '{{ $order->id }}' ?" id="{{ $i }}"/>
                    @endforeach
                </tbody>
            </x-show-table>
        </div>
    </div>
</x-app-layout>
