@extends('layouts.admin')

@section('title', 'Update Customer')
@section('content-header', 'Update Customer')

@section('content')

    <div class="card">
        <div class="card-body">

            <form action="{{ route('customers.update', $customer) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="first_name">Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           placeholder="Name" value="{{ old('name', $customer->name) }}">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone"
                           placeholder="Phone" value="{{ old('phone', $customer->phone) }}">
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
        
                <div class="form-group">
                    <label for="device_id">Device ID</label>
                    <input type="text" name="device_id" class="form-control @error('device_id') is-invalid @enderror"
                           id="device_id"
                           placeholder="device_id" value="{{ old('device_id', $customer->device_id) }}">
                    @error('device_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                
                <div class="form-group">
            <span>Current Image:</span>
            <img src="{{ asset('storage/app/public/customers/' . $customer->image) }}" alt="{{ $customer->first_name }}" style="max-width: 100px; max-height: 100px;">
            <br>
            <label for="image">New Image</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input" name="image" id="image">
        <label class="custom-file-label" for="image">Choose file</label>
        @if($customer->image)
            <input type="hidden" name="existing_image" value="{{ $customer->image }}">
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
