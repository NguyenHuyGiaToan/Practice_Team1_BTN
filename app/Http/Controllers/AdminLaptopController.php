<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminLaptopController extends Controller
{
    public function laptop_manager()
    {
        $products = DB::select("SELECT * FROM san_pham
                            where status = ?;", [1]);
        return view("admin.laptop_manager", compact("products"));
    }

    public function laptop_delete($id)
    {
        DB::update("UPDATE san_pham set status = 0 where id = ?", [$id]);
        return redirect()->route("laptop_manager")->with("success", "Xóa sản phẩm thành công.");
    }
}   