@extends('layouts.app')
@section('title')
    Bids | List
@endsection
@section('content')
    <div class="container single-container">
        <h3 class="mb-3">Bids</h3>
        <hr>
        @foreach ($bids as $item)
        <div class="bid-box">
            <table class="table">
                <tr>
                    <th>User(ID):</th>
                    <td>{{$item->username}}({{$item->user_id}})</td>
                    <th>Cash card(ID):</th>
                    <td>{{$item->cash_card_name}}({{$item->cash_card_id}})</td>
                </tr>
                <tr>
                    <th>Payment Status:</th>
                    <td>{{$item->payment_status == 1 ? 'Paid':'Unpaid'}}</td>
                    <th>Scratch Card:</th>
                    <td>
                        @if ($item->card_name == null)
                            <i class="text-danger">no scratch card available.</i>
                        @else
                            {{$item->card_name}}
                        @endif
                    </td>
                </tr>
            </table>
            <a href="{{('/bids/delete/'.$item->id)}}" onclick="return confirm('Are you sure?')"  class="btn btn-sm btn-danger float-right">Delete</a>
            <a href="{{('/scratch-card/create/'.$item->id)}}" class="btn btn-sm btn-info float-right mr-2" {{$item->card_name == null ? '':'hidden'}}>Add Scratch card</a>
            <a href="{{('/scratch-cards/view/'.$item->id)}}" class="btn btn-sm btn-info float-right mr-2" {{$item->card_name == null ? 'hidden':''}}>View Scratch card</a>
        </div>
        @endforeach
        @if ($bids->lastPage() > 1)
        <div class="btn-group" role="group" aria-label="Basic example">
        </div>
        @endif
        <div class="btn-group mt-4" role="group" aria-label="Basic example">
          <a href="{{ $bids->url($bids->currentPage()-1) }}" type="button" class="btn btn-outline-secondary {{ ($bids->currentPage() == 1) ? ' disabled' : '' }}"><i class="mdi mdi-arrow-left-bold"></i></a>
          @for ($i = 1; $i <= $bids->lastPage(); $i++)
          <a href="{{ $bids->url($i) }}" type="button" class="btn btn-outline-secondary{{ ($bids->currentPage() == $i) ? ' active' : '' }}">{{ $i }}</a>
          @endfor
          <a href="{{ $bids->url($bids->currentPage()+1) }}" type="button" class="btn btn-outline-secondary{{ ($bids->currentPage() == $bids->lastPage()) ? ' disabled' : '' }}"><i class="mdi mdi-arrow-right-bold"></i></a>
    </div>
@endsection