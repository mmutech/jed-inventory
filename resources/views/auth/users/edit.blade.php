@extends('components.layouts.guest')

@section('content')
    <!-- Content -->

    <div class="row">
      <div class="col-sm-12">
        <div class="authentication-inner">
        <h3>Edit User</h3>
          <!-- Register Card -->
          <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-xl-12 col-sm-12 col-md-12 mx-auto d-flex justify-content-between align-items-center">
                        <div class="col-xl-4 col-sm-4 col-md-4">
                           
                        </div>
                        <a class="" href="{{ route('users.index') }}"> <i class="bx bx-left-arrow-alt bx-sm align-middle"></i>Back</a>
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

              {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <strong>Name:</strong>
                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <strong>Email:</strong>
                            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <!-- <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <strong>Password:</strong>
                            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <strong>Confirm Password:</strong>
                            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                        </div>
                    </div> -->
                    <div class="col-md-12 mb-3">
                    <strong>Roles:</strong>
                    <div class="row">
                      @foreach($roles as $role)
                        <div class="col-md-3 mb-3">
                          {!! Form::checkbox('roles[]', $role, $user->roles->contains('name', $role), ['class' => 'form-check-input', 'id' => 'role_' . $role]) !!}
                          {!! Form::label('role_' . $role, $role, ['class' => 'form-check-label']) !!}
                        </div>
                      @endforeach
                    </div>

                    <div class="col-md-12 mb-3 text-end mt-3">
                        <button type="submit" class="btn btn-info">Update</button>
                    </div>
                </div>
              {!! Form::close() !!}
            </div>
          </div>
          <!-- Register Card -->
        </div>
      </div>
    </div>

    <!-- / Content -->
@endsection