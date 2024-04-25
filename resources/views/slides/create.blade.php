@extends('layouts.admin')

@section('title', 'Create Slides')
@section('content-header', 'Create Slides')

@section('content')

    <div class="card">
        <div class="card-body">

            <form action="{{ route('slides.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                <label for="image">Slide Image</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="image" id="image">
                    <label class="custom-file-label" for="image">Choose File</label>
                </div>
                @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

              

                <button class="btn btn-success btn-block btn-lg" type="submit">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init();
        });
    </script>
@endsection
