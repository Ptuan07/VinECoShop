@extends('admin_layout')
@section('content_dash')

<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Danh Sách Sản Phẩm có trong đơn nhập mã #{{$idPurchaseOrder}} </h4>
                        {{-- <div class="mb-2 col-lg-10">
                            <?php $Total = 0 ?>
                                            @foreach($purchaseDetails as $key => $detail)
                                                <?php $Total += ($detail->unitPrice * $detail->quantity); ?>
                                            @endforeach
                            <h4 class="text-primary">Tổng tiền hàng: {{number_format($Total,0,',','.')}}đ </h4>
                        </div> --}}
                    </div>
                    <a href="{{URL::to('/add-purchase-order-details/'.$idPurchaseOrder)}}" class="btn btn-primary add-list"><i class="las la-plus mr-3"></i>Thêm chi tiết đơn nhập</a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                    <th> Mã CTĐN</th>
                                    <th> Sản phẩm </th>
                                    <th> Hạn sử dụng </th>
                                    <th> Số lượng  </th>
                                    <th> Tổng tiền</th>
                                    <th> Thao tác </th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            @foreach($purchaseDetails as $key => $detail)
                            <tr>
                                <td>{{$detail->idDetails}}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php $image = json_decode($detail->ImageName)[0];?>
                                        <img src="{{asset('public/storage/kidoldash/images/product/'.$image)}}" class="img-fluid rounded avatar-50 mr-3" alt="image">
                                        <div>{{$detail->ProductName}}</div>        
                                    </div>
                                </td>
                                <td>{{$detail->expiryDate}}</td>
                                <td>{{$detail->quantity}}</td>
                                
                                <td>{{number_format($detail->unitPrice,0,',','.')}}đ</td>

                                <td>
                                    <form> @csrf
                                    <div class="d-flex align-items-center list-action">
                                        @if($detail->status == 0)
                                        <a class="badge badge-success mr-2" data-toggle="tooltip" data-placement="top" title="Xem chi tiết" 
                                            href="{{ URL::to('/order-details-info/'.$idPurchaseOrder.'/'.$detail->idDetails) }}"><i class="ri-eye-line mr-0"></i>
                                        </a>
                                        <a class="badge bg-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sửa"
                                            href="{{ URL::to('/edit-purchase-order-details/'.$idPurchaseOrder.'/'.$detail->idDetails.'/'.$detail->idProduct) }}"><i class="ri-pencil-line mr-0"></i></a>
                                        <a class="badge bg-warning mr-2" data-toggle="modal" data-tooltip="tooltip" data-target="#modal-delete-{{$detail->idDetails}}" data-placement="top" title="Xóa" data-original-title="Xóa"
                                            style="cursor:pointer;"><i class="ri-delete-bin-line mr-0"></i></a>
                                        @else
                                        <a class="badge badge-success mr-2" data-toggle="tooltip" data-placement="top" title="Xem chi tiết" 
                                            href="{{ URL::to('/order-details-info/'.$idPurchaseOrder.'/'.$detail->idDetails) }}"><i class="ri-eye-line mr-0"></i>
                                        </a>
                                        <a class="badge bg-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sửa"
                                            href="{{ URL::to('/edit-purchase-order-details/'.$idPurchaseOrder.'/'.$detail->idDetails.'/'.$detail->idProduct) }}"><i class="ri-pencil-line mr-0"></i>
                                        </a>
                                        @endif
                                    </div>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" id="modal-delete-{{$detail->idDetails}}"  aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Thông báo</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Bạn có muốn xóa chi tiết đơn nhập {{$detail->idDetails}} không?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-dismiss="modal">Trở về</button>
                                            <a href="{{URL::to('/delete-product/'.$detail->idDetails)}}" type="button" class="btn btn-primary">Xác nhận</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page end  -->

<script>
    $(document).ready(function(){  
        APP_URL = '{{url('/')}}' ;

        $('.btn-StatusPro').on('click',function(){
            var idProduct = $(this).data("id");
            var StatusPro = $(this).data("statuspro");
            var _token = $('input[name="_token"]').val();

            $.ajax({
                    url: APP_URL + '/change-status-product/' +idProduct,
                    method: 'POST',
                    data: {StatusPro:StatusPro,_token:_token},
                    success:function(data){
                        location.reload();
                    }
            });
        });
    });
</script>

@endsection