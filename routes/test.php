<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DefenseNews VN - Tin Tức Quân Sự</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700;900&family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              military: {
                red: '#8B0000', // Dark Red
                lightRed: '#B22222',
                gray: '#2F4F4F',
                cream: '#F5F5DC',
              }
            },
            fontFamily: {
              sans: ['Roboto', 'sans-serif'],
              serif: ['Merriweather', 'serif'],
            }
          }
        }
      }
    </script>
    <script type="importmap">
    {
      "imports": {
        "@google/genai": "https://esm.sh/@google/genai@^1.33.0"
      }
    }
    </script>
  </head>
  <body class="font-sans text-slate-800">
    <div id="app">
        <!-- App content injected by JS -->
    </div>

    <script type="module">
      import { GoogleGenAI } from "@google/genai";

      // --- 1. Hardcoded Data (Dữ liệu giả lập cứng) ---

      const Categories = {
        LUC_QUAN: 'Lục Quân',
        HAI_QUAN: 'Hải Quân',
        KHONG_QUAN: 'Không Quân',
        CONG_NGHE: 'Công Nghệ QP',
        QUOC_TE: 'Quốc Tế'
      };

      const Articles = [
        {
          id: '1',
          title: 'Việt Nam Tăng Cường Năng Lực Phòng Thủ Bờ Biển Với Hệ Thống Radar Mới',
          excerpt: 'Hệ thống radar cảnh báo sớm thế hệ mới đã chính thức được triển khai tại các điểm đảo trọng yếu, nâng cao đáng kể khả năng giám sát vùng biển.',
          category: Categories.HAI_QUAN,
          author: 'Minh Quân',
          timestamp: '2 giờ trước',
          imageUrl: 'https://picsum.photos/1200/800?grayscale',
          isBreaking: true,
        },
        {
          id: '2',
          title: 'Lục Quân Nghiệm Thu Dòng Xe Thiết Giáp Nội Địa Thế Hệ Mới',
          excerpt: 'Dòng xe thiết giáp chở quân do nền công nghiệp quốc phòng trong nước tự chủ thiết kế và chế tạo đã vượt qua các bài kiểm tra thực địa khắc nghiệt.',
          category: Categories.LUC_QUAN,
          author: 'Trần Bình',
          timestamp: '4 giờ trước',
          imageUrl: 'https://picsum.photos/800/600?grayscale',
        },
        {
          id: '3',
          title: 'Phân Tích: Xu Hướng Chiến Tranh Drone Trong Thập Kỷ Tới',
          excerpt: 'Các chuyên gia quân sự nhận định về vai trò thay đổi cuộc chơi của máy bay không người lái trong các xung đột hiện đại và đối sách cần thiết.',
          category: Categories.CONG_NGHE,
          author: 'Lê Thanh',
          timestamp: '5 giờ trước',
          imageUrl: 'https://picsum.photos/800/601?grayscale',
        },
        {
          id: '4',
          title: 'Không Quân Thực Hiện Diễn Tập Bắn Đạn Thật Quy Mô Lớn',
          excerpt: 'Trung đoàn không quân 935 vừa hoàn thành xuất sắc nhiệm vụ diễn tập bắn đạn thật, đảm bảo sẵn sàng chiến đấu trong mọi tình huống.',
          category: Categories.KHONG_QUAN,
          author: 'Nguyễn Phong',
          timestamp: '1 ngày trước',
          imageUrl: 'https://picsum.photos/800/602?grayscale',
        },
        {
          id: '5',
          title: 'Căng Thẳng Địa Chính Trị Khu Vực Trung Đông Leo Thang',
          excerpt: 'Cập nhật diễn biến mới nhất về tình hình an ninh tại khu vực Trung Đông và những tác động có thể có đến an ninh năng lượng toàn cầu.',
          category: Categories.QUOC_TE,
          author: 'Ban Quốc Tế',
          timestamp: '1 ngày trước',
          imageUrl: 'https://picsum.photos/800/603?grayscale',
        },
        {
          id: '6',
          title: 'Hợp Tác Quốc Phòng Việt Nam - Ấn Độ Đạt Tầm Cao Mới',
          excerpt: 'Hai bên nhất trí tăng cường trao đổi đoàn cấp cao và hợp tác đào tạo sĩ quan chỉ huy tham mưu.',
          category: Categories.QUOC_TE,
          author: 'Ban Quốc Tế',
          timestamp: '2 ngày trước',
          imageUrl: 'https://picsum.photos/800/604?grayscale',
        },
      ];

      // --- 2. State & Config ---
      const ai = new GoogleGenAI({ apiKey: process.env.API_KEY });

      let state = {
        activeCategory: 'ALL',
        isMenuOpen: false,
        modalTopic: null,
        modalContent: '',
        modalLoading: false,
        // Auth State
        isAuthOpen: false,
        authMode: 'LOGIN', // 'LOGIN' or 'REGISTER'
        user: null, // { name: 'Comrade' } if logged in
        authLoading: false
      };

      // --- 3. Render Functions (HTML Generation) ---

      function render() {
        const app = document.getElementById('app');
        
        // Filter Logic
        const filteredArticles = state.activeCategory === 'ALL' 
          ? Articles 
          : Articles.filter(a => a.category === state.activeCategory);
        
        const featured = filteredArticles[0];
        const list = filteredArticles.slice(1);

        // Template Assembly
        app.innerHTML = `
          ${renderHeader()}
          <main>
            ${featured ? renderFeatured(featured) : ''}
            
            <div class="container mx-auto px-4 py-12">
              <div class="flex flex-col lg:flex-row gap-12">
                
                <!-- Main Feed -->
                <div class="lg:w-2/3">
                  <div class="flex items-center justify-between mb-8 border-b-2 border-military-red pb-2">
                    <h2 class="text-2xl font-bold uppercase text-military-red tracking-wide">
                      ${state.activeCategory === 'ALL' ? 'Tin Nóng 24h' : state.activeCategory}
                    </h2>
                    <span class="text-xs font-bold text-gray-500 cursor-pointer hover:text-red-700" onclick="updateCategory('ALL')">XEM TẤT CẢ +</span>
                  </div>

                  ${list.length > 0 ? 
                    `<div class="grid md:grid-cols-2 gap-8">
                        ${list.map(article => renderCard(article)).join('')}
                    </div>` 
                    : 
                    `<div class="p-12 text-center bg-white border border-dashed border-gray-300">
                        <p class="text-gray-500">Không có tin tức nào trong danh mục này.</p>
                    </div>`
                  }
                </div>

                <!-- Sidebar -->
                ${renderSidebar()}
              </div>
            </div>
          </main>
          ${renderFooter()}
          ${state.modalTopic ? renderModal() : ''}
          ${state.isAuthOpen ? renderAuthModal() : ''}
        `;
      }

      function renderHeader() {
        const dateStr = new Date().toLocaleDateString('vi-VN', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        
        const navLinks = Object.values(Categories).map(cat => `
          <button 
            onclick="updateCategory('${cat}')"
            class="text-sm font-bold uppercase tracking-wide hover:text-yellow-400 border-b-2 border-transparent hover:border-yellow-400 py-2 transition-all ${state.activeCategory === cat ? 'text-yellow-400 border-yellow-400' : ''}"
          >
            ${cat}
          </button>
        `).join('');

        const mobileLinks = Object.values(Categories).map(cat => `
          <button 
             onclick="updateCategory('${cat}'); toggleMenu()"
             class="block w-full text-left px-4 py-3 text-sm font-bold uppercase tracking-wide hover:bg-red-800 border-b border-red-800/50"
          >
            ${cat}
          </button>
        `).join('');

        const authButtons = state.user 
          ? `
            <div class="flex items-center gap-3">
              <span class="text-xs text-yellow-400 font-bold uppercase tracking-wider">Chào, ${state.user.name}</span>
              <button onclick="logout()" class="text-xs font-bold uppercase hover:text-white text-gray-300">Đăng xuất</button>
            </div>
          `
          : `
            <button onclick="openAuth('LOGIN')" class="text-white hover:text-yellow-400 text-xs font-bold uppercase tracking-widest transition mr-4">
              Đăng Nhập
            </button>
            <button onclick="openAuth('REGISTER')" class="bg-white text-military-red px-4 py-1 text-xs font-bold uppercase tracking-widest hover:bg-gray-200 transition">
              Đăng Ký
            </button>
          `;

        return `
          <header class="sticky top-0 z-50 bg-military-red text-white shadow-lg border-b-4 border-yellow-500">
            <div class="bg-black text-xs py-1 px-4 flex justify-between items-center tracking-widest uppercase">
              <span class="opacity-80">${dateStr}</span>
              <span class="text-yellow-500 font-bold animate-pulse">CẬP NHẬT: TÌNH HÌNH BIÊN GIỚI MỚI NHẤT</span>
            </div>

            <div class="container mx-auto px-4">
              <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex flex-col items-start cursor-pointer group" onclick="updateCategory('ALL')">
                  <h1 class="text-3xl font-serif font-black tracking-tighter leading-none group-hover:text-yellow-400 transition-colors">
                    DEFENSE<span class="text-yellow-500">NEWS</span>
                  </h1>
                  <span class="text-[10px] tracking-[0.3em] font-sans text-gray-300 uppercase">Tin Tức Quân Sự Việt Nam</span>
                </div>

                <!-- Desktop Nav -->
                <nav class="hidden md:flex space-x-8">
                  ${navLinks}
                </nav>

                <div class="hidden md:flex items-center">
                   ${authButtons}
                </div>

                <!-- Mobile Menu Btn -->
                <button class="md:hidden text-white focus:outline-none" onclick="toggleMenu()">
                  <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="square" strokeLinejoin="miter" strokeWidth="2" d="M4 6h16M4 12h16M4 18h16"></path>
                  </svg>
                </button>
              </div>
            </div>

            <!-- Mobile Dropdown -->
            ${state.isMenuOpen ? `<div class="md:hidden bg-military-lightRed border-t border-red-800">${mobileLinks}</div>` : ''}
          </header>
        `;
      }

      function renderFeatured(article) {
        return `
          <div class="relative w-full h-[500px] bg-slate-900 group overflow-hidden">
            <div 
              class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
              style="background-image: url(${article.imageUrl})"
            ></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>

            <div class="absolute bottom-0 left-0 w-full p-6 md:p-10 lg:p-12 text-white">
              <div class="max-w-4xl">
                  <span class="inline-block bg-military-red px-3 py-1 text-xs font-bold uppercase tracking-widest mb-3">
                      ${article.category}
                  </span>
                  <h2 class="text-3xl md:text-5xl font-serif font-bold leading-tight mb-4 drop-shadow-lg">
                      ${article.title}
                  </h2>
                  <p class="text-gray-200 text-lg mb-6 line-clamp-2 md:line-clamp-none max-w-2xl font-light">
                      ${article.excerpt}
                  </p>
                  
                  <div class="flex flex-wrap gap-4">
                      <button class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 font-bold uppercase tracking-wider text-sm transition-colors flex items-center">
                          Đọc Chi Tiết
                          <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="square" strokeLinejoin="miter" strokeWidth="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                      </button>
                      <button 
                        onclick="openAnalyze('${article.title}')"
                        class="bg-transparent border border-white hover:bg-white hover:text-black text-white px-6 py-3 font-bold uppercase tracking-wider text-sm transition-all flex items-center"
                      >
                          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="square" strokeLinejoin="miter" strokeWidth="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                          Phân Tích AI
                      </button>
                  </div>
              </div>
            </div>
          </div>
        `;
      }

      function renderCard(article, compact = false) {
        if (compact) {
          return `
            <div class="flex gap-4 border-b border-gray-200 py-4 hover:bg-slate-50 transition p-2 cursor-pointer">
              <div class="w-24 h-24 flex-shrink-0 bg-gray-200 overflow-hidden">
                   <img src="${article.imageUrl}" alt="${article.title}" class="w-full h-full object-cover" />
              </div>
              <div>
                <span class="text-xs font-bold text-military-red uppercase">${article.category}</span>
                <h4 class="font-serif font-bold text-gray-800 leading-snug mt-1 hover:text-military-red transition-colors text-sm">
                  ${article.title}
                </h4>
                <span class="text-xs text-gray-400 mt-2 block">${article.timestamp}</span>
              </div>
            </div>
          `;
        }

        return `
          <div class="flex flex-col bg-white shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 group h-full">
            <div class="relative h-48 overflow-hidden">
              <img 
                  src="${article.imageUrl}" 
                  alt="${article.title}" 
                  class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
              />
              ${article.isBreaking ? 
                `<div class="absolute top-0 right-0 bg-red-600 text-white text-xs font-bold px-2 py-1 uppercase animate-pulse">Nóng</div>` 
                : ''}
            </div>
            <div class="p-5 flex flex-col flex-grow">
              <div class="flex items-center justify-between mb-2">
                  <span class="text-xs font-bold text-military-red uppercase tracking-wider">${article.category}</span>
                  <span class="text-xs text-gray-400">${article.timestamp}</span>
              </div>
              <h3 class="font-serif font-bold text-xl text-gray-900 mb-3 leading-tight group-hover:text-military-red transition-colors">
                  ${article.title}
              </h3>
              <p class="text-gray-600 text-sm line-clamp-3 mb-4 flex-grow font-light">
                  ${article.excerpt}
              </p>
              <button class="text-left text-xs font-bold uppercase tracking-widest text-slate-800 hover:text-military-red transition flex items-center mt-auto">
                  Xem thêm <span class="ml-1">→</span>
              </button>
            </div>
          </div>
        `;
      }

      function renderSidebar() {
        const mostRead = Articles.slice(0, 4).reverse().map(a => renderCard(a, true)).join('');
        
        return `
            <div class="lg:w-1/3 space-y-12">
              <!-- Widget: Most Read -->
              <div class="bg-white border border-gray-200 shadow-sm">
                <div class="bg-slate-800 text-white px-4 py-3 border-l-4 border-military-red">
                    <h3 class="font-bold uppercase tracking-wider text-sm">Đọc Nhiều Nhất</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    ${mostRead}
                </div>
              </div>

              <!-- Widget: Newsletter -->
              <div class="bg-military-red text-white p-6 text-center">
                  <h3 class="text-xl font-serif font-bold mb-2">Bản Tin Quân Sự</h3>
                  <p class="text-sm text-red-100 mb-4 font-light">Nhận phân tích chiến lược hàng tuần vào email của bạn.</p>
                  <input type="email" placeholder="Email của bạn" class="w-full px-4 py-2 text-slate-900 text-sm mb-3 focus:outline-none" />
                  <button class="w-full bg-slate-900 hover:bg-black text-white py-2 text-xs font-bold uppercase tracking-widest transition">
                      Đăng Ký Ngay
                  </button>
              </div>

               <!-- Widget: Multimedia -->
              <div>
                 <div class="flex items-center justify-between mb-4 border-b border-gray-300 pb-2">
                    <h3 class="font-bold uppercase text-slate-700 text-sm">Thư Viện Ảnh</h3>
                 </div>
                 <div class="grid grid-cols-2 gap-2">
                    <div class="aspect-square bg-gray-300 cursor-pointer hover:opacity-80 transition">
                         <img src="https://picsum.photos/300/300?random=1&grayscale" class="w-full h-full object-cover" />
                    </div>
                    <div class="aspect-square bg-gray-300 cursor-pointer hover:opacity-80 transition">
                         <img src="https://picsum.photos/300/300?random=2&grayscale" class="w-full h-full object-cover" />
                    </div>
                    <div class="aspect-square bg-gray-300 cursor-pointer hover:opacity-80 transition">
                         <img src="https://picsum.photos/300/300?random=3&grayscale" class="w-full h-full object-cover" />
                    </div>
                    <div class="aspect-square bg-gray-300 cursor-pointer hover:opacity-80 transition">
                         <img src="https://picsum.photos/300/300?random=4&grayscale" class="w-full h-full object-cover" />
                    </div>
                 </div>
              </div>
            </div>
        `;
      }

      function renderFooter() {
        return `
          <footer class="bg-slate-900 text-white pt-16 pb-8 border-t-8 border-military-red">
            <div class="container mx-auto px-4 grid md:grid-cols-4 gap-8 mb-12">
                <div>
                    <h2 class="text-2xl font-serif font-black mb-6 text-white">DEFENSE<span class="text-military-red">NEWS</span></h2>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Trang thông tin chuyên sâu về quân sự, quốc phòng và an ninh. Cập nhật liên tục, phân tích đa chiều, góc nhìn chuyên gia.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold uppercase tracking-widest mb-6 text-sm text-gray-300">Danh Mục</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        ${Object.values(Categories).map(cat => `<li><a href="#" class="hover:text-military-red transition">${cat}</a></li>`).join('')}
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold uppercase tracking-widest mb-6 text-sm text-gray-300">Liên Hệ</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li>Tòa soạn: Hà Nội, Việt Nam</li>
                        <li>Email: contact@defensenews.vn</li>
                        <li>Hotline: (+84) 999 888 777</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold uppercase tracking-widest mb-6 text-sm text-gray-300">Theo Dõi</h4>
                    <div class="flex space-x-4">
                        <div class="w-10 h-10 bg-gray-800 flex items-center justify-center hover:bg-military-red transition cursor-pointer">FB</div>
                        <div class="w-10 h-10 bg-gray-800 flex items-center justify-center hover:bg-military-red transition cursor-pointer">YT</div>
                        <div class="w-10 h-10 bg-gray-800 flex items-center justify-center hover:bg-military-red transition cursor-pointer">X</div>
                    </div>
                </div>
            </div>
            <div class="text-center border-t border-gray-800 pt-8 text-xs text-gray-500 uppercase tracking-widest">
                &copy; 2024 DefenseNews VN. All rights reserved.
            </div>
          </footer>
        `;
      }

      function renderAuthModal() {
        const isLogin = state.authMode === 'LOGIN';
        
        return `
          <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/90 backdrop-blur-sm animate-fade-in">
             <div class="relative w-full max-w-4xl bg-white shadow-2xl flex overflow-hidden min-h-[600px]">
                <!-- Close Button -->
                <button onclick="closeAuth()" class="absolute top-4 right-4 z-10 text-gray-400 hover:text-military-red">
                   <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="square" strokeLinejoin="miter" strokeWidth="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <!-- Left Side: Image -->
                <div class="hidden md:block w-1/2 bg-slate-800 relative">
                   <img src="https://images.unsplash.com/photo-1542282088-72c9c27ed0cd?q=80&w=1932&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-overlay" />
                   <div class="absolute inset-0 bg-gradient-to-t from-military-red/80 to-slate-900/60 flex flex-col justify-end p-12 text-white">
                      <h2 class="text-4xl font-serif font-black uppercase mb-4 leading-none">Tham Gia<br/>Mạng Lưới</h2>
                      <p class="text-sm text-gray-200 font-light opacity-80">
                         Truy cập các bản tin tình báo độc quyền, phân tích chuyên sâu và bình luận từ các chuyên gia hàng đầu.
                      </p>
                   </div>
                </div>

                <!-- Right Side: Form -->
                <div class="w-full md:w-1/2 p-12 flex flex-col justify-center bg-white relative">
                   <!-- Tabs -->
                   <div class="flex border-b border-gray-200 mb-8">
                      <button onclick="setAuthMode('LOGIN')" class="flex-1 pb-4 text-center text-xs font-bold uppercase tracking-widest transition-colors ${isLogin ? 'text-military-red border-b-2 border-military-red' : 'text-gray-400 hover:text-gray-600'}">
                         Đăng Nhập
                      </button>
                      <button onclick="setAuthMode('REGISTER')" class="flex-1 pb-4 text-center text-xs font-bold uppercase tracking-widest transition-colors ${!isLogin ? 'text-military-red border-b-2 border-military-red' : 'text-gray-400 hover:text-gray-600'}">
                         Đăng Ký
                      </button>
                   </div>

                   <form onsubmit="handleAuthSubmit(event)">
                      <div class="space-y-6">
                         ${!isLogin ? `
                           <div>
                              <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Họ và Tên</label>
                              <input type="text" required class="w-full bg-gray-50 border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-military-red focus:ring-1 focus:ring-military-red transition-all" placeholder="NHẬP HỌ TÊN CỦA BẠN" />
                           </div>
                         ` : ''}
                         
                         <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Địa chỉ Email</label>
                            <input type="email" required class="w-full bg-gray-50 border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-military-red focus:ring-1 focus:ring-military-red transition-all" placeholder="EMAIL QUÂN SỰ / CÁ NHÂN" />
                         </div>

                         <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Mật khẩu</label>
                            <input type="password" required class="w-full bg-gray-50 border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-military-red focus:ring-1 focus:ring-military-red transition-all" placeholder="••••••••" />
                         </div>

                         ${!isLogin ? `
                           <div>
                              <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Xác nhận Mật khẩu</label>
                              <input type="password" required class="w-full bg-gray-50 border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-military-red focus:ring-1 focus:ring-military-red transition-all" placeholder="••••••••" />
                           </div>
                         ` : ''}

                         <div class="pt-4">
                            <button type="submit" class="w-full bg-military-red hover:bg-red-900 text-white font-bold uppercase tracking-widest py-4 text-sm transition-all flex justify-center items-center shadow-lg hover:shadow-xl">
                               ${state.authLoading ? 
                                 `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> ĐANG XỬ LÝ...` 
                                 : (isLogin ? 'Đăng Nhập Hệ Thống' : 'Tạo Tài Khoản Mới')
                               }
                            </button>
                         </div>
                      </div>
                   </form>

                   <div class="mt-6 text-center">
                      <p class="text-xs text-gray-400">
                         Bằng việc đăng nhập, bạn đồng ý với <a href="#" class="underline hover:text-military-red">Điều khoản bảo mật</a> của DefenseNews.
                      </p>
                   </div>
                </div>
             </div>
          </div>
        `;
      }

      function renderModal() {
        return `
          <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
            <div class="bg-slate-50 max-w-2xl w-full shadow-2xl overflow-hidden border-t-4 border-military-red">
              <div class="bg-white p-6 border-b border-gray-200 flex justify-between items-center">
                  <div class="flex items-center gap-2">
                      <div class="w-8 h-8 bg-military-red flex items-center justify-center text-white">
                          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="square" strokeLinejoin="miter" strokeWidth="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                      </div>
                      <div>
                          <h3 class="text-xl font-bold text-gray-900 uppercase tracking-wide">Phân Tích Chiến Lược</h3>
                          <p class="text-xs text-gray-500">Powered by Gemini AI</p>
                      </div>
                  </div>
                  <button onclick="closeModal()" class="text-gray-400 hover:text-red-600">
                      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                  </button>
              </div>
              
              <div class="p-8">
                  <h4 class="text-lg font-serif font-bold text-military-red mb-4 border-l-4 border-military-red pl-4">
                      Chủ đề: ${state.modalTopic}
                  </h4>
                  
                  <div class="bg-white border border-gray-200 p-6 min-h-[200px]">
                      ${state.modalLoading ? `
                          <div class="flex flex-col items-center justify-center h-full space-y-4">
                              <div class="w-10 h-10 border-4 border-military-red border-t-transparent rounded-full animate-spin"></div>
                              <span class="text-sm font-bold text-gray-500 animate-pulse uppercase tracking-widest">Đang kết nối dữ liệu tình báo...</span>
                          </div>
                      ` : `
                          <div class="prose prose-red max-w-none">
                              <p class="text-gray-800 leading-relaxed font-light text-justify">
                                  ${state.modalContent}
                              </p>
                          </div>
                      `}
                  </div>
                  
                  <div class="mt-6 flex justify-end">
                       <button 
                          onclick="closeModal()"
                          class="bg-gray-800 hover:bg-gray-900 text-white px-5 py-2 text-sm font-bold uppercase tracking-wider"
                       >
                          Đóng Báo Cáo
                       </button>
                  </div>
              </div>
            </div>
          </div>
        `;
      }

      // --- 4. Event Handlers (Exposed to Global Scope) ---

      window.updateCategory = (cat) => {
        state.activeCategory = cat;
        render();
      };

      window.toggleMenu = () => {
        state.isMenuOpen = !state.isMenuOpen;
        render();
      };

      window.openAnalyze = async (topic) => {
        state.modalTopic = topic;
        state.modalLoading = true;
        state.modalContent = '';
        render(); // Show modal with loading state

        try {
          const response = await ai.models.generateContent({
            model: 'gemini-2.5-flash',
            contents: `Phân tích ngắn gọn (dưới 150 từ) về chủ đề quân sự sau đây dưới góc độ chuyên gia chiến lược: "${topic}". Tập trung vào khía cạnh kỹ thuật hoặc địa chính trị.`,
            config: {
              systemInstruction: "Bạn là một chuyên gia phân tích quân sự và quốc phòng kỳ cựu. Văn phong nghiêm túc, chính xác, khách quan.",
            }
          });
          state.modalContent = response.text || "Không có dữ liệu.";
        } catch (e) {
          console.error(e);
          state.modalContent = "Hệ thống phân tích đang bảo trì. Vui lòng thử lại sau.";
        } finally {
          state.modalLoading = false;
          render(); // Update with content
        }
      };

      window.closeModal = () => {
        state.modalTopic = null;
        render();
      };

      // --- Auth Handlers ---
      window.openAuth = (mode) => {
        state.authMode = mode;
        state.isAuthOpen = true;
        render();
      };

      window.closeAuth = () => {
        state.isAuthOpen = false;
        render();
      };

      window.setAuthMode = (mode) => {
        state.authMode = mode;
        render();
      };

      window.handleAuthSubmit = (e) => {
        e.preventDefault();
        state.authLoading = true;
        render();

        // Simulate API delay
        setTimeout(() => {
          state.authLoading = false;
          state.user = { name: 'Chỉ Huy' }; // Mock User
          state.isAuthOpen = false;
          render();
        }, 1500);
      };

      window.logout = () => {
        state.user = null;
        render();
      }

      // --- 5. Initial Boot ---
      render();
    </script>
  </body>
</html>