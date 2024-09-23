@extends('shop_layout')
@section('content')
    <!--Page Banner Start-->
    <div class="page-banner" style="background-image: url(public/kidolshop/images/oso.png);">
        <div class="container">
            <div class="page-banner-content text-center">
                <h2 class="title">Đổi mật khẩu</h2>
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ URL::to('/home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Đổi mật khẩu</li>
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
                                <a href="{{ URL::to('/account') }}"><i class="fa fa-user"></i> Hồ Sơ</a>
                            </li>
                            <li>
                                <a href="{{ URL::to('/change-password') }}"><i class="fa fa-key"></i> Đổi Mật Khẩu</a>
                            </li>
                            <li>
                                <a class="active"><i class="fa-solid fa-location-dot"></i> Địa chỉ nhận hàng</a>
                            </li>
                            <li>
                                <a href="{{ URL::to('/ordered') }}"><i class="fa fa-shopping-cart"></i> Đơn Đặt Hàng</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-9 col-md-8">
                    <div class="tab-content my-account-tab mt-30" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-password">
                            <div class="my-account-address account-wrapper">
                                <div class="row">
                                    <div class="col-md-12" style="border-bottom: solid 1px #efefef;">
                                        <h4 class="account-title" style="margin-bottom: 0;">Địa chỉ nhận hàng</h4>
                                        <h5 style="color: #666;">Quản lý thông tin hồ sơ để bảo mật tài khoản</h5>
                                    </div>
                                    <form id="form-change-password">
                                        @csrf
                                        <div class="container__address-content">
                                            <div class="container__address-content-hd justify-content-between">
                                                <div><i class="container__address-content-hd-icon fa fa-map-marker"></i>Địa
                                                    Chỉ Nhận Hàng</div>
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#AddressModal">+ Thêm Địa Chỉ</button>
                                            </div>
                                            <ul class="shipping-list list-address">

                                            </ul>
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
    <!--Address end-->
    <!-- Modal thêm địa chỉ -->
    <form id="form-insert-address">
        @csrf
        <div class="modal fade" id="AddressModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm Địa Chỉ</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="CustomerName" class="col-form-label">Họ và tên:</label>
                            <input type="text" class="form-control" name="CustomerName" id="CustomerName">
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="PhoneNumber" class="col-form-label">Số điện thoại:</label>
                            <input type="text" class="form-control" name="PhoneNumber" id="PhoneNumber">
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <span class="col-form-label">Tinh/Thành phố</span>
                            <select id="province" name="province" class="form-control" style="width:100%" data-style="py-0"
                                required>
                                <option value="">---Chọn Tinh/Thành phố---</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->idProvince }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="col-form-label">Quận/Huyện/Thị trấn</span>
                            <select id="district" name="district" class="form-control" data-style="py-0" required>
                                <option value="">---Chọn Quận/Huyện/Thị trấn---</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="col-form-label">Phường/xã</span>
                            <select id="ward" name="ward" class="form-control" data-style="py-0" required>
                                <option value="">---Chọn Phường/xã---</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Address" class="col-form-label">Số nhà:</label>
                            <textarea class="form-control" name="Address" id="Address"></textarea>
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <input type="submit" id="btn-insert-address" class="btn btn-primary" value="Thêm">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal sửa địa chỉ -->
    <form id="form-edit-address">
        @csrf
        <div class="modal fade" id="EditAddressModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sửa Địa Chỉ</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="CustomerName" class="col-form-label">Họ và tên:</label>
                            <input type="text" class="form-control" name="CustomerName" id="CustomerName">
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="PhoneNumber" class="col-form-label">Số điện thoại:</label>
                            <input type="text" class="form-control" name="PhoneNumber" id="PhoneNumber">
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <span class="col-form-label">Tinh/Thành phố</span>
                            <select id="province" name="province" class="form-control" style="width:100%"
                                data-style="py-0" required>
                                <option value="">---Chọn Tinh/Thành phố---</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->idProvince }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="col-form-label">Quận/Huyện/Thị trấn</span>
                            <select id="district" name="district" class="form-control" data-style="py-0" required>
                                <option value="">---Chọn Quận/Huyện/Thị trấn---</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="col-form-label">Phường/xã</span>
                            <select id="ward" name="ward" class="form-control" data-style="py-0" required>
                                <option value="">---Chọn Phường/xã---</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Address" class="col-form-label">Số nhà:</label>
                            <textarea class="form-control" name="Address" id="Address"></textarea>
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <input type="submit" id="btn-insert-address" class="btn btn-primary" value="Sửa">
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="{{ asset('public/kidolshop/js/jquery.validate.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            APP_URL = '{{ url('/') }}';
            fetch_address();
    
            // Ajax hiện danh sách địa chỉ nhận hàng
            function fetch_address() {
                var _token = $('input[name="_token"]').val();
    
                $.ajax({
                    url: "{{ url('/fetch-address') }}",
                    method: 'POST',
                    data: {
                        _token: _token
                    },
                    success: function(data) {
                        $('.list-address').html(data);
    
                        // Ajax xóa địa chỉ nhận hàng
                        $('.dlt-address').on('click', function() {
                            var idAddress = $(this).data("id");
                            var _token = $('input[name="_token"]').val();
    
                            $.ajax({
                                url: APP_URL + '/delete-address/' + idAddress,
                                method: 'DELETE',
                                data: {
                                    idAddress: idAddress,
                                    _token: _token
                                },
                                success: function(data) {
                                    fetch_address();
                                }
                            });
                        });
    
                        // Ajax validate form && sửa địa chỉ nhận hàng
                        $('.edit-address').on('click', function()  {
                            var addressData = $(this).data();
                            $('#form-edit-address #CustomerName').val(addressData.name);
                            $('#form-edit-address #PhoneNumber').val(addressData.phone);
                            $('#form-edit-address #Address').val(addressData.address);
    
                            // Đặt giá trị cho dropdown tỉnh/thành phố
                        $('#form-edit-address #province').val(addressData.idprovince);
    
                            // Lấy danh sách quận/huyện theo tỉnh
                            $.ajax({
                                url: APP_URL + '/districts/' + addressData.idprovince,
                                method: 'GET',
                                dataType: 'json',
                                success: function(districts) {
                                    $('#form-edit-address #district').empty().append('<option value="">---Chọn Quận/Huyện/Thị trấn---</option>');
                                    $.each(districts, function(key, district) {
                                        $('#form-edit-address #district').append('<option value="' + district.idDistrict + '">' + district.name + '</option>');
                                    });
                                    $('#form-edit-address #district').val(addressData.iddistrict);
    
                                    // Sau khi quận/huyện được chọn, load danh sách phường/xã
                                    $.ajax({
                                        url: APP_URL + '/wards/' + addressData.iddistrict,
                                        method: 'GET',
                                        dataType: 'json',
                                        success: function(wards) {
                                            $('#form-edit-address #ward').empty().append('<option value="">---Chọn Phường/Xã---</option>');
                                            $.each(wards, function(key, ward) {
                                                $('#form-edit-address #ward').append('<option value="' + ward.idWard + '">' + ward.name + '</option>');
                                            });
                                            $('#form-edit-address #ward').val(addressData.idward);
                                        }
                                    });
                                }
                        });
                            //
                             // Xử lý khi thay đổi tỉnh/thành phố
                        $('#form-edit-address #province').on('change', function() {
                            var provinceId = $(this).val();
                            if (provinceId) {
                                // Load quận/huyện mới khi tỉnh/thành phố thay đổi
                                $.ajax({
                                    url: APP_URL + '/districts/' + provinceId,
                                    method: 'GET',
                                    dataType: 'json',
                                    success: function(districts) {
                                        $('#form-edit-address #district').empty().append('<option value="">---Chọn Quận/Huyện/Thị trấn---</option>');
                                        $.each(districts, function(key, district) {
                                            $('#form-edit-address #district').append('<option value="' + district.idDistrict + '">' + district.name + '</option>');
                                        });
                                        // Sau khi chọn quận/huyện, reset dropdown phường/xã
                                        $('#form-edit-address #ward').empty().append('<option value="">---Chọn Phường/Xã---</option>');
                                    }
                                });
                            } else {
                                $('#form-edit-address #district').empty();
                                $('#form-edit-address #ward').empty();
                            }
                        });
    
                        // Xử lý khi thay đổi quận/huyện
                        $('#form-edit-address #district').on('change', function() {
                            var districtId = $(this).val();
                            if (districtId) {
                                // Load phường/xã mới khi quận/huyện thay đổi
                                $.ajax({
                                    url: APP_URL + '/wards/' + districtId,
                                    method: 'GET',
                                    dataType: 'json',
                                    success: function(wards) {
                                        $('#form-edit-address #ward').empty().append('<option value="">---Chọn Phường/Xã---</option>');
                                        $.each(wards, function(key, ward) {
                                            $('#form-edit-address #ward').append('<option value="' + ward.idWard + '">' + ward.name + '</option>');
                                        });
                                    }
                                });
                            } else {
                                $('#form-edit-address #ward').empty();
                            }
                        });
                            //
                            $("#form-edit-address").validate({
                                
                                rules: {
                                    Address: {
                                        required: true,
                                        minlength: 20
                                    },
                                    CustomerName: {
                                        required: true,
                                        minlength: 5
                                    },
                                    PhoneNumber: {
                                        required: true,
                                        minlength: 10,
                                        maxlength: 10
                                    },
                                    province: {
                                        required: true
                                    },
                                    district: {
                                        required: true
                                    },
                                    ward: {
                                        required: true
                                    }
                                },
                                messages: {
                                    Address: {
                                        required: "Vui lòng nhập trường này",
                                        minlength: "Nhập địa chỉ tối thiểu 20 ký tự"
                                    },
                                    CustomerName: {
                                        required: "Vui lòng nhập trường này",
                                        minlength: "Nhập họ và tên tối thiểu 5 ký tự"
                                    },
                                    PhoneNumber: {
                                        required: "Vui lòng nhập trường này",
                                        minlength: "Nhập số điện thoại tối thiểu 10 chữ số",
                                        maxlength: "Nhập số điện thoại tối đa 12 chữ số"
                                    },
                                    province: {
                                        required: "Vui lòng chọn tỉnh/thành phố"
                                    },
                                    district: {
                                        required: "Vui lòng chọn quận/huyện"
                                    },
                                    ward: {
                                        required: "Vui lòng chọn phường/xã"
                                    }
                                },
                                submitHandler: function(form) {
                                    console.log(addressData.id);
                                    var CustomerName = $('#form-edit-address #CustomerName').val();
                                    var PhoneNumber = $('#form-edit-address #PhoneNumber').val();
                                    var Address = $('#form-edit-address #Address').val();
                                    var idProvince = $('#form-edit-address #province').val();
                                    var idDistrict = $('#form-edit-address #district').val();
                                    var idWard = $('#form-edit-address #ward').val();
                                    var _token = $('input[name="_token"]').val();
                                    
                                    $.ajax({
                                        url: APP_URL + '/edit-address/' + addressData.id,
                                        method: 'POST',
                                        data: {
                                            idAddress: addressData.id,
                                            CustomerName: CustomerName,
                                            PhoneNumber: PhoneNumber,
                                            Address: Address,
                                            idProvince: idProvince,
                                            idDistrict: idDistrict,
                                            idWard: idWard,
                                            _token: _token
                                        },
                                        success: function(data) {
                                            console.log(data);
                                            $('#EditAddressModal').modal('hide');
                                            fetch_address(); // Giả sử bạn có hàm này để làm mới danh sách địa chỉ
                                        }
                                    });
                                }
                            });
                            ////
                        });
                    }
                });
            }
    
            // Ajax validate form && insert địa chỉ nhận hàng
            $("#form-insert-address").validate({
                rules: {
                    Address: {
                        required: true,
                        minlength: 20
                    },
                    CustomerName: {
                        required: true,
                        minlength: 5
                    },
                    PhoneNumber: {
                        required: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    province: {
                        required: true
                    },
                    district: {
                        required: true
                    },
                    ward: {
                        required: true
                    }
                },
    
                messages: {
                    Address: {
                        required: "Vui lòng nhập trường này",
                        minlength: "Nhập địa chỉ tối thiểu 20 ký tự"
                    },
                    CustomerName: {
                        required: "Vui lòng nhập trường này",
                        minlength: "Nhập họ và tên tối thiểu 5 ký tự"
                    },
                    PhoneNumber: {
                        required: "Vui lòng nhập trường này",
                        minlength: "Nhập số điện thoại tối thiểu 10 chữ số",
                        maxlength: "Nhập số điện thoại tối đa 10 chữ số"
                    },
                    province: {
                        required: "Vui lòng chọn tỉnh/thành phố"
                    },
                    district: {
                        required: "Vui lòng chọn quận/huyện"
                    },
                    ward: {
                        required: "Vui lòng chọn phường/xã"
                    }
                },
    
                submitHandler: function(form) {
                
                    var CustomerName = $('#CustomerName').val();
                    var PhoneNumber = $('#PhoneNumber').val();
                    var Address = $('#Address').val();
                    var province = $('#province').val();
                    var district = $('#district').val();
                    var ward = $('#ward').val();
                    var _token = $('input[name="_token"]').val();
    
                    $.ajax({
                        url: APP_URL + '/insert-address',
                        method: 'POST',
                        data: {
                            CustomerName: CustomerName,
                            PhoneNumber: PhoneNumber,
                            idProvince: province, // ID tỉnh
                            idDistrict: district, // ID huyện
                            idWard: ward, // ID xã
                            Address: Address, // Gửi địa chỉ chi tiết riêng biệt
                            _token: _token
                        },
                        success: function(data) {
                            $('#AddressModal').modal('hide');
                            fetch_address();
                        }
                    });
                }
            });
        });
    </script>
    
    <script>
        $(document).ready(function() {
            // Khi người dùng chọn tỉnh/thành phố
            $('#province').on('change', function() {
                var provinceId = $(this).val(); // Lấy ID của tỉnh/thành phố được chọn
                if (provinceId) {
                    $.ajax({
                        url: '{{ url('districts') }}/' + provinceId,

                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data);
                            $('#district').empty(); // Xóa dữ liệu cũ trong dropdown Quận/Huyện
                            $('#ward').empty(); // Xóa dữ liệu cũ trong dropdown Xã/Phường
                            $('#district').append(
                                '<option value="">---Chọn Quận/Huyện/Thị trấn---</option>');
                            $.each(data, function(key, district) {
                                $('#district').append('<option value="' + district.idDistrict + '">' + district.name + '</option>'
                                );
                            });
                            $('#ward').empty().append('<option value="">---Chọn Phường/Xã---</option>');

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
                if (districtId) {
                    $.ajax({
                        url: '{{ url('wards') }}/' + districtId,

                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log(data);

                            $('#ward').empty(); // Xóa dữ liệu cũ trong dropdown Xã/Phường
                            $('#ward').append('<option value="">---Chọn Phường/Xã---</option>');
                            $.each(data, function(key, ward) {
                                $('#ward').append('<option value="' + ward.idWard +
                                    '">' + ward.name + '</option>');
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
