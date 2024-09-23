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
                            <h4 class="card-title">Thêm banner</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{URL::to('/submit-edit-banner/'.$select_banner->idBanner)}}"  data-toggle="validator" >
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
                                        <label for="bannerName">Tên banner</label>
                                        <input id="bannerName" type="text" name="bannerName" class="form-control slug" onkeyup="ChangeToSlug()" value="{{$select_banner->bannerName}}" placeholder="Nhập tên banner">
                                        <span class="text-danger"></span>
                                    </div>
                                </div> 
                              
                                    <div class="form-group">
                                        <label>Hình ảnh *</label>
                                        <input name="imageName[]" id="images" type="file" onchange="loadPreview(this)" class="form-control  image-file" multiple/>
                                        <div class="help-block with-errors"></div>
                                        <div class="text-danger alert-img"></div>
                                        <div class="d-flex flex-wrap" id="image-list">
                                            @foreach(json_decode($select_banner->imageName) as $key => $image)
                                            <div id="image-item-{{$key}}" class="image-item">
                                                <img src="{{asset('public/storage/kidoldash/images/banner/'.$image)}}" class="img-fluid rounded avatar-100 mr-3 mt-2">
                                                <!-- <span class="dlt-item"><span class="dlt-icon">x</span></span> -->
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>   
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Mô tả</label>
                                        <input id="description" type="text" name="description" class="form-control" value="{{$select_banner->description}}" placeholder="Nhập mô tả">
                                    </div>
                                </div>  
                            </div>                            
                            <a href="{{URL::to('/manage-banner')}}" class="btn btn-light mr-2">Trở Về</a>
                            <input id="insertadmin" type="submit" class="btn btn-primary mr-2" value="Sửa banner"/>
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
            form: "#form-insert-banner",
            errorSelector: ".text-danger",
            parentSelector: ".form-group",
            rules:[
            Validator.isRequired("#bannerName"),
            ]
        });
    });
</script>

@endsection
