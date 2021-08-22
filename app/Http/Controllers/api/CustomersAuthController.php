<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Validator;

class CustomersAuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:customers,email',
                'phone' => 'required|numeric|digits:10|unique:customers,phone',
                'password' => 'required|min:4',
                'confirm_password' => 'required|same:password',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '0',
                'name' => implode('',$validator->messages()->get('name')),
                'email' => implode('',$validator->messages()->get('email')),
                'phone' => implode('',$validator->messages()->get('phone')),
                'password' => implode('',$validator->messages()->get('password')),
                'confirm_password' => implode('',$validator->messages()->get('confirm_password')),
            ]);
        }
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $password = bcrypt($request->password);
        $user = Customer::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $password,
        ]);
        return response()->json([
            'status' => '1',
            'success' => 'customer registered!',
        ]);
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(),
            [
                'username' => 'required',
                'password' => 'required|min:4',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '0',
                'username' => implode('',$validator->messages()->get('username')),
                'password' => implode('',$validator->messages()->get('password')),
            ]);
        }
        if(is_numeric($request->username)){
            $user = Customer::where('phone', $request->username)->first();
        }else{
            $user = Customer::where('email', $request->username)->first();
        }
        if ($user !== null) {
            $length = strlen($user->id);
            if (\Hash::check($request->password, $user->password)) {
                $user->api_token = $user->id.str_random(60 - $length);
                $user->save();
                return response()->json([
                    'status' => '1',
                    'api_token' => $user->api_token,
                ]);
            }
            return response()->json([
                'status' => '0',
                'message' => 'Password Incorrect'
            ]);
        }

        return response()->json([
            'status' => '0',
            'message' => 'Unauthenticated user'
        ]);
    }

    public function update(Request $request,$token){
        $user = customer::where('api_token', $token)->first();
        if ($user == null) {return response()->json(['error' => 'Authentication error']);}
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:customers,email,' . $user->id,
                'phone' => 'required|numeric|digits:10|unique:customers,phone,' . $user->id,
                'bank_name' => 'required',
                'branch' => 'required',
                'account_no' => 'required|numeric',
                'account_holder_name' => 'required',
                'ifsc' => 'required',
            ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '0',
                'name' => implode('',$validator->messages()->get('name')),
                'email' => implode('',$validator->messages()->get('email')),
                'phone' => implode('',$validator->messages()->get('phone')),
                'bank_name' => implode('',$validator->messages()->get('bank_name')),
                'branch' => implode('',$validator->messages()->get('branch')),
                'account_no' => implode('',$validator->messages()->get('account_no')),
                'account_holder_name' => implode('',$validator->messages()->get('account_holder_name')),
                'ifsc' => implode('',$validator->messages()->get('ifsc')),
                'upi_id' => implode('',$validator->messages()->get('upi_id')),
            ]);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->bank_name = $request->bank_name;
        $user->branch = $request->branch;
        $user->account_no = $request->account_no;
        $user->account_holder_name = $request->account_holder_name;
        $user->ifsc = $request->ifsc;
        $user->upi_id = $request->upi_id;
        $user->status = 1;
        $user->save();
        Wallet::create([
            'user_id' => $user->id,
            'amount'=>0
            ]);
        return response()->json([
            'status' => '1',
            'success' => 'Profile Updated'
            ]);
    }
    public function changePassword(Request $request,$token){
        $user = customer::where('api_token', $token)->first();
        if ($user == null) {return response()->json(['error' => 'Authentication error']);}
        $validator = Validator::make($request->all(),
            [
                'password' => 'required|min:4',
                'confirm_password' => 'required|same:password',
            ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => '0',
                'password' => implode('',$validator->messages()->get('password')),
                'confirm_password' => implode('',$validator->messages()->get('confirm_password')),
            ]);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            'status' => '1',
            'success' => 'Password Changed'
            ]);
    }
    public function profile($token){
        $user = Customer::where('api_token', $token)->first();
        if ($user == null) {
            return response()->json([
                'status' => '0',
                'message' => 'Authentication error'
            ]);
        }
        return response()->json([
            'user' => $user,
        ]);
        
    }
}
