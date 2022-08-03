@extends('layouts.app')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('summernote/dist/summernote-bs5.css') }}">
    <link rel="stylesheet" href="{{ asset('summernote/dist/summernote.min.css') }}">
@endpush
@section('content')
    <div class="container">
        <form method="post" action="" enctype="multipart/form-data">
            @method('patch')
            @csrf
            <div class="form-group mb-3">
                <label>Title</label>
                <input type="text" name="forum_title" value="{{ old('forum_title') ?? $forums->forum_title }}"
                    class="form-control" />
            </div>
            <div class="form-group mb-3">
                <label>Description</label>
                <textarea class="form-control" id="content" name="forum_content">
                    {{ $forums->forum_content }}
                </textarea>
                <p>Align center : CTRL + Shift + E </p>
            </div>

            <div class="form-group">
                <label for="tags">Tags</label>
                <select name="tags[]" id="tags" class="form-control select2 @error('tags') is-invalid @enderror"
                    multiple="multiple">

                    @foreach ($forums->tags as $tag)
                        <option selected value="{{ $tag->id }}"
                            {{ in_array($tag->id, old('tags') ?: []) ? 'selected' : '' }}>
                            {{ $tag->name }}</option>
                    @endforeach
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags') ?: []) ? 'selected' : '' }}>
                            {{ $tag->name }}</option>
                    @endforeach
                </select>

                <!-- untuk menampilkan error pada field input -->
                @error('tags')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="form-group my-2">
                <button type="submit" class="btn btn-primary btn-block my-2">Post Your Question</button>
            </div>
        </form>

    </div>
    @push('scripts')
        <script src="{{ asset('summernote/dist/summernote-bs5.js') }}"></script>
        <script src="{{ asset('summernote/dist/summernote.min.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#content').summernote({
                    popatmouse: true,
                    width: 800,
                    height: 300,
                    popover: {
                        image: [
                            ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                            ['float', ['floatLeft', 'floatRight', 'floatNone']],
                            ['remove', ['removeMedia']]
                        ],
                    },
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['insert', ['link', 'picture', 'hr']],
                        // ['para', ['ul', 'ol', 'paragraph']],
                    ],
                });
            });

            $(this).summernote({
                maximumImageFileSize: 3584000 //3,5MB
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: "Choose some tags"
                });
            });
        </script>
    @endpush
@endsection
