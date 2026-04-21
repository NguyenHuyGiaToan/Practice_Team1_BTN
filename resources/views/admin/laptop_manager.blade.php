<x-laptop-layout>
    <x-slot name="title">Quản lý sản phẩm</x-slot>

    <div class="container mt-4">
        <h3 class="text-center text-primary mb-3">QUẢN LÝ SẢN PHẨM</h3>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Thành công!</strong> {{ session('success') }}
            </div>
        @endif

        <table id="id-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tiêu đề</th>
                    <th>CPU</th>
                    <th>RAM</th>
                    <th>Ổ cứng</th>
                    <th>Khối lượng</th>
                    <th>Nhu cầu</th>
                    <th>Giá</th>
                    <th>Ảnh</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody> @foreach($products as $item)
                <tr>
                    <td>{{ $item->tieu_de }}</td>
                    <td>{{ $item->cpu }}</td>
                    <td>{{ $item->ram }}</td>
                    <td>{{ $item->luu_tru }}</td>
                    <td>{{ $item->khoi_luong }}</td>
                    <td>{{ $item->nhu_cau }}</td>
                    <td>{{ number_format($item->gia, 0, ',', '.') }} VNĐ</td>
                    <td>
                        <img src="{{ asset('storage/image/' . $item->hinh_anh) }}" width="50">
                    </td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('sanpham.show', $item->id) }}">Xem</a>
                        <form action="{{ route('laptop_delete', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#id-table').DataTable({
                "pageLength": 10, 
                "responsive": true,
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ sản phẩm",
                    "search": "Tìm kiếm:",
                    "paginate": {
                        "next": "Tiếp",
                        "previous": "Trước"
                    }
                }
            });
        });
    </script>
</x-laptop-layout>