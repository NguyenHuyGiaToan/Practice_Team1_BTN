<h2>Cảm ơn bạn đã đặt hàng!</h2>
<p>Thông tin chi tiết đơn hàng của bạn:</p>

<table border="1" cellpadding="10" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data['cart'] as $item)
            <tr>
                <td>{{ $item['tieu_de'] }}</td>
                <td style="text-align: center;">{{ $item['so_luong'] }}</td>
                <td>{{ number_format($item['gia'], 0, ',', '.') }}đ</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">Tổng cộng:</td>
            <td style="font-weight: bold; color: red;">{{ number_format($data['total'], 0, ',', '.') }}đ</td>
        </tr>
    </tbody>
</table>