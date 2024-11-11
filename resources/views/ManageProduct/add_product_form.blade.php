<x-app-layout>
    <div class="grid grid-cols-3 gap-12 mx-10 my-6">
            <div class="flex justify-between items-center w-auto">
                <p class="font-bold text-md">Add Product</p>
            </div>
    </div>
    <div class="mt-2 mx-4">
        <form action="{{ route('create.product') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex space-x-6 mt-4">
                <!-- Product Name -->
                <div class="flex flex-col w-1/2">
                    <label for="product_name" class="font-semibold text-sm text-gray mb-2">Product Name</label>
                    <x-input name="product_name" type="text" placeholder="Product's Name" value="{{ old('product_name') }}" required/>
                    @error('product_name')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- Serial Number -->
                <div class="flex flex-col w-1/2">
                    <label for="product_serial_number" class="font-semibold text-sm text-gray mb-2">Serial Number</label>
                    <x-input name="product_serial_number" type="text" placeholder="Product Serial Number" value="{{ old('product_serial_number') }}" required/>
                    @error('product_serial_number')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="flex space-x-6 mt-4">
                <!-- Product Description -->
                <div class="flex flex-col w-1/2">
                    <label for="product_description" class="font-semibold text-sm text-gray mb-2">Product Description (Max 255)</label>
                    <x-textarea-input name="product_description" type="text" placeholder="Product's Description" value="{{ old('product_description') }}" required/>
                    @error('product_description')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
    
                <!-- Product Quantity -->
                <div class="flex flex-col w-1/2">
                    <label for="product_quantity" class="font-semibold text-sm text-gray mb-2">Product Quantity</label>
                    <x-input name="product_quantity" type="text" placeholder="Product Quantity" value="{{ old('product_quantity') }}" required/>
                    @error('product_quantity')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="flex space-x-6 mt-4">
                <!-- Purchase Price -->
                <div class="flex flex-col w-1/2">
                    <label for="product_purchase_price" class="font-semibold text-sm text-gray mb-2">Product Purchase Price</label>
                    <div class="relative">
                        <x-input name="product_purchase_price" type="text" class="pl-10 w-full" value="{{ old('product_purchase_price') }}" required/>
                        <span class="absolute left-0 top-1/2 transform -translate-y-1/2 text-black font-semibold pl-3 text-sm">RM</span>
                    </div>
                    @error('product_purchase_price')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Selling Price -->
                <div class="flex flex-col w-1/2">
                    <label for="product_selling_price" class="font-semibold text-sm text-gray mb-2">Product Selling Price</label>
                    <div class="relative">
                        <x-input name="product_selling_price" type="text" class="pl-10 w-full" value="{{ old('product_selling_price') }}" required/>
                        <span class="absolute left-0 top-1/2 transform -translate-y-1/2 text-black font-semibold pl-3 text-sm">RM</span>
                    </div>
                    @error('product_selling_price')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>                
            </div>
            <div class="flex space-x-6 mt-4">
                <div class="flex flex-col w-1/2">
                    <label for="product_image" class="font-semibold text-sm text-gray mb-2">Upload Image</label>
                    <input type="file" name="product_image" id="product_image" accept="image/*" required class="border border-gray-300 rounded-md p-2"/>
                    @error('product_image')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end items-center mt-4">
                <a href="/product-list"><x-secondary-button class="mr-2">CANCEL</x-secondary-button></a>
                <x-button type="submit">Add</x-button>
            </div>
        </form>
    </div>    
</x-app-layout>