<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;

class SanPhamController extends Controller
{
    
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        if (!$keyword) {
            return redirect()->back()->with('error', 'Vui lòng nhập từ khóa!');
        }

        $products = SanPham::where('tieu_de', 'LIKE', '%' . $keyword . '%')
                    ->orderBy('tieu_de', 'asc')
                    ->get();

        return view('search', [
            'products' => $products,
            'keyword' => $keyword
        ]);
    }
}