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
                            <h4 class="card-title">Thêm Nhà Cung Cấp</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{URL::to('/submit-edit-supplier/'.$select_supplier->idSupplier)}}"  data-toggle="validator" >
                            @csrf
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
                            <div class="row">  
                                <div class="col-md-12">                      
                                    <div class="form-group">
                                        <label for="supplierName">Tên nhà cung cấp</label>
                                        <input id="supplierName" type="text" name="supplierName" class="form-control slug" onkeyup="ChangeToSlug()" value="{{$select_supplier->supplierName}}" placeholder="Nhập tên nhà cung cấp">
                                        <span class="text-danger"></span>
                                    </div>
                                </div> 
                                <input type="hidden" name="supplierSlug" class="form-control" id="convert_slug">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Hình ảnh *</label>
                                        <input name="ImageSupplier[]" id="images" type="file" onchange="loadPreview(this)" class="form-control  image-file" multiple/>
                                        <div class="help-block with-errors"></div>
                                        <div class="text-danger alert-img"></div>
                                        <div class="d-flex flex-wrap" id="image-list">
                                            @foreach(json_decode($select_supplier->ImageSupplier) as $key => $image)
                                            <div id="image-item-{{$key}}" class="image-item">
                                                <img src="{{asset('public/storage/kidoldash/images/supplier/'.$image)}}" class="img-fluid rounded avatar-100 mr-3 mt-2">
                                                <!-- <span class="dlt-item"><span class="dlt-icon">x</span></span> -->
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>   
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="phone">Số Điện Thoại</label>
                                        <input id="phone" type="text" name="phone" class="form-control" value="{{$select_supplier->phone}}" placeholder="Nhập Số Điện Thoại">
                                        <span class="text-danger"></span>
                                    </div>
                                </div> 
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="gmail">Email</label>
                                        <input id="gmail" type="text" name="gmail" class="form-control" value="{{$select_supplier->gmail}}" placeholder="Nhập Gmail">
                                        <span class="text-danger"></span>
                                    </div>
                                </div> 
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">Địa Chỉ</label>
                                        <input id="address" type="text" name="address" class="form-control" value="{{$select_supplier->address}}" placeholder="Nhập Địa Chỉ">
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Mô tả</label>
                                        <input id="description" type="text" name="description" class="form-control" value="{{$select_supplier->description}}" placeholder="Nhập mô tả">
                                    </div>
                                </div>  
                            </div>                            
                            <a href="{{URL::to('/manage-suppliers')}}" class="btn btn-light mr-2">Trở Về</a>
                            <input id="insertadmin" type="submit" class="btn btn-primary mr-2" value="Sửa nhà cung cấp"/>
                            <!-- <button type="reset" class="btn btn-danger">Reset</button> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page end  -->
<!-- Validate ảnh -->
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
<script>
    $(document).ready(function(){  
        Validator({
            form: "#form-insert-supplier",
            errorSelector: ".text-danger",
            parentSelector: ".form-group",
            rules:[
            Validator.isRequired("#supplierName"),
            Validator.isRequired("#address"), 
            Validator.isRequired("#gmail"),
            Validator.isRequired("#phone"),
            Validator.isEmail("#gmail"),
            Validator.isPhone("#phone")
            ]
        });
    });
</script>

@endsection
