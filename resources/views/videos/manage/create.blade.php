{{-- resources/views/videos/manage/create.blade.php --}}
@extends('layouts.videos-app-layout')

@section('content')
    @can('create videos')
        <h1>Create Video</h1>
        <form action="{{ route('videos.manage.store') }}" method="POST" data-qa="form-create-video">
            @csrf
            <label for="title" data-qa="label-title">Title:</label>
            <input type="text" id="title" name="title" required data-qa="input-title">
            <label for="description" data-qa="label-description">Description:</label>
            <textarea id="description" name="description" required data-qa="textarea-description"></textarea>
            <button type="submit" data-qa="button-submit">Create</button>
        </form>
    @else
        <p>You do not have permission to view this page.</p>
    @endcan
@endsection