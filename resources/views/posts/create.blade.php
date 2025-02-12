@extends('layout.app')

@section('content')
    <div class="container my-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Post List</span>
                <a href="{{ route('posts.index') }}" class="btn btn-sm btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf
                    <label>Blog Title:</label>
                    <input type="text" name="title" class="form-control">

                    <label>Blog Content:</label>
                    <textarea id="blog_content" name="content"></textarea> <!-- TinyMCE applies here -->

                    <button type="submit" class="btn btn-primary mt-3">Publish</button>
                </form>
            </div>
        </div>
    </div>
@endsection
