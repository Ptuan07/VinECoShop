@extends('admin_layout')
@section('content_dash')

<div class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Danh Sách Banner ( Tổng: {{$count_banner}} Banner )</h4>
                    </div>
                    <a href="{{URL::to('/add-banner')}}" class="btn btn-primary add-list"><i class="las la-plus mr-3"></i>Thêm Banner</a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                    <table class="data-tables table mb-0 tbl-server-info">
                        <thead class="bg-white text-uppercase">
                            <tr class="ligth ligth-data">
                                    <th> Mã</th>
                                    <th> Banner </th>
                                    <th> Mô tả </th>
                                    <th> Thao tác </th>
                            </tr>
                        </thead>
                        <tbody class="ligth-body">
                            @foreach($list_banner as $key => $banner)
                            <tr>
                                <td>{{$banner->idBanner}}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php 
                                    $images = json_decode($banner->imageBanner);
                                    $image = isset($images[0]) ? $images[0] : 'default-image.jpg'; // Hình ảnh mặc định nếu không có
                                    ?>

                                    <img src="{{ asset('public/storage/kidoldash/images/banner/' . $image) }}" class="img-fluid rounded avatar-50 mr-3" alt="image">
                                    <div>{{ $banner->bannerName }}</div>       
                                    </div>
                                </td>
                                <td>{{$banner->description}}</td>
                                <td>
                                    <form> @csrf
                                    <div class="d-flex align-items-center list-action">
                                        <a class="badge bg-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sửa"
                                            href="{{URL::to('/edit-banner/'.$banner->idBanner)}}"><i class="ri-pencil-line mr-0"></i></a>
                                        <a class="badge bg-warning mr-2" data-toggle="modal" data-tooltip="tooltip" data-target="#modal-delete-{{$banner->idBanner}}" data-placement="top" title="Xóa" data-original-title="Xóa"
                                            style="cursor:pointer;"><i class="ri-delete-bin-line mr-0"></i></a>
                                    </div>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" id="modal-delete-{{$banner->idBanner}}"  aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Thông báo</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Bạn có muốn xóa Banner {{$banner->bannerName}} không?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-dismiss="modal">Trở về</button>
                                            <a href="{{URL::to('/delete-banner/'.$banner->idBanner)}}" type="button" class="btn btn-primary">Xác nhận</a>
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