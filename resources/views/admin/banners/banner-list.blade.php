@extends('layouts.app')
@section('title')
    Banners | List
@endsection
@section('content')
    <div class="container single-container">
        <h3 class="mb-3">Banners <a href="{{('/banners/add')}}" type="button" class="btn btn-sm bg-white text-dark float-right" data-toggle="tooltip" data-placement="bottom" title="New Banner"><i class="mdi mdi-plus mdi-24px"></i></a></h3>
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
                        $no = $banners->perPage() * ($banners->currentPage() - 1) + 1;
                    @endphp
                    @foreach ($banners as $item)
                        <tr>
                            <td>{{$no++}}</td>
                            <td><img src="{{asset($item->image)}}" alt="" class="list-img"></td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->status == 1 ? 'active':'inactive'}}</td>
                            <td class="text-center"><a href="{{('/banners/edit/'.$item->id)}}" class="btn bg-light text-dark"><i class="mdi mdi-file-edit-outline"></i></a></td>
                        </tr>
                    @endforeach
                    @if (count($banners) == 0)
                        <tr>
                            <td colspan="10">no data</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @if ($banners->lastPage() > 1)
        <div class="btn-group" role="group" aria-label="Basic example">
        </div>
        @endif
        <div class="btn-group mt-4" role="group" aria-label="Basic example">
          <a href="{{ $banners->url($banners->currentPage()-1) }}" type="button" class="btn btn-outline-secondary {{ ($banners->currentPage() == 1) ? ' disabled' : '' }}"><i class="mdi mdi-arrow-left-bold"></i></a>
          @for ($i = 1; $i <= $banners->lastPage(); $i++)
          <a href="{{ $banners->url($i) }}" type="button" class="btn btn-outline-secondary{{ ($banners->currentPage() == $i) ? ' active' : '' }}">{{ $i }}</a>
          @endfor
          <a href="{{ $banners->url($banners->currentPage()+1) }}" type="button" class="btn btn-outline-secondary{{ ($banners->currentPage() == $banners->lastPage()) ? ' disabled' : '' }}"><i class="mdi mdi-arrow-right-bold"></i></a>
    </div>
@endsection