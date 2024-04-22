@extends('layouts.admin')

@section('title', 'Update Shop')
@section('content-header', 'Update Shop')

@section('content')

    <div class="card">
        <div class="card-body">

            <form action="{{ route('shops.update', $shop) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="owner_name">Owner Name</label>
                    <input type="text" name="owner_name" class="form-control @error('owner_name') is-invalid @enderror"
                           id="owner_name"
                           placeholder="Owner Name" value="{{ old('owner_name', $shop->owner_name) }}">
                    @error('owner_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="shop_name">Shop Name</label>
                    <input type="text" name="shop_name" class="form-control @error('shop_name') is-invalid @enderror"
                           id="shop_name"
                           placeholder="Shop Name" value="{{ old('shop_name', $shop->shop_name) }}">
                    @error('shop_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email"
                           placeholder="Email" value="{{ old('email', $shop->email) }}">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Contact Number</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="mobile"
                           placeholder="phone" value="{{ old('phone', $shop->phone) }}">
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
                           placeholder="device_id" value="{{ old('device_id', $shop->device_id) }}">
                    @error('device_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                           id="address"
                           placeholder="Address" value="{{ old('address', $shop->address) }}">
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
            <span>Current Logo:</span>
            <img src="{{ asset('storage/app/public/shops/' . $shop->logo) }}" alt="{{ $shop->first_name }}" style="max-width: 100px; max-height: 100px;">
            <br>
            <label for="image">New Logo</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input" name="logo" id="logo">
        <label class="custom-file-label" for="logo">Choose file</label>
        @if($shop->logo)
            <input type="hidden" name="existing_logo" value="{{ $shop->logo }}">
        @endif
    </div>
    @error('logo')
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
