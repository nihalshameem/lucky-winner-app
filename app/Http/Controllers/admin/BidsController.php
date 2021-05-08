<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Bid;
use App\Models\CashCard;
use App\Models\Customer;
use App\Models\ScratchCard;
use App\Models\User;
use Session;
use Validator;

class BidsController extends Controller
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
    public function bidList(){
        $bids = Bid::orderBy('created_at','asc')->paginate(15);
        foreach ($bids as $b) {
            $username = Customer::find($b->user_id);
            $cash_card_name = CashCard::find($b->cash_card_id);
            if ($username !== null) {
                $username = $username->name;
            }
            if ($cash_card_name !== null) {
                $cash_card_name = $cash_card_name->name;
            }
            $b->username = $username;
            $b->cash_card_name = $cash_card_name;
            $card = ScratchCard::where('bid_id',$b->id)->first();
            if($card == null){
                $b->card_name = null;
            }else {
                $b->card_name = $card->name;
            }
        }
        return view('admin.bids.bid-list',[
            'bids' => $bids
        ]);
    }
    public function delete($id){
        Bid::find($id)->delete();
        Session::flash('success','Bid deleted');
        return redirect('/bids/list');
    }
}
