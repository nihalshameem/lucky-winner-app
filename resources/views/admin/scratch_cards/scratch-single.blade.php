@extends('layouts.app')

@section('title')
    Scratch Cards | Edit
@endsection

@section('content')
    <div class="container single-container">
        <h3>View #{{$scratch_card->id}}</h3>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <img src="{{$scratch_card->image}}" alt="image" class="w-100">
            </div>
            <div class="col-md-9">
                <table class="table cus-table">
                    <tr>
                        <th>Name:</th>
                        <td>{{$scratch_card->name}}</td>
                    </tr>
                    <tr>
                        <th>Amount:</th>
                        <td>{{$scratch_card->amount}}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>{{$scratch_card->status == 1 ? 'Unscratched':'Scratched'}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-12">
                <a href="{{url('/scratch-cards/edit/'.$scratch_card->id)}}" class="btn btn-dark btn-sm float-right">Edit</a>
            </div>
        </div>
    </div>
@endsection