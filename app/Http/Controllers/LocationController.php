<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Location;
use App\Models\WareHouse;
use App\Models\Shelves;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
class LocationController extends Controller
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
            public function manage_location(){
                $this->checkLogin();
                $this->checkPostion();
       
                $list_location = DB::table('location')
                ->join('warehouse', 'location.idWareHouse', '=', 'warehouse.idWareHouse')
                ->leftJoin('shelves', 'location.idLocation', '=', 'shelves.idLocation')
                ->select('location.*', 'warehouse.wareName', 'shelves.shelf_number', 'shelves.status', 'shelves.idShelves')
                ->get()
                ->groupBy('idLocation');  // Gom nhóm theo idLocation
                $count_location = Location::count();
                return view("admin.warehouse.location.manage-location")->with(compact('list_location', 'count_location'));
            }
    
            // Chuyển đến trang thêm NCC
            public function add_location(){
                $this->checkLogin();
                $this->checkPostion();
                // $list_warehouse= Shelves::get();
                $list_warehouse= WareHouse::get();
                return view("admin.warehouse.location.add-location")->with(compact('list_warehouse'));
            }
    
            // Chuyển đến trang thêm NCC
            public function edit_location($idLocation){
                $this->checkLogin();
                $this->checkPostion();
                $select_location = Location::join('warehouse','warehouse.idWareHouse','=','location.idWareHouse')
                ->where('idLocation', $idLocation)->first();
                $list_warehouse= WareHouse::get();
                return view("admin.warehouse.location.edit-location")->with(compact('select_location','list_warehouse'));
            }
    
            public function submit_add_location(Request $request){
                $data = $request->all();
                $location = new Location();
                
                $select_location = Location::where('location', $data['location'])->first();
    
                if($select_location){
                    return Redirect::to('add-location')->with('error', 'Tên vị trí trong kho đã tồn tại');
                }else{
                    $location->location = $data['location'];
                    $location->locationSlug = $data['locationSlug'];
                    $location->idWareHouse = $data['idWareHouse'];
                    $location->total_shelves = $data['total_shelves'];
                    $location->description = $data['description'];
                    $location->save();

                    // Thêm các kệ tương ứng với vị trí mới
                for ($i = 1; $i <= $location->total_shelves; $i++) {
                    $shelf = new Shelves();
                    $shelf->idLocation = $location->idLocation;
                    $shelf->shelf_number = $i;
                    $shelf->status = 0; // Các kệ mới ban đầu đều trống
                    $shelf->save();
                    }
                    return Redirect::to('add-location')->with('message', 'Thêm vị trí trong kho thành công');
                }
            }
    
            // Sửa NCC
            public function submit_edit_location(Request $request, $idLocation){
                $data = $request->all();
                $location = Location::find($idLocation);
                $newShelfCount = $request->input('total_shelves');
                $currentShelfCount = Shelves::where('idLocation', $location->idLocation)->count();
                // dd(  $currentShelfCount);
                // die();
                $select_location = Location::where('location', $data['location'])->whereNotIn('idlocation',[$idLocation])->first();
                
                if ($newShelfCount < $currentShelfCount) {
                    // Kiểm tra các kệ từ cuối dãy đến kệ cần xóa
                    for ($i = $currentShelfCount; $i > $newShelfCount; $i--) {
                        $shelf = Shelves::where('idLocation', $location->idLocation)
                                        ->where('shelf_number', $i)
                                        ->first();
                        
                        if ($shelf) {
                            // Điều kiện kiểm tra đồng thời
                            if ($shelf->status != 0 && $shelf->shelf_number > $newShelfCount) {
                                return redirect()->back()->with('error', 'Vui lòng chuyển hàng sang các kệ có số thứ tự nhỏ hơn (nếu còn trống) tổng số kệ mới để thực hiện update do số kệ mới nhỏ hơn số kệ hiện có');
                            }
                        }
                    }
                }


                if($select_location){
                    return redirect()->back()->with('error', 'Tên vị trí trong kho này đã tồn tại');
                }else{
                    $location->location = $data['location'];
                    $location->locationSlug = $data['locationSlug'];
                    $location->idWareHouse = $data['idWareHouse'];
                    $location->total_shelves = $data['total_shelves'];
                    $location->description = $data['description'];
    
                    $location->save();

                    if ($newShelfCount > $currentShelfCount) {
                        for ($i = $currentShelfCount + 1; $i <= $newShelfCount; $i++) {
                            $shelf = new Shelves();
                            $shelf->idLocation = $location->idLocation;
                            $shelf->shelf_number = $i;
                            $shelf->status = 0; // Các kệ mới ban đầu đều trống
                            $shelf->save();
                        }
                    } elseif ($newShelfCount < $currentShelfCount) {
                        // Nếu số lượng kệ mới ít hơn số lượng kệ hiện tại
                        for ($i = $currentShelfCount; $i > $newShelfCount; $i--) {
                            $shelf = Shelves::where('idLocation', $location->idLocation)
                                          ->where('shelf_number', $i)
                                          ->first();
                            if ($shelf && $shelf->status == 0) {
                                $shelf->delete(); // Chỉ xóa kệ nếu kệ đó còn trống
                            } 
                        }
                    }
                    return redirect()->back()->with('message', 'Sửa vị trí trong kho thành công');
                }
            }
    
            // Xóa NCC
            public function delete_location($idLocation){
                location::where('idLocation', $idLocation)->delete();
                return redirect()->back();
            }
}
