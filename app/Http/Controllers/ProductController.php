<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->data['title'] = 'Products';

        $rows = 40;

        if ($request->qry == "") {
            $this->data['entities'] = Product::orderBy('created_at', 'DESC')->paginate($rows);
        } else {
            $this->data['entities'] = Product::where('name', 'LIKE', '%' . $request->qry . '%')->orWhere('sku', 'LIKE', '%' . $request->qry . '%')
                ->orderBy('created_at', 'DESC')
                ->paginate($rows)
                ->appends($request->only('qry'));
        }

        return view('products', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {}

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $this->data['title'] = 'Product';

        $this->data['product'] = $product;

        return view('products_show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function updateStatus(Request $request, Product $product)
    {
        if ($request->has('activateBtn')) {

            $product->update([
                'status' => ProductService::ACTIVE
            ]);

            return redirect()->route('products.show', [
                'product' => $product->id
            ])->with('success', 'Product activated successfully.!');
        }

        if ($request->has('suspendBtn')) {
            $product->update([
                'status' => ProductService::SUSPENDED
            ]);

            return redirect()->route('products.show', [
                'product' => $product->id
            ])->with('success', 'Product suspended successfully.!');
        }
    }
}
