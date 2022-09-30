@extends('layouts.main')

@section('content')
<div class="container">
    <form method="post" action="/tes" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <textarea class="ckeditor form-control" name="editor1"></textarea>
        </div>
        <div class="mb-0 row">
                            <div class="col-md-8 offset-md-4">
                                <a class="btn btn-danger bi bi-x" href="{{ url('/ticket') }}">
                                    Cancel
                                </a>

                                <button type="submit" class="btn btn-primary bi bi-check">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
    </form>
</div>
@endsection
@section('js')
<script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
<script>
                        CKEDITOR.replace( 'editor1', {
                            toolbar:[
                                { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike'] },
                                { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Blockquote'] },
                                { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                            ]
                        } );
                </script>
@endsection
