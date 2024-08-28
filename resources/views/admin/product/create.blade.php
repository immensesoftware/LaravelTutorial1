<x-app-layout>
    <x-slot name="header">
      <div class="row">
        <div class="col-md-10">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Create Product
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
                    @if(session('message'))        
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('message') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                    @endif
                    </div>
                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="product_name" id="exampleFormControlInput1" placeholder="Enter product name">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Category Name</label>
                            <select name="category_id" class="form-select" aria-label="Default select example">
                                <option selected disabled>select</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                              </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Description</label>
                            <input type="text" class="form-control" name="product_description" id="exampleFormControlInput1" placeholder="Enter product description">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Product Image</label>
                            <input type="file" class="form-control" name="product_image" id="exampleFormControlInput1" placeholder="Enter product description">
                        </div>    
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Product Gallery Image</label>
                            <input type="file" class="form-control" multiple="" name="product_gallery_image[]" id="exampleFormControlInput1" placeholder="Enter product description">
                        </div>                    
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary mb-3">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
