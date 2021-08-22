<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Banner;
use App\Models\Bid;
use App\Models\Category;
use App\Models\CashCard;
use App\Models\ScratchCard;
use App\Models\Customer;
use App\Models\MinimumWithdraw;
use App\Models\Wallet;
use App\Models\WithdrawRequest;
use App\Models\RazorPayKey;
use Validator;

class ApiController extends Controller
{

    public function categories($token)
    {
        $user = Customer::where('api_token', $token)->first();
        if ($user == null) {
            return response()->json([
                'status' => '0',
                'message' => 'Authentication error'
            ]);
        }
        $categories = Category::where('status', 1)->get();
        return response()->json([
            'categories' => $categories,
        ]);
    }

    public function cashCards($token)
    {
        $user = Customer::where('api_token', $token)->first();
        if ($user == null) {
            return response()->json([
                'status' => '0',
                'message' => 'Authentication error'
            ]);
        }
        $cash_cards = CashCard::where('status', 1)->get();
        foreach ($cash_cards as $key => $value) {
            $category = Category::find($value->cat_id);
            if ($category->status != 1) {
                $cash_cards->forget($key);
            }else{
                $value->category = $category;
            }
        }
        return response()->json([
            'cash_cards' => $cash_cards,
        ]);
    }

    public function singleCategory($id){
        $category = Category::where('id',$id)->where('status',1)->first();
        if ($category == null) {
            return response()->json([
                'status' => '0',
                'message' => 'Category Not Found!',
            ]);
        }
        $cash_cards = CashCard::where('cat_id',$id)->where('status',1)->get();
        return response()->json([
            'status' => '1',
            'category' => $id,
            'cash_cards' => $cash_cards,
        ]);
    }
    public function newBid(Request $request,$token){
        $user = Customer::where('api_token', $token)->first();
        if ($user == null) {
            return response()->json([
                'status' => '0',
                'message' => 'Authentication error'
            ]);
        }
        $validator = Validator::make($request->all(),
            [
                'cash_card_id' => 'required',
                'payment_status' => 'required',
            ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => '0',
                'cash_card_id' => implode('',$validator->messages()->get('cash_card_id')),
                'payment_status' => implode('',$validator->messages()->get('payment_status')),
            ]);
        }
        $cardExists = CashCard::find($request->cash_card_id);
        if($cardExists == null){
            return response()->json([
                'status' => '0',
                'message' => 'Cash card does not exists'
            ]);
        }
        Bid::create([
            'user_id' => $user->id,
            'cash_card_id' => $request->cash_card_id,
            'payment_status' => $request->payment_status,
        ]);
        return response()->json([
            'status' => '1',
            'success' => 'Bid created'
        ]);
    }
    public function scratchCards($token)
    {
        $user = Customer::where('api_token', $token)->first();
        if ($user == null) {
            return response()->json([
                'status' => '0',
                'message' => 'Authentication error'
            ]);
        }
        $unscratched = ScratchCard::where('status', 1)->where('user_id',$user->id)->get();
        $scratched = ScratchCard::where('status', 0)->where('user_id',$user->id)->get();
        return response()->json([
            'unscratched' => $unscratched,
            'scratched' => $scratched,
            'user' => $user,
        ]);
    }
    public function scratched(Request $request,$token)
    {
        $user = Customer::where('api_token', $token)->first();
        if ($user == null) {
            return response()->json([
                'status' => '0',
                'message' => 'Authentication error'
            ]);
        }
        $validator = Validator::make($request->all(),[
                'card_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => '0',
                'card_id' => implode('',$validator->messages()->get('card_id')),
            ]);
        }
        $card = ScratchCard::find($request->card_id);
        $card->status = 0;
        $card->save();
        $wallet = Wallet::where('user_id',$user->id)->first();
        if($wallet == null){
            Wallet::create([
                'user_id' => $user->id,
                'amount' => $card->amount,
            ]);
        }else {
            $wallet->amount = $wallet->amount + $card->amount;
            $wallet->save();
        }
        return response()->json([
            'status' => '1',
            'message' => 'Amount added to wallet',
        ]);
    }
    public function wallet($token){
        $user = Customer::where('api_token', $token)->first();
        if ($user == null) {
            return response()->json([
                'status' => '0',
                'message' => 'Authentication error'
            ]);
        }
        $wallet = Wallet::where('user_id',$user->id)->first();
        if ($wallet == null) {
            return response()->json([
                'status' => '0',
                'message' => 'Wallet not found',
            ]);
        }
        return response()->json([
            'wallet' => $wallet->amount,
        ]);
    }
    public function withdrawReq($token){
        $user = Customer::where('api_token', $token)->first();
        if ($user == null) {
            return response()->json([
                'status' => '0',
                'message' => 'Authentication error'
            ]);
        }
        $wallet = Wallet::where('user_id',$user->id)->first();
        if($wallet == null){
            return response()->json([
                'status' => '0',
                'message' => 'Wallet not found! create your Profile to continue.',
            ]);
        }
        $req = WithdrawRequest::where('user_id',$user->id)->first();
        if($req !== null){
            return response()->json([
                'status' => '0',
                'message' => 'Previous request pending',
            ]);
        }
        $amount = $wallet->amount;
        $wallet->amount = 0;
        $wallet->save();
        WithdrawRequest::create([
            'user_id' => $user->id,
            'amount' => $amount,
        ]);
        return response()->json([
            'status' => '1',
            'success' => 'Request success',
        ]);
    }
    public function minWithdraw($token){
        $user = Customer::where('api_token', $token)->first();
        if ($user == null) {
            return response()->json([
                'status' => '0',
                'message' => 'Authentication error'
            ]);
        }
        $min_withdraw = MinimumWithdraw::find(1);
        return response()->json([
            'status' => '1',
            'min_withdraw' => $min_withdraw->amount,
        ]);
    }
    public function bannerList(){
        $banners = Banner::where('status',1)->get();
        return response()->json([
            'status' => '1',
            'banners' => $banners,
        ]);
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
        return response()->json([
            'status' => '1',
            'winners' => $winners,
        ]);
    }
    public function paymentKey(){
        $payment_key = RazorPayKey::find(1);
        return response()->json([
            'status' => '1',
            'winners' => $payment_key->key,
        ]);
    }
}
