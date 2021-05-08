@extends('layouts.app')
@section('title')
    Scratch cards | Today Winners
@endsection
@section('content')
    <div class="container single-container">
        <h3 class="mb-3">Today Winners</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sl.No.</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($winners as $item)
                        <tr>
                            <td>{{$no++}}</td>
                            <td><img src="{{asset($item->image)}}" alt="" class="list-img"></td>
                            <td>{{$item->username}}</td>
                            <td>{{$item->amount}}</td>
                        </tr>
                    @endforeach
                    @if (count($winners) == 0)
                        <tr>
                            <td colspan="10">no data</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection