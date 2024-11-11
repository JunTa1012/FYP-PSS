<x-app-layout>
    @if(auth()->user()->hasRole('admin'))
    <div class="mx-10">
        <a href="/add-product"><x-button>Add Product</x-button></a>
    </div>
    @endif 

    <x-page-comment>
        <x-slot name="title">
            Page Description
        </x-slot>
        <x-slot name="data">
            {{ auth()->user()->hasRole('admin') ? 
            'Admin able to create, edit, and delete products on this page.' : 
            'You can view the selling products on this page.' 
           }}        
        </x-slot>
    </x-page-comment>

    <div class="grid grid-cols-3 gap-12 mx-10 my-6">
        <div class="col-span-3">
            <div class="flex justify-between items-center w-auto">
                <p class="font-bold text-md">Product Lists</p>
                <a class="font-bold text-sm text-primary-700">Search</a>
            </div>
            <x-show-table :headers="['Product', 'Serial', 'Sales Price (RM)', 'Purchase Price (RM)', 'Quantity','Image','Action']">
                <tbody class="flex flex-col overflow-y-auto w-full" style="height: 40vh;">
                    @foreach ($products as $i => $product)
                        <tr class="flex px-8 py-2 {{ ($loop->index % 2 == 0)? 'bg-primary-50' : '';}}">
                            <td class="mx-4 py-2 text-gray text-sm font-semibold w-4">{{ $loop->iteration }}.</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $product->product_name }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $product->product_serial_number }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $product->product_selling_price }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $product->product_purchase_price }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">{{ $product->product_quantity }}</td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">
                                @if($product->product_image)
                                    <img src="{{ asset('images/products/' . $product->product_image) }}" class="w-12 h-12 object-cover rounded">
                                @else
                                    <span>No Image</span>
                                @endif
                            </td>
                            </td>
                            <td class="py-2 text-gray text-sm font-semibold text-left w-1/3">
                                <a href="{{ route('view.product', $product->id) }}" class="rounded-full py-2 px-3 bg-blue-100 border border-blue-200 justify-center items-center hover:bg-blue-200 ml-2">
                                    <i class="fa-regular fa-eye text-blue-500 fa-sm"></i>
                                </a>
                                @if(auth()->user()->hasRole('admin'))
                                <a href="{{ route('edit.product', $product->id) }}" class="rounded-full py-2 px-3 bg-green-100 border border-green-200 justify-center items-center hover:bg-green-200 ml-2">
                                    <i class="fa-regular fa-pen text-green-500 fa-sm"></i>
                                </a>
                                <button type="button" data-modal-target="popup-modal-[{{ $i }}]" data-modal-toggle="popup-modal-[{{ $i }}]" class="rounded-full py-2 px-3 bg-red-50 border border-red-200 justify-center items-center hover:bg-red-100 ml-2"><i class="fa-regular fa-trash-can text-red-500 fa-sm"></i></button>
                                @endif 
                            </td>
                        </tr>
                        <x-delete-confirmation-modal route="/delete-products/{{ $product->id }}" title="Delete Product" description="Are you sure to delete '{{ $product->product_name }}' ?" id="{{ $i }}"/>
                    @endforeach
                </tbody>
            </x-show-table>
        </div>
    </div>
</x-app-layout>
