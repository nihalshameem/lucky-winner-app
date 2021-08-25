<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Session;
use Validator;

class BannersController extends Controller
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
    public function bannerList(){
        $banners = Banner::paginate(20);
        return view('admin.banners.banner-list',[
            'banners' => $banners
        ]);
    }

    public function addPage(){
        return view('admin.banners.banner-add');
    }

    public function addNew(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'image' => 'required|mimes:jpeg,jpg,png|max:5000',
            'status' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            Session::flash('error', 'Validation Error');
            return redirect()->back()->withErrors($validator);
        }
        $new_card = Banner::create([
            'name' => $request->name,
            'image' => 'nill',
            'status' => $request->status,
        ]);

        // image
        $imageFile = $request->file('image');
        $imageExt = $imageFile->getClientOriginalExtension();
        $imageDestinationPath = public_path('/images/banners/');
        $imageFilename = $new_card->id . '.' . $imageExt;
        $imageFile->move($imageDestinationPath, $imageFilename);
        $imageFilename = '/images/banners/' . $imageFilename;
        $new_card->image = $imageFilename;
        $new_card->save();
        Session::flash('success','New banner added');
        return redirect('banners/list');
    }

    public function editPage($id){
        $banner = Banner::find($id);
        if($banner == null){
            Session::flash('error','Banner not found!');
            return redirect()->back();
        }
        return view('admin.banners.banner-edit',[
            'banner' => $banner,
        ]);
    }

    public function update(Request $request,$id){
        $update = Banner::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
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
            $imageDestinationPath = public_path('/images/banners/');
            $imageFilename = $update->id . '.' . $imageExt;
            $imageFile->move($imageDestinationPath, $imageFilename);
            $imageFilename = '/images/banners/' . $imageFilename;
        }else{
            $imageFilename = $update->image;
        }
        $update->name = $request->name;
        $update->status = $request->status;
        $update->image = $imageFilename;
        $update->save();
        Session::flash('success','Banner updated');
        return redirect('banners/list');
    }

    public function delete($id){
        $banner = Banner::find($id);
        \File::delete(public_path($banner->image));
        $banner->delete();
        Session::flash('success','Banner deleted');
        return redirect('banners/list');
    }
}
