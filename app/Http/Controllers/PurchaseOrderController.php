<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\WareHouse;
use App\Models\Location;
use App\Models\Shelves;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetails;
use App\Models\OrderWarehouse;
use App\Models\ProductAttriBute;
use App\Models\Attribute;
use App\Models\OrderProductAttriBute;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
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

         // Chuyển đến trang quản lý dơn nhập
        public function manage_purchase_order(){
            $this->checkLogin();
            $this->checkPostion();
            // $purchaseOrderDetail = PurchaseOrderDetails::where('idPurchaseOrder', $idPurchaseOrder)->first();
            $list_order = PurchaseOrder::with(['creator', 'updater', 'supplier'])->get();
            return view("admin.purchase-order.manage-purchase-order")->with(compact('list_order'));
        }

        // Chuyển đến trang quản lý chi tiết dơn nhập
        public function manage_purchase_order_details($idPurchaseOrder){
            $this->checkLogin();
            $this->checkPostion();
            // Truy vấn dữ liệu mà không có select
            $purchaseDetails = DB::table('purchaseorderdetails')
            ->join('purchaseorder', 'purchaseorderdetails.idPurchaseOrder', '=', 'purchaseorder.idPurchaseOrder')
            ->join('product', 'purchaseorderdetails.idProduct', '=', 'product.idProduct')
            ->leftJoin('productimage', 'product.idProduct', '=', 'productimage.idProduct')
            ->where('purchaseorderdetails.idPurchaseOrder', $idPurchaseOrder)
            ->get();

            // dd($purchaseDetails);
            // die();
            return view("admin.purchase-order.purchase-order-details.manage-purchase-order-details")->with(compact('purchaseDetails', 'idPurchaseOrder'));
        }
        public function updateTotalAmount($idPurchaseOrder) {
            $totalAmount = DB::table('purchaseOrderDetails')
                            ->where('idPurchaseOrder', $idPurchaseOrder)
                            ->sum('unitPrice');
        
            DB::table('purchaseOrder')
                ->where('idPurchaseOrder', $idPurchaseOrder)
                ->update(['totalPrice' => $totalAmount, 'updated_at' => now()]);
        }

        // Chuyển đến trang thêm đơn nhập
        public function add_purchase_order(){
            $this->checkLogin();
            $this->checkPostion();
            $list_supplier  = Supplier::get();
            return view("admin.purchase-order.add-purchase-order")->with(compact('list_supplier', ));
        }

        public function add_purchase_order_details($idPurchaseOrder){
            $this->checkLogin();
            $this->checkPostion();
            $list_warehouse = WareHouse::all();
            $list_attribute = Attribute::get();
            $list_product = DB::table('Product')
            ->join('productimage', 'product.idProduct', '=', 'productimage.idProduct')
            ->get();
            // dd($list_product);
            // die();
            $list_supplier= Supplier::get();
            return view("admin.purchase-order.purchase-order-details.add-purchase-order-details")->with(compact('list_supplier', 'list_product', 'list_warehouse', 'idPurchaseOrder','list_attribute'));
        }

         //Tạo đơn nhập
         public function submit_add_purchase_order(Request $request){
            $data = $request->all();
            // dd($data);
            // die();
            $purchase = new PurchaseOrder();
            
                $purchase->idSupplier = $data['idSupplier'];
                $purchase->orderDate = $data['orderDate'];
                // $purchase->totalPrice = $data['totalPrice'];
                $purchase->createdBy = $data['createById'];
                $purchase->status = $data['status'];
                $purchase->description = $data['description'];
                $purchase->save();
 
                 return redirect()->to('/add-purchase-order-details/'.$purchase->idPurchaseOrder);
            
        }

        
         //Tạo chi tđơn nhập
        public function submit_add_purchase_order_details(Request $request){
            $data = $request->all();

                // Thêm dữ liệu vào bảng purchaseorderdetails
                $purchaseOrderDetail = new PurchaseOrderDetails();
                $purchaseOrderDetail->idPurchaseOrder = $data['idPurchaseOrder'];
                $purchaseOrderDetail->idProduct = $data['idProduct'];
                $purchaseOrderDetail->expiryDate = $data['expiryDate'];
                $purchaseOrderDetail->quantity = $data['QuantityTotal'];
                $purchaseOrderDetail->unitPrice = $data['TotalPrice'];
                $purchaseOrderDetail->description = $data['description'];
                $timestamp = now();
                $purchaseOrderDetail->save();
            
                // Lưu dữ liệu vào bảng trung gian orderwarehouse
                if ($request->has('warehouses')) {
                    foreach ($request->input('warehouses') as $warehouseId) {
                        if ($request->has("locations.$warehouseId")) {
                            foreach ($request->input("locations.$warehouseId") as $locationId) {
                                if ($request->has("shelves.$locationId")) {
                                    foreach ($request->input("shelves.$locationId") as $shelfId) {
                                        $orderWarehouse = new OrderWarehouse();
                                        $orderWarehouse->idDetails = $purchaseOrderDetail->idDetails;
                                        $orderWarehouse->idWareHouse = $warehouseId;
                                        $orderWarehouse->idLocation = $locationId;
                                        $orderWarehouse->idShelves = $shelfId;
                                        $orderWarehouse->save();
            
                                        // Cập nhật trạng thái của kệ trong bảng shelves
                                        $shelf = Shelves::find($shelfId);
                                        if ($shelf) {
                                            $shelf->status = 1; // Cập nhật trạng thái thành 'đầy'
                                            $shelf->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $get_pd = PurchaseOrderDetails::where('created_at', $timestamp)->first();
                // Thêm phân loại vào bảng Product_Attribute
                if($request->qty_attr){
                    foreach($data['qty_attr'] as $key => $qty_attr)
                    {
                        $price_attr = $data['price_attr'][$key];  // Lấy giá tiền cho từng phân loại
                        $data_all = array(
                            'idDetails' => $get_pd->idDetails,
                            'idProduct' => $data['idProduct'],
                            'idAttrValue' => $data['chk_attr'][$key],
                            'Quantity' => $qty_attr,
                            'quantity_available' => $qty_attr,
                            'Price' => $price_attr,  // Thêm trường giá tiền cho phân loại
                            'created_at' => now(),
                            'updated_at' => now()
                        );
                        OrderProductAttriBute::insert($data_all);
                    }
                } else {
                    $data_all = array(
                        'idDetails' => $get_pd->idDetails,
                        'idProduct' => $data['idProduct'],
                        'Quantity' => $data['QuantityTotal'],
                        'quantity_available' => $data['QuantityTotal'],
                        'Price' => $data['Price'],  // Giá tiền mặc định nếu không có phân loại
                        'created_at' => now(),
                        'updated_at' => now()
                    );
                    OrderProductAttriBute::insert($data_all);
                }

                 // Tính và cập nhật tổng tiền
                    $this->updateTotalAmount($request->idPurchaseOrder);
            
                return redirect()->back()->with('message', 'Thêm chi tiết đơn nhập thành công.');
        }

        // Chuyển đến trang sửa đơn nhập
        public function edit_order($idPurchaseOrder){
            $this->checkLogin();
            $this->checkPostion();
            $list_supplier  = Supplier::get();
            $purchaseOrder = PurchaseOrder::with(['creator', 'updater', 'supplier'])->findOrFail($idPurchaseOrder);
            return view("admin.purchase-order.edit-purchase-order")->with(compact('purchaseOrder','list_supplier'));
        }

        // public function edit_order_details($idPurchaseOrder){
        //     $purchaseOrderDetail = PurchaseOrderDetails::findOrFail($idPurchaseOrder);
           
        //     $list_product = Product::all(); // Hoặc thêm điều kiện nếu cần
        //     $list_warehouse = Warehouse::all();
        //     $selectedWarehouses = $purchaseOrderDetail->warehouses->pluck('idWareHouse')->toArray();
        //     $selected_locations = $purchaseOrderDetail->locations->pluck('idLocation', 'idWareHouse')->toArray();
        //     $selected_shelves = $purchaseOrderDetail->shelves->pluck('idShelves', 'idLocation')->toArray();
    
        //     return view("admin.purchase-order.purchase-order-details.edit-purchase-order-details")->with(compact('purchaseOrderDetail', 'list_product', 'list_warehouse', 'selectedWarehouses', 'selected_locations','selected_shelves'));
           
        // }

        public function edit_purchase_order_details($idPurchaseOrder, $idDetails, $idProduct)
        {
            $purchaseOrder = PurchaseOrderDetails::where('idPurchaseOrder', $idPurchaseOrder)->first();
            
            if (!$purchaseOrder) {
                return redirect()->to('/add-purchase-order-details/'.$idPurchaseOrder);
            }

            $purchaseOrderDetail = PurchaseOrderDetails:: join('product', 'purchaseorderdetails.idProduct', '=', 'product.idProduct')
            ->leftJoin('productimage', 'product.idProduct', '=', 'productimage.idProduct')
            ->where('idDetails', $idDetails)->first();
            $list_product = DB::table('Product')
            ->join('productimage', 'product.idProduct', '=', 'productimage.idProduct')
            ->get();
            $list_warehouse = Warehouse::get();

            $selectedWarehouses = OrderWarehouse::where('idDetails', $idDetails)
                ->pluck('idWareHouse')
                ->toArray();

            $selectedLocations = [];
            $selectedShelves = [];

            foreach ($selectedWarehouses as $warehouseId) {
                $locations = Location::where('idWareHouse', $warehouseId)->get();
                $selectedLocations[$warehouseId] = OrderWarehouse::where('idDetails', $idDetails)
                    ->where('idWareHouse', $warehouseId)
                    ->pluck('idLocation')
                    ->toArray();

                foreach ($selectedLocations[$warehouseId] as $locationId) {
                    $shelves = Shelves::where('idLocation', $locationId)->get();
                    $selectedShelves[$locationId] = OrderWarehouse::where('idDetails', $idDetails)
                        ->where('idLocation', $locationId)
                        ->pluck('idShelves')
                        ->toArray();
                }
            }
            
            $warehouse_names = Warehouse::whereIn('idWareHouse', $selectedWarehouses)
                ->pluck('wareName', 'idWareHouse')
                ->toArray();

            $location_names = [];
            $shelf_names = [];

            foreach ($selectedWarehouses as $warehouseId) {
                $location_names[$warehouseId] = Location::whereIn('idLocation', $selectedLocations[$warehouseId])
                    ->pluck('location', 'idLocation')
                    ->toArray();
                    

                foreach ($selectedLocations[$warehouseId] as $locationId) {
                    $shelf_names[$locationId] = Shelves::whereIn('idShelves', $selectedShelves[$locationId])
                        ->pluck('idShelves', 'idShelves')
                        ->toArray();
                }
            }
            $list_pd_attr = OrderProductAttriBute::join('attribute_value','attribute_value.idAttrValue','=','order_product_attribute.idAttrValue')
                ->join('attribute','attribute.idAttribute','=','attribute_value.idAttribute')
                ->where('order_product_attribute.idDetails', $idDetails)->get();

            $name_attribute = OrderProductAttriBute::join('attribute_value','attribute_value.idAttrValue','=','order_product_attribute.idAttrValue')
                ->join('attribute','attribute.idAttribute','=','attribute_value.idAttribute')
                ->where('order_product_attribute.idDetails', $idDetails)->first();
        
            
            $list_attribute = Attribute::get();
            // dd($selectedLocations);
            // die();

            return view("admin.purchase-order.purchase-order-details.edit-purchase-order-details")->with(compact(
                'purchaseOrderDetail',
                'idDetails',
                'list_product',
                'list_warehouse',
                'selectedWarehouses',
                'selectedLocations',
                'selectedShelves',
                'warehouse_names',
                'location_names',
                'shelf_names',
                'list_attribute','list_pd_attr','name_attribute'
            ));
        }

        public function submit_edit_purchase_order(Request $request, $idPurchaseOrder){
            $data = $request->all();
            $order = PurchaseOrder::find($idPurchaseOrder);
           
                $order->idSupplier = $data['idSupplier'];
                $order->orderDate = $data['orderDate'];
                // $order->totalPrice = $data['totalPrice'];
                // $order->createdBy = $data['createBy'];
                $order->updatedBy = $data['updateBy'];
                $order->status = $data['status'];
                $order->description = $data['description'];
                $order->save();

                 return redirect()->to('/add-purchase-order-details/'.$idPurchaseOrder);
            
        }

        public function submit_edit_purchase_order_details(Request $request, $idDetails){
            $data = $request->all();
            // Validation
            $request->validate([
                'idPurchaseOrder' => 'required',
                'idProduct' => 'required',
                'expiryDate' => 'required|date',
                'quantity' => 'required|integer',
                'unitPrice' => 'required|numeric',
                'description' => 'nullable|string',
                'warehouses' => 'required|array',
                'locations' => 'required|array',
                'shelves' => 'required|array',
            ]);
                // Lấy thông tin chi tiết đơn nhập cần cập nhật
                $purchaseOrderDetail = PurchaseOrderDetails::find($idDetails);

                // Cập nhật thông tin chi tiết đơn nhập
                $purchaseOrderDetail->idProduct = $request->input('idProduct');
                $purchaseOrderDetail->expiryDate = $request->input('expiryDate');
                $purchaseOrderDetail->quantity = $request->input('quantity');
                $purchaseOrderDetail->unitPrice = $request->input('unitPrice');
                $purchaseOrderDetail->description = $request->input('description');
                $purchaseOrderDetail->save();
                
                // Xóa các bản ghi cũ trong bảng trung gian orderwarehouse
                $existingOrderWarehouses = OrderWarehouse::where('idDetails', $purchaseOrderDetail->idDetails)->get();
                $existingShelfIds = $existingOrderWarehouses->pluck('idShelves')->toArray();

                OrderWarehouse::where('idDetails', $purchaseOrderDetail->idDetails)->delete();

                // Lưu các bản ghi mới và cập nhật trạng thái shelves
                $newShelfIds = [];

                if ($request->has('warehouses')) {
                    foreach ($request->input('warehouses') as $warehouseId) {
                        if ($request->has("locations.$warehouseId")) {
                            foreach ($request->input("locations.$warehouseId") as $locationId) {
                                if ($request->has("shelves.$locationId")) {
                                    foreach ($request->input("shelves.$locationId") as $shelfId) {
                                        $newShelfIds[] = $shelfId;

                                        // Thêm bản ghi mới vào bảng orderwarehouse
                                        $orderWarehouse = new OrderWarehouse();
                                        $orderWarehouse->idDetails = $purchaseOrderDetail->idDetails;
                                        $orderWarehouse->idWareHouse = $warehouseId;
                                        $orderWarehouse->idLocation = $locationId;
                                        $orderWarehouse->idShelves = $shelfId;
                                        $orderWarehouse->idProduct = $request->input('idProduct');
                                        $orderWarehouse->save();

                                        // Cập nhật trạng thái của kệ (shelves) thành 'đầy'
                                        $shelf = Shelves::find($shelfId);
                                        if ($shelf) {
                                            $shelf->status = 1; // Đánh dấu kệ là 'đầy'
                                            $shelf->save();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                // Chuyển các kệ bị bỏ chọn từ trạng thái 'đầy' về 'rỗng'
                $shelvesToUpdate = array_diff($existingShelfIds, $newShelfIds);

                foreach ($shelvesToUpdate as $shelfId) {
                    $shelf = Shelves::find($shelfId);
                    if ($shelf) {
                        $shelf->status = 0; // Đánh dấu kệ là 'rỗng'
                        $shelf->save();
                    }
                }
                 // Sửa phân loại Product_Attribute
                 if($request->qty_attr){
                    OrderProductAttriBute::where('idDetails',$idDetails)->delete();
                    foreach($data['qty_attr'] as $key => $qty_attr)
                    {
                        $price_attr = $data['price_attr'][$key];  // Lấy giá tiền cho từng phân loại
                        $data_all = array(
                            'idDetails' => $idDetails,
                            'idProduct' => $data['idProduct'],
                            'idAttrValue' => $data['chk_attr'][$key],
                            'Quantity' => $qty_attr,
                            'quantity_available' => $qty_attr,
                            'Price' => $price_attr,  // Thêm trường giá tiền cho phân loại
                            'created_at' => now(),
                            'updated_at' => now()
                        );
                        
                        OrderProductAttriBute::insert($data_all);
                    }
                }else{
                    OrderProductAttriBute::where('idProduct',$data['idProduct'])->delete();
                    $data_all = array(
                        'idDetails' => $idDetails,
                        'idProduct' => $data['idProduct'],
                        'Quantity' => $data['quantity'],
                        'quantity_available' => $data['quantity'],
                        'Price' => $data['Price'],  // Giá tiền mặc định nếu không có phân loại
                        'created_at' => now(),
                        'updated_at' => now()
                    );
                    OrderProductAttriBute::insert($data_all);
                }
                 // Tính và cập nhật tổng tiền
                    $this->updateTotalAmount($request->idPurchaseOrder);
                return redirect()->back()->with('message', 'Sửa đơn nhập thành công.');
            }

            // Xóa đơn nhập khi chưa haonf thành chi tiết đơn nhập
            public function deletePurchaseOrder($idPurchaseOrder)
            {
                $purchaseOrder = PurchaseOrder::find($idPurchaseOrder);
                
                    $purchaseOrder->delete();
                    return redirect()->back();
                
            }

            //hủy đơn nhập
            public function cancelPurchaseOrder($idPurchaseOrder)
            {
                PurchaseOrder::where('idPurchaseOrder', $idPurchaseOrder)->update(['status' => 2]);
                    return redirect()->back();
                
            }

            public function purchase_order_info(Request $request, $idDetails){
                // Validation
                $request->validate([
                    'idPurchaseOrder' => 'required',
                    'idProduct' => 'required',
                    'expiryDate' => 'required|date',
                    'quantity' => 'required|integer',
                    'unitPrice' => 'required|numeric',
                    'description' => 'nullable|string',
                    'warehouses' => 'required|array',
                    'locations' => 'required|array',
                    'shelves' => 'required|array',
                ]);
                    // Lấy thông tin chi tiết đơn nhập cần cập nhật
                    $purchaseOrderDetail = PurchaseOrderDetails::find($idDetails);
    
                    // Cập nhật thông tin chi tiết đơn nhập
                    $purchaseOrderDetail->idProduct = $request->input('idProduct');
                    $purchaseOrderDetail->expiryDate = $request->input('expiryDate');
                    $purchaseOrderDetail->quantity = $request->input('quantity');
                    $purchaseOrderDetail->unitPrice = $request->input('unitPrice');
                    $purchaseOrderDetail->description = $request->input('description');
                    $purchaseOrderDetail->save();
                    
                    // Xóa các bản ghi cũ trong bảng trung gian orderwarehouse
                    $existingOrderWarehouses = OrderWarehouse::where('idDetails', $purchaseOrderDetail->idDetails)->get();
                    $existingShelfIds = $existingOrderWarehouses->pluck('idShelves')->toArray();
    
                    OrderWarehouse::where('idDetails', $purchaseOrderDetail->idDetails)->delete();
    
                    // Lưu các bản ghi mới và cập nhật trạng thái shelves
                    $newShelfIds = [];
    
                    if ($request->has('warehouses')) {
                        foreach ($request->input('warehouses') as $warehouseId) {
                            if ($request->has("locations.$warehouseId")) {
                                foreach ($request->input("locations.$warehouseId") as $locationId) {
                                    if ($request->has("shelves.$locationId")) {
                                        foreach ($request->input("shelves.$locationId") as $shelfId) {
                                            $newShelfIds[] = $shelfId;
    
                                            // Thêm bản ghi mới vào bảng orderwarehouse
                                            $orderWarehouse = new OrderWarehouse();
                                            $orderWarehouse->idDetails = $purchaseOrderDetail->idDetails;
                                            $orderWarehouse->idWareHouse = $warehouseId;
                                              $orderWarehouse->idLocation = $locationId;
                                            $orderWarehouse->idShelves = $shelfId;
                                            $orderWarehouse->save();
    
                                            // Cập nhật trạng thái của kệ (shelves) thành 'đầy'
                                            $shelf = Shelves::find($shelfId);
                                            if ($shelf) {
                                                $shelf->status = 1; // Đánh dấu kệ là 'đầy'
                                                $shelf->save();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
    
                    // Chuyển các kệ bị bỏ chọn từ trạng thái 'đầy' về 'rỗng'
                    $shelvesToUpdate = array_diff($existingShelfIds, $newShelfIds);
    
                    foreach ($shelvesToUpdate as $shelfId) {
                        $shelf = Shelves::find($shelfId);
                        if ($shelf) {
                            $shelf->status = 0; // Đánh dấu kệ là 'rỗng'
                            $shelf->save();
                        }
                    }
                    return redirect()->back()->with('message', 'Sửa đơn nhập thành công.');
                }
            
        // Lấy danh sách location theo warehouse ID
        public function getLocations($warehouseId){
            $warehouse = Warehouse::find($warehouseId);
            $locations = $warehouse->locations; // Giả sử có quan hệ đã định nghĩa
        
            return response()->json([
                'warehouseName' => $warehouse->wareName,
                'locations' => $locations,
            ]);
                
        }

            // Lấy danh sách shelves theo location ID
        public function getShelves($locationId){
                $shelves = Shelves::where('idLocation', $locationId)->get();
                return response()->json($shelves);
        }

       

          // Xác nhận đơn hàng
          public function confirm_order($idPurchaseOrder)
{
    // Cập nhật trạng thái đơn nhập và thời gian nhận hàng
    PurchaseOrder::find($idPurchaseOrder)->update([
        'receiveDate' => now(),
        'status' => 1, 
        'updatedBy' => Session::get('idAdmin')
    ]);

    // Lấy danh sách chi tiết đơn hàng theo idPurchaseOrder
    $list_order_details = PurchaseOrderDetails::where('idPurchaseOrder', $idPurchaseOrder)->get();

    // Lặp qua từng chi tiết đơn hàng
    foreach ($list_order_details as $order) {
        // Cập nhật số lượng tổng của sản phẩm trong bảng product
        DB::table('product')
            ->where('idProduct', $order->idProduct)
            ->increment('QuantityTotal', $order->quantity);

        // Lấy danh sách phân loại của sản phẩm từ bảng order_product_attribute
        $order_product_attributes = DB::table('order_product_attribute')
            ->where('idProduct', $order->idProduct)
            ->where('idDetails', $order->idDetails)
            ->get();

        // Cập nhật số lượng cho từng phân loại trong bảng product_attribute
        foreach ($order_product_attributes as $attr) {
            // Kiểm tra xem phân loại có tồn tại trong product_attribute hay chưa
            $product_attr = DB::table('product_attribute')
                ->where('idProduct', $attr->idProduct)
                ->where('idAttrValue', $attr->idAttrValue)
                ->first();

            if ($product_attr) {
                // Nếu phân loại tồn tại, cộng thêm số lượng từ order_product_attribute
                DB::table('product_attribute')
                    ->where('idProAttr', $product_attr->idProAttr)
                    ->increment('Quantity', $attr->Quantity);
            } else {
                // Nếu phân loại chưa tồn tại, thêm mới phân loại vào product_attribute
                DB::table('product_attribute')->insert([
                    'idProduct' => $attr->idProduct,
                    'idAttrValue' => $attr->idAttrValue,
                    'Quantity' => $attr->Quantity,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    return redirect()->back();
}

        public function order_details_info($idPurchaseOrder, $idDetails){
            $this->checkLogin();
            $this->checkPostion();
            // Truy vấn dữ liệu mà không có select
            $purchaseDetails = DB::table('purchaseorderdetails')
            ->join('purchaseorder', 'purchaseorderdetails.idPurchaseOrder', '=', 'purchaseorder.idPurchaseOrder')
            ->join('product', 'purchaseorderdetails.idProduct', '=', 'product.idProduct')
            ->leftJoin('productimage', 'product.idProduct', '=', 'productimage.idProduct')
            ->leftJoin('admin', 'purchaseorder.createdBy', '=', 'admin.idAdmin')
            ->leftJoin('supplier', 'purchaseorder.idSupplier', '=', 'supplier.idSupplier')
            ->where('purchaseorderdetails.idPurchaseOrder', $idPurchaseOrder)
            ->where('purchaseorderdetails.idDetails', $idDetails)
            ->first();
            // dd($purchaseDetails);
            // die();
            return view("admin.purchase-order.purchase-order-details.order-details-info")->with(compact('purchaseDetails'));
        }
}
