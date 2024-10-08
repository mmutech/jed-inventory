@extends('components.layouts.guest')

@section('content')
     <h3 class="card-header mb-3">User Lists</h3>
     <!-- Responsive Table -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-xl-12 col-sm-12 col-md-12 mx-auto d-flex justify-content-between align-items-center">
                        
                        <!--Search Filter-->
                        <div class="col-xl-4 col-sm-4 col-md-4">
                          
                        </div>
                        <!-- Create user -->
                        @can('create-user')
                        <a class="btn btn-primary" href="{{ route('users.create') }}"> Create New User</a>
                        @endcan
                    </div>

                    <div class="col-xl-4 col-sm-4 col-md-4 mx-auto"></div>
                    <div class="col-xl-4 col-sm-4 col-md-4 mx-auto"></div>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table" id="dataTable">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Roles</th>
                      <th width="280px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $key => $user)
                      <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                          @if(!empty($user->getRoleNames()))
                            @foreach($user->getRoleNames() as $v)
                              <label class="">{{ $v.',' }}</label>
                            @endforeach
                          @endif
                        </td>
                          <td>
                          @can('modify-user')
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                  <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('users.edit',$user->id) }}">
                                <i class="bx bx-edit-alt me-1"></i> Edit</a>
                                {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                  {!! Form::submit('Delete', ['class' => 'dropdown-item']) !!}
                                {!! Form::close() !!}
                                </div>
                              </div>
                            <!-- <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a> -->
                          @endcan 
                          </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
        </div>
    <!--/ Responsive Table -->
@endsection