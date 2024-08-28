<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $catagories = Category::latest()->paginate(10);  
        
        $trashList = Category::onlyTrashed()->latest()->paginate(10);

        // $catagories = DB::table('categories')
        // ->join('users', 'categories.user_id', 'users.id')
        // ->select('categories.*', 'users.name')
        // ->latest()
        // ->paginate(10);

        //$catagories = DB::table('categories')->latest()->paginate(10);
        return view('admin.category.index', compact('catagories', 'trashList'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ],
        [
            'category_name.required' => 'Category name is mandatory.',
            'category_name.unique' => 'Category name already exist.',
            'category_name.max' => 'Category name should be lessthan 255 char.',
            
        ]);

        // Category::create([
        //     'user_id' => Auth::user()->id,
        //     'category_name' => $request->category_name,
        // ]);

        // Category::insert([
        //     'user_id' => Auth::user()->id,
        //     'category_name' => $request->category_name,
        // ]);

        // $category = new Category();
        // $category->user_id = Auth::user()->id;
        // $category->category_name = $request->category_name;
        // $category->save();

        DB::table('categories')->insert([
            'user_id' => Auth::user()->id,
            'category_name' => $request->category_name,
        ]);
        
        return redirect()->back()->with('message', 'Category created successfully');
    }

    public function edit($id)
    {
        //$category = Category::find($id);

        $category = DB::table('categories')->where('id', $id)->first();

        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category_name' => 'required|max:255|unique:categories,category_name,' . $id,
        ],
        [
            'category_name.required' => 'Category name is mandatory.',
            'category_name.unique' => 'Category name already exist.',
            'category_name.max' => 'Category name should be lessthan 255 char.',
            
        ]);

        // Category::find($id)->update([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id
        // ]);

        // $category = Category::find($id);
        // $category->user_id = Auth::user()->id;
        // $category->category_name = $request->category_name;
        // $category->save();

        DB::table('categories')->where('id', $id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('category')->with('message', 'Category updated successfully.');

    }

    public function trash($id)
    {
        Category::find($id)->delete();

        return redirect()->route('category')->with('message', 'Category deleted successfully.');
    }

    public function restore($id)
    {
        Category::withTrashed()->find($id)->restore();

        return redirect()->route('category')->with('message', 'Category restored successfully.');
    }
    
    public function destroy($id)
    {
        Category::withTrashed()->find($id)->forceDelete();

        return redirect()->route('category')->with('message', 'Category permanently deleted successfully.');
    }
}
