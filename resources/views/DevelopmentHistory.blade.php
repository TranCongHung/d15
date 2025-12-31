@extends('layouts.app')

@section('title', 'Lịch sử phát triển Tiểu đoàn 15')

@section('content')
<div class="bg-[#0c0c0c] min-h-screen text-gray-200 font-sans pb-20">
    <section class="max-w-6xl mx-auto py-20 px-6">
        {{-- Header Section --}}
        <div class="text-center mb-24">
            <h2 class="text-5xl md:text-6xl font-serif italic font-bold text-white mb-6">Lịch sử Truyền thống</h2>
            <div class="w-24 h-1 bg-red-700 mx-auto mb-6"></div>
            <p class="text-gray-400 font-serif text-xl max-w-3xl mx-auto italic">
                "Hỏa lực nòng cốt của Đoàn Ngự Bình - Những bước chân không mỏi trên dải đất miền Trung và nước bạn Lào."
            </p>
        </div>

        <div class="relative">
            {{-- Vertical Line --}}
            <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-[2px] bg-gradient-to-b from-transparent via-red-700 to-transparent hidden md:block"></div>

            <div class="space-y-16 md:space-y-24">
                @php
                    $timeline = [
                        [
                            'year' => '01/07/1955', 
                            'title' => 'Nguồn gốc & Thành lập', 
                            'icon' => '🎖️', 
                            'desc' => 'Tiểu đoàn 15 hình thành cùng sự ra đời của Sư đoàn 324 tại Tĩnh Gia, Thanh Hóa. Là đơn vị hỏa lực chủ lực, trang bị vũ khí hiện đại lúc bấy giờ để bảo vệ vùng tự do.'
                        ],
                        [
                            'year' => '1961 - 1964', 
                            'title' => 'Nghĩa vụ quốc tế', 
                            'icon' => '🤝', 
                            'desc' => 'Hành quân sang giúp nước bạn Lào, tham gia chiến dịch giải phóng Cánh Đồng Chum - Xiêng Khoảng, xây dựng tình đoàn kết liên minh chiến đấu đặc biệt Việt - Lào.'
                        ],
                        [
                            'year' => '1966 - 1971', 
                            'title' => 'Bão lửa Quảng Trị', 
                            'icon' => '💥', 
                            'desc' => 'Tham gia chiến dịch Đường 9 - Khe Sanh và Đường 9 - Nam Lào. Những khẩu pháo của Tiểu đoàn 15 đã góp phần đập tan các cứ điểm kiên cố của địch, tạo đà cho bộ binh tiến công.'
                        ],
                        [
                            'year' => '1972', 
                            'title' => 'Thành cổ Quảng Trị', 
                            'icon' => '🚩', 
                            'desc' => 'Chiến đấu kiên cường trong 81 ngày đêm bảo vệ Thành cổ. Hỏa lực pháo binh Tiểu đoàn 15 là nỗi khiếp sợ của các đơn vị dù và thủy quân lục chiến tinh nhuệ nhất của đối phương.'
                        ],
                        [
                            'year' => '1975', 
                            'title' => 'Chiến dịch Huế - Đà Nẵng', 
                            'icon' => '✌️', 
                            'desc' => 'Trong cuộc tổng tiến công mùa Xuân, tiểu đoàn cùng Sư đoàn phối hợp nhịp nhàng, giải phóng Thừa Thiên Huế, thọc sâu vào Đà Nẵng, góp phần vào thắng lợi cuối cùng.'
                        ],
                        [
                            'year' => 'Hiện nay', 
                            'title' => 'Huấn luyện & Sẵn sàng', 
                            'icon' => '🛡️', 
                            'desc' => 'Đóng quân tại Nghệ An, đơn vị tập trung huấn luyện làm chủ khí tài mới, giỏi kỹ thuật, tinh thông chiến thuật, xứng danh đơn vị Anh hùng trong thời kỳ mới.'
                        ],
                    ];
                @endphp

                @foreach($timeline as $index => $item)
                    <div class="relative flex flex-col md:flex-row items-center justify-between w-full {{ $index % 2 == 0 ? 'md:flex-row-reverse' : '' }}">
                        {{-- Content Box --}}
                        <div class="w-full md:w-5/12">
                            <div class="bg-white/5 p-8 rounded-2xl border border-white/10 hover:border-red-600/50 transition-all duration-500 shadow-2xl group relative overflow-hidden">
                                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                                    <span class="text-6xl">{{ $item['icon'] }}</span>
                                </div>
                                <div class="text-red-500 font-serif font-bold text-2xl md:text-3xl italic mb-3">{{ $item['year'] }}</div>
                                <h4 class="text-xl md:text-2xl font-bold text-white mb-4 uppercase tracking-tighter group-hover:text-red-500 transition-colors">
                                    {{ $item['title'] }}
                                </h4>
                                <p class="text-gray-400 font-serif text-lg leading-relaxed">
                                    {{ $item['desc'] }}
                                </p>
                            </div>
                        </div>
                        
                        {{-- Center Dot (Desktop only) --}}
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-12 h-12 rounded-full border-4 border-[#0c0c0c] bg-[#8b0000] shadow-[0_0_20px_rgba(139,0,0,0.6)] z-10 hidden md:flex items-center justify-center text-xl shadow-red-900/50">
                            <span class="text-white drop-shadow-md">{{ $item['icon'] }}</span>
                        </div>

                        <div class="hidden md:block md:w-5/12"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
<style>
    .font-serif { font-family: 'Crimson Pro', serif; }
</style>
@endpush