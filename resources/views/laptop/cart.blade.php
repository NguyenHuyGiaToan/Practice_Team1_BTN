<x-laptop-layout>
    <x-slot name="title">
        Giỏ hàng
    </x-slot>

    <style>
        .container { max-width: 1200px; margin: 0 auto; font-family: Arial, sans-serif; padding-top: 20px; }
        
        /* Căn chỉnh Banner */
        .banner img { width: 100%; border-radius: 4px; display: block; margin-bottom: 20px; object-fit: cover; }
        
        /* Header bảng giống ảnh mẫu */
        .cart-title { color: #004085; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px; font-size: 18px; }
        .table-cart { width: 85%; margin: 0 auto; border-collapse: collapse; margin-bottom: 20px; background: #fff; }
        .table-cart th, .table-cart td { border: 1px solid #ddd; padding: 12px; text-align: center; }
        .table-cart th { background-color: #f8f9fa; color: #333; }
        .text-left { text-align: left !important; }
        .text-bold { font-weight: bold; }
        
        /* Nút Xóa màu đỏ */
        .btn-delete { background-color: #dc3545; color: white; border: none; padding: 6px 15px; border-radius: 3px; cursor: pointer; font-size: 13px; }
        .btn-delete:hover { background-color: #c82333; }
        
        /* Khu vực Đặt hàng */
        .checkout-section { text-align: center; margin-bottom: 50px; margin-top: 20px; }
        .payment-select { padding: 8px; width: 180px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-checkout { background-color: #007bff; color: white; border: none; padding: 12px 30px; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 15px; text-transform: uppercase; }
        .btn-checkout:hover { background-color: #0056b3; }
        
        /* Thông báo */
        .alert { width: 85%; margin: 0 auto 20px; padding: 15px; text-align: center; border-radius: 4px; font-weight: bold; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>

    <div class="container">
        <div class="banner">
            <img src="{{ asset('storage/image/banner.jpg') }}" alt="Banner" onerror="this.style.display='none'">
        </div>

        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-error">{{ session('error') }}</div> @endif

        <h3 class="cart-title">DANH SÁCH SẢN PHẨM</h3>

        <table class="table-cart">
            <thead>
                <tr>
                    <th width="5%">STT</th>
                    <th class="text-left">Tên sản phẩm</th>
                    <th width="10%">Số lượng</th>
                    <th width="20%">Đơn giá</th>
                    <th width="10%">Xóa</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @forelse($cart as $id => $item)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td class="text-left">{{ $item['tieu_de'] }}</td>
                        <td>{{ $item['so_luong'] }}</td>
                        <td>{{ number_format($item['gia'], 0, ',', '.') }}đ</td>
                        <td>
                            <form action="{{ route('cart.remove') }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <button type="submit" class="btn-delete">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 50px; color: #888;">Giỏ hàng của bạn hiện đang trống!</td>
                    </tr>
                @endforelse
                
                @if(count($cart) > 0)
                    <tr>
                        <td colspan="3" class="text-bold" style="background: #fdfdfd;">Tổng cộng</td>
                        <td colspan="2" class="text-left text-bold" style="color: #d32f2f; font-size: 18px;">{{ number_format($total, 0, ',', '.') }}đ</td>
                    </tr>
                @endif
            </tbody>
        </table>

        @if(count($cart) > 0)
            <div class="checkout-section">
                <form action="{{ route('cart.checkout') }}" method="POST">
                    @csrf
                    <label style="font-weight: bold; display: block; margin-bottom: 10px;">Hình thức thanh toán</label>
                    <select name="hinh_thuc_thanh_toan" class="payment-select">
                        <option value="1">Tiền mặt</option>
                        <option value="2">Chuyển khoản</option>
                    </select>
                    <br>
                    <button type="submit" class="btn-checkout">ĐẶT HÀNG</button>
                </form>
            </div>
        @endif
    </div>
</x-laptop-layout>