<x-app-layout>
    <x-slot name="header">
      <div class="row">
        <div class="col-md-10">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Edit Category
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
                    <form action="{{ route('category.update', $category->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Category Name</label>
                            <input type="text" class="form-control" name="category_name" id="exampleFormControlInput1" placeholder="Enter category name" value="{{ $category->category_name }}">
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
