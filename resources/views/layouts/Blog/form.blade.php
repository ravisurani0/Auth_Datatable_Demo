@extends('layouts.admin')

@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Blog Details') }}</h1>

@if (session('success'))
<div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="row">
    <div class="col-lg-8 order-lg-1">

        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Blog Details</h6>
            </div>


            <div class="card-body">

               <form action="{{$blogs ?  route( 'blog.update',['role'=>$blogs->id]) : route('blog.store') }}" method="POST">
                    @if($blogs)
                    
                    @method('PUT')
                    @else
                    @method('POST')
                    @endif
                    @csrf
                    
                        <h6 class="heading-small text-muted mb-4">Blog information</h6>
                        <div class="pl-lg-4">
                            <input type="hidden" name="user_id" value="{{Auth::user()->id;}}">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="title">Title</label>
                                        <input type="text" id="title" class="form-control" name="title" placeholder="Title" value="{{ isset( $blogs->title) ? $blogs->title : @old('title') }}" />

                                        @error('title')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="description">Description</label>
                                        <textarea type="text" id="description" class="form-control" name="description" placeholder="description">{{ isset( $examSubjet->description) ? $examSubjet->description : @old('description') }}</textarea>
    
                                        @error('description')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                           <div class="pl-lg-4">
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col text-right">
                                        <a href="{{ route( 'blog.index' ) }}" class="btn btn-danger">back</a>

                                        <button type="submit" class="btn btn-primary">{{$blogs ? 'Update':'Save'}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                     </form>

                    

            </div>

        </div>

    </div>

</div>

@endsection