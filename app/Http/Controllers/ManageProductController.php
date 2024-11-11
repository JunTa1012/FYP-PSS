<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Model\Product as ModelProduct;

class ManageProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function showProductList()
    {
        $products = Product::all();
        return view('ManageProduct.product_list', compact('products'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function addProduct()
    {
        return view('ManageProduct.add_product_form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createProduct(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'product_serial_number' => 'required',
            'product_description' => 'required',
            'product_quantity' => 'required',
            'product_purchase_price' => 'required',
            'product_selling_price' => 'required',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('product_image')) {
            $imageName = time() . '.' . $request->product_image->extension();
            $request->product_image->move(public_path('images/products'), $imageName);
        }
    
        $product = Product::create(array_merge($request->all(), ['product_image' => $imageName]));
    
        return redirect()->route('product.list');
    }

    public function viewProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('ManageProduct.view_product_form', compact('product'));
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('ManageProduct.edit_product_form', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'product_name' => 'required',
            'product_serial_number' => 'required',
            'product_description' => 'required',
            'product_quantity' => 'required',
            'product_purchase_price' => 'required',
            'product_selling_price' => 'required',
            'product_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $imageName = $product->product_image;
        if ($request->hasFile('product_image')) {
            $imageName = time() . '.' . $request->product_image->extension();
            $request->product_image->move(public_path('images/products'), $imageName);
        }

        $product->update(array_merge($request->except('product_image'), ['product_image' => $imageName]));
    
        return redirect()->route('product.list');
    }

    public function deleteProduct($id) {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('product.list')->with('success', 'Product deleted successfully!');
    }

}
