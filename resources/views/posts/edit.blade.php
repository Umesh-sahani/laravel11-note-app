@extends('layout.app')

@section('content')
    <div class="container my-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Edit Post</span>
                <a href="{{ route('posts.index') }}" class="btn btn-sm btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('posts.update', $post->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <label>Blog Title:</label>
                    <input type="text" name="title" class="form-control" value="{{ $post->title }}">

                    <label>Blog Content:</label>
                    <textarea id="blog_content" class="tinymce6" name="content">{{ $post->content }}</textarea>

                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
