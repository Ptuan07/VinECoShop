@extends('shop_layout')
@section('content')

<!--Page Banner Start-->
<div class="page-banner" style="background-image: url(public/kidolshop/images/oso.png);">
    <div class="container">
        <div class="page-banner-content text-center">
            <h2 class="title">Tài khoản của tôi</h2>
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{URL::to('/home')}}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tài khoản của tôi</li>
            </ol>
        </div>
    </div>
</div>
<!--Page Banner End-->


<!--My Account Start-->
<div class="register-page section-padding-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-md-4">
                <div class="my-account-menu mt-30">
                    <ul class="nav account-menu-list flex-column">
                        <li>
                            <a href="{{URL::to('/account')}}"><i class="fa fa-user"></i> Hồ Sơ</a>
                        </li>
                        <li>
                            <a href="{{URL::to('/change-password')}}"><i class="fa fa-key"></i> Đổi Mật Khẩu</a>
                        </li>
                        <li>
                            <a class="active"><i class="fa-solid fa-location-dot"></i> Địa chỉ nhận hàng</a>
                        </li>
                        <li>
                            <a href="{{URL::to('/ordered')}}"><i class="fa fa-shopping-cart"></i> Đơn Đặt Hàng</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-9 col-md-8">
                <div class="tab-content my-account-tab mt-30" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-account">
                        <div class="tab-content my-account-tab" id="pills-tabContent">
                            <div class="tab-pane fade active show">
                                <div class="my-account-address account-wrapper">
                                    <div class="row">
                                        <div class="col-md-12" style="border-bottom: solid 1px #efefef;">
                                            <h4 class="account-title" style="margin-bottom: 0;">Hồ Sơ Của Tôi</h4>
                                            <h5 style="color: #666;">Quản lý thông tin hồ sơ để bảo mật tài khoản</h5>
                                        </div>
                                        <form id="form-edit-profile" style="display:flex; padding: 0;" enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-md-8 mt-10">
                                                <div class="account-address">
                                                    <div class="form-group mb-30">
                                                        <span for="CustomerName" class="profile__info-body-left-item-title ml-30" >Họ Và Tên</span>
                                                        <input id="CustomerName" name="CustomerName" class="ml-30" style="width:65%;" type="text" value="{{$customer->CustomerName}}">
                                                    </div>
                                                    <div class="form-group mb-30">
                                                        <span class="profile__info-body-left-item-title ml-30">Số Điện Thoại</span>
                                                        <input class="ml-30" style="width:65%;" name="PhoneNumber" id="PhoneNumber" type="text" value="{{$customer->PhoneNumber}}">
                                                    </div>
                                                    <div class="form-group mb-30">
                                                        <span class="profile__info-body-left-item-title ml-30">Tinh/Thành phố</span>
                                                        <select id="province" name="province" class="ml-30 form-control" style="width:65%;" data-style="py-0" required>
                                                            <option value="">---Chọn Tinh/Thành phố---</option>
                                                            @foreach($provinces as $province)
                                                            <option value="{{ $province->idProvince}}">{{ $province->name }}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group mb-30">
                                                        <span class="profile__info-body-left-item-title ml-30" >Quận/Huyện/Thị trấn</span>
                                                        <select  id="district" name="district" class="ml-30 form-control" style="width:65%;" data-style="py-0" required>
                                                            <option value="">---Chọn Quận/Huyện/Thị trấn---</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-30">
                                                        <span class="profile__info-body-left-item-title ml-30" >Phường/xã</span>
                                                        <select id="ward" name="ward" class="ml-30 form-control" style="width:65%;" data-style="py-0" required>
                                                            <option value="">---Chọn Phường/xã---</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-30">
                                                        <span class="profile__info-body-left-item-title ml-30">Số nhà/đường</span>
                                                        <input class="ml-30" style="width:65%;" name="PhoneNumber" id="PhoneNumber" type="text" >
                                                    </div>
                                                    <button class="btn btn-primary edit-profile" style="float: right;"><i class="fa fa-edit"></i> Sửa Hồ Sơ</button>
                                                </div>
                                            </div>
                                            
                                        </form>
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
<!--My Account End-->

<script>
    $(document).ready(function() {
        // Khi người dùng chọn tỉnh/thành phố
        $('#province').on('change', function() {
            var provinceId = $(this).val(); // Lấy ID của tỉnh/thành phố được chọn
            if(provinceId) {
                $.ajax({
                    url: '{{ url("districts") }}/' + provinceId, 

                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        console.log(data);
                        $('#district').empty(); // Xóa dữ liệu cũ trong dropdown Quận/Huyện
                        $('#ward').empty(); // Xóa dữ liệu cũ trong dropdown Xã/Phường
                        $('#district').append('<option value="">---Chọn Quận/Huyện/Thị trấn---</option>');
                        $.each(data, function(key, district) {
                            $('#district').append('<option value="'+ district.idDistrict +'">'+ district.name +'</option>');
                        });
                    }
                });
            } else {
                $('#district').empty();
                $('#ward').empty();
            }
        });

        // Khi người dùng chọn quận/huyện
        $('#district').on('change', function() {
            var districtId = $(this).val(); // Lấy ID của quận/huyện được chọn
            if(districtId) {
                $.ajax({
                    url: '{{ url("wards") }}/' + districtId,

                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        console.log(data);

                        $('#ward').empty(); // Xóa dữ liệu cũ trong dropdown Xã/Phường
                        $('#ward').append('<option value="">---Chọn Phường/Xã---</option>');
                        $.each(data, function(key, ward) {
                            $('#ward').append('<option value="'+ ward.idWard +'">'+ ward.name +'</option>');
                        });
                    }
                });
            } else {
                $('#ward').empty();
            }
        });
    });
</script>


@endsection