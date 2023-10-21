<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('admin.product.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'price' => 'required',
            'slug' => 'required',
            'image' => 'required'
        ]);

        $data = $request->all();

        foreach ($request->image as $image) {

            $imageName = time() . '.'  . $image->getClientOriginalName();

            $image->move(public_path('images/products'), $imageName);

            ProductImage::create([
                'product_id' => $product->id,
                'image' => 'images/products/' . $imageName
            ]);

        }

        $product = Product::create($data);

        return redirect()->route('admin.product.index')->with('success', 'Product added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::where('id', $id)->first();
        $categories = Category::where('status', 1)->get();

        return view('admin.product.edit', ['product' => $product,'categories'=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'price' => 'required',
            'slug' => 'required'
        ]);

        $product = Product::find($id);

        $data = $request->all();

        if($request->has('image')){
            foreach ($request->image as $image) {
    
                $imageName = time() . '.'  . $image->getClientOriginalName();
    
                $image->move(public_path('images/products'), $imageName);
    
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'images/products/' . $imageName
                ]);
    
            }
        }
        
        $product->update($data);
        
        if($request->has('removed_image')){
            foreach($request->removed_image as $image_id){
                 ProductImage::find($image_id)->delete();
            }
        }
        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Product = Product::find($id);
        $Product->delete();

        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully.');
    }
}
