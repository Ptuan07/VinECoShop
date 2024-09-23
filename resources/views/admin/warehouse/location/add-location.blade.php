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
                        <h4 class="card-title">Thêm Vị Trí Kho Hàng</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{URL::to('/submit-add-location')}}" method="POST" data-toggle="validator">
                        @csrf
                        <div class="row"> 
                            <div class="col-md-12">
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
                                <div class="form-group">
                                    <span class="col-form-label">Tên kho</span>
                                    <select id="idWareHouse" name="idWareHouse" class="form-control" style="width:100%"
                                        data-style="py-0" required>
                                        <option value="">---Chọn kho---</option>
                                        @foreach ($list_warehouse as $warehouse)
                                            <option value="{{ $warehouse->idWareHouse }}">{{ $warehouse->wareName}}</option>
                                        @endforeach
                                    </select>
                                </div>                 
                                <div class="form-group">
                                    <label>Vị Trí Trong Kho</label>
                                    <input type="text" name="location" class="form-control slug" onkeyup="ChangeToSlug()" placeholder="Nhập vị trí trong kho" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <input type="hidden" name="locationSlug" class="form-control" id="convert_slug">
                                    <div class="form-group">
                                        <label for="total_shelves">Số kệ hàng</label>
                                        <input id="total_shelves" type="text" name="total_shelves" class="form-control" placeholder="Nhập số lượng kệ hàng">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Mô tả</label>
                                        <input id="description" type="text" name="description" class="form-control" placeholder="Nhập Mô Tả">
                                    </div>
                            </div>    
                        </div>                             
                        <input type="submit" name="addcategory" class="btn btn-primary mr-2" value="Thêm vị trí trong kho ">
                        <a href="{{URL::to('/manage-location')}}" class="btn btn-light mr-2">Trở Về</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>
</div>
<script>
     $("#idWareHouse").validate({
                                
                                rules: {
                                   
                                    idWareHouse: {
                                        required: true
                                    }
                                  
                                },
                                messages: {
                                    
                                    idWareHouse: {
                                        required: "Vui lòng chọn kho hàng"
                                    }
                                 
                                },
                            })
</script>


@endsection