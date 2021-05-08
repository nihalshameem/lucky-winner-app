@extends('layouts.app')
@section('title')
    Paid | Details
@endsection
@section('content')
    <div class="container single-container">
        <h3 class="mb-3">Paid Details<button type="button" id="deleteBtn" class="btn btn-sm bg-white text-danger float-right" data-toggle="tooltip" data-placement="bottom" title="Delete Payment"><i class="mdi mdi-delete mdi-24px"></i></button></h3>
        <hr>
        <div class="table-responsive">
            <table class="table cus-table">
                <tbody>
                    <tr>
                        <td class="form-text text-muted">General</td>
                    </tr>
                    <tr>
                        <th>Name:</th>
                        <td>{{$paid->name}}</td>
                        <th>Email:</th>
                        <td>{{$paid->email}}</td>
                        <th>Phone:</th>
                        <td>{{$paid->phone}}</td>
                    </tr>
                    <tr>
                        <td class="form-text text-muted">Bank Details</td>
                    </tr>
                    <tr>
                        <th>Bank Name:</th>
                        <td>{{$paid->bank_name}}</td>
                        <th>Branch:</th>
                        <td>{{$paid->branch}}</td>
                    </tr>
                    <tr>
                        <th>Account No.:</th>
                        <td>{{$paid->account_no}}</td>
                        <th>Account Holder Name:</th>
                        <td>{{$paid->account_holder_name}}</td>
                    </tr>
                    <tr>
                        <th>IFSC:</th>
                        <td>{{$paid->ifsc}}</td>
                        <th>UPI ID:</th>
                        <td>{{$paid->upi_id}}</td>
                    </tr>
                    <tr>
                        <td class="form-text text-muted">Payment Details</td>
                    </tr>
                    <tr>
                        <th>Amount:</th>
                        <td>{{$paid->amount}}</td>
                        <th>Paid Date:</th>
                        <td>{{date('Y-m-d',strtotime($paid->created_at))}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
<form action="{{('/paids/delete/'.$paid->id)}}" method="post" id="deleteForm">
    @csrf
</form>
@endsection