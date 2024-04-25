@extends('layouts.admin')

@section('title', 'Update Slides')
@section('content-header', 'Update Slides')

@section('content')

    <div class="card">
        <div class="card-body">

            <form action="{{ route('slides.update', $slide) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
            <span>Current Image:</span>
            <img src="{{ asset('storage/app/public/slides/' . $slide->image) }}" alt="" style="max-width: 100px; max-height: 100px;">
            <br>
            <label for="image">New Image</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input" name="image" id="image">
        <label class="custom-file-label" for="image">Choose file</label>
        @if($slide->image)
            <input type="hidden" name="existing_image" value="{{ $slide->image }}">
        @endif
    </div>
    @error('image')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>



                <button class="btn btn-success btn-block btn-lg" type="submit">Save Changes</button>
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
