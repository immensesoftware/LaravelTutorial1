<x-app-layout>
    <x-slot name="header">
      <div class="row">
        <div class="col-md-10">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Category
        </h2>
        </div>
        <div class="col-md-2">
          <a class="btn btn-primary" href="{{ route('category.create') }}">Create Category</a>
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
                            <th scope="col">Category Name</th>
                            <th scope="col">User</th>
                            <th scope="col">Created At</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                         @foreach($catagories as $category)  
                          <tr>
                            <th scope="row">{{ $catagories->firstItem() + $loop->index }}</th>
                            <td>{{ $category->category_name }}</td>
                            <td>{{ $category->user->name }}</td>
                            @if($category->created_at)
                            <td>{{ Carbon\Carbon::parse($category->created_at)->diffForHumans() }}</td>
                            @else
                            <td>No Date</td>
                            @endif
                            <td>
                              <a class="btn btn-secondary" href="{{ route('category.edit', $category->id) }}">Edit</a>
                              {{-- <a class="btn btn-danger" href="">Delete</a>--}}
                              <a class="btn btn-danger" href="javascript:void();"
                                  onclick="event.preventDefault(); document.getElementById('delete-form-{{$category->id}}').submit();">Delete</a>
                              <form id="delete-form-{{$category->id}}" action="{{ route('category.trash', $category->id ) }}" method="POST" style="display: none;">
                                  @csrf
                              </form>
                            </td>
                          </tr>
                         @endforeach
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="5">
                              {{ $catagories->links() }}
                            </td>
                          </tr>
                        </tfoot>
                      </table>
                </div>
            </div>  
            {{-- trash list --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-10">
              
              <div class="p-6 text-gray-900">
                <p>Trash List</p>
                  <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">SL No</th>
                          <th scope="col">Category Name</th>
                          <th scope="col">User</th>
                          <th scope="col">Deleted At</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                       @foreach($trashList as $trash)  
                        <tr>
                          <th scope="row">{{ $trashList->firstItem() + $loop->index }}</th>
                          <td>{{ $trash->category_name }}</td>
                          <td>{{ $trash->user->name }}</td>
                          @if($trash->deleted_at)
                          <td>{{ Carbon\Carbon::parse($trash->deleted_at)->diffForHumans() }}</td>
                          @else
                          <td>No Date</td>
                          @endif
                          <td>
                            {{-- <a class="btn btn-secondary" href="{{ route('category.edit', $trash->id) }}">Restore</a> --}}
                            <a class="btn btn-secondary" href="javascript:void();"
                                onclick="event.preventDefault(); document.getElementById('restore-form-{{$trash->id}}').submit();">Restore</a>
                            <form id="restore-form-{{$trash->id}}" action="{{ route('category.restore', $trash->id ) }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            {{-- <a class="btn btn-danger" href="">Delete</a>--}}
                            <a class="btn btn-danger" href="javascript:void();"
                                onclick="event.preventDefault(); document.getElementById('destroy-form-{{$trash->id}}').submit();">Permanent Delete</a>
                            <form id="destroy-form-{{$trash->id}}" action="{{ route('category.destroy', $trash->id ) }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                          </td>
                        </tr>
                       @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="5">
                            {{ $trashList->links() }}
                          </td>
                        </tr>
                      </tfoot>
                    </table>
              </div>
          </div> 
        </div>
    </div>
</x-app-layout>
