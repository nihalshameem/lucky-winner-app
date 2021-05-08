@extends('layouts.app')

@section('title')
    Banners | Add
@endsection

@section('content')
    <div class="container single-container">
        <form action="{{url('/banners/add/new')}}" method="post" enctype="multipart/form-data">
            @csrf
            <h3>Add New</h3>
            <hr>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group row">
                        <label for="" class="col-3">Name:</label>
                        <div class="col-9">
                            <input type="text" name="name" class="form-control form-control-sm">
                            {!! $errors->first('name', '<small class="text-danger">:message</small>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group row">
                        <label for="" class="col-3">Image:</label>
                        <div class="col-9">
                            <input type="file" name="image" class="form-control-file form-control-sm">
                            {!! $errors->first('image', '<small class="text-danger">:message</small>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group row">
                        <label for="" class="col-3">Status:</label>
                        <div class="col-9">
                            <select name="status" id="" class="form-control form-control-sm">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <hr>
                    <button type="button" id="clearInputs" class="btn btn-sm btn-dark float-right">Clear</button>
                    <button type="submit" class="btn btn-sm btn-success mr-2 float-right">Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection