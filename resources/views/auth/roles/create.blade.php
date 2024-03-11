@extends('components.layouts.guest')

@section('content')
<div class="row">
      <div class="col-sm-12">
        <div class="authentication-inner">
        <h3>Create Role</h3>
          <!-- Create Role -->
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

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif

            {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
                <div class="row">
                    <div class="col-xs-6 col-sm-12 col-md-6">
                        <div class="form-group">
                            <strong>Name:</strong>
                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control mt-3')) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                        <strong class="mb-3">Permissions:</strong>
                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-md-3">
                                    <label>
                                        <input type="checkbox" name="permission[]" value="{{$permission->name}}">
                                        {{$permission->name}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            {!! Form::close() !!}
            </div>
          </div>
          <!-- Create Role -->
        </div>
      </div>
    </div>
@endsection