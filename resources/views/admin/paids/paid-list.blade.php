@extends('layouts.app')
@section('title')
    Paid | List
@endsection
@section('content')
    <div class="container single-container">
        <h3 class="mb-3">
            Paids
            <button onclick="t()" class="btn btn-sm btn-success mt-1 float-right" {{count($paids) == 0 ? 'hidden':''}}><i class="mdi mdi-google-spreadsheet"></i> Export</button>
        </h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sl.No.</th>
                        <th>User Name</th>
                        <th>Amount</th>
                        <th>Paid on</th>
                        <th class="text-center">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = $paids->perPage() * ($paids->currentPage() - 1) + 1;
                    @endphp
                    @foreach ($paids as $item)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->amount}}</td>
                            <td>{{date('Y-m-d',strtotime($item->created_at))}}</td>
                            <td class="text-center"><a href="{{('/paids/details/'.$item->id)}}" class="btn bg-light text-dark"><i class="mdi mdi-account-details"></i></a></td>
                        </tr>
                    @endforeach
                    @if (count($paids) == 0)
                        <tr>
                            <td colspan="10">no data</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @if ($paids->lastPage() > 1)
        <div class="btn-group" role="group" aria-label="Basic example">
        </div>
        @endif
        <div class="btn-group mt-4" role="group" aria-label="Basic example">
          <a href="{{ $paids->url($paids->currentPage()-1) }}" type="button" class="btn btn-outline-secondary {{ ($paids->currentPage() == 1) ? ' disabled' : '' }}"><i class="mdi mdi-arrow-left-bold"></i></a>
          @for ($i = 1; $i <= $paids->lastPage(); $i++)
          <a href="{{ $paids->url($i) }}" type="button" class="btn btn-outline-secondary{{ ($paids->currentPage() == $i) ? ' active' : '' }}">{{ $i }}</a>
          @endfor
          <a href="{{ $paids->url($paids->currentPage()+1) }}" type="button" class="btn btn-outline-secondary{{ ($paids->currentPage() == $paids->lastPage()) ? ' disabled' : '' }}"><i class="mdi mdi-arrow-right-bold"></i></a>
    </div>
<script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script>
    var a = $('meta[name="csrf-token"]').attr("content");
    function t() {
        $('.pre-loader').show();
        $.ajax({
            url: "/paids/sheet",
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
        var xlsHeader = ["User(ID)", "Email",'Phone','Account Holder Name','Bank Name','Branch','Account Number','IFSC','UPI ID','Amount','Paid'];
        var xlsRows = JSON.parse(list);
        createXLSLFormatObj.push(xlsHeader);
        $.each(xlsRows, function(index, value) {
            var innerRowData = [];
            $.each(value, function(ind, val) {
                innerRowData.push(val);
            });
            createXLSLFormatObj.push(innerRowData);
        });
        var filename = "Paid_lists.xlsx";
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