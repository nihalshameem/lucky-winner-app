@extends('layouts.app')
@section('title')
    Categories | List
@endsection
@section('content')
    <div class="container single-container">
        <h3 class="mb-3">Categories <a href="{{('/categories/add')}}" type="button" class="btn btn-sm bg-white text-dark float-right" data-toggle="tooltip" data-placement="bottom" title="New Cash card"><i class="mdi mdi-plus mdi-24px"></i></a></h3>
        <form action="{{url('/categories/list/search')}}" method="post" class="form-inline">
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
                        <th>Image</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th class="text-center">View/Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = $categories->perPage() * ($categories->currentPage() - 1) + 1;
                    @endphp
                    @foreach ($categories as $item)
                        <tr>
                            <td>{{$no++}}</td>
                            <td><img src="{{asset($item->image)}}" alt="" class="list-img"></td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->status == 1 ? 'active':'inactive'}}</td>
                            <td class="text-center"><a href="{{('/categories/edit/'.$item->id)}}" class="btn bg-light text-dark"><i class="mdi mdi-file-edit-outline"></i></a></td>
                        </tr>
                    @endforeach
                    @if (count($categories) == 0)
                        <tr>
                            <td colspan="10">no data</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @if ($categories->lastPage() > 1)
        <div class="btn-group" role="group" aria-label="Basic example">
        </div>
        @endif
        <div class="btn-group mt-4" role="group" aria-label="Basic example">
          <a href="{{ $categories->url($categories->currentPage()-1) }}" type="button" class="btn btn-outline-secondary {{ ($categories->currentPage() == 1) ? ' disabled' : '' }}"><i class="mdi mdi-arrow-left-bold"></i></a>
          @for ($i = 1; $i <= $categories->lastPage(); $i++)
          <a href="{{ $categories->url($i) }}" type="button" class="btn btn-outline-secondary{{ ($categories->currentPage() == $i) ? ' active' : '' }}">{{ $i }}</a>
          @endfor
          <a href="{{ $categories->url($categories->currentPage()+1) }}" type="button" class="btn btn-outline-secondary{{ ($categories->currentPage() == $categories->lastPage()) ? ' disabled' : '' }}"><i class="mdi mdi-arrow-right-bold"></i></a>
    </div>
@endsection