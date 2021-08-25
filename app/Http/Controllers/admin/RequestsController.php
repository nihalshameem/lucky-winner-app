<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\WithdrawRequest;
use App\Models\Wallet;
use App\Models\Customer;
use App\Models\Paid;
use Session;
use Validator;


class RequestsController extends Controller
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
    public function reqList(){
        $withdraw_req = WithdrawRequest::paginate(15);
        foreach ($withdraw_req as $r) {
            $r->user = Customer::find($r->user_id);
        }
        return view('admin.withdraw_req.req-list',[
            'withdraw_req' => $withdraw_req,
        ]);
    }
    public function reqDecline($id){
        $req = WithdrawRequest::find($id);
        if($req == null){
            Session::flash('error','Request not found');
            return redirect()->back();
        }
        $wallet = Wallet::where('user_id',$req->user_id)->first();
        if ($wallet == null) {
            Wallet::create([
                'user_id' => $req->user_id,
                'amount' => $req->amount
            ]);
        } else {
            $wallet->amount = $wallet->amount + $req->amount;
            $wallet->save();
        }
        $req->delete();
        Session::flash('success','Request Declined');
        return redirect('withdraw-request/list');
    }
    public function paid($id){
        $req = WithdrawRequest::find($id);
        if($req == null){
            Session::flash('error','Request not found');
            return redirect()->back();
        }
        $cus = Customer::find($req->user_id);
        Paid::create([
            'user_id' => $req->user_id,
            'amount' => $req->amount,
            'name' => $cus->name,
            'email' => $cus->email,
            'phone' => $cus->phone,
            'bank_name' => $cus->bank_name,
            'branch' => $cus->branch,
            'account_no' => $cus->account_no,
            'account_holder_name' => $cus->account_holder_name,
            'ifsc' => $cus->ifsc,
            'upi_id' => $cus->upi_id,
        ]);
        $req->delete();
        Session::flash('success','Amount Paid');
        return redirect('withdraw-request/list');
    }
    public function reqSheet(){
        $withdraw_req = WithdrawRequest::all();
        $list = [];
        foreach ($withdraw_req as $r) {
            $u = Customer::find($r->user_id);
            $l = [];
            $l['user'] = $u->name.'('.$u->id.')';
            $l['email'] = $u->email;
            $l['phone'] = $u->phone;
            $l['account_holder_name'] = $u->account_holder_name;
            $l['bank_name'] = $u->bank_name;
            $l['branch'] = $u->branch;
            $l['account_no'] = $u->account_no;
            $l['ifsc'] = $u->ifsc;
            $l['upi_id'] = $u->upi_id;
            $l['amount'] = $r->amount;
            $list[] = $l;
        }
        return response()->json($list);
    }
}
