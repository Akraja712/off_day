@extends('layouts.admin')

@section('title', 'Update Offers')
@section('content-header', 'Update Offers')

@section('content')

    <div class="card">
        <div class="card-body">

            <form action="{{ route('offers.update', $offer) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                           id="title"
                           placeholder="First Name" value="{{ old('title', $offer->title) }}">
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
                           placeholder="description" value="{{ old('description', $offer->description) }}">
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="valid_date">Valid Date</label>
                    <input type="date" name="valid_date" class="form-control @error('valid_date') is-invalid @enderror" id="valid_date"
                           placeholder="valid_date" value="{{ old('valid_date', $offer->valid_date) }}">
                    @error('valid_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="max_users">Maximum Users</label>
                    <input type="number" name="max_users" class="form-control @error('max_users') is-invalid @enderror" id="max_users"
                           placeholder="max_users" value="{{ old('max_users', $offer->max_users) }}">
                    @error('max_users')
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
            <option value="{{ $shop->id }}" {{ $shop->id == $offer->shop_id ? 'selected' : '' }}>{{ $shop->name }}</option>
        @endforeach
    </select>
    @error('shop_id')
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
