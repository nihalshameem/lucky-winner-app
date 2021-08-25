<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Banner;
use App\Models\Bid;
use App\Models\Category;
use App\Models\CashCard;
use App\Models\ScratchCard;
use App\Models\User;
use App\Models\Customer;
use App\Models\MinimumWithdraw;
use App\Models\WithdrawRequest;
use App\Models\Paid;
use App\Models\RazorPayKey;
use Session;
use Validator;
use Redirect;
use URL;

class HomeController extends Controller
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
    public function index()
    {
        $categories = count(Category::all());
        $cash_card = count(CashCard::all());
        $cash_card_active = count(CashCard::where('status',1)->get());
        $scratch_card = count(ScratchCard::all());
        $unscratch = count(ScratchCard::where('status',1)->get());
        $scratched = count(ScratchCard::where('status',0)->get());
        $bids = count(Bid::all());
        $customers = count(Customer::all());
        $min_withdraw = MinimumWithdraw::find(1)->amount;
        $req_count = count(WithdrawRequest::all());
        $paid_count = count(Paid::all());
        $banner_total = count(Banner::all());
        $banner_active = count(Banner::where('status',1)->get());
        $banner_inactive = count(Banner::where('status',0)->get());
        $payment_key = RazorPayKey::find(1);
        return view('home',[
            'categories' => $categories,
            'cash_card' => $cash_card,
            'cash_card_active' => $cash_card_active,
            'scratch_card' => $scratch_card,
            'unscratch' => $unscratch,
            'scratched' => $scratched,
            'bids' => $bids,
            'customers' => $customers,
            'min_withdraw' => $min_withdraw,
            'req_count' => $req_count,
            'paid_count' => $paid_count,
            'banner_total' => $banner_total,
            'banner_active' => $banner_active,
            'banner_inactive' => $banner_inactive,
            'payment_key' => $payment_key->key,
        ]);
    }

    public function profile(){
        $profile = User::find(auth()->user()->id);
        return view('admin.profile.profile',[
            'profile' => $profile
        ]);
    }

    public function paymentKey(Request $request){
        $payment_key = RazorPayKey::find(1);
        $payment_key->key = $request->key;
        $payment_key->save();
        
        Session::flash('success','Payment Key updated');
        return redirect('home');
    }

    public function profileUpdate(Request $request){
        $profile = User::find(auth()->user()->id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$profile->id,
            'password' => 'nullable|min:4|max:8',
        ]);
        if ($validator->fails()) {
            Session::flash('error', 'Validation Error');
            return Redirect::to(URL::previous() . "#update")->withErrors($validator);
        }
        $profile->name = $request->name;
        $profile->email = $request->email;
        if(!empty($request->password)){
            $profile->password = bcrypt($request->password);
        }
        $profile->save();
        Session::flash('success','Profile updated');
        return redirect('profile');
    }
    public function minWithdraw(Request $request){
        $min = MinimumWithdraw::find(1);
        $min->amount = $request->amount;
        $min->save();
        Session::flash('success','Minimum withdraw updated');
        return redirect('home');
    }
}
