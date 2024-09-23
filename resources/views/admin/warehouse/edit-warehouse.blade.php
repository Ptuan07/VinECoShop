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
                        <h4 class="card-title">Chỉnh Sửa Kho</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{URL::to('/submit-edit-warehouse/'.$select_warehouse->idWareHouse)}}" method="POST" data-toggle="validator">
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
                                    <label>Vị Trí Trong Kho</label>
                                    <input type="text" name="warehouse" class="form-control slug" onkeyup="ChangeToSlug()" value="{{$select_warehouse->wareName}}" placeholder="Nhập tên danh mục" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <input type="hidden" name="wareSlug" value="{{$select_warehouse->wareSlug}}" class="form-control" id="convert_slug">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Mô tả</label>
                                        <input id="description" type="text" name="description" value="{{$select_warehouse->description}}" class="form-control" placeholder="Nhập Mô Tả">
                                    </div>
                                </div> 
                            </div>    
                        </div>                             
                        <input type="submit" class="btn btn-primary mr-2" value="Sửa kho">
                        <a href="{{URL::to('/manage-warehouse')}}" class="btn btn-light mr-2">Trở Về</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page end  -->
</div>
</div>


@endsection