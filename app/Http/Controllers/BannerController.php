<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\Banner;

class BannerController extends Controller
{
    //
      // Kiểm tra đăng nhập
      public function checkLogin(){
        $idAdmin = Session::get('idAdmin');
        if($idAdmin == false) return Redirect::to('admin')->send();
        }

    // //  // Kiểm tra chức vụ
        public function checkPostion(){
            $position = Session::get('Position');
            if($position === 'Nhân Viên') return Redirect::to('/my-adprofile')->send();
        }

    //     // Chuyển đến trang quản lý danh mục
        public function manage_banner(){
            $this->checkLogin();
            $this->checkPostion();
            $list_banner = Banner::get();
            $count_banner = Banner::count();
            return view("admin.banner.manage-banner")->with(compact('list_banner', 'count_banner'));
        }

        // Chuyển đến trang thêm NCC
        public function add_banner(){
            $this->checkLogin();
            $this->checkPostion();
            return view("admin.banner.add-banner");
        }

        // Chuyển đến trang thêm NCC
        public function edit_banner($idbanner){
            $this->checkLogin();
            $this->checkPostion();
            $select_banner = Banner::where('idBanner', $idbanner)->first();
            return view("admin.banner.edit-banner")->with(compact('select_banner'));
        }

        public function submit_add_banner(Request $request){
            $data = $request->all();
            $banner = new Banner();
            
            $select_banner = Banner::where('bannerName', $data['bannerName'])->first();

            if ($select_banner) {
                return Redirect::to('add-banner')->with('error', 'Tên banner này đã tồn tại');
            } else {
                $banner->bannerName = $data['bannerName'];
                $banner->description = $data['description'];
            
                $get_image = $request->file('imageName');
                $images = []; // Khởi tạo mảng
            
                if ($get_image && is_array($get_image)) { // Kiểm tra nếu tồn tại và là mảng
                    foreach ($get_image as $image) {
                        $get_name_image = $image->getClientOriginalName();
                        $name_image = current(explode('.', $get_name_image));
                        $new_image = $name_image . rand(0, 99) . '.' . $image->getClientOriginalExtension();
                        $image->storeAs('public/kidoldash/images/supplier', $new_image);
                        $images[] = $new_image;
                    }
            
                    $banner->imageName = json_encode($images);
                } else {
                    return Redirect::to('add-banner')->with('error', 'Không có hình ảnh nào được tải lên');
                }
            
                $banner->save();
                return Redirect::to('add-supplier')->with('message', 'Thêm nhà cung cấp thành công');
        }
    }

        // Sửa NCC
        public function submit_edit_banner(Request $request, $idbanner){
            $data = $request->all();
            $banner = Banner::find($idbanner);
            
            $select_banner = Banner::where('bannerName', $data['bannerName'])->whereNotIn('idBanner',[$idbanner])->first();

            if($select_banner){
                return redirect()->back()->with('error', 'Tên banner này đã tồn tại');
            }else{
                $banner->bannerName = $data['bannerName'];
                $banner->description = $data['description'];

                 // Thêm hình ảnh vào table ProductImage
                 if($request->file('imageName')){
                    $get_image = $request->file('imageName');

                    foreach($get_image as $image){
                        $get_name_image = $image->getClientOriginalName();
                        $name_image = current(explode('.',$get_name_image));
                        $new_image = $name_image.rand(0,99).'.'.$image->getClientOriginalExtension();
                        $image->storeAs('public/kidoldash/images/banner',$new_image);
                        $images[] = $new_image;
                    }

                    // Xoá hình cũ trong csdl và trong folder 
                    $get_old_mg = Banner::where('idBanner', $idbanner)->first();
                    foreach(json_decode($get_old_mg->imageName) as $old_img){
                        Storage::delete('public/kidoldash/images/banner/'.$old_img);
                    }
                    Banner::where('idBanner', $idbanner)->delete();
                    $banner->ImageName=json_encode($images);
                }
                $banner->save();
                return redirect()->back()->with('message', 'Sửa banner thành công');
            }
        }

        // Xóa NCC
        public function delete_banner($idbanner){
            Banner::where('idBanner', $idbanner)->delete();
            return redirect()->back();
        }
}
