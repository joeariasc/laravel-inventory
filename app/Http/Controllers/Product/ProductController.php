<?php

namespace App\Http\Controllers\Product;

use App\Helpers\Utilities;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Picqer\Barcode\BarcodeGeneratorHTML;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('products.index', [
            'products' => $products,
        ]);
    }

    public function create()
    {
        return view('products.form', [
            'product' => new Product(),
            'categories' => Category::pluck('name', 'id'),
            'units' => Unit::pluck('name', 'id'),
        ]);
    }

    public function store(ProductRequest $request)
    {
        if ($request->hasFile('product_image')) {
            $image = Utilities::uploadFile('product_image', '/public/products');
            $request->merge(['product_image' => $image]);
        }

        $request->merge(['user_id' => auth()->id()]);

        Product::create($request->input());


        return to_route('products.index')->with('success', 'Product has been created!');
    }

    public function show(Product $product)
    {
        // Generate a barcode
        $generator = new BarcodeGeneratorHTML();

        $barcode = $generator->getBarcode($product->barcode, $generator::TYPE_CODE_128);

        return view('products.show', [
            'product' => $product,
            'barcode' => $barcode,
        ]);
    }

    public function edit(Product $product)
    {
        return view('products.form', [
            'categories' => Category::pluck('name', 'id'),
            'units' => Unit::pluck('name', 'id'),
            'product' => $product
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        if ($request->hasFile('product_image')) {
            Utilities::deleteFile('/public/users', $product->product_image);
            $image = Utilities::uploadFile('product_image', '/public/products');
            $request->merge(['product_image' => $image]);
        }

        $product->fill($request->input())->save();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product has been updated!');
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()
                ->route('products.index')
                ->with('success', 'Product has been deleted!');
        } catch (\Exception) {
            return redirect()
                ->route('products.index')
                ->with('success', 'Failed try to delete the product');
        }
    }
}
