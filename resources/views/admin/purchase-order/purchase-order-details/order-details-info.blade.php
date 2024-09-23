@extends('admin_layout')
@section('content_dash')

<div class="content-page">
    <div class="container-fluid">
        <div class="row">                  
            <div class="col-lg-12">
                <div class="card card-block card-stretch card-height print rounded">
                    <div class="card-header d-flex justify-content-between bg-primary header-invoice">
                        <div class="iq-header-title">
                            <h4 class="card-title mb-0">Chi tiết Đơn hàng #{{$purchaseDetails->idPurchaseOrder}}</h4>
                        </div>
                        <!-- <div class="invoice-btn">
                            <button type="button" class="btn btn-primary-dark mr-2"><i class="las la-print"></i> Print
                                Print</button>
                            <button type="button" class="btn btn-primary-dark"><i class="las la-file-download"></i>PDF</button>
                        </div> -->
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive-sm">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Người tạo đơn </th>
                                                <th scope="col">Người chỉnh sửa</th>
                                                <th scope="col">Ngày đặt</th>
                                                <th scope="col">Ngày nhận</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="padding-left:12px !important;">{{$purchaseDetails->createdBy}}</td>
                                                <td style="padding-left:12px !important;">{{$purchaseDetails->updatedBy}}</td>
                                                <td style="padding-left:12px !important;">{{$purchaseDetails->orderDate}}</td>
                                                <td style="padding-left:12px !important;">{{$purchaseDetails->receiveDate}}</td>

                                            </tr> 
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <h5 class="mb-3">Chi tiết đơn hàng</h5>
                                <div class="table-responsive-sm">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Sản phẩm</th>
                                                <th class="text-center" scope="col">Nhà cung cấp</th>
                                                <th class="text-center" scope="col">Giá</th>
                                                <th class="text-center" scope="col">Số lượng</th>
                                                <th class="text-center" scope="col">Hạn sử dụng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                {{-- <th class="text-center" scope="row">{{$key + 1}}</th> --}}
                                                <td class="row" style="border-bottom:0;">
                                                        <?php $image = json_decode($purchaseDetails->ImageName)[0]; ?>
                                                        <img class="avatar-70 rounded" src="{{asset('public/storage/kidoldash/images/product/'.$image)}}" alt="">
                                                        <div class="ml-2" style="flex:1;">
                                                            <h6 class="mb-0">{{$purchaseDetails->ProductName}}</h6>
                                                            <p class="mb-0">Mã sản phẩm: {{$purchaseDetails->idProduct}}</p>
                                                            {{-- <span>{{$purchaseDetails->AttributeProduct}}</span> --}}
                                                        </div>
                                                </td>
                                                <td class="text-center" style="border-bottom:0;">{{$purchaseDetails->supplierName}}</td>
                                                <td class="text-center" style="border-bottom:0;">{{number_format($purchaseDetails->unitPrice,0,',','.')}}đ</td>
                                                <td class="text-center" style="border-bottom:0;">{{$purchaseDetails->quantity}}</td>
                                                <td class="text-center" style="border-bottom:0;"><b>{{$purchaseDetails->expiryDate}}</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>                              
                        </div>
                        <!-- <div class="row">
                            <div class="col-sm-12">
                                <b class="text-danger">Notes:</b>
                                <p class="mb-0">a</p>
                            </div>
                        </div> -->
                        <div class="row mt-4 mb-3">
                            <div class="col-lg-12">
                                <div class="or-detail rounded">
                                    <div class="p-3 row">
                                        <h5 class="mb-3 col-lg-12">Order Details</h5>
                                        <div class="mb-2 col-lg-10">
                                            <h6>Tổng tiền hàng</h6>
                                        </div>
                                        <div class="mb-2 col-lg-2 text-right">
                                            <h4>{{number_format($purchaseDetails->unitPrice * $purchaseDetails->quantity,0,',','.')}}đ</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                            
                    </div>
                </div>
            </div>                                    
        </div>
    </div>
</div>

@endsection