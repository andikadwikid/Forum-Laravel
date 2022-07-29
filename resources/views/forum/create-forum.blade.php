@extends('layouts.app')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop
@section('content')
    <div class="container">
        <form method="post" action="{{ route('home.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="forum_title" class="form-control" />
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea id="summernote" name="forum_content"></textarea>
                <p>```
                    <span class="badge text-bg-light">code</span>
                    ```
                </p>
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

            <div class="form-group text-center">
                <button type="submit" class="btn btn-danger btn-block">Publish</button>
            </div>
        </form>
    </div>

    @push('scripts')
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#summernote').summernote({
                    height: 150,
                    tabsize: 2,
                    direction: 'rtl',
                    codemirror: {
                        theme: 'monokai'
                    },
                    // justifyLeft,
                    toolbar: [
                        // [groupName, [list of button]]
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['insert', ['link', 'picture']],
                    ],
                    callbacks: {
                        onImageUpload: function(files) {

                            if (!files.length) return;
                            var file = files[0];
                            // create FileReader
                            var reader = new FileReader();
                            reader.onloadend = function() {
                                // when loaded file, img's src set datauri
                                console.log("img", $("<img>"));
                                var img = $("<img>").attr({
                                    src: reader.result,
                                    width: "30%"
                                }); // << Add here img attributes !
                                console.log("var img", img);
                                $('#summernote').summernote("insertNode", img[0]);
                            }

                            if (file) {
                                // convert fileObject to datauri
                                reader.readAsDataURL(file);
                            }

                        }
                    }
                });
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
