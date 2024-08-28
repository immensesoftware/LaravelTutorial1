<x-app-layout>
    <x-slot name="header">
      <div class="row">
        <div class="col-md-10">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Product
        </h2>
        </div>
        <div class="col-md-2">
          <a class="btn btn-primary" href="{{ route('product.create') }}">Create Product</a>
        </div>
      </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          @if(session('message'))        
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>{{ session('message') }}</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
          @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">SL No</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Image</th>
                            <th scope="col">Created At</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                         @foreach($products as $product)  
                          <tr>
                            <th scope="row">{{ $products->firstItem() + $loop->index }}</th>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->category->category_name }}</td>
                            <td>
                              <img src="{{ asset($product->product_image) }}" style="width:50px; height:50px;">
                            </td>
                            @if($product->created_at)
                            <td>{{ $product->created_at->diffForHumans() }}</td>
                            @else
                            <td>No Date</td>
                            @endif
                            <td>
                              <a class="btn btn-secondary" href="{{ route('product.edit', $product->id) }}">Edit</a>
                              {{-- <a class="btn btn-danger" href="">Delete</a>--}}
                              <a class="btn btn-danger" href="javascript:void();"
                                  onclick="event.preventDefault(); document.getElementById('delete-form-{{$product->id}}').submit();">Delete</a>
                              <form id="delete-form-{{$product->id}}" action="{{ route('product.destroy', $product->id ) }}" method="POST" style="display: none;">
                                  @csrf
                              </form>
                            </td>
                          </tr>
                         @endforeach
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="6">
                              {{ $products->links() }}
                            </td>
                          </tr>
                        </tfoot>
                      </table>
                </div>
            </div>  
            
        </div>
    </div>
</x-app-layout>
