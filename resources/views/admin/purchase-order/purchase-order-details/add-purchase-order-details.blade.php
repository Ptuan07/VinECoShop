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
                                <h4 class="card-title">Tạo đơn nhập</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ URL::to('/submit-add-purchase-order-details') }}" method="POST" id="form-add-purchase-order-detail"
                                data-toggle="validator">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php
                                        $message = Session::get('message');
                                        $error = Session::get('error');
                                        if ($message) {
                                            echo '<span class="text-success">' . $message . '</span>';
                                            Session::put('message', null);
                                        } elseif ($error) {
                                            echo '<span class="text-danger">' . $error . '</span>';
                                            Session::put('error', null);
                                        }
                                        ?>
                                        <div class="form-group">
                                            <label for="idPurchaseOrder">Mã đơn nhập</label>
                                            <input id="idPurchaseOrder" type="text" name="idPurchaseOrder"
                                                class="form-control" value="{{ $idPurchaseOrder }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <span class="col-form-label">Tên sản phẩm</span>
                                            <select id="idProduct" name="idProduct"
                                                class=" js-example-templating form-control" style="width:100%"
                                                data-style="py-0" required>
                                                <option value="">---Chọn sản phẩm---</option>
                                                @foreach ($list_product as $product)
                                                    <?php $image = json_decode($product->ImageName)[0]; ?>
                                                    <option value="{{ $product->idProduct }}" data-image="{{ asset('public/storage/kidoldash/images/product/'.$image) }}">
                                                        #{{ $product->idProduct }} {{ $product->ProductName }}
                                                      </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="expiryDate">Hạn sử dụng</label>
                                            <input id="expiryDate" type="text" name="expiryDate" class="form-control" placeholder="YYYY-MM-DD">
                                            <small id="expiryDateError" style="color: red; display: none;">Hạn sử dụng phải lớn hơn ngày hiện tại.</small>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="idBrand">Phân loại hàng</label>
                                                <button class="btn btn-primary d-block col-md-12" type="button" data-toggle="modal" data-target="#modal-attributes">Chọn phân loại</button>
                                            </div>
                                        </div>
                                        <div class="col-md-12 d-flex flex-wrap input-attrs">
                                            <div class="col-md-12 d-flex flex-wrap attr-title">
                                                <div class="attr-title-1 col-md-6 text-center d-none"></div>
                                                <div class="attr-title-2 col-md-6 text-center d-none">Số lượng *</div>
                                                <div class="attr-title-3 col-md-4 text-center d-none">Giá tiền *</div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Quantity">Tổng số lượng *</label>
                                                    <input id="Quantity" name="QuantityTotal" type="number" min="0" class="form-control" placeholder="Tổng số lượng" required readonly>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Price">Tổng tiền</label>
                                                    <input id="Price" type="text" name="TotalPrice" class="form-control" placeholder="Tổng tiền" required readonly>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Chọn Warehouse -->
                                        <div class="form-group">
                                            <label for="warehouses">Chọn Warehouse:</label>
                                            <div id="warehouses">
                                                @foreach ($list_warehouse as $warehouse)
                                                    <div class="form-check">
                                                        <input class="form-check-input warehouse-checkbox" type="checkbox"
                                                            value="{{ $warehouse->idWareHouse }}"
                                                            id="warehouse-{{ $warehouse->idWareHouse }}"
                                                            name="warehouses[]">
                                                        <label class="form-check-label"
                                                            for="warehouse-{{ $warehouse->idWareHouse }}">
                                                            {{ $warehouse->wareName }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Chọn Location theo Warehouse -->
                                        <div class="form-group" id="locations-container" style="display:none;">
                                            <label for="locations"></label>
                                            <div id="locations"></div>
                                        </div>

                                        <!-- Chọn Shelves theo Location -->
                                        <div class="form-group" id="shelves-container" style="display:none;">
                                            <label for="shelves"></label>
                                            <div id="shelves"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Mô tả</label>
                                            <input id="description" type="text" name="description" class="form-control"
                                                placeholder="Nhập Mô Tả">
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" name="addcategory" class="btn btn-primary mr-2"
                                    value="Thêm vị trí trong kho ">
                                <a href="{{ URL::to('/manage-purchase-order') }}" class="btn btn-light mr-2">Trở Về</a>
                            
                            <!-- Model phân loại hàng -->
                                <div class="modal fade" id="modal-attributes" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="popup text-left">
                                                    <h4 class="mb-3">Thêm phân loại hàng</h4>
                                                    <div class="content create-workform bg-body">
                                                        <label class="mb-0">Nhóm phân loại</label>
                                                        <select name="idAttribute" id="attribute" class="selectpicker form-control choose-attr" data-style="py-0">
                                                            <option value="">Chọn nhóm phân loại</option>
                                                            @foreach($list_attribute as $key => $attribute)
                                                            <option id="attr-group-{{$attribute->idAttribute}}" data-attr-group-name="{{$attribute->AttributeName}}" value="{{$attribute->idAttribute}}">{{$attribute->AttributeName}}</option>
                                                            @endforeach
                                                        </select>

                                                        <div class="pb-3 d-flex flex-wrap" id="attribute_value">
                                                            
                                                        </div>
                                                        <div class="col-lg-12 mt-4">
                                                            <div class="d-flex flex-wrap align-items-ceter justify-content-center">
                                                                <div class="btn btn-light mr-4" data-dismiss="modal">Trở về</div>
                                                                <div class="btn btn-primary" id="confirm-attrs" data-dismiss="modal">Xác nhận</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page end  -->
        </div>
    </div>


    {{-- datetimepicker --}}
    <script>
        $(document).ready(function() {
            APP_URL = '{{ url('/') }}';
            jQuery.datetimepicker.setLocale('vi');
    
            // Hàm lấy ngày hiện tại
            function getCurrentDate() {
                let today = new Date();
                let dd = String(today.getDate()).padStart(2, '0');
                let mm = String(today.getMonth() + 1).padStart(2, '0'); // Tháng bắt đầu từ 0
                let yyyy = today.getFullYear();
                return yyyy + '-' + mm + '-' + dd;
            }
    
            jQuery(function() {
                jQuery('#expiryDate').datetimepicker({
                    format: 'Y-m-d',
                    onShow: function(ct) {
                        this.setOptions({
                            minDate: getCurrentDate() // Đặt minDate là ngày hiện tại
                        })
                    },
                    timepicker: false // Ẩn chọn giờ nếu không cần
                });
    
                // Kiểm tra khi ngày thay đổi
                $('#expiryDate').on('change', function() {
                    const selectedDate = $(this).val();
                    const currentDate = getCurrentDate();
    
                    if (selectedDate <= currentDate) {
                        // Hiển thị thông báo lỗi nếu ngày không hợp lệ
                        $('#expiryDateError').show();
                    } else {
                        // Ẩn thông báo lỗi nếu ngày hợp lệ
                        $('#expiryDateError').hide();
                    }
                });
            });
        });
    </script>

    {{-- người dùng chọn vị trí đơn nhập --}}
    <script>
        $(document).ready(function() {
            // Khi người dùng chọn Warehouse
            $('.warehouse-checkbox').on('change', function() {
                var warehouseId = $(this).val(); // Lấy ID của Warehouse được chọn
                if ($(this).is(':checked')) {
                    $.ajax({
                        url: '{{ url('locations') }}/' +
                            warehouseId, // Gửi yêu cầu AJAX đến URL này
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            let locationsHtml = `
                            <div id="warehouse-${warehouseId}-locations" class="warehouse-locations">
                                <h5>Vị trí ${$(this).next('label').text()}:</h5>`;
                            $.each(data.locations, function(key, location) {
                                locationsHtml += `
                                <span class="form-check" style="display: inline-block; margin-right: 15px; margin-bottom: 10px;">
                                    <input class="form-check-input location-checkbox" type="checkbox" value="${location.idLocation}" id="location-${location.idLocation}" name="locations[${warehouseId}][]">
                                    <label class="form-check-label" for="location-${location.idLocation}">
                                        ${location.location}
                                    </label>
                                </span>`;
                            });
                            locationsHtml += '</div>';
                            $('#locations').append(
                                locationsHtml
                                ); // Thêm HTML cho Locations của Warehouse vào container
                            $('#locations-container').show(); // Hiển thị khu vực Location
                        }.bind(this) // Bind this để đảm bảo đúng context
                    });
                } else {
                    // Nếu bỏ chọn Warehouse, xóa các dữ liệu liên quan
                    $(`#warehouse-${warehouseId}-locations`).remove();
                    $(`#warehouse-${warehouseId}-shelves`).remove();
                }
            });


            // Khi người dùng chọn Location
            $(document).on('change', '.location-checkbox', function() {
                var locationId = $(this).val(); // Lấy ID của Location được chọn
                var warehouseId = $(this).closest('.warehouse-locations').attr('id').split('-')[
                    1]; // Lấy ID của Warehouse
                if ($(this).is(':checked')) {
                    $.ajax({
                        url: '{{ url('shelves') }}/' + locationId, // Gửi yêu cầu AJAX đến URL này
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            let shelvesHtml = `
                            <div id="warehouse-${warehouseId}-shelves-${locationId}" class="warehouse-shelves">
                                <h5>Kệ cho vị trí ${$(this).next('label').text()}:</h5>`;
                            $.each(data, function(key, shelf) {
                                let disabled = (shelf.status === 1) ? 'readonly disabled' : '';
                                shelvesHtml += `
                                <span class="form-check" style="display: inline-block; margin-right: 15px; margin-bottom: 10px;">
                                    <input class="form-check-input shelf-checkbox" type="checkbox" value="${shelf.idShelves}" id="shelf-${shelf.idShelves}" name="shelves[${locationId}][]" ${disabled   }>
                                    <label class="form-check-label" for="shelf-${shelf.idShelves}">
                                        ${shelf.shelf_number}
                                    </label>
                                </span>`;
                            });
                            shelvesHtml += '</div>';

                            $('#shelves').append(
                                shelvesHtml); // Thêm HTML cho Shelves vào đúng vị trí
                            $('#shelves-container').show(); // Hiển thị khu vực Shelves
                        }.bind(this) // Bind this để đảm bảo đúng context
                    });
                } else {
                    $(`#warehouse-${warehouseId}-shelves-${locationId}`).remove();
                }
            });
        });
    </script>
    <script>
        function formatState(state) {
            if (!state.id) {
                return state.text; // Nếu không có ID (tức là tùy chọn trống), trả về text mặc định
            }

            // Lấy đường dẫn ảnh từ thuộc tính data-image của mỗi option
            var imageUrl = $(state.element).data('image');

            // Nếu không có ảnh, chỉ trả về text
            if (!imageUrl) {
                return state.text;
            }

            // Nếu có ảnh, trả về ảnh và text
            var $state = $(
                '<span><img src="' + imageUrl +
                '" class="img-flag" style="width: 20px; height: 20px; margin-right: 8px;" /> ' + state.text + '</span>'
            );
            return $state;
        };

        $(".js-example-templating").select2({
            templateResult: formatState
        });
    </script>
    <script>
        $(document).ready(function(){  
        $('.choose-attr').on('change',function(){
            var action = $(this).attr('id');
            var idAttribute = $(this).val();
            var attr_group_name = $("#attr-group-"+idAttribute).data("attr-group-name");
            var _token = $('input[name="_token"]').val();
            var result = '';
    
            if(action == 'attribute') result = 'attribute_value';
            $.ajax({
                url: '{{url("/select-attribute")}}',
                method: 'POST',
                data: {action: action, idAttribute: idAttribute, _token: _token},
                success:function(data){
                    $('#'+result).html(data);
                    console.log(data);
                    $("input[type=checkbox]").on("click", function() {
                        var attr_id = $(this).data("id");
                        var attr_name = $(this).data("name");
    
                        if($(this).is(":checked")){
                            $("#attr-name-"+attr_id).addClass("border-primary text-primary");
    
                            $("#confirm-attrs").click(function(){
                                var input_attrs_item = `
                                    <div id="input-attrs-item-${attr_id}" class="col-md-12 d-flex flex-wrap input_attrs_items">
                                        <div class="col-md-4">
                                            <input class="form-control text-center" type="text" value="${attr_name}" disabled>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input id="qty-attr-${attr_id}" class="form-control text-center qty-attr" name="qty_attr[]" placeholder="Nhập số lượng phân loại" type="number" min="0" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input id="price-attr-${attr_id}" class="form-control text-center price-attr" name="price_attr[]" placeholder="Nhập giá tiền" type="number" min="0" required>
                                        </div>
                                    </div>`;
    
                                if ($('#input-attrs-item-' + attr_id).length < 1) {
                                    $('.input-attrs').append(input_attrs_item);
                                }
    
                                // Update total quantity and price
                                $(".qty-attr, .price-attr").on("input", function() {
                                var total_qty = 0;
                                var total_price = 0;

                                // Duyệt qua từng phân loại và tính tổng số lượng, tổng tiền
                                $(".input_attrs_items").each(function() {
                                    var qty = parseInt($(this).find('.qty-attr').val());
                                    var price = parseFloat($(this).find('.price-attr').val());

                                    // Nếu số lượng và giá đều hợp lệ, tính tổng
                                    if (!isNaN(qty) && !isNaN(price)) {
                                        total_qty += qty;
                                        total_price += qty * price;  // Tổng tiền cho mỗi phân loại
                                    }
                                });
                                    $("#Quantity").val(total_qty);
                                    $("#Price").val(total_price.toFixed(2));
                                });
                                
                                  // Validate input số lượng
                                $("#qty-attr-"+attr_id+", #price-attr-"+attr_id).on("change", function() {
                                    var qty_val = $('#qty-attr-' + attr_id).val();
                                    var price_val = $('#price-attr-' + attr_id).val();
                                    if (qty_val == "" || qty_val < 0 || price_val == "" || price_val < 0) {
                                        $('#qty-attr-' + attr_id).css("border", "1px solid #E08DB4");
                                        $('#price-attr-' + attr_id).css("border", "1px solid #E08DB4");
                                        $('#btn-submit').addClass('disabled-button');
                                    } else {
                                        $('#qty-attr-' + attr_id).css("border", "1px solid #DCDFE8");
                                        $('#price-attr-' + attr_id).css("border", "1px solid #DCDFE8");
                                        $('#btn-submit').removeClass('disabled-button');
                                    }
                                });
    
                                $("#form-add-purchase-order-detail").submit(function(e) {
                                    if ($('#qty-attr-' + attr_id).val() == "" || $('#price-attr-' + attr_id).val() == "") {
                                        e.preventDefault();
                                        $('#qty-attr-' + attr_id).css("border", "1px solid #E08DB4");
                                        $('#price-attr-' + attr_id).css("border", "1px solid #E08DB4");
                                    }
                                });
                            });
                        } else {
                            // Remove input fields when unchecking
                            $("#attr-name-"+attr_id).removeClass("border-primary text-primary");
                            $("#confirm-attrs").click(function(){
                                $('#input-attrs-item-' + attr_id).remove();
                            });
                        }
                    });
                }
            });
        });
    });
    
    </script>
@endsection
