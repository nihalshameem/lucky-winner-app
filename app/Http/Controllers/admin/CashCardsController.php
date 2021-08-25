<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CashCard;
use App\Models\Category;
use Session;
use Validator;

class CashCardsController extends Controller
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
    public function cashCardList(){
        $cash_cards = CashCard::paginate(15);
        foreach ($cash_cards as $key => $value) {
            $value->cat_name = Category::find($value->cat_id)->name;
        }
        return view('admin.cash_cards.list',[
            'cash_cards' => $cash_cards,
            'search' => '',
        ]);
    }
    public function search(Request $request){
        $search = $request->search;
        if($search == null){
            return redirect('cash-cards/list');
        }
        $cash_cards = CashCard::where('name', 'LIKE', "%$search%")->paginate(15);
        return view('admin.cash_cards.list',[
            'cash_cards' => $cash_cards,
            'search' => $search,
        ]);
    }
    public function addPage(){
        $categories = Category::where('status',1)->get();
        return view('admin.cash_cards.add',['categories'=>$categories]);
    }

    public function addNew(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:cash_cards,name',
            'image' => 'required|mimes:jpeg,jpg,png|max:5000',
            'amount' => 'required|numeric|min:0',
            'cat_id' => 'required',
            'status' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            Session::flash('error', 'Validation Error');
            return redirect()->back()->withErrors($validator);
        }
        $new_card = CashCard::create([
            'name' => $request->name,
            'image' => 'nill',
            'amount' => $request->amount,
            'cat_id' => $request->cat_id,
            'status' => $request->status,
        ]);

        // image
        $imageFile = $request->file('image');
        $imageExt = $imageFile->getClientOriginalExtension();
        $imageDestinationPath = public_path('/images/cash_cards/');
        $imageFilename = $new_card->id . '.' . $imageExt;
        $imageFile->move($imageDestinationPath, $imageFilename);
        $imageFilename = '/images/cash_cards/' . $imageFilename;
        $new_card->image = $imageFilename;
        $new_card->save();
        Session::flash('success','Cash card added');
        return redirect('cash-cards/list');
    }

    public function editPage($id){
        $cat_deactive = false;
        $cash_card = CashCard::find($id);
        $categories = Category::where('status',1)->get();
        $selected_cat =  Category::find($cash_card->cat_id);
        if($cash_card == null){
            Session::flash('error','Cash card not found!');
            return redirect()->back();
        }
        if ($selected_cat->status !== 1) {
            $cat_deactive = true;
            $categories->push($selected_cat);
        }
        return view('admin.cash_cards.edit',[
            'cat_deactive' => $cat_deactive,
            'cash_card' => $cash_card,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request,$id){
        $update = CashCard::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:cash_cards,name,' . $update->id,
            'image' => 'nullable|mimes:jpeg,jpg,png|max:5000',
            'amount' => 'required|numeric|min:0',
            'cat_id' => 'required',
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
            $imageDestinationPath = public_path('/images/cash_cards/');
            $imageFilename = $update->id . '.' . $imageExt;
            $imageFile->move($imageDestinationPath, $imageFilename);
            $imageFilename = '/images/cash_cards/' . $imageFilename;
        }else{
            $imageFilename = $update->image;
        }
        $update->name = $request->name;
        $update->amount = $request->amount;
        $update->cat_id = $request->cat_id;
        $update->status = $request->status;
        $update->image = $imageFilename;
        $update->save();
        Session::flash('success','Cash card updated');
        return redirect('cash-cards/list');
    }

    public function delete($id){
        $cash_card = CashCard::find($id);
        \File::delete(public_path($cash_card->image));
        $cash_card->delete();
        Session::flash('success','Cash card deleted');
        return redirect('cash-cards/list');
    }
}
