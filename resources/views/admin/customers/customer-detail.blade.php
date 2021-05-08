@extends('layouts.app')
@section('title')
    Customer | Details
@endsection
@section('content')
    <div class="container single-container">
        <h3 class="mb-3">Customer Details<button type="button" id="deleteBtn" class="btn btn-sm bg-white text-danger float-right" data-toggle="tooltip" data-placement="bottom" title="Delete User"><i class="mdi mdi-delete mdi-24px"></i></button></h3>
        <hr>
        <div class="table-responsive">
            <table class="table cus-table">
                <tbody>
                    <tr>
                        <td class="form-text text-muted">General</td>
                    </tr>
                    <tr>
                        <th>Name:</th>
                        <td>{{$customer->name}}</td>
                        <th>Email:</th>
                        <td>{{$customer->email}}</td>
                    </tr>
                    <tr>
                        <th>Phone:</th>
                        <td>{{$customer->phone}}</td>
                    </tr>
                    <tr>
                        <td class="form-text text-muted">Bank Details</td>
                    </tr>
                    <tr>
                        <th>Bank Name:</th>
                        <td>{{$customer->bank_name}}</td>
                        <th>Branch:</th>
                        <td>{{$customer->branch}}</td>
                    </tr>
                    <tr>
                        <th>Account No.:</th>
                        <td>{{$customer->account_no}}</td>
                        <th>Account Holder Name:</th>
                        <td>{{$customer->account_holder_name}}</td>
                    </tr>
                    <tr>
                        <th>IFSC:</th>
                        <td>{{$customer->ifsc}}</td>
                        <th>UPI ID:</th>
                        <td>{{$customer->upi_id}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<form action="{{('/customers/delete/'.$customer->id)}}" method="post" id="deleteForm">
    @csrf
</form>
@endsection