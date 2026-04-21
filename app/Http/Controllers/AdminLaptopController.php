<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCayCanhController extends Controller
{
    public function caycanh_manager()
    {
        $products = DB::select("SELECT * FROM san_pham
                            where status = ?;", [1]);
        return view("admin.caycanh_manager", compact("products"));
    }

    public function caycanh_add()
    {
        return view("admin.caycanh_add");
    }
    public function caycanh_add_func(Request $request)
    {
        // 1. Validate với thông báo Tiếng Việt
        $request->validate([
            'ten_san_pham' => 'required',
            'ten_khoa_hoc'  => 'required',
            'ten_thong_thuong' => 'required',
            'mo_ta' => 'required',
            'do_kho' => 'required',
            'yeu_cau_anh_sang' => 'required',
            'nhu_cau_nuoc' => 'required',
            'gia_ban' => 'required|numeric|min:0',
            'hinh_anh'        => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Chỉ cho phép định dạng ảnh
        ], [
            // Định nghĩa thông báo lỗi tiếng Việt
            'required'              => 'Trường :attribute không được để trống.',
            'date_format'           => 'Trường :attribute phải đúng định dạng yyyy-mm-dd.',
            'image'                 => 'File tải lên phải là định dạng ảnh.',
            'mimes'                 => 'Ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'max'                   => 'Dung lượng ảnh không được quá 2MB.',
        ], [
            // Đặt tên tiếng Việt cho các trường để thông báo thân thiện hơn
            'ten_san_pham' => 'Tên sản phẩm',
            'ten_khoa_hoc' => 'Tên khoa học',
            'ten_thong_thuong' => 'Tên thông thường',
            'mo_ta' => 'Mô tả',
            'do_kho' => 'Độ khó',
            'yeu_cau_anh_sang' => 'Yêu cầu ánh sáng',
            'nhu_cau_nuoc' => 'Nhu cầu nước',
            'gia_ban' => 'Giá bán',
            'hinh_anh' => 'Ảnh',
        ]);

        // 2. Xử lý File (Giữ nguyên logic của bạn nhưng tối ưu đường dẫn)
        $filePath = null;
        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // LƯU Ý: Phải có tiền tố 'public/'
            $file->storeAs('public/image', $fileName);

            // Đường dẫn lưu vào DB để hiển thị ngoài giao diện
            $filePath = "" . $fileName;
        }

        // 3. Database Insert
        DB::insert(
            "INSERT INTO san_pham (ten_san_pham, ten_khoa_hoc, ten_thong_thuong, mo_ta, do_kho, yeu_cau_anh_sang, nhu_cau_nuoc, gia_ban, hinh_anh) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $request->input("ten_san_pham"),
                $request->input("ten_khoa_hoc"),
                $request->input("ten_thong_thuong"),
                $request->input("mo_ta"),
                $request->input("do_kho"),
                $request->input("yeu_cau_anh_sang"),
                $request->input("nhu_cau_nuoc"),
                $request->input("gia_ban"),
                $filePath
            ]
        );

        return redirect()->route("caycanh_manager")->with("success", "Thêm sản phẩm thành công.");
    }
    public function caycanh_delete($id)
    {
        DB::update("UPDATE san_pham set status = 0 where id = ?", [$id]);
        return redirect()->route("caycanh_manager")->with("success", "Xóa sản phẩm thành công.");
    }
}
?>