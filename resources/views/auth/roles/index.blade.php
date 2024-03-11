@extends('components.layouts.guest')

@section('content')
    <h3 class="card-header mb-3">Role Management</h3>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xl-12 col-sm-12 col-md-12 mx-auto d-flex justify-content-between align-items-center">
                    <!--Search Filter-->
                    <div class="col-xl-4 col-sm-4 col-md-4">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Search..."
                                aria-label="Search..."
                                aria-describedby="basic-addon-search31"
                                wire:model.live.debounce.100ms="search"
                            />
                        </div>
                    </div>
                    <!-- Create Role -->
                   
                        <a class="btn btn-primary" href="{{ route('roles.create') }}"> Create New Role</a>
                  
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
            <table class="table">
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th width="280px">Action</th>
                </tr>
                @foreach ($roles as $key => $role)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        <a class="mx-4" href="{{ route('roles.show',$role->id) }}"><i class="bx bx-show-alt me-1 text-secondary"> Show</i></a>
                        
                        <a  href="{{ route('roles.edit',$role->id) }}"><i class="bx bx-edit-alt me-1 text-info"> Edit</i></a>
                        @can('role-delete')
                            {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!}
                        @endcan
                    </td>
                </tr>
                @endforeach
            </table>

            {!! $roles->render() !!}
        </div>
    </div>
@endsection