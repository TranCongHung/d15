@extends('layouts.app')

@section('title', 'Lịch sử phát triển')

@section('content')
<div class="bg-[#0c0c0c] min-h-screen text-gray-200 font-sans pb-20">
    <section class="max-w-6xl mx-auto py-20 px-6">
        {{-- Header Section --}}
        <div class="text-center mb-24">
            <h2 class="text-5xl md:text-6xl font-serif italic font-bold text-white mb-6">Lịch sử Phát triển</h2>
            <div class="w-24 h-1 bg-yellow-600 mx-auto mb-6"></div>
            <p class="text-gray-400 font-serif text-xl max-w-2xl mx-auto italic">
                "Chặng đường hơn 70 năm xây dựng, chiến đấu và trưởng thành của lực lượng vũ trang Quân khu 4."
            </p>
        </div>

        <div class="relative">
            {{-- Vertical Line (Desktop only) --}}
            <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-[2px] bg-gradient-to-b from-transparent via-[#d4af37] to-transparent hidden md:block"></div>

            <div class="space-y-16 md:space-y-24">
                @php
                    $timeline = [
                        ['year' => '15/10/1945', 'title' => 'Thành lập Chiến khu 4', 'icon' => '⭐', 'desc' => 'Tiền thân của Quân khu 4, bảo vệ chính quyền non trẻ tại Bắc Trung Bộ.'],
                        ['year' => '1946 - 1954', 'title' => 'Kháng chiến chống Pháp', 'icon' => '⚔️', 'desc' => 'Xây dựng hậu phương vững chắc, đối đầu trực tiếp với thực dân Pháp.'],
                        ['year' => '01/7/1955', 'title' => 'Thành lập Sư đoàn 324', 'icon' => '🛡️', 'desc' => 'Đoàn Ngự Bình chính thức ra đời tại Tĩnh Gia, Thanh Hóa.'],
                        ['year' => '1966 - 1972', 'title' => 'Chiến trường Trị - Thiên', 'icon' => '🚩', 'desc' => 'Lập nhiều chiến công vang dội tại Đường 9 - Nam Lào.'],
                        ['year' => '1975', 'title' => 'Tổng tiến công mùa Xuân', 'icon' => '✌️', 'desc' => 'Giải phóng Huế, Đà Nẵng và tiến vào Sài Gòn.'],
                        ['year' => 'Hiện nay', 'title' => 'Xây dựng và Bảo vệ', 'icon' => '🏢', 'desc' => 'Phát huy truyền thống, xây dựng đơn vị chính quy, tinh nhuệ.'],
                    ];
                @endphp

                @foreach($timeline as $index => $item)
                    <div class="relative flex flex-col md:flex-row items-center justify-between w-full {{ $index % 2 == 0 ? 'md:flex-row-reverse' : '' }}">
                        {{-- Content Box --}}
                        <div class="w-full md:w-5/12">
                            <div class="bg-white/5 p-8 rounded-[2rem] border border-white/10 hover:border-yellow-600/50 transition-all duration-500 shadow-2xl group">
                                <div class="text-yellow-500 font-serif font-bold text-2xl md:text-3xl italic mb-3">{{ $item['year'] }}</div>
                                <h4 class="text-xl md:text-2xl font-bold text-white mb-4 uppercase tracking-tighter group-hover:text-yellow-500 transition-colors">{{ $item['title'] }}</h4>
                                <p class="text-gray-400 font-serif text-lg leading-relaxed">{{ $item['desc'] }}</p>
                            </div>
                        </div>
                        
                        {{-- Center Dot (Desktop only) --}}
                        <div class="absolute left-1/2 transform -translate-x-1/2 w-12 h-12 rounded-full border-4 border-[#0c0c0c] bg-[#8b0000] shadow-[0_0_15px_#d4af37] z-10 hidden md:flex items-center justify-center text-xl">
                            {{ $item['icon'] }}
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
<style>
    .font-serif { font-family: 'Crimson Pro', serif; }
</style>
@endpush