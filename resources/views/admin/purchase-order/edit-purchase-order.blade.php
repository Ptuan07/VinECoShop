@extends('admin_layout')
@section('content_dash')

<?php use Illuminate\Support\Facades\Session; ?>

<div class="content-page">
    <div class="container-fluid add-form-list">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Sửa đơn nhập mã #{{$purchaseOrder->idPurchaseOrder}}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ URL::to('/submit-edit-purchase-order/'.$purchaseOrder->idPurchaseOrder) }}" method="POST" data-toggle="validator">
                        @csrf
                        <div class="row"> 
                            <div class="col-md-12">
                                <?php
                                    $message = Session::get('message');
                                    $error = Session::get('error');
                                    if($message){
                                        echo '<span class="text-success">'.$message.'</span>';
                                        Session::put('message', null);
                                    }else if($error){
                                        echo '<span class="text-danger">'.$error.'</span>';
                                        Session::put('error', null);
                                    }
                                ?>     
                                <div class="form-group">
                                    <span class="col-form-label">Tên nhà cung cấp</span>
                                    <select id="idSupplier" name="idSupplier" class="form-control" style="width:100%"
                                        data-style="py-0" required>
                                        <option value="{{$purchaseOrder->idSupplier}}">{{optional($purchaseOrder->supplier)->supplierName}}</option>
                                        @foreach ($list_supplier as $supplier)
                                            <option value="{{ $supplier->idSupplier }}">{{ $supplier->supplierName}}</option>
                                        @endforeach
                                    </select>
                                </div>                 
                                    <div class="form-group">
                                        <label for="orderDate">Thời gian tạo</label>
                                        <input id="orderDate" type="text" name="orderDate" value="{{$purchaseOrder->orderDate}}" class="form-control" placeholder="Thời gian tạo">
                                    </div>

                                    <div class="form-group">
                                        <label for="	totalPrice">Tổng tiền</label>
                                        <input id="	totalPrice" type="text" name="totalPrice"  class="form-control" value="{{$purchaseOrder->totalPrice}}" placeholder="Tổng tiền">
                                    </div>

                                    <div class="form-group">
                                        <label for="createBy">Người tạo</label>
                                        <input id="	createBy" type="text" name="createBy"  class="form-control" value="{{optional($purchaseOrder->creator)->AdminName}}" readonly>
                                    </div>
                                    {{-- <input type="hidden" name="createById" value="{{ Session::get('idAdmin') }}"> --}}
                                    <div class="form-group">
                                        <label for="updateBy">Người tạo</label>
                                        <input id="	updateBy" type="text" name="updateBy"  class="form-control" value="{{ Session::get('AdminName') }}" readonly>
                                    </div>
                                    <input type="hidden" name="updateBy" value="{{ Session::get('idAdmin') }}">

                                    <div class="form-group">
                                        <span class="col-form-label">Trạng thái đơn nhập</span>
                                        <select id="status" name="status" class="form-control" style="width:100%"
                                            data-style="py-0" required>
                                            @if($purchaseOrder->status == 0){
                                                <option value="0">Chưa hoàn thành</option>
                                            }@else
                                            <option value="1">Hoàn thành</option>
                                            @endif
                                            <option value="0">Chưa hoàn thành</option>
                                            <option value="1">Hoàn thành</option>
                                        </select>
                                    </div> 

                                    <div class="form-group">
                                        <label for="description">Mô tả</label>
                                        <input id="description" type="text" name="description" class="form-control" placeholder="Nhập Mô Tả">
                                    </div>
                            </div>    
                        </div>                             
                        <input type="submit" name="addcategory" class="btn btn-primary mr-2" value="Thêm vị trí trong kho ">
                        <a href="{{URL::to('/add-purchase-order-details')}}" class="btn btn-light mr-2">Trở Về</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>
</div>
{{-- <script>
     $("#idWareHouse").validate({
                                
                                rules: {
                                   
                                    idWareHouse: {
                                        required: true
                                    }
                                  
                                },
                                messages: {
                                    
                                    idWareHouse: {
                                        required: "Vui lòng chọn kho hàng"
                                    }
                                 
                                },
                            })
</script> --}}


@endsection