<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\Paid;
use Session;
use Validator;

class PaidsController extends Controller
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
    public function paidList(){
        $paids = Paid::paginate(15);
        return view('admin.paids.paid-list',[
            'paids' => $paids,
        ]);
    }
    public function single($id){
        $paid = Paid::find($id);
        if($paid == null){
            Session::flash('error','Paid-details not found');
            return redirect()->back();
        }
        return view('admin.paids.paid-single',[
            'paid' => $paid,
        ]);
    }
    public function delete($id){
        Paid::find($id)->delete();
        Session::flash('success','Payment deleted');
        return redirect('/paids/list');
    }
    public function sheet(){
        $paids = Paid::all();
        $list = [];
        foreach ($paids as $p) {
            $l = [];
            $l['user'] = $p->name.'('.$p->user_id.')';
            $l['email'] = $p->email;
            $l['phone'] = $p->phone;
            $l['account_holder_name'] = $p->account_holder_name;
            $l['bank_name'] = $p->bank_name;
            $l['branch'] = $p->branch;
            $l['account_no'] = $p->account_no;
            $l['ifsc'] = $p->ifsc;
            $l['upi_id'] = $p->upi_id;
            $l['amount'] = $p->amount;
            $l['paid_on'] = date('Y-m-d',strtotime($p->created_at));
            $list[] = $l;
        }
        return response()->json($list);
    }
}
