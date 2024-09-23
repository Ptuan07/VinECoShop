@extends('admin_layout')
@section('content_dash')

<div class="content-page">
    <div class="container-fluid add-form-list">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Chỉnh sửa đơn nhập #{{$idDetails}} </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{URL::to('/submit-edit-purchase-order-details/'.$purchaseOrderDetail->idDetails)}}" method="POST" data-toggle="validator">
                            @csrf
                            
                            <div class="row"> 
                                <div class="col-md-12">
                                    @if(session('message'))
                                        <span class="text-success">{{ session('message') }}</span>
                                        {{ session()->forget('message') }}
                                    @elseif(session('error'))
                                        <span class="text-danger">{{ session('error') }}</span>
                                        {{ session()->forget('error') }}
                                    @endif

                                    <!-- Existing form fields here -->
                                    <div class="form-group">
                                        <label for="idPurchaseOrder">Mã đơn nhập</label>
                                        <input id="idPurchaseOrder" type="text" name="idPurchaseOrder" class="form-control" value="{{$purchaseOrderDetail->idPurchaseOrder}}" readonly>
                                    </div>     
                                    <div class="form-group">
                                        <span class="col-form-label">Tên sản phẩm</span>
                                        <select id="idProduct" name="idProduct" class=" js-example-templating form-control" style="width:100%"
                                            data-style="py-0" required>
                                            <?php $image = json_decode($purchaseOrderDetail->ImageName)[0]; ?>
                                            <option value="{{$purchaseOrderDetail->idProduct}}" data-image="{{ asset('public/storage/kidoldash/images/product/'.$image) }}">  #{{ $purchaseOrderDetail->idProduct }} {{ $purchaseOrderDetail->ProductName }}</option>
                                            @foreach ($list_product as $product)
                                            <?php $image1 = json_decode($product->ImageName)[0]; ?>
                                                <option 
                                                value="{{ $product->idProduct }}" data-image="{{ asset('public/storage/kidoldash/images/product/'.$image1) }}">
                                                #{{ $product->idProduct }} {{ $product->ProductName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>                 
                                    <div class="form-group">
                                        <label for="expiryDate">Hạn sử dụng</label>
                                        <input id="expiryDate" type="text" name="expiryDate" value="{{$purchaseOrderDetail->expiryDate}}" class="form-control" placeholder="YYYY-MM-DD">
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
                                            @if($name_attribute)    
                                                <div class="attr-title-1 col-md-4 text-center">{{$name_attribute->AttributeName}}</div>
                                                <div class="attr-title-2 col-md-4 text-center">Số lượng *</div>
                                                <div class="attr-title-3 col-md-4 text-center">Giá tiền *</div> <!-- Thêm dòng này -->
                                            @else
                                                <div class="attr-title-1 col-md-4 text-center d-none"></div>
                                                <div class="attr-title-2 col-md-4 text-center d-none">Số lượng *</div>
                                                <div class="attr-title-3 col-md-4 text-center d-none">Giá tiền *</div> <!-- Thêm dòng này -->
                                            @endif
                                        </div>
                                        @foreach($list_pd_attr as $key => $pd_attr)
                                            <div id="input-attrs-item-{{$pd_attr->idAttrValue}}" class="col-md-12 d-flex flex-wrap input_attrs_items">
                                                <div class="col-md-4">
                                                    <input class="form-control text-center" type="text" value="{{$pd_attr->AttrValName}}" disabled>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <input id="qty-attr-{{$pd_attr->idAttrValue}}" value="{{$pd_attr->Quantity}}" class="form-control text-center qty-attr" name="qty_attr[]" type="number" placeholder="Nhập số lượng phân loại">
                                                </div>
                                                <div class="form-group col-md-4"> <!-- Thêm trường nhập giá tiền -->
                                                    <input id="price-attr-{{$pd_attr->idAttrValue}}" value="{{$pd_attr->Price}}" class="form-control text-center price-attr" name="price_attr[]" type="number" placeholder="Nhập giá tiền phân loại">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Quantity">Tổng số lượng *</label>
                                                <input id="Quantity" name="quantity" type="number" min="0" class="form-control" value="{{$purchaseOrderDetail->quantity}}" placeholder="Tổng số lượng" required >
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Price">Tổng tiền</label>
                                                <input id="Price" type="text" name="unitPrice" class="form-control" value="{{$purchaseOrderDetail->unitPrice}}" placeholder="Tổng tiền" required >
                                            </div>
                                        </div>
                                    </div>
    
                                    <!-- Chọn Warehouse -->
                                    <div class="form-group">
                                        <label for="warehouses">Kho đã chọn:</label>
                                        <div id="warehouses">
                                            @foreach ($list_warehouse as $warehouse)
                                                <div class="form-check" style="display: inline-block; margin-right: 15px; margin-bottom: 10px;">
                                                    <input class="form-check-input warehouse-checkbox" type="checkbox" value="{{ $warehouse->idWareHouse }}" id="warehouse-{{ $warehouse->idWareHouse }}" name="warehouses[]" 
                                                        @if(in_array($warehouse->idWareHouse, $selectedWarehouses)) checked @endif>
                                                    <label class="form-check-label" for="warehouse-{{ $warehouse->idWareHouse }}">
                                                        {{ $warehouse->wareName }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Chọn Location theo Warehouse -->
                                    <div class="form-group" id="locations-container">
                                        <label for="locations">Vị trí đã chọn:</label>
                                        <div id="locations">
                                        </div>
                                    </div>

                                    <!-- Chọn Shelves theo Location -->
                                    <div class="form-group" id="shelves-container">
                                        <label for="shelves">Kệ đã chọn:</label>
                                        <div id="shelves">
                                            @foreach ($selectedShelves as $locationId => $shelves)
                                                <div id="location-{{ $locationId }}-shelves" class="location-shelves">
                                                    <h4>Shelves for {{ $location_names[$locationId] ?? 'Location Name' }}:</h4>
                                                    @foreach ($shelves as $shelfId)
                                                        @php
                                                            $shelf = $shelf_names[$locationId][$shelfId] ?? null;
                                                        @endphp
                                                        @if ($shelf)
                                                            <span class="form-check" style="display: inline-block; margin-right: 15px; margin-bottom: 10px;">
                                                                <input class="form-check-input shelf-checkbox" type="checkbox" value="{{ $shelfId }}" id="shelf-{{ $shelfId }}" name="shelves[{{ $locationId }}][]" checked>
                                                                <label class="form-check-label" for="shelf-{{ $shelfId }}">
                                                                    {{ $shelf }}
                                                                </label>
                                                            </span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Mô tả -->
                                    <div class="form-group">
                                        <label for="description">Mô tả</label>
                                        <input id="description" type="text" name="description" class="form-control" placeholder="Nhập Mô Tả" value="{{ $purchaseOrderDetail->description }}">
                                    </div>
                                </div>    
                            </div>                             
                            <input type="submit" name="editcategory" class="btn btn-primary mr-2" value="Cập nhật thông tin đơn nhập">
                            <a href="{{URL::to('/manage-purchase-order')}}" class="btn btn-light mr-2">Trở Về</a>
                        
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
                                                        @if($name_attribute) <option class="option-default" value="{{$name_attribute->idAttribute}}" id="attr-group-{{$name_attribute->idAttribute}}" data-attr-group-name="{{$name_attribute->AttributeName}}">{{$name_attribute->AttributeName}}</option>
                                                        @else <option value="">Chọn nhóm phân loại</option> @endif

                                                        @foreach($list_attribute as $key => $attribute)
                                                        <option id="attr-group-{{$attribute->idAttribute}}" data-attr-group-name="{{$attribute->AttributeName}}" value="{{$attribute->idAttribute}}">{{$attribute->AttributeName}}</option>
                                                        @endforeach
                                                    </select>

                                                    <div class="pb-3 d-flex flex-wrap" id="attribute_value">
                                                        @foreach($list_pd_attr as $key => $pd_attr)
                                                        <label for="chk-attr-{{$pd_attr->idAttrValue}}" class="d-block col-lg-3 p-0 m-0"><div id="attr-name-{{$pd_attr->idAttrValue}}" class="select-attr text-center mr-2 mt-2 border-primary text-primary">{{$pd_attr->AttrValName}}</div></label>
                                                        <input type="checkbox" class="checkstatus d-none chk_attr" id="chk-attr-{{$pd_attr->idAttrValue}}" data-id="{{$pd_attr->idAttrValue}}" data-name = "{{$pd_attr->AttrValName}}" name="chk_attr[]" value="{{$pd_attr->idAttrValue}}">
                                                        @endforeach
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
    </div>
</div>

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
<script>
    $(document).ready(function() {
    // Hàm hiển thị Shelves cho từng Location
        function loadShelves(locationId, selectedShelves) {
            $.ajax({
                url: '{{ url('shelves') }}/' + locationId,
                type: "GET",
                dataType: "json",
                success: function(data) {

                    let shelvesHtml = `
                    
                        <div id="location-${locationId}-shelves" class="location-shelves">
                            <h5>Kệ trong vị trí ${$(`#location-${locationId}`).next('label').text()}:</h5>`;
                    $.each(data, function(key, shelf) {
                    console.log(shelf.idShelves);

                        let checked = selectedShelves.includes(shelf.idShelves) ? 'checked' : '';
                        let readonly = (shelf.status === 1 && !selectedShelves.includes(shelf.idShelves)) ? 'readonly disabled' : '';
                        shelvesHtml += `
                            <span class="form-check" style="display: inline-block; margin-right: 15px; margin-bottom: 10px;">
                                <input class="form-check-input shelf-checkbox" type="checkbox" value="${shelf.idShelves}" id="shelf-${shelf.idShelves}" name="shelves[${locationId}][]" ${checked} ${readonly}>
                                <label class="form-check-label" for="shelf-${shelf.idShelves}">
                                    ${shelf.shelf_number}
                                </label>
                            </span>`;
                    });
                    shelvesHtml += '</div>';
                    // Kiểm tra xem shelves cho location đã được thêm chưa
                    if (!$(`#location-${locationId}-shelves`).length) {
                        $('#shelves').append(shelvesHtml);
                        $('#shelves-container').show();
                    }
                }
            });
        }

        // Hiển thị Locations và Shelves đã chọn khi tải trang
        function showSelectedLocationsAndShelves() {
            $('#locations').empty();
            $('#shelves').empty();

            let seenWarehouses = {}; // Đánh dấu kho đã được xử lý
            let seenLocations = {}; // Đánh dấu vị trí đã được xử lý

            @php
                $selectedWarehousesJson = json_encode($selectedWarehouses);
                $selectedLocationsJson = json_encode($selectedLocations);
                $selectedShelvesJson = json_encode($selectedShelves);
            @endphp

            let selectedWarehouses = @json($selectedWarehouses);
            let selectedLocations = @json($selectedLocations);
            let selectedShelves = @json($selectedShelves);

            selectedWarehouses.forEach(function(warehouseId) {
                $.ajax({
                    url: '{{ url('locations') }}/' + warehouseId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        let $warehouseContainer = $(`#warehouse-${warehouseId}-locations`);
                        let warehouseName = data.warehouseName;
                        // Nếu container của kho chưa tồn tại, thêm tiêu đề và container mới
                        if (!$warehouseContainer.length) {
                            let locationsHtml = `
                                <div id="warehouse-${warehouseId}-locations" class="warehouse-locations">
                                        <h5>Vị trí trong kho ${warehouseName}:</h5>;<br>`
                            
                            $.each(data.locations, function(key, location) {
                                let locationId = location.idLocation;
                                let checked = (selectedLocations[warehouseId] || []).includes(locationId) ? 'checked' : '';

                                // Kiểm tra xem location đã được thêm chưa
                                if (!seenLocations[locationId]) {
                                    locationsHtml += `
                                    <div>
                                        <span class="form-check" style="display: inline-block; margin-right: 15px; margin-bottom: 10px;">
                                            <input class="form-check-input location-checkbox" type="checkbox" value="${locationId}" id="location-${locationId}" name="locations[${warehouseId}][]" ${checked}>
                                            <label class="form-check-label" for="location-${locationId}">
                                                ${location.location}
                                            </label>
                                        </span>
                                    </div>`;
                                    seenLocations[locationId] = true; // Đánh dấu location đã được thêm

                                    // Hiển thị Shelves cho từng Location đã được chọn
                                    if (checked) {
                                        loadShelves(locationId, (selectedShelves[locationId] || []));
                                    }
                                }
                            });

                            locationsHtml += '</div>';
                            $('#locations').append(locationsHtml);
                            $('#locations-container' ).show();
                        }
                    }
                });
            });
        }
                showSelectedLocationsAndShelves();

                // Khi người dùng chọn Warehouse mới
                $('.warehouse-checkbox').on('change', function() {
                    var warehouseId = $(this).val();
                    if ($(this).is(':checked')) {
                        $.ajax({
                            url: '{{ url('locations') }}/' + warehouseId,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                let locationsHtml = `
                                    <div id="warehouse-${warehouseId}-locations" class="warehouse-locations">
                                        <h5>Vị trí trong ${$(this).next('label').text()}:</h5>`;
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
                                $('#locations').append(locationsHtml);
                                $('#locations-container').show();
                            }.bind(this)
                        });
                    } else {
                        $(`#warehouse-${warehouseId}-locations`).remove();
                        $(`#warehouse-${warehouseId}-shelves`).remove();
                    }
                });
                
                // Khi người dùng chọn Location mới
                $(document).on('change', '.location-checkbox', function() {
                    var locationId = $(this).val();
                    var warehouseId = $(this).closest('.warehouse-locations').attr('id').split('-')[1];
                    if ($(this).is(':checked')) {
                        $.ajax({
                            url: '{{ url('shelves') }}/' + locationId,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                let shelvesHtml = `
                                    <div id="location-${locationId}-shelves" class="location-shelves">
                                        <h5>Kệ thuộc vị trí ${$(this).next('label').text()}:</h5>`;
                                $.each(data, function(key, shelf) {
                                    let disabled = (shelf.status === 1) ? 'readonly disabled' : '';
                                    shelvesHtml += `
                                        <span class="form-check" style="display: inline-block; margin-right: 15px; margin-bottom: 10px;">
                                            <input class="form-check-input shelf-checkbox" type="checkbox" value="${shelf.idShelves}" id="shelf-${shelf.idShelves}" name="shelves[${locationId}][]" ${disabled} >
                                            <label class="form-check-label" for="shelf-${shelf.idShelves}">
                                                ${shelf.shelf_number}
                                            </label>
                                        </span>`;
                                });
                                shelvesHtml += '</div>';
                                $('#shelves').append(shelvesHtml);
                                $('#shelves-container').show();
                            }.bind(this)
                        });
                    } else {
                        $(`#location-${locationId}-shelves`).remove();
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
        $('.chk_attr').prop('checked', true);

        $('.choose-attr').on('change',function(){
            $('.input_attrs_items').remove();
            var action = $(this).attr('id');
            var idAttribute = $(this).val();
            console.log(action);
            var attr_group_name = $("#attr-group-"+idAttribute).data("attr-group-name");
            var _token = $('input[name="_token"]').val();
            var result = '';

            if(action == 'attribute')   result = 'attribute_value';
            $.ajax({
                url: '{{url("/select-attribute")}}',
                method: 'POST',
                data: {action:action, idAttribute:idAttribute, _token:_token},
                success:function(data){
                    $('#'+result).html(data);

                    $("input[type=checkbox]").on("click", function() {
                        var attr_id = $(this).data("id");
                        var attr_name = $(this).data("name");

                        if($(this).is(":checked")){
                            $("#attr-name-"+attr_id).addClass("border-primary text-primary");

                            $("#confirm-attrs").click(function(){
                                var input_attrs_item = '<div id="input-attrs-item-'+ attr_id +'" class="col-md-12 d-flex flex-wrap input_attrs_items"><div class="col-md-4"><input class="form-control text-center" type="text" value="'+ attr_name +'" disabled></div><div class="form-group col-md-4"><input id="qty-attr-'+ attr_id +'" class="form-control text-center qty-attr" name="qty_attr[]" type="number" placeholder="Nhập số lượng phân loại" required></div><div class="form-group col-md-4"><input id="price-attr-'+ attr_id +'" class="form-control text-center price-attr" name="price_attr[]" type="number" step="0.01" placeholder="Nhập giá tiền" required></div></div>';
                                
                                if($('#input-attrs-item-' +attr_id).length < 1) $('.input-attrs').append(input_attrs_item);
                                
                                // Số lượng input
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
                                $("#qty-attr-"+ attr_id).on("change",function() {
                                    if($(this).val() == "" || $(this).val() < 0){
                                        $(this).css("border","2px solid #E08DB4");
                                        $('#btn-submit').addClass('disabled-button');
                                    }else{
                                        $(this).css("border","1px solid #DCDFE8");
                                        $('#btn-submit').removeClass('disabled-button');
                                    }
                                });

                                // Validate input giá tiền
                                $("#price-attr-"+ attr_id).on("change",function() {
                                    if($(this).val() == "" || $(this).val() < 0){
                                        $(this).css("border","2px solid #E08DB4");
                                        $('#btn-submit').addClass('disabled-button');
                                    }else{
                                        $(this).css("border","1px solid #DCDFE8");
                                        $('#btn-submit').removeClass('disabled-button');
                                    }
                                });

                                // Validate input khi submit
                                $("#form-edit-product").submit( function(e) {
                                    var val_input_qty = $('#qty-attr-'+attr_id).val();
                                    var val_input_price = $('#price-attr-'+attr_id).val();
                                    if(val_input_qty == "" || val_input_qty < 0 || val_input_price == "" || val_input_price < 0){
                                        e.preventDefault();
                                        $('#qty-attr-'+attr_id).css("border","2px solid #E08DB4");
                                        $('#price-attr-'+attr_id).css("border","2px solid #E08DB4");
                                    }
                                });
                            });
                        }
                        else if($(this).is(":not(:checked)")){
                            $("#attr-name-"+attr_id).removeClass("border-primary text-primary");
                            
                            $("#confirm-attrs").click(function(){
                                $('#input-attrs-item-' +attr_id).remove();

                                // Số lượng input
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
                            });
                        }
                    });

                    $("#confirm-attrs").click(function(){
                        if($('[name="chk_attr[]"]:checked').length >= 1){
                            $('.attr-title-1').html(attr_group_name);
                            $('.attr-title-1').removeClass('d-none');
                            $('.attr-title-2').removeClass('d-none');
                            $('#Quantity').addClass('disabled-input');
                        }else{
                            $('.attr-title-1').addClass('d-none');
                            $('.attr-title-2').addClass('d-none');
                            $('#Quantity').removeClass('disabled-input');
                        }
                    });
                }
            });
        });

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
                                    $(this).css("border", "2px solid #E08DB4");
                                    $('#btn-submit').addClass('disabled-button');
                                } else {
                                    $(this).css("border", "1px solid #DCDFE8");
                                    $('#btn-submit').removeClass('disabled-button');
                                }
                            });

                            $("#form-add-product").submit(function(e) {
                                if ($('#qty-attr-' + attr_id).val() == "" || $('#price-attr-' + attr_id).val() == "") {
                                    e.preventDefault();
                                    $('#qty-attr-' + attr_id).css("border", "2px solid #E08DB4");
                                    $('#price-attr-' + attr_id).css("border", "2px solid #E08DB4");
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

                                // Số lượng input
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

        // Validate số lượng và giá tiền khi click vào ô nhập liệu
        $('.qty-attr, .price-attr').click(function(){
            var attr_id = $(this).attr('id');
            // Validate input số lượng và giá tiền khi thay đổi giá trị
            $('#'+attr_id).on("change",function() {
                if($(this).val() == ""){
                    $(this).css("border","2px solid #E08DB4");
                    $('#btn-submit').addClass('disabled-button');
                }else{
                    $(this).css("border","2px solid #DCDFE8");
                    $('#btn-submit').removeClass('disabled-button');
                }
            });
        });

        // Validate cả số lượng và giá tiền khi submit form
        $("#form-edit-product").submit(function(e) {
            // Kiểm tra tất cả các trường số lượng
            $(".qty-attr").each(function() {
                var qty_id = $(this).attr('id');
                var val_input_qty = $('#'+qty_id).val();

                if(val_input_qty == ""){
                    e.preventDefault();
                    $('#'+qty_id).css("border","2px solid #E08DB4");
                }
            });

            // Kiểm tra tất cả các trường giá tiền
            $(".price-attr").each(function() {
                var price_id = $(this).attr('id');
                var val_input_price = $('#'+price_id).val();

                if(val_input_price == ""){
                    e.preventDefault();
                    $('#'+price_id).css("border","2px solid #E08DB4");
                }
            });
        });

        if($('[name="chk_attr[]"]:checked').length > 0) $('#Quantity').addClass('disabled-input');
        else $('#Quantity').removeClass('disabled-input');
    });
</script>
@endsection
