@extends('layouts.app')

@section('content')
<div class="bg-[#0c0c0c] min-h-screen text-gray-200 font-sans">
    {{-- Internal Navigation --}}
    <div class="container mx-auto px-4 py-6 flex justify-between items-center border-b border-white/10">
        <h2 class="text-xl md:text-2xl font-serif font-bold tracking-widest uppercase">Kho tàng Sử liệu</h2>
        <div class="flex space-x-4 md:space-x-6 text-[10px] md:text-sm font-bold uppercase">
            <button onclick="changeIdx(0, true)" class="hover:text-red-500 transition">Bìa</button>
            <button onclick="changeIdx(1, true)" class="hover:text-red-500 transition">Quân khu 4</button>
            <button onclick="changeIdx(2, true)" class="hover:text-red-500 transition">Sư đoàn 324</button>
        </div>
    </div>

    {{-- Book Display --}}
    <div id="book-display-area" class="container mx-auto py-8 md:py-12 px-4 transition-all duration-500">
        </div>
</div>

<audio id="flip-sound" src="https://assets.mixkit.co/active_storage/sfx/147/147-preview.mp3" preload="auto"></audio>

<style>
    .page-paper {
        background: #fdfaf0 url("https://www.transparenttextures.com/patterns/paper-fibers.png");
        box-shadow: inset 0 0 100px rgba(0,0,0,0.05);
        color: #1a1a1a;
    }
    .center-fold {
        background: linear-gradient(to right, transparent 0%, rgba(0,0,0,0.05) 48%, rgba(0,0,0,0.2) 50%, rgba(0,0,0,0.05) 52%, transparent 100%);
    }
    .book-shadow { box-shadow: 0 30px 60px rgba(0,0,0,0.7); }
    .font-serif { font-family: 'Crimson Pro', serif; }
    /* Giới hạn chiều cao scroll cho nội dung dài */
    .custom-scroll::-webkit-scrollbar { width: 4px; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #880000; }
</style>
@endsection

@section('scripts')
<script>
    const BOOK_DATA = [
        {
            type: 'cover',
            title: "QUÂN KHU 4",
            subtitle: "ĐỊA BÀN CHIẾN LƯỢC QUAN TRỌNG",
            image: "https://images.unsplash.com/photo-1590133325985-2c6a9a59d8b2?q=80&w=2000"
        },
        {
            type: 'spread',
            left: { title: "VỊ TRÍ", image: "https://images.unsplash.com/photo-1506466010722-395aa2bef877?q=80&w=1200", caption: "Địa bàn 6 tỉnh từ Thanh Hóa đến Thừa Thiên Huế." },
            right: { title: "TRỌNG YẾU", paragraphs: ["Khu 4 thuộc Bắc Trung Bộ, gần cửa ngõ phía nam Thủ đô Hà Nội...", "Vừa là hậu phương, vừa là tiền tuyến."] }
        },
        {
            type: 'spread',
            left: { title: "SƯ ĐOÀN 324", image: "https://images.unsplash.com/photo-1585007600263-ad1f301f2c27?q=80&w=1200", caption: "Sư đoàn 324 thành lập ngày 01/7/1955." },
            right: { title: "TRUYỀN THỐNG", paragraphs: ["Tham gia giải phóng Huế, Đà Nẵng...", "Bản lĩnh 'Đoàn kết - Kiên cường - Đánh thắng'."] }
        }
    ];

    let currentIdx = 0;
    const area = document.getElementById('book-display-area');
    const sound = document.getElementById('flip-sound');

    function renderPage() {
        const data = BOOK_DATA[currentIdx];
        
        if (data.type === 'cover') {
            area.innerHTML = `
                <div class="relative w-full max-w-4xl mx-auto aspect-[1.4/1] book-shadow bg-gray-900 border-4 border-yellow-900/30 overflow-hidden">
                    <img src="${data.image}" class="absolute inset-0 w-full h-full object-cover opacity-30 grayscale">
                    <div class="relative z-10 h-full flex flex-col items-center justify-center p-6 text-center">
                        <div class="border-2 border-yellow-600/50 p-6 bg-black/40 backdrop-blur-sm">
                            <h1 class="text-4xl md:text-6xl font-serif italic text-white mb-2">${data.title}</h1>
                            <p class="text-sm md:text-lg text-yellow-500 font-bold uppercase tracking-widest">${data.subtitle}</p>
                        </div>
                        <button onclick="changeIdx(1)" class="mt-8 px-6 py-2 bg-red-800 text-white font-bold hover:bg-red-700 transition">MỞ SÁCH</button>
                    </div>
                </div>`;
        } else {
            area.innerHTML = `
                <div class="relative w-full max-w-6xl mx-auto aspect-[1.6/1] book-shadow flex page-paper border border-black/10">
                    <div class="absolute left-1/2 inset-y-0 w-16 -translate-x-1/2 center-fold z-10"></div>
                    <div class="w-1/2 p-6 md:p-10 flex flex-col border-r border-black/5">
                        <img src="${data.left.image}" class="w-full h-48 md:h-64 object-cover shadow-md grayscale mb-4">
                        <p class="font-serif italic text-sm text-gray-600 text-center border-t pt-2 mt-auto">${data.left.caption}</p>
                    </div>
                    <div class="w-1/2 p-6 md:p-10 flex flex-col custom-scroll overflow-y-auto">
                        <h3 class="text-red-900 font-bold mb-4 uppercase border-b pb-1">${data.right.title}</h3>
                        <div class="text-gray-800 font-serif text-sm md:text-base leading-relaxed space-y-4">
                            ${data.right.paragraphs.map(p => `<p>${p}</p>`).join('')}
                        </div>
                    </div>
                    <button onclick="changeIdx(-1)" class="absolute left-2 top-1/2 bg-black/10 hover:bg-black/30 p-2 rounded-full z-20">❮</button>
                    <button onclick="changeIdx(1)" class="absolute right-2 top-1/2 bg-black/10 hover:bg-black/30 p-2 rounded-full z-20">❯</button>
                </div>`;
        }
    }

    window.changeIdx = function(val, direct = false) {
        let next = direct ? val : currentIdx + val;
        if (next >= 0 && next < BOOK_DATA.length) {
            sound.currentTime = 0;
            sound.play();
            currentIdx = next;
            renderPage();
        }
    }

    document.addEventListener('DOMContentLoaded', renderPage);
</script>
@endsection