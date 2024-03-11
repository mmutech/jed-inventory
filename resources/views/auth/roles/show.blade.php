@extends('components.layouts.guest')

@section('content')
<div class="row">
      <div class="col-sm-12">
        <div class="authentication-inner">
        <h3>Assigned Permissions To Role</h3>
          <!-- Show Role -->
          <div class="card">
            <div class="card-body">
            <div class="row mb-3">
                <div class="col-xl-12 col-sm-12 col-md-12 mx-auto d-flex justify-content-between align-items-center">
                    <div class="col-xl-4 col-sm-4 col-md-4">
                        
                    </div>
                    <a class="" href="{{ route('roles.index') }}"> <i class="bx bx-left-arrow-alt bx-sm align-middle"></i>Back</a>
                </div>

                <div class="col-xl-4 col-sm-4 col-md-4 mx-auto"></div>
                <div class="col-xl-4 col-sm-4 col-md-4 mx-auto"></div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <strong>Role:</strong>
                    <span>{{$role->name}}</span>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                    <strong class="mb-5">Permissions:</strong>
                    <div class="row">
                        @foreach($rolePermissions as $permission)
                            <div class="col-md-3 mt-3">
                                <label>
                                <i class="bx bx-check me-1 text-success"></i>
                                    {{$permission->name}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            </div>
          </div>
          <!-- Show Role -->
        </div>
      </div>
    </div>
@endsection