@extends('layouts.app')
@section('title')
    Withdraw Requests | List
@endsection
@section('content')
    <div class="container single-container">
        <h3 class="mb-3">
            Withdraw Requests
            <button onclick="t()" class="btn btn-sm btn-success mt-1 float-right" {{count($withdraw_req) == 0 ? 'hidden':''}}><i class="mdi mdi-google-spreadsheet"></i> Export</button>
        </h3>
        <hr>
        @foreach ($withdraw_req as $item)
        <div class="bid-box">
            <table class="table">
                <tr>
                    <th>User Name:</th>
                    <td>{{$item->user->name}}</td>
                    <th>Email:</th>
                    <td>{{$item->user->email}}</td>
                    <th>Phone:</th>
                    <td>{{$item->user->phone}}</td>
                </tr>
                <tr>
                    <th>Account Holder Name:</th>
                    <td>{{$item->user->account_holder_name}}</td>
                    <th>Bank Name:</th>
                    <td>{{$item->user->bank_name}}</td>
                    <th>Branch:</th>
                    <td>{{$item->user->branch}}</td>
                </tr>
                <tr>
                    <th>Account Number:</th>
                    <td>{{$item->user->account_no}}</td>
                    <th>IFSC:</th>
                    <td>{{$item->user->ifsc}}</td>
                    <th>UPI ID:</th>
                    <td>{{$item->user->upi_id}}</td>
                </tr>
                <tr>
                    <th>Request Amount:</th>
                    <td>{{$item->amount}}</td>
                </tr>
            </table>
            <a href="{{url('/withdraw-request/decline/'.$item->id)}}" onclick="return confirm('Are you sure?')"  class="btn btn-sm btn-danger float-right">Decline</a>
            <a href="{{url('/withdraw-request/paid/'.$item->id)}}" class="btn btn-sm btn-primary float-right mr-2">Paid</a>
        </div>
        @endforeach
        @if ($withdraw_req->lastPage() > 1)
        <div class="btn-group" role="group" aria-label="Basic example">
        </div>
        @endif
        <div class="btn-group mt-4" role="group" aria-label="Basic example">
          <a href="{{ $withdraw_req->url($withdraw_req->currentPage()-1) }}" type="button" class="btn btn-outline-secondary {{ ($withdraw_req->currentPage() == 1) ? ' disabled' : '' }}"><i class="mdi mdi-arrow-left-bold"></i></a>
          @for ($i = 1; $i <= $withdraw_req->lastPage(); $i++)
          <a href="{{ $withdraw_req->url($i) }}" type="button" class="btn btn-outline-secondary{{ ($withdraw_req->currentPage() == $i) ? ' active' : '' }}">{{ $i }}</a>
          @endfor
          <a href="{{ $withdraw_req->url($withdraw_req->currentPage()+1) }}" type="button" class="btn btn-outline-secondary{{ ($withdraw_req->currentPage() == $withdraw_req->lastPage()) ? ' disabled' : '' }}"><i class="mdi mdi-arrow-right-bold"></i></a>
    </div>
<script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script>
    var a = $('meta[name="csrf-token"]').attr("content");
    function t() {
        $('.pre-loader').show();
        $.ajax({
            url: "/withdraw-request/req-sheet",
            type: "GET",
            dataType: "html",
            data: { _token: a },
        })
            .done(function (a) {
                $('.pre-loader').hide();
                sheetfun(a)
            })
            .fail(function () {
                $('.pre-loader').hide();
                console.log('something wroung!')
            });
    }
    function sheetfun(list){
        var createXLSLFormatObj = [];
        var xlsHeader = ["User(ID)", "Email",'Phone','Account Holder Name','Bank Name','Branch','Account Number','IFSC','UPI ID','Request Amount'];
        var xlsRows = JSON.parse(list);
        createXLSLFormatObj.push(xlsHeader);
        $.each(xlsRows, function(index, value) {
            var innerRowData = [];
            $.each(value, function(ind, val) {
                innerRowData.push(val);
            });
            createXLSLFormatObj.push(innerRowData);
        });
        var filename = "Withdraw_Requests.xlsx";
        var ws_name = "FreakySheet";
        if (typeof console !== 'undefined') console.log(new Date());
        var wb = XLSX.utils.book_new(),
        ws = XLSX.utils.aoa_to_sheet(createXLSLFormatObj);
        XLSX.utils.book_append_sheet(wb, ws, ws_name);
        if (typeof console !== 'undefined') console.log(new Date());
        XLSX.writeFile(wb, filename);
        if (typeof console !== 'undefined') console.log(new Date());
    }
</script>
@endsection