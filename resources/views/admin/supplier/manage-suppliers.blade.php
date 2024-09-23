@extends('admin_layout')
@section('content_dash')

<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Danh Sách Nhà Cung Cấp ( Tổng: {{$count_supplier}} nhà cung cấp )</h4>
                    </div>
                    <a href="{{URL::to('/add-supplier')}}" class="btn btn-primary add-list"><i class="las la-plus mr-3"></i>Thêm nhà cung cấp</a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                    <th> Mã</th>
                                    <th> Nhà cung cấp </th>
                                    <th> Địa chỉ </th>
                                    <th> SĐT</th>
                                    <th> Gmail </th>
                                    <th> Mô tả </th>
                                    <th> Thao tác </th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            @foreach($list_supplier as $key => $supplier)
                            <tr>
                                <td>{{$supplier->idSupplier}}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php $image = json_decode($supplier->ImageSupplier)[0];?>
                                        <img src="{{asset('public/storage/kidoldash/images/supplier/'.$image)}}" class="img-fluid rounded avatar-50 mr-3" alt="image">
                                        <div>{{$supplier->supplierName}}</div>        
                                    </div>
                                </td>
                                <td>{{$supplier->address}}</td>
                                <td>{{$supplier->phone}}</td>
                                <td>{{$supplier->gmail}}</td>
                                <td>{{$supplier->description}}</td>
                                <td>
                                    <form> @csrf
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge bg-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sửa"
                                            href="{{URL::to('/edit-supplier/'.$supplier->idSupplier)}}"><i class="ri-pencil-line mr-0"></i></a>
                                        <a class="badge bg-warning mr-2" data-toggle="modal" data-tooltip="tooltip" data-target="#modal-delete-{{$supplier->idSupplier}}" data-placement="top" title="Xóa" data-original-title="Xóa"
                                            style="cursor:pointer;"><i class="ri-delete-bin-line mr-0"></i></a>
                                    </div>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" id="modal-delete-{{$supplier->idSupplier}}"  aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Thông báo</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Bạn có muốn xóa Nhà cung cấp {{$supplier->supplierName}} không?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-dismiss="modal">Trở về</button>
                                            <a href="{{URL::to('/delete-supplier/'.$supplier->idSupplier)}}" type="button" class="btn btn-primary">Xác nhận</a>
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



@endsection