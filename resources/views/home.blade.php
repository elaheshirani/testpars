@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-3">
                            You are logged in!  <br><br>
                            <a href="{{route('video.download')}}" >Get Video</a>
                        </div>
                        <div class="col-9">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Source</th>
                                    <th scope="col">View count</th>
                                    <th scope="col">Tags</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($videos as $video)
                                    <tr>
                                        <th scope="row">{{$video->id}}</th>
                                        <td>{{$video->title}}</td>
                                        <td>{{$video->source}}</td>
                                        <td>{{$video->view_count}}</td>
                                        <td>{{$video->tagList}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
