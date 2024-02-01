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
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="user_id">User<span class="small text-danger">*</span></label>
                                        <input type="text"  class="form-control" placeholder="user" value="{{$order->user->name }}" disabled/>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="date">Date</label>
                                        <input type="text"  class="form-control" placeholder="user" value="{{$order->date }}" disabled/>

                                    </div>
                                </div>
                            
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="total">Total<span class="small text-danger">*</span></label>
                                        <input type="number" id="total" class="form-control" name="total" placeholder="total"  value="{{$order->total }}" disabled />

                                        @error('total')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <table  class="table">
                                <thead><tr>
                                    <td>Product</td>
                                    <td>Qnt</td>
                                    <td>Total</td>
                                
                                </tr></thead>
                                @forEach($order->OreHasProducts as $OreProducts)
                                
                                <tr>
                                    <td>{{$OreProducts->Products->title}}</td>
                                    <td>{{$OreProducts->qnt}}</td>
                                    <td>{{$OreProducts->qnt *$OreProducts->Products->price}}</td>
                                    </tr>

                                @endforeach
                            </table>
                            
                        </div>
                           <div class="pl-lg-4 mt-3">
                                <div class="row">
                                    <div class="col text-right">
                                        <a href="{{ route( 'order.index' ) }}" class="btn btn-danger">back</a>
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