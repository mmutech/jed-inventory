@extends('components.layouts.guest')

@section('content')
    <h3 class="card-header mb-3">Role Management</h3>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xl-12 col-sm-12 col-md-12 mx-auto d-flex justify-content-between align-items-center">
                    <!--Search Filter-->
                    <div class="col-xl-4 col-sm-4 col-md-4">
                    </div>
                    <!-- Create Role -->
                    @can('create-role')
                        <a class="btn btn-primary" href="{{ route('roles.create') }}"> Create New Role</a>
                    @endcan
                </div>

                <div class="col-xl-4 col-sm-4 col-md-4 mx-auto"></div>
                <div class="col-xl-4 col-sm-4 col-md-4 mx-auto"></div>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table" id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th width="280px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $key => $role)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                @can('view-role')
                                    <a class="dropdown-item" href="{{ route('roles.show',$role->id) }}">Show</a>
                                @endcan

                                @can('modify-role')
                                    <a class="dropdown-item" href="{{ route('roles.edit',$role->id) }}">Edit</a> 
                                @endcan
                            </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection