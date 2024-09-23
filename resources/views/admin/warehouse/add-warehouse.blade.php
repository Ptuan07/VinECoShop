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
                        <h4 class="card-title">Thêm Kho Hàng</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{URL::to('/submit-add-warehouse')}}" method="POST" data-toggle="validator">
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
                                    <label>Tên kho</label>
                                    <input type="text" name="wareName" class="form-control slug" onkeyup="ChangeToSlug()" placeholder="Nhập tên kho" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <input type="hidden" name="wareSlug" class="form-control" id="convert_slug">
                                    <div class="form-group">
                                        <label for="description">Mô tả</label>
                                        <input id="description" type="text" name="description" class="form-control" placeholder="Nhập Mô Tả">
                                    </div>
                            </div>    
                        </div>                             
                        <input type="submit" name="addwarehouse" class="btn btn-primary mr-2" value="Thêm kho ">
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