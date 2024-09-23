<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use App\Models\WareHouse;
use App\Models\Location;
use Illuminate\Support\Facades\Redirect;




use Illuminate\Http\Request;

class WareHouseController extends Controller
{
    //
     /* ---------- Admin ---------- */

        // Kiểm tra đăng nhập
        public function checkLogin(){
            $idAdmin = Session::get('idAdmin');
            if($idAdmin == false) return Redirect::to('admin')->send();
        }

        // Kiểm tra chức vụ
        public function checkPostion(){
            $position = Session::get('Position');
            if($position === 'Nhân Viên') return Redirect::to('/my-adprofile')->send();
        }

        // Chuyển đến trang quản lý thương hiệu
        public function manage_warehouse(){
            $this->checkLogin();
            $this->checkPostion();
            $list_warehouse = WareHouse::get();
            $count_warehouse = WareHouse::count();
            return view("admin.warehouse.manage-warehouse")->with(compact('list_warehouse', 'count_warehouse'));
        }

        // Chuyển đến trang thêm thương hiệu
        public function add_warehouse(){
            $this->checkLogin();
            $this->checkPostion();
            return view("admin.warehouse.add-warehouse");
        }

        // Chuyển đến trang sửa thương hiệu
        public function edit_warehouse($idWareHouse){
            $this->checkLogin();
            $this->checkPostion();
            $select_warehouse = WareHouse::where('idWareHouse', $idWareHouse)->first();
            return view("admin.warehouse.edit-warehouse")->with(compact('select_warehouse'));
        }

        // Thêm thương hiệu
        public function submit_add_warehouse(Request $request){
            $data = $request->all();
            $warehouse = new WareHouse();
            
            $select_warehouse = WareHouse::where('wareName', $data['wareName'])->first();

            if($select_warehouse){
                return Redirect::to('add-warehouse')->with('error', 'Tên kho này đã tồn tại');
            }else{
                $warehouse->wareName = $data['wareName'];
                $warehouse->wareSlug = $data['wareSlug'];
                $warehouse->description = $data['description'];
                $warehouse->save();
                return Redirect::to('add-warehouse')->with('message', 'Thêm kho thành công');
            }
        }

        // Sửa thương hiệu
        public function submit_edit_warehouse(Request $request, $idWareHouse){
            $data = $request->all();
            $warehouse = WareHouse::find($idWareHouse);
            
            $select_warehouse = WareHouse::where('wareName', $data['wareName'])->whereNotIn('idWareHouse',[$idWareHouse])->first();

            if($select_warehouse){
                return redirect()->back()->with('error', 'Tên kho này đã tồn tại');
            }else{
                $warehouse->wareName = $data['wareName'];
                $warehouse->wareSlug = $data['wareSlug'];
                $warehouse->description = $data['description'];
                $warehouse->save();
                return redirect()->back()->with('message', 'Sửa kho thành công');
            }
        }

        // Xóa thương hiệu
        public function delete_warehouse($idWareHouse){
            WareHouse::where('idWareHouse', $idWareHouse)->delete();
            return redirect()->back();
        }
}
