<x-app-layout>
    <x-slot name="header">
      <div class="row">
        <div class="col-md-10">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Edit Product
        </h2>
        </div>
        <div class="col-md-2">
          
        </div>
      </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="row">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif                    
                    </div>
                    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_image_old" value="{{ $product->product_image }}">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="product_name" id="exampleFormControlInput1" placeholder="Enter product name" value="{{ $product->product_name }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Category Name</label>
                            <select name="category_id" class="form-select" aria-label="Default select example">
                                <option selected disabled>select</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                @endforeach
                              </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Description</label>
                            <input type="text" class="form-control" name="product_description" id="exampleFormControlInput1" placeholder="Enter product description" value="{{ $product->product_description }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Product Image</label>
                            <input type="file" class="form-control" name="product_image" id="exampleFormControlInput1" placeholder="Enter product description">
                        </div>
                        <div class="mb-3">
                            <img src="{{ asset($product->product_image) }}" alt="" style="width:200px; height:100px;">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Product Gallery Image</label>
                            <input type="file" class="form-control" multiple="" name="product_gallery_image[]" id="exampleFormControlInput1" placeholder="Enter product description">
                        </div>   
                        <div class="mb-3">
                            <div class="row">
                                {{-- @foreach($product->productGalleryImage as $image) --}}
                                @foreach($productGalleryImage as $image)
                                <div class="col-md-3">
                                    <div class="card">
                                        <img class="card-img-top" src="{{ asset($image->image) }}" alt="">
                                        <div class="card-body text-center">
                                            Details
                                        </div>
                                    </div>
                                </div>
                               @endforeach 
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary mb-3">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
