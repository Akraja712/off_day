@extends('layouts.admin')

@section('title', 'Create Offers')
@section('content-header', 'Create Offer')

@section('content')

    <div class="card">
        <div class="card-body">

            <form action="{{ route('offers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                           id="title"
                           placeholder="Title" value="{{ old('title') }}">
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                           id="description"
                           placeholder="Description" value="{{ old('description') }}">
                    @error('last_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="date">Valid Date</label>
                    <input type="date" name="valid_date" class="form-control @error('valid_date') is-invalid @enderror" id="valid_date"
                           placeholder="valid_date" value="{{ old('valid_date') }}">
                    @error('valid_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="max_users">Maximum Users</label>
                    <input type="number" name="max_users" class="form-control @error('max_users') is-invalid @enderror" id="max_users"
                           placeholder="max_users" value="{{ old('max_users') }}">
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="shop_id">Shop</label>
                    <select name="shop_id" id="shop_id" class="form-control @error('shop_id') is-invalid @enderror">
                        <option value="">Select Shop</option>
                        @foreach($shops as $shop)
                            <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                        @endforeach
                    </select>
                    @error('shop_id')
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
