<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\Wallet;
use Session;
use Validator;

class CustomersController extends Controller
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
    public function customerList(){
        $customers = Customer::paginate(15);
        foreach ($customers as $cus) {
            $wallet = Wallet::where('user_id',$cus->id)->first();
            if ($wallet == null) {
                $cus->wallet = '0.00';
            } else {
                $cus->wallet = $wallet->amount;
            }
        }
        return view('admin.customers.customer-list',[
            'customers' => $customers,
            'search' => '',
        ]);
    }
    public function search(Request $request){
        $search = $request->search;
        if($search == null){
            return redirect('/customers/list');
        }
        $customers = Customer::where('name', 'LIKE', "%$search%")->orWhere('phone', 'LIKE', "%$search%")->orWhere('email', 'LIKE', "%$search%")->paginate(15);
        return view('admin.customers.customer-list',[
            'customers' => $customers,
            'search' => $search,
        ]);
    }
    public function detail($id){
        $customer = Customer::find($id);
        if($customer == null){
            Session::flash('error','Customer not found');
            return redirect()->back();
        }
        return view('admin.customers.customer-detail',[
            'customer' => $customer
        ]);
    }

    public function delete($id){
        Customer::find($id)->delete();
        Session::flash('success','Customer deleted');
        return redirect('/customers/list');
    }
}
