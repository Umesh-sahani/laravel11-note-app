@extends('layout.app')

@section('content')
    <div class="container my-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>{{ $post->title }}</span>
                <a href="{{ route('posts.index') }}" class="btn btn-sm btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <div class="content">
                    {!! $post->content !!}
                </div>
            </div>
        </div>
    </div>
@endsection
