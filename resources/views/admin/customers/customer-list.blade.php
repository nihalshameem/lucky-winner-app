@extends('layouts.app')
@section('title')
    Customers | List
@endsection
@section('content')
    <div class="container single-container">
        <h3 class="mb-3">Customers</h3>
        <form action="{{url('/customers/list/search')}}" method="post" class="form-inline">
            @csrf
            <div class="form-group mx-sm-3 mb-2">
              <label for="inputPassword2" class="sr-only">Search</label>
              <input type="search" class="form-control" id="inputPassword2" placeholder="Search..." value="{{$search}}" name="search">
            </div>
            <button type="submit" class="btn btn-primary mb-2"><i class="mdi mdi-magnify"></i></button>
        </form>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sl.No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Wallet</th>
                        <th class="text-center">View</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = $customers->perPage() * ($customers->currentPage() - 1) + 1;
                    @endphp
                    @foreach ($customers as $item)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->phone}}</td>
                            <td>{{$item->wallet}}</td>
                            <td class="text-center"><a href="{{url('/customers/details/'.$item->id)}}" class="btn bg-light text-dark"><i class="mdi mdi-account-details"></i></a></td>
                        </tr>
                    @endforeach
                    @if (count($customers) == 0)
                        <tr>
                            <td colspan="10">no data</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @if ($customers->lastPage() > 1)
        <div class="btn-group" role="group" aria-label="Basic example">
        </div>
        @endif
        <div class="btn-group mt-4" role="group" aria-label="Basic example">
          <a href="{{ $customers->url($customers->currentPage()-1) }}" type="button" class="btn btn-outline-secondary {{ ($customers->currentPage() == 1) ? ' disabled' : '' }}"><i class="mdi mdi-arrow-left-bold"></i></a>
          @for ($i = 1; $i <= $customers->lastPage(); $i++)
          <a href="{{ $customers->url($i) }}" type="button" class="btn btn-outline-secondary{{ ($customers->currentPage() == $i) ? ' active' : '' }}">{{ $i }}</a>
          @endfor
          <a href="{{ $customers->url($customers->currentPage()+1) }}" type="button" class="btn btn-outline-secondary{{ ($customers->currentPage() == $customers->lastPage()) ? ' disabled' : '' }}"><i class="mdi mdi-arrow-right-bold"></i></a>
    </div>
@endsection