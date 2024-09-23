  @extends('admin_layout')
@section('content_dash')

<?php use Illuminate\Support\Facades\Session; ?>

<form action="{{URL::to('/submit-edit-product/'.$product->idProduct)}}" method="POST" id="form-edit-product" data-toggle="validator" enctype="multipart/form-data">
@csrf
<div class="content-page">
    <div class="container-fluid add-form-list">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Sửa sản phẩm</h4>
                        </div>
                    </div>
                    <?php
                        $message = Session::get('message');
                        $error = Session::get('error');
                        if($message){
                            echo '<span class="text-success ml-3 mt-3">'.$message.'</span>';
                            Session::put('message', null);
                        }else if($error){
                            echo '<span class="text-danger ml-3 mt-3">'.$error.'</span>';
                            Session::put('error', null);
                        }
                    ?> 
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">                      
                                <div class="form-group">
                                    <label for="ProductName">Tên sản phẩm *</label>
                                    <input id="ProductName" name="ProductName" type="text" class="form-control slug" onkeyup="ChangeToSlug()" value="{{$product->ProductName}}" placeholder="Vui lòng nhập tên" data-errors="Please Enter Name." required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>  
                            <input type="hidden" name="ProductSlug" class="form-control" value="{{$product->ProductSlug}}" id="convert_slug">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="idCategory">Danh mục *</label>
                                    <select id="idCategory" name="idCategory" class="selectpicker form-control" data-style="py-0" required>
                                        <option value="{{$product->idCategory}}">{{$product->CategoryName}}</option>
                                        @foreach($list_category as $key => $category)
                                        <option value="{{$category->idCategory}}">{{$category->CategoryName}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div> 
                            </div>    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="idBrand">Thương hiệu *</label>
                                    <select id="idBrand" name="idBrand" class="selectpicker form-control" data-style="py-0" required>
                                        <option value="{{$product->idBrand}}">{{$product->BrandName}}</option>
                                        @foreach($list_brand as $key => $brand)
                                        <option value="{{$brand->idBrand}}">{{$brand->BrandName}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
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
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Price">Giá *</label>
                                    <input id="Price" name="Price" type="number" min="0" class="form-control" value="{{$product->Price}}" placeholder="Vui lòng nhập giá" data-errors="Please Enter Price." required>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div> --}}
                            <div class="col-md-6">                                    
                                <div class="form-group">
                                    <label for="Quantity">Tổng số lượng *</label>
                                    <input id="Quantity" name="QuantityTotal" type="number" min="0" class="form-control" value="{{$product->QuantityTotal}}" placeholder="Vui lòng nhập số lượng" required readonly>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Hình ảnh *</label>
                                    <input name="ImageName[]" id="images" type="file" onchange="loadPreview(this)" class="form-control  image-file" multiple/>
                                    <div class="help-block with-errors"></div>
                                    <div class="text-danger alert-img"></div>
                                    <div class="d-flex flex-wrap" id="image-list">
                                        @foreach(json_decode($product->ImageName) as $key => $image)
                                        <div id="image-item-{{$key}}" class="image-item">
                                            <img src="{{asset('public/storage/kidoldash/images/product/'.$image)}}" class="img-fluid rounded avatar-100 mr-3 mt-2">
                                            <!-- <span class="dlt-item"><span class="dlt-icon">x</span></span> -->
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <span class="col-form-label">Trạng thái sản phẩm</span>
                                <select id="statusPro" name="statusPro" class="form-control" style="width:100%"
                                    data-style="py-0" required>
                                    @if($product->StatusPro === 0){
                                        <option value="{{$product->StatusPro}}">Ẩn sản phẩm</option>
                                    }@elseif($product->StatusPro === 1){
                                        <option value="{{$product->StatusPro}}">Hiện sản phẩm</option>
                                    }@else
                                        <option value="{{$product->StatusPro}}">Đang chờ hàng</option>
                                    @endif 
                                    <option value="0">Ẩn sản phẩm</option>
                                    <option value="1">Hiện sản phẩm</option>
                                    <option value="2">Đang chờ hàng</option>
                                </select>
                            </div> 
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Mô tả ngắn *</label>
                                    <textarea id="ShortDes" name="ShortDes" class="form-control" placeholder="Nhập mô tả ngắn" rows="3" required>{{$product->ShortDes}}</textarea>
                                    <div class="text-danger alert-shortdespd"></div>
                                    <script>$(document).ready(function(){CKEDITOR.replace('ShortDes');});</script>
                                </div>
                            </div>
                             
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Mô tả / Chi tiết sản phẩm *</label>
                                    <textarea id="DesProduct" name="DesProduct" class="form-control tinymce" placeholder="Nhập mô tả chi tiết" rows="4">{{$product->DesProduct}}</textarea>
                                    <div class="text-danger alert-despd"></div>
                                    <script>$(document).ready(function(){CKEDITOR.replace('DesProduct');});</script>
                                </div>
                            </div>

                            <!-- Chọn Warehouse -->
                            <div class="form-group col-md-12" style="display: block">
                                <label for="warehouses" class="col-form-label">Kho đã chọn:</label>
                                <div class="col-12">
                                    <div id="warehouses" class="row">
                                        @foreach ($list_warehouse as $warehouse)
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input warehouse-checkbox" type="checkbox" value="{{ $warehouse->idWareHouse }}" id="warehouse-{{ $warehouse->idWareHouse }}" name="warehouses[]" 
                                                        @if(in_array($warehouse->idWareHouse, $selectedWarehouses)) checked @endif>
                                                    <label class="form-check-label" for="warehouse-{{ $warehouse->idWareHouse }}">
                                                        {{ $warehouse->wareName }}
                                                    </label>
                                                </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- Chọn Location theo Warehouse -->
                            <div class="form-group" style="display: block" id="locations-container">
                                <label for="locations" class="col-12 col-form-label">Vị trí đã chọn:</label>
                                <div class="col-12">
                                    <div id="locations" style="margin-bottom: 15px;"></div>
                                </div>
                            </div>

                            <!-- Chọn Shelves theo Location -->
                            <div class="form-group col-md-12" id="shelves-container">
                                <label for="shelves" class="col-form-label">Kệ đã chọn:</label>
                                <div class="col-12">
                                    <div id="shelves">
                                        @foreach ($selectedShelves as $locationId => $shelves)
                                            <div id="location-{{ $locationId }}-shelves" class="location-shelves">
                                                <h4>Shelves for {{ $location_names[$locationId] ?? 'Location Name' }}:</h4>
                                                <div class="row">
                                                    @foreach ($shelves as $shelfId)
                                                        @php
                                                            $shelf = $shelf_names[$locationId][$shelfId] ?? null;
                                                        @endphp
                                                        @if ($shelf)
                                                            <div class="col-12 col-md-6 col-lg-4">
                                                                <div class="form-check mb-3">
                                                                    <input class="form-check-input shelf-checkbox" type="checkbox" value="{{ $shelfId }}" id="shelf-{{ $shelfId }}" name="shelves[{{ $locationId }}][]" checked>
                                                                    <label class="form-check-label" for="shelf-{{ $shelfId }}">
                                                                        {{ $shelf }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>                            
                        <input type="submit" class="btn btn-primary mr-2" id="btn-submit" value="Sửa sản phẩm">
                        <a href="{{URL::to('/manage-products')}}" class="btn btn-light">Trở về</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page end  -->

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

<!-- Validate hình ảnh -->
<script>
    function loadPreview(input){
        $('.image-item').remove();
        var data = $(input)[0].files; //this file data
        $.each(data, function(index, file){
            if(/(\.|\/)(gif|jpeg|png|jpg|svg)$/i.test(file.type) && file.size < 2000000 ){
                var fRead = new FileReader();
                fRead.onload = (function(file){
                    return function(e) {
                        var img = $('<img/>').addClass('img-fluid rounded avatar-100 mr-3 mt-2').attr('src', e.target.result); //create image thumb element
                        $("#image-list").append('<div id="image-item-'+index+'" class="image-item"></div>');
                        $('#image-item-'+index).append(img);
                        //    $('#image-item-'+index).append('<span id="dlt-item-'+index+'" class="dlt-item"><span class="dlt-icon">x</span></span>');
                    };
                })(file);
                fRead.readAsDataURL(file);
                $('.alert-img').html("");
                $('#btn-submit').removeClass('disabled-button');
            }else{
                document.querySelector('#images').value = '';
                $('.alert-img').html("Tệp hình ảnh phải có định dạng .gif, .jpeg, .png, .jpg, .svg dưới 2MB");
                //    $('#btn-submit').addClass('disabled-button');
            }
        });
    }
</script>

<!-- Validate CKEDITOR -->
<script>
    $(document).ready(function(){  
        CKEDITOR.instances['DesProduct'].on('change', function () {
            var messageLength = CKEDITOR.instances['DesProduct'].getData().replace(/<[^>]*>/gi, '').length;
            if( !messageLength ) {
                $('.alert-despd').html("Vui lòng điền vào trường này.");
                $('#btn-submit').addClass('disabled-button');
                
            }else{
                $('.alert-despd').html("");
                $('#btn-submit').removeClass('disabled-button');
            }
        });

        CKEDITOR.instances['ShortDes'].on('change', function () {
            var messageLength = CKEDITOR.instances['ShortDes'].getData().replace(/<[^>]*>/gi, '').length;
            if( !messageLength ) {
                $('.alert-shortdespd').html("Vui lòng điền vào trường này.");
                $('#btn-submit').addClass('disabled-button');
                
            }else{
                $('.alert-shortdespd').html("");
                $('#btn-submit').removeClass('disabled-button');
            }
        });

        $("#form-edit-product").submit( function(e) {
            var messageLength = CKEDITOR.instances['DesProduct'].getData().replace(/<[^>]*>/gi, '').length;
            var messageLength2 = CKEDITOR.instances['ShortDes'].getData().replace(/<[^>]*>/gi, '').length;

            if(!messageLength){
                $('.alert-despd').html("Vui lòng điền vào trường này.");
                e.preventDefault();
            }
            if(!messageLength2){
                $('.alert-shortdespd').html("Vui lòng điền vào trường này.");
                e.preventDefault();
            }
        });
    });
</script>

<!-- Validate phân loại hàng -->
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
                                $(".qty-attr").on("input",function() {
                                    var total_qty = 0;
                                    $(".qty-attr").each(function(){
                                        if(!isNaN(parseInt($(this).val()))){
                                            total_qty += parseInt($(this).val());  
                                        }
                                    });
                                    $("#Quantity").val(total_qty);
                                });

                                // Tổng giá tiền
                                $(".price-attr").on("input",function() {
                                    var total_price = 0;
                                    $(".price-attr").each(function(){
                                        if(!isNaN(parseFloat($(this).val()))){
                                            total_price += parseFloat($(this).val());  
                                        }
                                    });
                                    $("#TotalPrice").val(total_price.toFixed(2)); // Đặt giá tổng vào input (cần thêm input với id là TotalPrice)
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

                                var total_qty = 0;
                                $(".qty-attr").each(function(){
                                    if(!isNaN(parseInt($(this).val()))){
                                        total_qty += parseInt($(this).val());  
                                    }
                                });
                                $("#Quantity").val(total_qty);
                                
                                // Xử lý tổng giá
                                var total_price = 0;
                                $(".price-attr").each(function(){
                                    if(!isNaN(parseFloat($(this).val()))){
                                        total_price += parseFloat($(this).val());  
                                    }
                                });
                                $("#TotalPrice").val(total_price.toFixed(2));
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
                                $(".qty-attr").each(function(){
                                    if(!isNaN(parseInt($(this).val()))){
                                        total_qty += parseInt($(this).val());
                                    }
                                });
                                $(".price-attr").each(function(){
                                    if(!isNaN(parseInt($(this).val()))){
                                        total_price += parseFloat($(this).val()) * parseInt($(this).closest('.input_attrs_items').find('.qty-attr').val());
                                    }
                                });
                                $("#Quantity").val(total_qty);
                                $("#TotalPrice").val(total_price.toFixed(2));
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

        $(".qty-attr").on("input",function() {
            var total_qty = 0;
            $(".qty-attr").each(function(){
                if(!isNaN(parseInt($(this).val())))
                {
                    total_qty += parseInt($(this).val());  
                }
            });
            $("#Quantity").val(total_qty);
        });

        // Validate số lượng và giá tiền khi click vào ô nhập liệu
        $('.qty-attr, .price-attr').click(function(){
            var attr_id = $(this).attr('id');
            console.log(attr_id);

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
                            <p>Kệ trong vị trí ${$(`#location-${locationId}`).next('label').text()}:</p>`;
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
                                        <p>Vị trí trong kho ${warehouseName}:</p>;<br>`
                            
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
                                        <p>Vị trí trong ${$(this).next('label').text()}:</p>`;
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
                                        <p>Kệ thuộc vị trí ${$(this).next('label').text()}:</p>`;
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
@endsection