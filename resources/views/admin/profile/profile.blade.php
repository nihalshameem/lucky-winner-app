@extends('layouts.app')

@section('title')
    Profile
@endsection

@section('content')
    <div class="container single-container">
        <form action="{{url('/profile/update')}}" method="post" id="profileform" enctype="multipart/form-data">
            @csrf
            <h3>Profile Details</h3>
            <hr>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="" class="col-3">Name:</label>
                        <div class="col-9">
                            <input type="text" name="name" class="form-control form-control-sm" value="{{$profile->name}}" disabled>
                            {!! $errors->first('name', '<small class="text-danger">:message</small>') !!}
                        </div>
                    </div>
                    <div class="form-group row" id="password" hidden>
                        <label for="" class="col-3">Password:</label>
                        <div class="col-9">
                            <input type="text" value="" name="password" class="form-control form-control-sm">
                            {!! $errors->first('password', '<small class="text-danger">:message</small>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="" class="col-3">Email:</label>
                        <div class="col-9">
                            <input type="email" value="{{$profile->email}}" name="email" class="form-control form-control-sm" disabled>
                            {!! $errors->first('email', '<small class="text-danger">:message</small>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <hr>
                    <button type="button" id="profileEdit" class="btn btn-sm btn-dark float-right">Edit</button>
                    <button type="button" id="profileCancel" class="btn btn-sm btn-secondary float-right" hidden>Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary mr-2 float-right" hidden>Update</button>
                </div>
            </div>
        </form>
    </div>
@endsection