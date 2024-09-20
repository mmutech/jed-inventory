@extends('components.layouts.guest')

@section('content')
    <h3 class="card-header mb-3">Permission Management</h3>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xl-12 col-sm-12 col-md-12 mx-auto d-flex justify-content-between align-items-center">
                    <!--Search Filter-->
                    <div class="col-xl-4 col-sm-4 col-md-4">
                    </div>
                    <!-- Create permission -->
                    @can('create-permission')
                        <a class="btn btn-primary" href="{{ route('permissions.create') }}"> Create Permission</a>
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
                    @foreach ($permissions as $key => $permission)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $permission->name }}</td>
                        <td>
                            @can('modify-permission')
                            <a href="{{ route('permissions.edit',$permission->id) }}"><i class="bx bx-edit-alt me-1 text-info"></i></a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection