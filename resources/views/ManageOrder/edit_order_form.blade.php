<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center w-full">
            <p class="font-bold text-md">Edit Order</p>
        </div>
    </div>
    <x-order-form>
        <div class="mt-2 mb-4 mx-4">
            <form action="{{ route('update.order', $order->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="flex space-x-6 mt-4">
                    <div class="flex flex-col w-1/3">
                        <label class="font-semibold text-sm text-gray mb-2">User</label>
                        <x-input type="text" value="{{ $order->user->name }}" disabled/>
                    </div>
                    
                    <div class="flex flex-col w-1/3">
                        <label class="font-semibold text-sm text-gray mb-2">Current Datetime</label>
                        <x-input name="order_datetime" type="datetime-local" value="{{ $order->order_datetime }}" required/>
                    </div>

                    <div class="flex flex-col w-1/3">
                        <label class="font-semibold text-sm text-gray mb-2">Status</label>
                        <select name="order_status" class="border border-gray-300 rounded-md p-2" required>
                            <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="canceled" {{ $order->order_status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                    </div>
                </div>

                <div class="overflow-x-auto w-full mt-4">
                    <table class="min-w-full border border-gray-200 mt-4">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-2">Product</th>
                                <th class="border p-2">Quantity</th>
                                <th class="border p-2">Price</th>
                                <th class="border p-2">Discount %</th>
                                <th class="border p-2">Amount</th>
                                <th class="border p-2"><a class="addRow badge badge-success text-black"><i class="fa fa-plus text-green-500"></i></a></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $index => $item)
                            <tr>
                                <td class="border p-2">
                                    <select name="product_id[]" class="form-control productname" onchange="updatePrice(this)">
                                        <option value="" disabled>Select Product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ $product->id == $item->product_id ? 'selected' : '' }} data-price="{{ $product->product_selling_price }}">{{ $product->product_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="border p-2"><input type="number" name="qty[]" value="{{ $item->order_item_quantity }}" class="form-control qty" min="1" oninput="calculateAmount(this)"></td>
                                <td class="border p-2"><input type="text" name="price[]" value="{{ $item->order_item_price }}" class="form-control price" readonly></td>
                                <td class="border p-2"><input type="number" name="dis[]" value="{{ $item->order_item_discount }}" class="form-control dis" min="0" max="100" oninput="calculateAmount(this)"></td>
                                <td class="border p-2"><input type="text" name="amount[]" value="{{ $item->order_item_amount }}" class="form-control amount" readonly></td>
                                <td class="border p-2"><a class="btn btn-danger remove"><i class="fa-regular fa-trash-can text-red-500"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right font-bold p-2">Total</td>
                                <td class="font-bold p-2 total">{{ number_format($order->order_total_price, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="flex justify-end mt-4 px-4">
                    <a href="/order-list"><x-secondary-button class="mr-2">CANCEL</x-secondary-button></a>
                    <x-button type="submit">Update</x-button>
                </div>
            </form>
        </div>
    </x-order-form>
</x-app-layout>


<script>
    $(document).ready(function() {
        // Fetch price when product is selected
        $('tbody').on('change', '.productname', function() {
            var tr = $(this).closest('tr');
            var price = $(this).find(':selected').data('price'); // Get the data-price from selected option
            
            if (price) {
                tr.find('.price').val(price); // Set price
                calculateAmount(tr.find('.qty')[0]); // Recalculate amount
            }
        });
    
        // Calculate amount when quantity or discount changes
        $('tbody').on('input', '.qty, .dis', function() {
            calculateAmount(this);
        });
    
        // Function to calculate the amount for a row
        function calculateAmount(element) {
            var tr = $(element).closest('tr');
            var qty = parseFloat(tr.find('.qty').val()) || 0;
            var price = parseFloat(tr.find('.price').val()) || 0;
            var dis = parseFloat(tr.find('.dis').val()) || 0;
            var amount = qty * price * (1 - dis / 100);
            
            tr.find('.amount').val(amount.toFixed(2));
            updateTotal();
        }
    
        // Update the total amount
        function updateTotal() {
            var total = 0;
            $('.amount').each(function() {
                total += parseFloat($(this).val()) || 0;
            });
            $('.total').text(total.toFixed(2));
        }
    
        // Add new row
        $('.addRow').click(function() {
            var row = `<tr>
                            <td class="border p-2">
                                <select name="product_id[]" class="form-control productname" onchange="updatePrice(this)">
                                    <option value="0" selected="true" disabled="true">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->product_selling_price }}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="border p-2"><input type="number" name="qty[]" class="form-control qty" min="1" oninput="calculateAmount(this)"></td>
                            <td class="border p-2"><input type="text" name="price[]" class="form-control price" readonly></td>
                            <td class="border p-2"><input type="number" name="dis[]" class="form-control dis" min="0" max="100" oninput="calculateAmount(this)"></td>
                            <td class="border p-2"><input type="text" name="amount[]" class="form-control amount" readonly></td>
                            <td class="border p-2"><a class="btn btn-danger remove"><i class="fa-regular fa-trash-can text-red-500"></i></a></td>
                        </tr>`;
            $('tbody').append(row);
        });
    
        // Remove row and update total
        $('tbody').on('click', '.remove', function() {
            $(this).closest('tr').remove();
            updateTotal();
        });
    });
</script>
