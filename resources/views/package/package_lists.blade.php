{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Package Lists')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Package Lists
        </h3>
    </div>
    <div class="page-header">

        <nav aria-label="breadcrumb">

        </nav>
        <div class="d-sm-flex justify-content-center justify-content-sm-between">

            <a href="#" data-toggle="modal" data-target="#addPackageModal"
                class="btn btn-info btn-fw float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                <span>
                    <i class="fa fa-plus"></i>
                </span>Add Package
            </a>
            <span>&nbsp;&nbsp;</span>
            <a href="{{ route('package.export') }}" class="btn btn-primary">Export to Excel</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Packages</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> Sl No </th>
                                    <th> Package Name </th>
                                    <th> Store Name </th>
                                    <th> Client Full name </th>
                                    <th> Status </th>
                                    <th> Phone </th>
                                    <th> Wilaya </th>
                                    <th> Commune </th>

                                    <th> Delivery type </th>

                                    <th> Tracking Code </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($packages && $packages->isNotEmpty())
                                    @foreach ($packages as $package)
                                        <tr>
                                            <td>
                                                <label>{{ $loop->iteration }}</label>
                                                <!-- This will show the serial number -->
                                            </td>
                                            <td>
                                                <label class="badge badge badge-info">{{ $package->name }}</label>
                                            </td>
                                            <td>
                                                {{ $package->store->name }}
                                            </td>
                                            <td>

                                                {{ $package->client->name }}
                                            </td>
                                            <td> <label class="badge badge-gradient-success">{{ $package->status }}</label>
                                            </td>
                                            <td> {{ $package->client->phone }} </td>
                                            <td> {{ $package->client->wilaya }} </td>
                                            <td> {{ $package->client->commune }} </td>

                                            <td> {{ $package->delivery_type }} </td>

                                            <td> {{ $package->tracking_code }} </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="10" class="text-center">No packages found.</td>
                                    </tr>
                                @endif


                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {{ $packages->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addPackageModal" tabindex="-1" role="dialog" aria-labelledby="addPackageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPackageModalLabel">Add Package</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="addPackageForm" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="package_name" class="form-label">Package Name</label>
                                        <input type="text" name="package_name" class="form-control" id="package_name"
                                            required placeholder="Enter Package Name">
                                        <span class="text-danger error-message" id="error-package_name"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="store_id" class="form-label">Store</label>
                                        <select name="store_id" id="store_id" class="s-states form-control" required>
                                            <option value="">Select Store</option>
                                            @foreach ($stores as $store)
                                                <option value="{{$store->store_id}}">{{$store->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-message" id="error-store_id"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="client_id" class="form-label">Client</label>
                                        <select name="client_id" id="client_id" class="form-control" required>
                                            <option value="">Select Client</option>
                                            @foreach ($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger error-message" id="error-client_id"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="Pending">Pending</option>
                                            <option value="Shipped">Shipped</option>
                                            <option value="Delivered">Delivered</option>
                                        </select>
                                        <span class="text-danger error-message" id="error-status"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="delivery_type" class="form-label">Delivery Type</label>
                                        <select name="delivery_type" id="delivery_type" class="form-control" required>
                                            <option value="Standard">Standard</option>
                                            <option value="Express">Express</option>
                                            <option value="Overnight">Overnight</option>
                                        </select>
                                        <span class="text-danger error-message" id="error-delivery_type"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>



@endsection
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {

            $('#addPackageForm').on('submit', function(e) {
                e.preventDefault();
            $('.error-message').text('');
            $.ajax({
                url: '{{ route("package.store") }}',
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.success) {
                        $('#addPackageModal').modal('hide');
                            toastr.success('Package Added Successfully');
                            setTimeout(function() {
                            location.reload();
                            }, 1000);
                    } else {
                        toastr.error('An error occurred while saving the package.');

                    }
                },
                error: function(response) {
                    if(response.status === 422) {
                        var errors = response.responseJSON.errors;
                        $.each(errors, function(key, message) {
                            $('#error-' + key).text(message[0]);
                        });
                    } else {
                        toastr.error('An error occurred while saving the package.');
                    }
                }
            });
        });
    });
    </script>
