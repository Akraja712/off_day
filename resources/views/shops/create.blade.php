@extends('layouts.admin')

@section('title', 'Create Shop')
@section('content-header', 'Create Shop')

@section('content')

    <div class="card">
        <div class="card-body">

            <form action="{{ route('shops.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="owner_name">Owner Name</label>
                    <input type="text" name="owner_name" class="form-control @error('owner_name') is-invalid @enderror"
                           id="owner_name"
                           placeholder="owner_name" value="{{ old('owner_name') }}">
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
                           placeholder="shop_name" value="{{ old('shop_name') }}">
                    @error('shop_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email"
                           placeholder="Email" value="{{ old('email') }}">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Contact Number</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="mobile"
                           placeholder="Contact Number" value="{{ old('phone') }}">
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="mobile">Address</label>
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" id="address"
                           placeholder="address" value="{{ old('address') }}">
                    @error('mobile')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                <label for="logo">Shop Logo</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="logo" id="logo">
                    <label class="custom-file-label" for="logo">Choose File</label>
                </div>
                @error('logo')
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
