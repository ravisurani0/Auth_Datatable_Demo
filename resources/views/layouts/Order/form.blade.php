@extends('layouts.admin')
@section('main-content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Product Details') }}</h1>
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
                <h6 class="m-0 font-weight-bold text-primary">Order Details</h6>
            </div>
            <div class="card-body">
               <form action="{{route('order.store')}}" method="POST">
                    @method('POST')
                    @csrf
                       <h6 class="heading-small text-muted mb-4">Order information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <input type='hidden' id='productList' value="{{json_encode($productList)}}" />
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="user_id">User<span class="small text-danger">*</span></label>
                                        <select class="form-control" id="user_id" name="user_id">
                                            @foreach($userList as $user)
                                            <option value="{{$user->id}}" {{$orders?->user_id ==
                                                $user->id ? 'selected' :''}}>{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="date">Date</label>
                                        <input type="date" id="date" class="form-control" name="date" placeholder="date" value="{{ isset( $products->date) ? $products->date : @old('date') }}" required/>
                                        @error('date')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="product_id">Product<span class="small text-danger">*</span></label>
                                        <select class="form-control" id="product_id" name="product_id" onchange="addProduct(this,{{$productList}})" >
                                            @foreach($productList as $product)
                                            <option value="{{$product->id}}" {{$orders?->product_id ==
                                                $product->id ? 'selected' :''}}>{{$product->title}}</option>
                                            @endforeach
                                        </select>
                                        @error('product_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="total">Total<span class="small text-danger">*</span></label>
                                        <input type="number" id="total" class="form-control" name="total" placeholder="total" value="0" required />

                                        @error('total')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div id="questions_list" >
                            </div>
                            
                        </div>
                           <div class="pl-lg-4 mt-3">
                                <div class="row">
                                    <div class="col text-right">
                                        <a href="{{ route( 'order.index' ) }}" class="btn btn-danger">back</a>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                        </div>
                     </form>
            </div>
        </div>
    </div>
</div>


<script>

let orderTotal = 0
    function addProduct(event,productList) {

        if(!$('.product_'+event.value)[0]?.value){
            let product = productList.filter(item => item.id == event.value)[0]
            let product_html = "<div class='row' id='product_" + product.id + "'>";
            product_html += "<span class='col-2 font-weight-bolder'> " + product.title + "</span>";
            product_html += "<input type='hidden' min='0' id='product_qnt_id"+product.id+"' class='form-control col-9+ product_"+product.id+"' name='product["+product.id+"]' value="+[product.id]+" placeholder='Qnt'  required />";
            product_html += "<input type='number' min='0' id='product_qnt"+product.id+"' class='form-control col-9 product_qnt' name='qnt["+product.id+"]' placeholder='Qnt' onchange='updateProductQnt()' required />";
            product_html += "<button class='col-1 btn btn-danger'  onclick='removeProduct(" + product.id + ")'> x</button>";
            product_html += "</div>";
            
            $('#questions_list').append(product_html);
        }
        else{
            alert('Product allrady added.')
        }
     
    }

    function updateProductQnt(productList) {
        let products = JSON.parse($('#productList')[0].value)
        let total = 0
    products.forEach(product=>
        {  
            if($('#product_qnt'+product.id)[0]?.value){
                total= total + $('#product_qnt'+product.id)[0]?.value * product.price
                
            }
    })
    $('#total').val(  total)
    }

    // function removeProduct(item) {
    //     $('#product_' + item).remove()
    // }
</script>
@endsection