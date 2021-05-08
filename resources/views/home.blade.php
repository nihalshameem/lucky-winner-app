@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard</h1>
    <hr>
    <h4>Welcome back, {{ Auth::user()->name }}</h4>
    <div class="row justify-content-center equaller">
        <div class="col-lg-3 col-md-5">
            <div class="card dash-box" style="background: ghostwhite">
                <div class="card-header text-dark">Minimum Withdraw</div>
                <form action="{{url('/min-withdraw/update')}}" id="minwdForm" method="POST" class="card-body">
                    @csrf
                    <input type="number" class="form-control form-control-sm" value="{{$min_withdraw}}" name="amount" min="0" required>
                </form>
                <div class="card-footer text-dark" style="background: rgba(0,0,0,.03)">
                    <button form="minwdForm" class=""><i class="mdi mdi-rotate-3d-variant"></i> Update</button>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-5">
            <div class="card dash-box" style="background: blueviolet">
                <div class="card-header">Cash Cards</div>
                <a href="{{('/cash-cards/list')}}" class="card-body">
                    <p>Total Cards: {{$cash_card}}</p>
                    <p>Active Cards: {{$cash_card_active}}</p>
                </a>
                <div class="card-footer">
                    <a href="{{url('/cash-cards/add')}}" class=""><i class="mdi mdi-plus"></i> ADD CARD</a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-5">
            <div class="card dash-box" style="background: forestgreen">
                <div class="card-header">Scratch Cards</div>
                <a href="{{url('/scratch-cards/list')}}" class="card-body">
                    <p>Scratched Cards: {{$scratched}}</p>
                    <p>Unscratched Cards: {{$unscratch}}</p>
                    <p>Total Cards: {{$scratch_card}}</p>
                </a>
                <div class="card-footer" style="background: rgb(42, 124, 42)">
                    <a href="{{url('/scratch-cards/winners')}}" class=""><i class="mdi mdi-gift-open-outline"></i> TODAY WINNERS</a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-5">
            <div class="card dash-box" style="background: brown">
                <div class="card-header">Bannners</div>
                <a href="{{url('/banners/list')}}" class="card-body">
                    <p>Banner Active: {{$banner_active}}</p>
                    <p>Banner Inactive: {{$banner_inactive}}</p>
                    <p>Banner Total: {{$banner_total}}</p>
                </a>
                <div class="card-footer" style="background: rgb(131, 40, 40)">
                    <a href="{{url('/banners/add')}}" class=""><i class="mdi mdi-plus"></i> ADD BANNER</a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-5">
            <div class="card dash-box" style="background: rebeccapurple">
                <div class="card-header">Bids</div>
                <a href="{{url('/bids/list')}}" class="card-body">
                    <p>Total Bids: {{$bids}}</p>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-5">
            <div class="card dash-box" style="background: dodgerblue">
                <div class="card-header">Customers</div>
                <a href="{{url('/customers/list')}}" class="card-body">
                    <p>No. of Users: {{$customers}}</p>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-5">
            <div class="card dash-box" style="background: crimson">
                <div class="card-header">Withdraw Requests</div>
                <a href="{{url('/withdraw-request/list')}}" class="card-body">
                    <p>No. of Requests: {{$req_count}}</p>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-5">
            <div class="card dash-box" style="background: steelblue">
                <div class="card-header">Paid List</div>
                <a href="{{url('/paids/list')}}" class="card-body">
                    <p>Paids: {{$paid_count}}</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
