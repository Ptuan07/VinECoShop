<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\Supplier;

class SupplierController extends Controller
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
        public function manage_suppliers(){
            $this->checkLogin();
            $this->checkPostion();
            $list_supplier = Supplier::get();
            $count_supplier = Supplier::count();
            return view("admin.supplier.manage-suppliers")->with(compact('list_supplier', 'count_supplier'));
        }

        // Chuyển đến trang thêm NCC
        public function add_supplier(){
            $this->checkLogin();
            $this->checkPostion();
            return view("admin.supplier.add-supplier");
        }

        // Chuyển đến trang thêm NCC
        public function edit_supplier($idSupplier){
            $this->checkLogin();
            $this->checkPostion();
            $select_supplier = Supplier::where('idSupplier', $idSupplier)->first();
            return view("admin.supplier.edit-supplier")->with(compact('select_supplier'));
        }

        public function submit_add_supplier(Request $request){
            $data = $request->all();
            $Supplier = new Supplier();
            
            $select_Supplier = Supplier::where('supplierName', $data['supplierName'])->first();

            if($select_Supplier){
                return Redirect::to('add-supplier')->with('error', 'Tên nhà cung cấp này đã tồn tại');
            }else{
                $Supplier->supplierName = $data['supplierName'];
                $Supplier->supplierSlug = $data['supplierSlug'];
                $Supplier->phone = $data['phone'];
                $Supplier->address = $data['address'];
                $Supplier->gmail = $data['gmail'];
                $Supplier->description = $data['description'];
                $get_image = $request->file('ImageSupplier');
                // dd( $get_image);
                // dd($request->all());
                // die(); 
               
                foreach($get_image as $image){
                    $get_name_image = $image->getClientOriginalName();
                    $name_image = current(explode('.',$get_name_image));
                    $new_image = $name_image.rand(0,99).'.'.$image->getClientOriginalExtension();
                    $image->storeAs('public/kidoldash/images/supplier',$new_image);
                    $images[] = $new_image;
                }
                $Supplier->ImageSupplier=json_encode($images);
                $Supplier->save();
                return Redirect::to('add-supplier')->with('message', 'Thêm nhà cung cấp thành công');
            }
        }

        // Sửa NCC
        public function submit_edit_supplier(Request $request, $idSupplier){
            $data = $request->all();
            $Supplier = Supplier::find($idSupplier);
            
            $select_Supplier = Supplier::where('supplierName', $data['supplierName'])->whereNotIn('idSupplier',[$idSupplier])->first();

            if($select_Supplier){
                return redirect()->back()->with('error', 'Tên nhà cung cấp này đã tồn tại');
            }else{
                $Supplier->supplierName = $data['supplierName'];
                // $Supplier->supplierSlug = $data['supplierSlug'];
                $Supplier->phone = $data['phone'];
                $Supplier->address = $data['address'];
                $Supplier->gmail = $data['gmail'];
                $Supplier->description = $data['description'];

                 // Thêm hình ảnh vào table ProductImage
                 if($request->file('ImageSupplier')){
                    $get_image = $request->file('ImageSupplier');

                    foreach($get_image as $image){
                        $get_name_image = $image->getClientOriginalName();
                        $name_image = current(explode('.',$get_name_image));
                        $new_image = $name_image.rand(0,99).'.'.$image->getClientOriginalExtension();
                        $image->storeAs('public/kidoldash/images/supplier',$new_image);
                        $images[] = $new_image;
                    }

                    // Xoá hình cũ trong csdl và trong folder 
                    $get_old_mg = Supplier::where('idSupplier', $idSupplier)->first();
                    foreach(json_decode($get_old_mg->ImageSupplier) as $old_img){
                        Storage::delete('public/kidoldash/images/supplier/'.$old_img);
                    }
                    Supplier::where('idSupplier', $idSupplier)->delete();
                    $Supplier->ImageSupplier=json_encode($images);
                }
                $Supplier->save();
                return redirect()->back()->with('message', 'Sửa nhà cung cấp thành công');
            }
        }

        // Xóa NCC
        public function delete_supplier($idSupplier){
            Supplier::where('idSupplier', $idSupplier)->delete();
            return redirect()->back();
        }
}
