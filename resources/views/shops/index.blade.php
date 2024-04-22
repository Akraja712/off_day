@extends('layouts.admin')

@section('title', 'Shop Management')
@section('content-header', 'Shop Management')
@section('content-actions')
    <a href="{{route('shops.create')}}" class="btn btn-success"><i class="fas fa-plus"></i> Add New Shops</a>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Logo</th>
                        <th>Owner Name</th>
                        <th>Shop Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shops as $shop)
                    <tr>
                        <td>{{$shop->id}}</td>
                        <td>
                       <img class="customer-img img-thumbnail img-fluid rounded-circle" src="{{ asset('public/storage/shops/' . $shop->logo) }}"   alt=""
                        style="max-width: 100px; max-height: 100px;">
                       </td>
                        <td>{{$shop->owner_name}}</td>
                        <td>{{$shop->shop_name}}</td>
                        <td>{{$shop->email}}</td>
                        <td>{{$shop->phone}}</td>
                        <td>{{$shop->address}}</td>
                        <td>{{$shop->created_at}}</td>
                        <td>
                            <a href="{{ route('shops.edit', $shop) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-danger btn-delete" data-url="{{route('shops.destroy', $shop)}}"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $shops->render() }}
    </div>
</div>

@endsection

@section('js')
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.btn-delete', function () {
                $this = $(this);
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "Do you really want to delete this customer?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        $.post($this.data('url'), {_method: 'DELETE', _token: '{{csrf_token()}}'}, function (res) {
                            $this.closest('tr').fadeOut(500, function () {
                                $(this).remove();
                            })
                        })
                    }
                })
            })
        })
    </script>
@endsection
