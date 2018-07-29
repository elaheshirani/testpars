@extends('layouts.app')

@section('content')
    <script src="{{ asset('js/jquery.tagsinput.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.tagsinput.css') }}" />
    <script>
        $('#tags').tagsInput();
    </script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Download Video</div>
                    <div class="card-body">
                        <form action="{{route('video.store')}}" method="post">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title"  placeholder="Enter Title">
                            </div>
                            <div class="form-group">
                                <label for="video_url">Video URL</label>
                                <input type="url" class="form-control" id="video_url" name="video_url" placeholder="Video URL">
                            </div>
                            <div class="form-group">
                                <label for="tag">Tag</label>
                                <input type="text" class="form-control" id="video_tag" name="video_tag"   placeholder="foo,bar,baz">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection