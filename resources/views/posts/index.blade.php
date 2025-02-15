@extends('layout.app')

@section('content')
    <div class="container my-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Post List</span>
                <a href="{{ route('posts.create') }}" class="btn btn-sm btn-success">Create</a>
            </div>
            <div class="card-body p-0 m-0">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th style="width: 100px">#</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th style="width: 180px">Created At</th>
                            <th style="width: 120px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($posts->isNotEmpty())
                            @foreach ($posts as $post)
                                <tr id="{{ $post->id }}">
                                    <th scope="row">{{ $post->id }}</th>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->slug }}</td>
                                    <td>{{ $post->created_at }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-primary">
                                            view
                                        </a>
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning">
                                            edit
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">No rows found.</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('customJS')
@endsection
