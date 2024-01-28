@extends('layouts.admin')

@section('main-content')
<!-- Page Heading -->

<h1 class="h3 mb-4 text-gray-800">{{$user ? "User Details":"New User Details"}}</h1>

@if (session('success'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger border-left-danger" role="alert">
    <ul class="pl-4 my-2">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="card-body">
  
        <div class="row">
            @if($user)
        <div class="col-lg-4 order-lg-2">

                <div class="card shadow mb-4">
                    <div class="card-profile-image mt-4">
                        <figure class="rounded-circle avatar avatar font-weight-bold" style="font-size: 60px; height: 180px; width: 180px"></figure>
                    </div>
                    <div class="card-body">
    
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card-profile-stats">
                                    <span class="heading">22</span>
                                    <span class="description">Friends</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-profile-stats">
                                    <span class="heading">10</span>
                                    <span class="description">Photos</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-profile-stats">
                                    <span class="heading">89</span>
                                    <span class="description">Comments</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
            </div>
            @endif
    
            <div class="col-lg-8 order-lg-1">
    
                <div class="card shadow mb-4">
    
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">My Account</h6>
                    </div>
    
                    <div class="card-body">
    
                        <form action="{{$user ?  route( 'users.update',['user'=>$user->id]) : route('users.store') }}" method="POST">
                            @if($user)
                            @method('PUT')
                            @else
                            @method('POST')
                            @endif
                            @csrf                   
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
    
    
                            <h6 class="heading-small text-muted mb-4">User information</h6>
    
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="name">Name<span class="small text-danger">*</span></label>
                                            <input type="text" id="name" class="form-control" name="name" placeholder="Name" value="{{ isset($user->name) ? $user->name : @old('name')}}">
                                            @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group ">
                                            <label class="form-control-label" for="last_name">Last name</label>
                                            <input type="text" id="last_name" class="form-control" name="last_name" placeholder="Last name" value="{{ isset($user->last_name) ? $user->last_name : @old('last_name')}}">
                                            @error('last_name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
        
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="email">Email address<span class="small text-danger">*</span></label>
                                            <input type="email" id="email" class="form-control" name="email" placeholder="example@example.com" value="{{ isset($user->email) ? $user->email : @old('email')}}">
                                            @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
        
                                    </div>
                                    <div class="row">
    
                                    <div class="col-lg-6" style="{{ isset($user->id)   ?  "display: none":""}}">
                                        <div class="form-group " >
                                            <label class="form-control-label" for="new_password">Password</label>
                                            <input type="password" id="new_password" class="form-control" name="new_password" placeholder="New password">
                                        </div>
                                    </div>
                                    <div class="col-lg-6" style="{{ isset($user->id)  ?  "display: none":""}}">
                                        <div class="form-group ">
                                            <label class="form-control-label" for="confirm_password">Confirm password</label>
                                            <input type="password" id="confirm_password" class="form-control" name="password_confirmation" placeholder="Confirm password">
                                        </div>
                                    </div>
                                    </div>        
                                </div>
                             
                                
                                <!-- Button -->
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col text-right">
                                        <a href="{{ route( 'users.index' ) }}" class="btn btn-danger">back</a>
                                        <button type="submit" class="btn btn-primary">{{$user ? 'Update':'Save'}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        </form>
    
                    </div>
    
                </div>
    
            </div>

            
    </form>


            </div>
</div>

@endsection