<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductGalleryImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.product.index', compact('products'));
    }
    
    public function create()
    {
        $categories = Category::get();
        return view('admin.product.create', compact('categories'));
    }

    public function store(Request $request)
    {       
        $validated = $request->validate([
            'product_name' => 'required|unique:products|max:255|min:3',
            'category_id' => 'required',
            'product_description' => 'nullable|max:255',
            'product_image' => 'required|mimes:png,jpg,jpeg',
            'product_gallery_image.*' => 'mimes:png,jpg,jpeg'
        ],
        [
            'product_name.required' => 'Product name is mandatory.',
            'product_name.unique' => 'Product name already exist.',
            'product_name.max' => 'Product name should be lessthan 255 char.',
            'product_name.min' => 'Product name should be at least 3 char.',
            'category_id.required' => 'Category is mandatory.',
            'product_description.max' => 'Product description should be lessthan 255 char.',
            'product_image.required' => 'Product image is mandatory.',
            'product_image.mimes' => 'Product image type should be png, jpg, jpeg.',
            
        ]);

        // $file = $request->file('product_image');
        // $fileName = date('YmdHi') . '.' . $file->extension();
        // $file->move(public_path('uploads/product'), $fileName);
        // $productPath = 'uploads/product/' . $fileName;

        $file = $request->file('product_image');
        $fileName = date('YmdHi') . '.' . $file->extension();
        $path = public_path('uploads/product/' . $fileName );
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file);
        $image = $image->resize(500, 300);
        $image->toJpeg(80)->save($path);
        $productPath = 'uploads/product/' . $fileName;
        
        $product  = new Product();
        $product->product_name = $request->product_name;
        $product->category_id = $request->category_id;
        $product->product_description = $request->product_description;
        $product->product_image = $productPath;
        $product->save();    
        
        $productGalleryImages = $request->file('product_gallery_image');

        foreach($productGalleryImages as $productGalleryImageFile){

            $fileName = hexdec(uniqid()) . '.' . $productGalleryImageFile->extension();
            $path = public_path('uploads/product/gallery/' . $fileName );
            $manager = new ImageManager(new Driver());
            $image = $manager->read($productGalleryImageFile);
            $image = $image->resize(500, 300);
            $image->toJpeg(80)->save($path);
            $productGalleryImagePath = 'uploads/product/gallery/' . $fileName;

            $productGalleryImage = new ProductGalleryImage();
            $productGalleryImage->product_id = $product->id;
            $productGalleryImage->image = $productGalleryImagePath;
            $productGalleryImage->save();

        }

        return redirect()->back()->with('message', 'Product created successfully.');


    }

    public function edit($id)
    {
        $categories = Category::get();
        $product = Product::with('productGalleryImage')->find($id);
        $productGalleryImage = ProductGalleryImage::where('product_id', $id)->get();
        return view('admin.product.edit', compact('product', 'categories', 'productGalleryImage'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_name' => 'required|max:255|min:3|unique:products,product_name,' . $id,
            'category_id' => 'required',
            'product_description' => 'nullable|max:255',
            'product_image' => 'nullable|mimes:png,jpg,jpeg',
        ],
        [
            'product_name.required' => 'Product name is mandatory.',
            'product_name.unique' => 'Product name already exist.',
            'product_name.max' => 'Product name should be lessthan 255 char.',
            'product_name.min' => 'Product name should be at least 3 char.',
            'category_id.required' => 'Category is mandatory.',
            'product_description.max' => 'Product description should be lessthan 255 char.',            
            'product_image.mimes' => 'Product image type should be png, jpg, jpeg.',
            
        ]);

        $productPath = null;

        if($request->file('product_image')){
            $file = $request->file('product_image');
            $fileName = date('YmdHi') . '.' . $file->extension();
            $file->move(public_path('uploads/product'), $fileName);
            $productPath = 'uploads/product/' . $fileName;
                        
           if(File::exists($request->product_image_old)){
             unlink($request->product_image_old);
             //File::delete($request->product_image_old);
           }
            
        }
        

        $product  = Product::find($id);
        $product->product_name = $request->product_name;
        $product->category_id = $request->category_id;
        $product->product_description = $request->product_description;
        if($productPath != null){
            $product->product_image = $productPath;
        }        
        $product->save();

        return redirect()->route('product')->with('message', 'Product updated successfully.');

    }

    public function destroy($id)
    {
        if($id){
            $product = Product::find($id);
            if($product){
                if(isset($product->product_image)){
                   if(File::exists($product->product_image)){
                        File::delete($product->product_image);
                   }
                }
                $product->delete();

                return redirect()->route('product')->with('message', 'Product deleted successfully.');

            }
        }
    }
}
