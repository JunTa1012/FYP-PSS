<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ManageOrderController extends Controller
{
    public function showOrderList()
    {
        $orders = Order::with(['orderItems', 'user'])->get();
        return view('ManageOrder.order_list', compact('orders'));
    }

    // Method to retrieve product price via AJAX
    public function findPrice(Request $request)
    {
        $product = Product::find($request->id);
        if ($product) {
            return response()->json(['product_selling_price' => $product->product_selling_price]);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    public function addOrder()
    {
        $users = User::all();
        $products = Product::all();


        return view('ManageOrder.add_order_form', compact('users', 'products'));
    }
    
    public function createOrder(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:users,id', // Ensure customer_id exists in the users table
            'order_datetime' => 'required|date', // Ensure the datetime is in the correct format
            'order_status' => 'required|string', // Ensure order status is a string
            'product_id.*' => 'required|exists:products,id', // Ensure each product exists
            'qty.*' => 'required|integer|min:1', // Ensure valid quantity
            'price.*' => 'required|numeric', // Ensure valid price for each product
            'dis.*' => 'nullable|numeric|min:0|max:100', // Ensure valid discount (optional)
            'amount.*' => 'required|numeric', // Ensure valid amount for each item
        ]);
    
        // Set the order total price
        $validatedData['order_total_price'] = array_sum($request->amount); // Calculate total price from amounts
    
        // Create the order
        $order = Order::create([
            'user_id' => $validatedData['customer_id'], // Store the customer ID as user_id
            'order_datetime' => $validatedData['order_datetime'], // Store the order datetime
            'order_status' => $validatedData['order_status'], // Store the order status
            'order_total_price' => $validatedData['order_total_price'], // Store the total price
        ]);
    
        // Save the order items
        foreach ($request->product_id as $index => $productId) {
            $order->orderItems()->create([
                'product_id' => $productId, // Product ID from the form
                'order_item_quantity' => $request->qty[$index], // Quantity from the form
                'order_item_price' => $request->price[$index], // Price from the form
                'order_item_discount' => $request->dis[$index] ?? 0, // Discount (optional)
                'order_item_amount' => $request->amount[$index], // Amount from the form
            ]);
        }
    
        // Redirect to the order list with a success message
        return redirect()->route('order.list')->with('success', 'Order created successfully.');
    }
    
    public function deleteOrder($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);

        DB::beginTransaction();

        try {
            // Delete all associated order items
            $order->orderItems()->delete();

            // Delete the order itself
            $order->delete();

            DB::commit(); // Commit the transaction

            return redirect()->route('order.list')->with('success', 'Order deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction if something goes wrong
            return redirect()->route('order.list')->with('error', 'Failed to delete order.');
        }
    }

    public function viewOrder($id)
    {
        $order = Order::with('orderItems')->findOrFail($id);
        return view('ManageOrder.view_order_form', compact('order', 'id'));
    }

    public function editOrder($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        $products = Product::all();
        return view('ManageOrder.edit_order_form', compact('order', 'products'));
    }

    public function updateOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validatedData = $request->validate([
            'order_datetime' => 'required|date',
            'order_status' => 'required|string',
            'product_id.*' => 'required|exists:products,id',
            'qty.*' => 'required|integer|min:1',
            'price.*' => 'required|numeric',
            'dis.*' => 'nullable|numeric|min:0|max:100',
            'amount.*' => 'required|numeric',
        ]);

        $order->update([
            'order_datetime' => $validatedData['order_datetime'],
            'order_status' => $validatedData['order_status'],
            'order_total_price' => array_sum($request->amount),
        ]);

        $order->orderItems()->delete();

        foreach ($request->product_id as $index => $productId) {
            $order->orderItems()->create([
                'product_id' => $productId,
                'order_item_quantity' => $request->qty[$index],
                'order_item_price' => $request->price[$index],
                'order_item_discount' => $request->dis[$index] ?? 0,
                'order_item_amount' => $request->amount[$index],
            ]);
        }

        return redirect()->route('order.list')->with('success', 'Order updated successfully.');
    }

}
