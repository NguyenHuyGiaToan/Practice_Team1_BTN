<x-laptop-layout>
    <x-slot name="title">
        Laptop
    </x-slot>

    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            font-family: Arial, sans-serif;
            padding-top: 20px;
        }

        /* Filter Section */
        .filter-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .filter-section span {
            font-size: 14px;
            color: #333;
            margin-right: 10px;
        }

        .filter-btn {
            border: 1px solid #eaeaea;
            background: white;
            padding: 8px 15px;
            text-decoration: none;
            color: #555;
            font-size: 14px;
            border-radius: 4px;
            margin: 0 5px;
            display: inline-block;
            transition: all 0.2s;
        }

        .filter-btn:hover {
            border-color: #ccc;
        }

        /* Product Grid */
        .grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            padding-bottom: 30px;
        }

        .card {
            border: 1px solid #eaeaea;
            border-radius: 6px;
            padding: 10px;
            text-align: center;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: box-shadow 0.2s;
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-img {
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fcfcfc;
            border-radius: 4px;
            margin-bottom: 12px;
        }

        .card-img img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .card-title {
            font-size: 13px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            line-height: 1.4;
            min-height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-price {
            font-size: 14px;
            color: #d32f2f;
            font-weight: bold;
            font-style: italic;
        }

        /* Fix lỗi giao diện phân trang mặc định của Laravel */
        .pagination-container {
            text-align: center;
            margin-bottom: 50px;
        }

        .pagination-container nav {
            display: flex;
            justify-content: center;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .pagination-container svg {
            width: 20px;
            height: 20px;
            display: inline-block;
        }

        .pagination-container a,
        .pagination-container span[aria-disabled] {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #333;
            text-decoration: none;
            background: #fff;
        }

        .pagination-container a:hover {
            background: #f8f9fa;
        }

        .pagination-container span[aria-current="page"] span {
            background: #28a745;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #28a745;
            display: inline-block;
        }

        .pagination-container p.text-sm {
            display: none;
        }

        .pagination-container .hidden {
            display: block !important;
        }
    </style>

    <div class="container">

        <div class="filter-section">
            <span>Tìm kiếm theo</span>
            <a href="{{ request()->fullUrlWithQuery(['sort_gia' => 'asc']) }}" class="filter-btn">Giá tăng dần</a>
            <a href="{{ request()->fullUrlWithQuery(['sort_gia' => 'desc']) }}" class="filter-btn">Giá giảm dần</a>


            @if(request()->anyFilled(['sort_gia']))
            <a href="{{ request()->fullUrlWithQuery(['sort_gia' => null]) }}" class="filter-btn" style="color: red; border-color: red;">Xóa lọc</a>
            @endif
        </div>
        @if(session('success'))
        <div style="background-color: #d1ecf1; color: #0c5460; padding: 10px; border: 1px solid #bee5eb; border-radius: 5px; text-align: center; margin-bottom: 20px; font-weight: bold;">
            {{ session('success') }}
        </div>
        @endif
        <div class="grid">
            @forelse($sanPhams as $sp)
            <div class="card">
                <div class="card-img">
                    <a href="{{ route('sanpham.show', $sp->id) }}">
                        <img src="{{ asset('storage/image/' . $sp->hinh_anh) }}" alt="{{ $sp->ten }}">
                    </a>
                </div>
                <div class="card-title">
                    <a href="{{ route('sanpham.show', $sp->id) }}" style="text-decoration: none; color: inherit;">
                        {{ $sp->tieu_de }}
                    </a>
                </div>
                <div class="card-price">
                    {{ number_format($sp->gia, 0, ',', '.') }} VNĐ
                </div>
            </div>
            @empty
            <div style="grid-column: span 5; text-align: center; color: #777; padding: 40px 0;">
                Không có sản phẩm nào phù hợp.
            </div>
            @endforelse
        </div>


    </div>
</x-laptop-layout>