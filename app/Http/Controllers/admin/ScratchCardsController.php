<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ScratchCard;
use App\Models\Bid;
use App\Models\Customer;
use Session;
use Validator;

class ScratchCardsController extends Controller
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
    public function scratchCardList(){
        $scratch_cards = ScratchCard::paginate(15);
        return view('admin.scratch_cards.scratch-list',[
            'scratch_cards' => $scratch_cards,
            'search' => '',
        ]);
    }
    public function search(Request $request){
        $search = $request->search;
        if($search == null){
            return redirect('/scratch-cards/list');
        }
        $scratch_cards = ScratchCard::where('name', 'LIKE', "%$search%")->paginate(15);
        return view('admin.scratch_cards.scratch-list',[
            'scratch_cards' => $scratch_cards,
            'search' => '',
        ]);
    }

    public function createPage($id){
        $bid = Bid::find($id);
        if ($bid == null) {
            Session::flash('error','Bid not found');
            return redirect()->back();
        }
        $exists = ScratchCard::where('bid_id',$bid->id)->first();
        if ($exists !== null) {
            Session::flash('error','Scratch card already exists');
            return redirect()->back();
        }
        return view('admin.scratch_cards.scratch-add',[
            'bid' => $bid
        ]);
    }
    public function addNew(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'image' => 'required|mimes:jpeg,jpg,png|max:5000',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            Session::flash('error', 'Validation Error');
            return redirect()->back()->withErrors($validator);
        }
        $bid = Bid::find($id);
        $new_card = ScratchCard::create([
            'name' => $request->name,
            'amount' => $request->amount,
            'image' => 'nill',
            'bid_id' => $bid->id,
            'cashcard_id' => $bid->cash_card_id,
            'user_id' => $bid->user_id,
            'status' => $request->status,
        ]);

        // image
        $imageFile = $request->file('image');
        $imageExt = $imageFile->getClientOriginalExtension();
        $imageDestinationPath = public_path('/images/scratch_cards/');
        $imageFilename = $new_card->id . '.' . $imageExt;
        $imageFile->move($imageDestinationPath, $imageFilename);
        $imageFilename = '/images/scratch_cards/' . $imageFilename;
        $new_card->image = $imageFilename;
        $new_card->save();
        Session::flash('success','Scratch card added');
        return redirect('/scratch-cards/list');
    }
    public function editPage($id){
        $scratch_card = ScratchCard::find($id);
        if($scratch_card == null){
            Session::flash('error','Scratch card not found!');
            return redirect()->back();
        }
        return view('admin.scratch_cards.scratch-edit',[
            'scratch_card' => $scratch_card,
        ]);
    }
    public function single($id){
        $scratch_card = ScratchCard::find($id);
        if($scratch_card == null){
            Session::flash('error','Scratch card not found!');
            return redirect()->back();
        }
        return view('admin.scratch_cards.scratch-single',[
            'scratch_card' => $scratch_card,
        ]);
    }

    public function update(Request $request,$id){
        $update = ScratchCard::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:5000',
            'amount' => 'required|numeric|min:0',
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
            $imageDestinationPath = public_path('/images/scratch_cards/');
            $imageFilename = $update->id . '.' . $imageExt;
            $imageFile->move($imageDestinationPath, $imageFilename);
            $imageFilename = '/images/scratch_cards/' . $imageFilename;
        }else{
            $imageFilename = $update->image;
        }
        $update->name = $request->name;
        $update->amount = $request->amount;
        $update->status = $request->status;
        $update->image = $imageFilename;
        $update->save();
        Session::flash('success','Cash card updated');
        return redirect('/scratch-cards/list');
    }
    public function winners(){
        $winners = ScratchCard::where('status',0)->get();
        foreach ($winners as $key  => $w) {
            if((date('Y-m-d',strtotime($w->updated_at))) == date('Y-m-d')){
                $w->username = Customer::find($w->user_id)->name;
            }else{
                $winners->forget($key);
            }
        }
        return view('admin.scratch_cards.winners',[
            'winners' => $winners,
        ]);
    }

    public function delete($id){
        $scratch_card = ScratchCard::find($id);
        \File::delete(public_path($scratch_card->image));
        $scratch_card->delete();
        Session::flash('success','Scratch card deleted');
        return redirect('/scratch-cards/list');
    }
}
