<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use Session;
use Validator;

class CategoriesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function categoryList(){
        $categories = Category::paginate(15);
        return view('admin.categories.list',[
            'categories' => $categories,
            'search' => '',
        ]);
    }
    public function search(Request $request){
        $search = $request->search;
        if($search == null){
            return redirect('/categories/list');
        }
        $categories = Category::where('name', 'LIKE', "%$search%")->paginate(15);
        return view('admin.categories.list',[
            'categories' => $categories,
            'search' => $search,
        ]);
    }
    public function addPage(){
        return view('admin.categories.add');
    }

    public function addNew(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name',
            'image' => 'required|mimes:jpeg,jpg,png|max:5000',
            'status' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            Session::flash('error', 'Validation Error');
            return redirect()->back()->withErrors($validator);
        }
        $new_card = Category::create([
            'name' => $request->name,
            'image' => 'nill',
            'status' => $request->status,
        ]);

        // image
        $imageFile = $request->file('image');
        $imageExt = $imageFile->getClientOriginalExtension();
        $imageDestinationPath = public_path('/images/categories/');
        $imageFilename = $new_card->id . '.' . $imageExt;
        $imageFile->move($imageDestinationPath, $imageFilename);
        $imageFilename = '/images/categories/' . $imageFilename;
        $new_card->image = $imageFilename;
        $new_card->save();
        Session::flash('success','Category added');
        return redirect('/categories/list');
    }

    public function editPage($id){
        $category = Category::find($id);
        if($category == null){
            Session::flash('error','Category not found!');
            return redirect()->back();
        }
        return view('admin.categories.edit',[
            'category' => $category,
        ]);
    }

    public function update(Request $request,$id){
        $update = Category::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name,' . $update->id,
            'image' => 'nullable|mimes:jpeg,jpg,png|max:5000',
            'status' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            Session::flash('error', 'Validation Error');
            return redirect()->back()->withErrors($validator);
        }
        if ($request->hasFile('image')) {
            \File::delete(public_path($update->image));
            // image
            $imageFile = $request->file('image');
            $imageExt = $imageFile->getClientOriginalExtension();
            $imageDestinationPath = public_path('/images/categories/');
            $imageFilename = $update->id . '.' . $imageExt;
            $imageFile->move($imageDestinationPath, $imageFilename);
            $imageFilename = '/images/categories/' . $imageFilename;
        }else{
            $imageFilename = $update->image;
        }
        $update->name = $request->name;
        $update->status = $request->status;
        $update->image = $imageFilename;
        $update->save();
        Session::flash('success','Category updated');
        return redirect('/categories/list');
    }

    public function delete($id){
        $category = Category::find($id);
        \File::delete(public_path($category->image));
        $category->delete();
        Session::flash('success','Category deleted');
        return redirect('/categories/list');
    }
}
