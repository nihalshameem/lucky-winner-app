@extends('layouts.app')

@section('title')
    Category | Edit
@endsection

@section('content')
    <div class="container single-container">
        <form action="{{url('/categories/update/'.$category->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <h3>Edit #{{$category->id}}</h3>
            <hr>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="" class="col-3">Name:</label>
                        <div class="col-9">
                            <input type="text" name="name" class="form-control form-control-sm" value="{{$category->name}}">
                            {!! $errors->first('name', '<small class="text-danger">:message</small>') !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-3">Status:</label>
                        <div class="col-9">
                            <select name="status" id="" class="form-control form-control-sm">
                                <option value="1" {{$category->status == 1 ? 'selected':''}}>Active</option>
                                <option value="0" {{$category->status == 0 ? 'selected' : ''}}>Inactive</option>
                            </select>
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
                </div>
                <div class="col-lg-12">
                    <hr>
                    <button type="button" id="deleteBtn" data-id="{{$category->id}}" class="btn btn-sm btn-danger float-right">Delete</button>
                    <button type="submit" class="btn btn-sm btn-success mr-2 float-right">Save</button>
                </div>
            </div>
        </form>
    </div>
    
<form id="deleteForm" action="{{('/categories/delete/'.$category->id)}}" method="post" hidden>
    @csrf
</form>
@endsection