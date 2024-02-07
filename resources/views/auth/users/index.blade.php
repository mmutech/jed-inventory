@extends('components.layouts.app')

@section('content')
     <!-- Responsive Table -->
        <div class="card">
            <h5 class="card-header">User Lists</h5>
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
                        <!-- Create user -->
                        <a class="btn btn-primary" href="{{ route('users.create') }}"> Create New User</a>
                    </div>

                    <div class="col-xl-4 col-sm-4 col-md-4 mx-auto"></div>
                    <div class="col-xl-4 col-sm-4 col-md-4 mx-auto"></div>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Roles</th>
                      <th width="280px">Action</th>
                    </tr>
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
                          
                      </td>
                    </tr>
                  @endforeach
                </table>

                {!! $data->render() !!}
            </div>
        </div>
    <!--/ Responsive Table -->
@endsection