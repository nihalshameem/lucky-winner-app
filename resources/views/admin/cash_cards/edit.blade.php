@extends('layouts.app')

@section('title')
    Cash Cards | Edit
@endsection

@section('content')
    <div class="container single-container">
        <form action="{{url('/cash-cards/update/'.$cash_card->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <h3>Edit #{{$cash_card->id}}</h3>
            <hr>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="" class="col-3">Name:</label>
                        <div class="col-9">
                            <input type="text" name="name" class="form-control form-control-sm" value="{{$cash_card->name}}">
                            {!! $errors->first('name', '<small class="text-danger">:message</small>') !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-3">Amount:</label>
                        <div class="col-9">
                            <input type="number" min="0" value="{{$cash_card->amount}}" name="amount" class="form-control form-control-sm" required>
                            {!! $errors->first('amount', '<small class="text-danger">:message</small>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="" class="col-3">Image:</label>
                        <div class="col-9">
                            <input type="file" name="image" class="form-control-file form-control-sm">
                            {!! $errors->first('image', '<small class="text-danger">:message</small>') !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-3">Status:</label>
                        <div class="col-9">
                            <select name="status" id="" class="form-control form-control-sm">
                                <option value="1" {{$cash_card->status == 1 ? 'selected':''}}>Active</option>
                                <option value="0" {{$cash_card->status == 0 ? 'selected' : ''}}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <hr>
                    <button type="button" id="deleteBtn" data-id="{{$cash_card->id}}" class="btn btn-sm btn-danger float-right">Delete</button>
                    <button type="submit" class="btn btn-sm btn-success mr-2 float-right">Save</button>
                </div>
            </div>
        </form>
    </div>
    
<form id="deleteForm" action="{{('/cash-cards/delete/'.$cash_card->id)}}" method="post" hidden>
    @csrf
</form>
@endsection