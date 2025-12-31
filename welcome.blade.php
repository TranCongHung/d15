<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sử liệu điện tử - Quân khu 4 & Sư đoàn 324</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Pro:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --military-red: #8b0000;
            --military-gold: #d4af37;
            --paper-color: #fdfaf0;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0c0c0c;
            color: #e5e7eb;
            margin: 0;
            overflow-x: hidden;
        }
        h1, h2, h3, h4, .font-serif {
            font-family: 'Crimson Pro', serif;
        }
        .page-paper {
            background-color: var(--paper-color);
            background-image: url("https://www.transparenttextures.com/patterns/paper-fibers.png");
            box-shadow: inset 0 0 100px rgba(0,0,0,0.05);
            color: #1a1a1a;
            position: relative;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .center-fold {
            background: linear-gradient(to right, 
                rgba(0,0,0,0) 0%, 
                rgba(0,0,0,0.05) 48%, 
                rgba(0,0,0,0.2) 50%, 
                rgba(0,0,0,0.05) 52%, 
                rgba(0,0,0,0) 100%);
        }
        .book-shadow {
            box-shadow: 0 50px 100px rgba(0,0,0,0.8), 0 10px 20px rgba(0,0,0,0.5);
        }
        .page-left-edge {
            background: linear-gradient(to right, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0) 5%);
        }
        .page-right-edge {
            background: linear-gradient(to left, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0) 5%);
        }
        .btn-military {
            background-color: var(--military-red);
            color: white;
            transition: all 0.3s;
        }
        .btn-military:hover {
            background-color: #a00000;
            transform: scale(1.05);
        }
        .chat-bubble {
            max-width: 85%;
            padding: 1rem 1.5rem;
            border-radius: 1.5rem;
            margin-bottom: 1rem;
            font-size: 1rem;
            line-height: 1.6;
        }
        .chat-user {
            background-color: var(--military-red);
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 0;
        }
        .chat-ai {
            background-color: rgba(255,255,255,0.1);
            color: #e5e7eb;
            align-self: flex-start;
            border-bottom-left-radius: 0;
            border: 1px border rgba(255,255,255,0.1);
        }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        
        .timeline-line {
            background: linear-gradient(to bottom, transparent, var(--military-gold), transparent);
            width: 2px;
        }
        .timeline-dot {
            border: 4px solid #0c0c0c;
            box-shadow: 0 0 15px var(--military-gold);
        }
    </style>
    <script type="importmap">
    {
      "imports": {
        "@google/genai": "https://esm.sh/@google/genai@^1.34.0"
      }
    }
    </script>
</head>
<body>
    <!-- Header -->
    <header class="bg-black/90 backdrop-blur-md border-b border-yellow-700/30 sticky top-0 z-50 h-20">
        <div class="max-w-7xl mx-auto px-6 h-full flex items-center justify-between">
            <div class="flex items-center space-x-4 cursor-pointer" onclick="navigateTo('HOME')">
                <div class="w-12 h-12 bg-red-700 rounded-full border-2 border-yellow-500 flex items-center justify-center shadow-lg">
                    <span class="text-yellow-400 font-bold text-xl italic leading-none">324</span>
                </div>
                <div>
                    <h1 class="text-xl font-bold tracking-tighter text-white">QUÂN KHU 4</h1>
                    <p class="text-[10px] text-yellow-500 font-bold tracking-[0.2em] uppercase">Sử liệu điện tử</p>
                </div>
            </div>
            <nav class="hidden md:flex items-center space-x-8">
                <button onclick="navigateTo('HOME')" class="nav-link text-sm font-bold uppercase tracking-widest text-gray-400 hover:text-white transition-all">Trang chủ</button>
                <button onclick="navigateTo('DEVELOPMENT')" class="nav-link text-sm font-bold uppercase tracking-widest text-gray-400 hover:text-white transition-all">Lịch sử phát triển</button>
                <button onclick="navigateTo('BOOK')" class="nav-link text-sm font-bold uppercase tracking-widest text-gray-400 hover:text-white transition-all">Sách sử</button>
                <button onclick="navigateTo('AI')" class="nav-link text-sm font-bold uppercase tracking-widest text-gray-400 hover:text-white transition-all">Hỏi đáp AI</button>
            </nav>
            <div class="flex items-center space-x-2">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Trực tuyến</span>
            </div>
        </div>
    </header>

    <main id="content-area">
        <!-- Nội dung được render bởi JS -->
    </main>

    <!-- Footer -->
    <footer class="bg-black py-20 px-10 border-t border-white/5 text-gray-600 mt-20">
        <div class="max-w-7xl mx-auto text-center space-y-4">
            <p class="text-white font-bold tracking-widest uppercase text-[10px]">Cổng thông tin Truyền thống Quân khu 4</p>
            <p class="text-sm">Bản quyền nội dung thuộc Bộ Quốc phòng Việt Nam</p>
            <p class="text-[10px] uppercase tracking-[0.4em] mt-10">© 2024 Sư đoàn 324 - Ngự Bình</p>
        </div>
    </footer>

    <!-- Audio for page flip -->
    <audio id="flip-sound" src="https://assets.mixkit.co/active_storage/sfx/147/147-preview.mp3" preload="auto"></audio>

    <script type="module">
        import { GoogleGenAI } from "@google/genai";

        // --- Data ---
        const BOOK_PAGES = [
            {
                type: 'cover',
                title: "QUÂN KHU 4",
                subtitle: "ĐỊA BÀN CHIẾN LƯỢC QUAN TRỌNG CỦA TỔ QUỐC",
                image: "https://images.unsplash.com/photo-1590133325985-2c6a9a59d8b2?q=80&w=2000&auto=format&fit=crop"
            },
            {
                type: 'spread',
                left: {
                    title: "VỊ TRÍ CHIẾN LƯỢC",
                    image: "https://images.unsplash.com/photo-1506466010722-395aa2bef877?q=80&w=1200&auto=format&fit=crop",
                    caption: "Quân khu 4 nằm trên dải đất miền Trung, bao gồm 6 tỉnh: Thanh Hóa, Nghệ An, Hà Tĩnh, Quảng Bình, Quảng Trị, Thừa Thiên Huế."
                },
                right: {
                    title: "ĐỊA BÀN TRỌNG YẾU",
                    paragraphs: [
                        "Khu 4 thuộc Bắc Trung Bộ, gần cửa ngõ phía nam Thủ đô Hà Nội, nằm ở phía tây Thái Bình Dương, cùng chung dải Trường Sơn hùng vĩ với nước bạn Lào anh em.",
                        "Địa bàn có giá trị hết sức quan trọng trong chiến tranh giải phóng dân tộc hay trong chiến tranh bảo vệ Tổ quốc. Quân khu 4 có nhiệm vụ chiến lược: Vừa là hậu phương, vừa là tiền tuyến."
                    ]
                }
            },
            {
                type: 'spread',
                left: {
                    title: "SƯ ĐOÀN 324",
                    image: "https://images.unsplash.com/photo-1585007600263-ad1f301f2c27?q=80&w=1200&auto=format&fit=crop",
                    caption: "Sư đoàn 324 (Sư đoàn Ngự Bình) thành lập ngày 01/7/1955. Là đơn vị chủ lực mạnh, 2 lần Anh hùng LLVTND."
                },
                right: {
                    title: "TRUYỀN THỐNG VẺ VANG",
                    paragraphs: [
                        "Trải qua hàng chục năm chiến đấu, Sư đoàn đã tham gia giải phóng Huế, Đà Nẵng và góp phần quan trọng vào chiến dịch Hồ Chí Minh lịch sử.",
                        "Bản lĩnh 'Đoàn kết - Kiên cường - Đánh thắng' luôn là kim chỉ nam cho mọi hành động của cán bộ, chiến sĩ Sư đoàn qua các thời kỳ."
                    ]
                }
            }
        ];

        const DEVELOPMENT_TIMELINE = [
            {
                year: "15/10/1945",
                title: "Thành lập Chiến khu 4",
                desc: "Tiền thân của Quân khu 4 ngày nay, được thành lập ngay sau Cách mạng Tháng Tám để bảo vệ chính quyền non trẻ tại khu vực Bắc Trung Bộ.",
                icon: "⭐"
            },
            {
                year: "1946 - 1954",
                title: "Kháng chiến chống Pháp",
                desc: "Xây dựng dải đất miền Trung thành hậu phương vững chắc, đồng thời là tiền tuyến trực tiếp đối đầu với thực dân Pháp.",
                icon: "⚔️"
            },
            {
                year: "01/7/1955",
                title: "Thành lập Sư đoàn 324",
                desc: "Tại huyện Tĩnh Gia, tỉnh Thanh Hóa, Sư đoàn 324 (Đoàn Ngự Bình) chính thức ra đời, trở thành đấm thép của Quân đội ta.",
                icon: "🛡️"
            },
            {
                year: "1966 - 1972",
                title: "Chiến trường Trị - Thiên",
                desc: "Đơn vị lập nhiều chiến công vang dội tại Quảng Trị, Thừa Thiên Huế, tiêu biểu là chiến dịch Đường 9 - Nam Lào.",
                icon: "🚩"
            },
            {
                year: "1975",
                title: "Tổng tiến công mùa Xuân",
                desc: "Tham gia giải phóng Huế, Đà Nẵng và tiến vào Sài Gòn, góp phần quan trọng vào ngày thống nhất đất nước.",
                icon: "✌️"
            },
            {
                year: "Hiện nay",
                title: "Xây dựng và Bảo vệ",
                desc: "Quân khu 4 và Sư đoàn 324 tiếp tục phát huy truyền thống, xây dựng đơn vị chính quy, tinh nhuệ, hiện đại, bảo vệ vững chắc chủ quyền Tổ quốc.",
                icon: "🏢"
            }
        ];

        let currentPage = 0;
        let chatMessages = [];

        // --- Core Functions ---
        window.navigateTo = function(section) {
            const area = document.getElementById('content-area');
            if (section === 'HOME') renderHome(area);
            else if (section === 'BOOK') renderBook(area);
            else if (section === 'AI') renderAI(area);
            else if (section === 'DEVELOPMENT') renderDevelopment(area);
            
            // Update active nav links
            document.querySelectorAll('.nav-link').forEach(link => {
                const label = section === 'HOME' ? 'Trang chủ' : 
                              section === 'BOOK' ? 'Sách sử' : 
                              section === 'DEVELOPMENT' ? 'Lịch sử phát triển' : 'AI';
                if (link.textContent.includes(label)) {
                    link.classList.add('text-yellow-500', 'border-b-2', 'border-yellow-500', 'pb-1');
                    link.classList.remove('text-gray-400');
                } else {
                    link.classList.remove('text-yellow-500', 'border-b-2', 'border-yellow-500', 'pb-1');
                    link.classList.add('text-gray-400');
                }
            });
            window.scrollTo(0, 0);
        };

        function playFlipSound() {
            const sound = document.getElementById('flip-sound');
            sound.currentTime = 0;
            sound.play().catch(() => {});
        }

        function renderHome(container) {
            container.innerHTML = `
                <div class="space-y-32 pb-32">
                    <section class="relative h-[85vh] flex items-center justify-center overflow-hidden mx-6 mt-6 rounded-[3.5rem] shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1590133325985-2c6a9a59d8b2?q=80&w=2000&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover grayscale brightness-[0.25]" alt="Hero" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/30 to-transparent"></div>
                        <div class="relative text-center max-w-6xl px-10 space-y-10">
                            <div class="inline-block px-6 py-2 border-2 border-yellow-600/30 bg-black/40 backdrop-blur-xl rounded-full text-yellow-500 font-bold tracking-[0.4em] uppercase text-[10px]">
                                Truyền thống anh hùng - Khí phách Ngự Bình
                            </div>
                            <h1 class="text-8xl md:text-[10rem] font-serif font-bold text-white tracking-tighter leading-none italic">QUÂN KHU 4</h1>
                            <h3 class="text-2xl md:text-4xl text-gray-300 font-serif italic max-w-4xl mx-auto leading-tight">
                                "Địa bàn chiến lược trọng yếu, tiền tuyến của mọi tiền tuyến"
                            </h3>
                            <div class="flex justify-center gap-6 pt-10">
                                <button onclick="document.getElementById('home-book').scrollIntoView({behavior: 'smooth'})" class="btn-military px-14 py-5 rounded-full font-bold text-xl shadow-2xl">
                                    Mở sử liệu điện tử
                                </button>
                                <button onclick="document.getElementById('home-development').scrollIntoView({behavior: 'smooth'})" class="bg-white/10 backdrop-blur-2xl border border-white/20 text-white px-14 py-5 rounded-full font-bold text-xl hover:bg-white/20 transition-all">
                                    Tiến trình phát triển
                                </button>
                            </div>
                        </div>
                    </section>
                    <section class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-12">
                        <div class="bg-white/5 p-16 rounded-[3.5rem] border border-white/10 text-center hover:bg-white/10 transition-all cursor-default">
                            <p class="text-yellow-600 font-bold tracking-[0.3em] text-[10px] mb-6 uppercase">Thành lập</p>
                            <div class="text-8xl font-serif font-bold text-white italic mb-6 leading-none">1945</div>
                            <p class="text-gray-400 font-serif text-lg italic">Nơi khởi nguồn hào khí miền Trung</p>
                        </div>
                        <div class="bg-white/5 p-16 rounded-[3.5rem] border border-white/10 text-center hover:bg-white/10 transition-all cursor-default">
                            <p class="text-yellow-600 font-bold tracking-[0.3em] text-[10px] mb-6 uppercase">Sư đoàn</p>
                            <div class="text-8xl font-serif font-bold text-white italic mb-6 leading-none">324</div>
                            <p class="text-gray-400 font-serif text-lg italic">Đoàn kết - Kiên cường - Đánh thắng</p>
                        </div>
                        <div class="bg-white/5 p-16 rounded-[3.5rem] border border-white/10 text-center hover:bg-white/10 transition-all cursor-default">
                            <p class="text-yellow-600 font-bold tracking-[0.3em] text-[10px] mb-6 uppercase">Anh hùng</p>
                            <div class="text-8xl font-serif font-bold text-white italic mb-6 leading-none">02 LẦN</div>
                            <p class="text-gray-400 font-serif text-lg italic">Vinh dự tự hào quân đội ta</p>
                        </div>
                    </section>

                    <div id="home-development"></div>
                    <div id="home-book"></div>
                    <div id="home-ai"></div>
                </div>
            `;

            renderDevelopment(document.getElementById('home-development'));
            renderBook(document.getElementById('home-book'));
            renderAI(document.getElementById('home-ai'));
        }

        function renderDevelopment(container) {
            container.innerHTML = `
                <div class="max-w-6xl mx-auto py-20 px-6">
                    <div class="text-center mb-24">
                        <h2 class="text-6xl font-serif italic font-bold text-white mb-6">Lịch sử Phát triển</h2>
                        <div class="w-24 h-1 bg-yellow-600 mx-auto mb-6"></div>
                        <p class="text-gray-400 font-serif text-xl max-w-2xl mx-auto">Chặng đường hơn 70 năm xây dựng, chiến đấu và trưởng thành của lực lượng vũ trang Quân khu 4.</p>
                    </div>

                    <div class="relative">
                        <!-- Vertical line -->
                        <div class="absolute left-1/2 transform -translate-x-1/2 h-full timeline-line"></div>

                        <div class="space-y-24">
                            ${DEVELOPMENT_TIMELINE.map((item, index) => `
                                <div class="relative flex items-center justify-between w-full ${index % 2 === 0 ? 'flex-row-reverse' : ''}">
                                    <div class="w-5/12">
                                        <div class="bg-white/5 p-10 rounded-[2.5rem] border border-white/10 hover:border-yellow-600/50 transition-all group shadow-xl">
                                            <div class="text-yellow-500 font-serif font-bold text-3xl italic mb-4">${item.year}</div>
                                            <h4 class="text-2xl font-bold text-white mb-4 uppercase tracking-tighter">${item.title}</h4>
                                            <p class="text-gray-400 font-serif text-lg leading-relaxed">${item.desc}</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Center Dot -->
                                    <div class="absolute left-1/2 transform -translate-x-1/2 w-12 h-12 bg-red-800 rounded-full timeline-dot z-10 flex items-center justify-center text-xl">
                                        ${item.icon}
                                    </div>

                                    <div class="w-5/12"></div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `;
        }

        function renderBook(container) {
            const page = BOOK_PAGES[currentPage];
            let innerHTML = '';

            if (page.type === 'cover') {
                innerHTML = `
                    <div class="w-full h-full relative flex flex-col items-center justify-center text-center p-20 bg-gray-900">
                        <img src="${page.image}" class="absolute inset-0 w-full h-full object-cover opacity-30 grayscale" alt="" />
                        <div class="relative z-10 border-8 border-double border-yellow-700/50 p-12 bg-black/40 backdrop-blur-sm shadow-2xl">
                            <h1 class="text-7xl font-serif italic text-white mb-6 tracking-widest leading-tight">${page.title}</h1>
                            <div class="w-32 h-1 bg-yellow-600 mx-auto mb-8"></div>
                            <h2 class="text-2xl font-bold text-yellow-500 tracking-[0.3em] uppercase">${page.subtitle}</h2>
                        </div>
                    </div>
                `;
            } else {
                innerHTML = `
                    <div class="flex w-full h-full relative">
                        <div class="absolute left-1/2 top-0 bottom-0 w-24 -translate-x-1/2 center-fold z-10 pointer-events-none"></div>
                        <div class="w-1/2 p-12 flex flex-col page-left-edge border-r border-black/5">
                            <img src="${page.left.image}" class="w-full h-72 object-cover shadow-xl grayscale mb-10" alt="" />
                            <p class="mt-auto font-serif italic text-xl text-center text-gray-700 leading-relaxed border-t border-gray-200 pt-8">
                                "${page.left.caption}"
                            </p>
                        </div>
                        <div class="w-1/2 p-12 flex flex-col page-right-edge overflow-y-auto">
                            <h3 class="text-xs font-bold text-yellow-800 tracking-[0.3em] mb-12 uppercase border-b border-yellow-800/20 pb-4 self-start">
                                ${page.right.title}
                            </h3>
                            <div class="space-y-8">
                                ${page.right.paragraphs.map(p => `<p class="font-serif text-[19px] leading-relaxed text-gray-800 text-justify first-letter:text-5xl first-letter:font-bold first-letter:mr-2 first-letter:float-left first-letter:text-red-900">${p}</p>`).join('')}
                            </div>
                            <div class="mt-auto pt-10 text-right text-xs text-gray-400 font-bold italic tracking-widest uppercase">Trang ${currentPage + 1}</div>
                        </div>
                    </div>
                `;
            }

            container.innerHTML = `
                <div class="flex flex-col items-center py-10 px-4 min-h-[80vh]">
                    <div class="relative w-full max-w-6xl aspect-[1.6/1] rounded-sm book-shadow overflow-hidden flex page-paper border border-black/10" id="book-container">
                        <button onclick="changePage(-1)" class="absolute left-0 inset-y-0 w-20 z-20 flex items-center justify-center group ${currentPage === 0 ? 'hidden' : ''}">
                            <div class="p-4 rounded-full bg-black/5 group-hover:bg-black/10 transition-all text-gray-400">❮</div>
                        </button>
                        <button onclick="changePage(1)" class="absolute right-0 inset-y-0 w-20 z-20 flex items-center justify-center group ${currentPage === BOOK_PAGES.length - 1 ? 'hidden' : ''}">
                            <div class="p-4 rounded-full bg-black/5 group-hover:bg-black/10 transition-all text-gray-400">❯</div>
                        </button>
                        ${innerHTML}
                    </div>
                    <div class="mt-10 bg-white/95 rounded-full px-8 py-3 flex items-center space-x-8 shadow-2xl border border-gray-200 z-10">
                        <span class="text-xs font-bold text-gray-400 tracking-tighter">${currentPage + 1} / ${BOOK_PAGES.length}</span>
                        <div class="flex space-x-4 border-l pl-8 border-gray-200">
                           <button onclick="changePage(-1)" class="p-2 hover:bg-gray-100 rounded-full text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7"/></svg></button>
                           <button onclick="changePage(1)" class="p-2 hover:bg-gray-100 rounded-full text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7"/></svg></button>
                        </div>
                    </div>
                </div>
            `;
        }

        window.changePage = function(dir) {
            const next = currentPage + dir;
            if (next >= 0 && next < BOOK_PAGES.length) {
                playFlipSound();
                currentPage = next;
                const container = document.getElementById('home-book') || document.getElementById('content-area');
                renderBook(container);
            }
        };

        function renderAI(container) {
            container.innerHTML = `
                <div class="max-w-4xl mx-auto h-[650px] flex flex-col bg-white/5 backdrop-blur-3xl rounded-[2.5rem] border border-white/10 overflow-hidden shadow-2xl mt-10">
                    <div class="bg-red-800 p-8 flex items-center space-x-5 shadow-lg">
                        <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center text-white text-xl font-bold">AI</div>
                        <div>
                            <h4 class="font-bold text-white text-lg leading-none">Cố vấn Lịch sử 324</h4>
                            <p class="text-[10px] text-yellow-100 uppercase tracking-widest font-bold mt-2">Đang trực tuyến</p>
                        </div>
                    </div>
                    <div id="chat-window" class="flex-1 overflow-y-auto p-10 space-y-4 flex flex-col scrollbar-hide bg-black/20">
                        ${chatMessages.length === 0 ? `
                            <div class="text-center py-20 opacity-20 flex flex-col items-center">
                                <svg class="w-20 h-20 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13"/></svg>
                                <p class="font-serif italic text-2xl">Mời đồng chí đặt câu hỏi về truyền thống đơn vị...</p>
                            </div>
                        ` : chatMessages.map(m => `
                            <div class="chat-bubble ${m.role === 'user' ? 'chat-user' : 'chat-ai'}">
                                <p class="font-serif text-lg">${m.text}</p>
                            </div>
                        `).join('')}
                    </div>
                    <div class="p-8 bg-black/40 border-t border-white/5 flex space-x-4">
                        <input id="ai-input" type="text" placeholder="Nhập câu hỏi..." 
                            class="flex-1 bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-white focus:outline-none focus:ring-2 focus:ring-red-800"
                            onkeydown="if(event.key === 'Enter') handleAskAI()">
                        <button onclick="handleAskAI()" id="ai-send-btn" class="bg-red-800 text-white px-10 rounded-2xl font-bold hover:bg-red-700 transition-all">Gửi</button>
                    </div>
                </div>
            `;
            const chatWin = document.getElementById('chat-window');
            chatWin.scrollTop = chatWin.scrollHeight;
        }

        window.handleAskAI = async function() {
            const inputEl = document.getElementById('ai-input');
            const prompt = inputEl.value.trim();
            if (!prompt) return;

            inputEl.value = '';
            chatMessages.push({ role: 'user', text: prompt });
            
            const container = document.getElementById('home-ai') || document.getElementById('content-area');
            renderAI(container);

            const btn = document.getElementById('ai-send-btn');
            btn.disabled = true;
            btn.textContent = '...';

            try {
                const ai = new GoogleGenAI({ apiKey: "{{ env('GOOGLE_API_KEY') }}" });
                const response = await ai.models.generateContent({
                    model: 'gemini-1.5-flash',
                    contents: prompt,
                    config: {
                        systemInstruction: "Bạn là chuyên gia lịch sử Quân khu 4 và Sư đoàn 324. Trả lời trang trọng, hào hùng và chính xác.",
                        temperature: 0.7,
                    }
                });
                chatMessages.push({ role: 'ai', text: response.text });
            } catch (err) {
                chatMessages.push({ role: 'ai', text: "Hệ thống đang bận, đồng chí vui lòng thử lại sau." });
            } finally {
                btn.disabled = false;
                btn.textContent = 'Gửi';
                renderAI(container);
            }
        };

        // --- Init ---
        navigateTo('HOME');
    </script>
</body>
</html>
