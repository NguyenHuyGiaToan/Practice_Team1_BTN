<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\OrderSuccessNotification;

class HomeController extends Controller
{
    // 1. TRANG CHỦ: Hiển thị 20 sản phẩm & Xử lý tất cả bộ lọc
    public function index(Request $request)
    {
        // Lấy danh sách danh mục để in ra Menu
        $danhMucs = DB::table('danh_muc_laptop')->get();

        // Khởi tạo query lấy sản phẩm
        $query = DB::table('san_pham as sp');

        // Xử lý Lọc theo Danh mục (nếu người dùng click vào menu)
        if ($request->has('id_danh_muc')) {
            $query->join('danh_muc_laptop as dm', 'sp.id_danh_muc', '=', 'dm.id')
                  ->where('dm.id', $request->id_danh_muc)
                  ->select('sp.*'); 
        }

        // Xử lý Sắp xếp Giá
        if ($request->has('sort_gia')) {
            if ($request->sort_gia == 'asc') {
                $query->orderBy('gia', 'asc');
            } elseif ($request->sort_gia == 'desc') {
                $query->orderBy('gia', 'desc');
            }
        }

        // Lấy ra dữ liệu và Phân trang (20 sản phẩm/trang theo yêu cầu)
        $sanPhams = $query->paginate(20);

        return view("laptop.index", compact('sanPhams', 'danhMucs'));
    }

    // 2. CHI TIẾT SẢN PHẨM
    public function show($id)
    {
        $danhMucs = DB::table('danh_muc_laptop')->get();
        $sanPham = DB::table('san_pham')->where('id', $id)->first();

        if (!$sanPham) {
            abort(404);
        }

        return view('laptop.show', compact('sanPham', 'danhMucs'));
    }

    // 3. THÊM VÀO GIỎ HÀNG
    public function addToCart(Request $request)
    {
        $id = $request->input('product_id');
        $quantity = $request->input('so_luong', 1);

        $sanPham = DB::table('san_pham')->where('id', $id)->first();
        if(!$sanPham) abort(404);

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['so_luong'] += $quantity;
        } else {
            $cart[$id] = [
                "tieu_de" => $sanPham->tieu_de,
                "so_luong" => $quantity,
                "gia" => $sanPham->gia,
                "hinh_anh" => $sanPham->hinh_anh
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    // 4. TRANG GIỎ HÀNG
public function cart()
    {
        $danhMucs = DB::table('danh_muc_laptop')->get();
        $cart = session()->get('cart', []);
        
        $total = 0;
        foreach($cart as $item) {
            $total += $item['gia'] * $item['so_luong'];
        }

        return view('caycanh.cart', compact('cart', 'total', 'danhMucs'));
    }

    // 5. XÓA SẢN PHẨM KHỎI GIỎ
    public function removeFromCart(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Đã xóa sản phẩm.');
        }
    }

    // 6. XỬ LÝ ĐẶT HÀNG VÀ GỬI EMAIL
   public function checkout(Request $request)
    {
        $cart = session()->get('cart');
        if (!$cart) return redirect()->back();

        // 1. Kiểm tra đăng nhập và lấy thông tin người dùng hiện tại
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để đặt hàng.');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user(); 

        // 2. Tính tổng tiền từ giỏ hàng
        $total = 0;
        foreach($cart as $item) {
            $total += $item['gia'] * $item['so_luong'];
        }

        // 3. Lưu đơn hàng vào Database (Dùng đúng ID của người đang mua)
        $maDonHang = DB::table('don_hang')->insertGetId([
            'ngay_dat_hang' => now(),
            'tinh_trang' => 0,
            'hinh_thuc_thanh_toan' => $request->hinh_thuc_thanh_toan,
            'user_id' => $user->id // Tự động lấy ID 3 nếu bạn đang đăng nhập Long
        ]);

        // 4. Lưu chi tiết đơn hàng
        foreach ($cart as $id => $item) {
            DB::table('chi_tiet_don_hang')->insert([
                'ma_don_hang' => $maDonHang,
                'id_san_pham' => $id,
                'so_luong' => $item['so_luong'],
                'don_gia' => $item['gia']
            ]);
        }
        
        // 5. Chuẩn bị dữ liệu và GỬI EMAIL cho đúng người đó
        $data = [
            'cart' => $cart,
            'total' => $total
        ];

        // Lệnh này sẽ gửi mail đến địa chỉ email trong DB của người đang đăng nhập
        $user->notify(new OrderSuccessNotification($data));

        session()->forget('cart');
        return redirect()->route('home')->with('success', 'Đặt hàng thành công! Thông báo đã được gửi đến email của bạn.');
    }
}