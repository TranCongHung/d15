<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DefenseNews Admin Portal</title>
    
    {{-- 1. Thư viện Tailwind CSS (CDN) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- 2. Font chữ --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700;900&family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">
    
    {{-- 3. Cấu hình Tailwind (Sẽ tách riêng ở mục 2) --}}
    <script>
      tailwind.config = {
    theme: {
        extend: {
            colors: {
                military: {
                    red: '#8B0000',
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
</head>
<body class="bg-gray-100 font-sans text-slate-800">
    <div id="admin-app" class="flex h-screen overflow-hidden">
        <aside class="w-64 bg-slate-900 text-white flex-shrink-0 flex flex-col shadow-2xl z-20">
            <div class="h-16 flex items-center px-6 bg-military-red font-serif font-black tracking-tighter text-xl shadow-md">
                DEFENSE<span class="text-yellow-400">ADMIN</span>
            </div>
            
            <nav class="flex-1 px-2 py-6 space-y-1">
                <button onclick="setView('DASHBOARD')" id="nav-dashboard" class="w-full text-left px-4 py-3 rounded hover:bg-slate-800 transition flex items-center text-gray-300 hover:text-white">
                    <span class="mr-3">📊</span> Tổng Quan
                </button>
                <button onclick="setView('ARTICLES')" id="nav-articles" class="w-full text-left px-4 py-3 rounded hover:bg-slate-800 transition flex items-center text-gray-300 hover:text-white">
                    <span class="mr-3">📝</span> Quản Lý Tin Tức
                </button>
                <a href="{{ route('home') }}" class="w-full text-left px-4 py-3 rounded hover:bg-slate-800 transition flex items-center text-gray-300 hover:text-white mt-8 border-t border-slate-700">
                    <span class="mr-3">🏠</span> Về Trang Chủ
                </a>
            </nav>
            
            <div class="p-4 bg-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-military-red flex items-center justify-center font-bold text-white">AD</div>
                    <div>
                        <div class="text-sm font-bold">Admin User</div>
                        <div class="text-xs text-green-400">● Online</div>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1 flex flex-col relative overflow-hidden bg-gray-50">
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-8 border-b border-gray-200 z-10">
                <h2 id="page-title" class="text-xl font-bold text-gray-800 uppercase tracking-wide">Tổng Quan</h2>
                <button onclick="createNew()" class="hidden id-create-btn bg-military-red hover:bg-red-800 text-white px-4 py-2 text-sm font-bold uppercase tracking-wider rounded shadow transition">
                    + Thêm Bài Mới
                </button>
            </header>

            <div id="content-area" class="flex-1 overflow-y-auto p-8">
                </div>
        </main>
    </div>

    {{-- 4. JavaScript Logic (Sẽ tách riêng ở mục 3) --}}
    <script>
        const STORAGE_KEY = 'defense_news_articles';
let Articles = [];
let currentView = 'DASHBOARD';
let editingId = null;

// --- DỮ LIỆU VÀ LƯU TRỮ ---
function loadData() {
    const data = localStorage.getItem(STORAGE_KEY);
    Articles = data ? JSON.parse(data) : [];
}

function saveData() {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(Articles));
    render();
}

// --- QUẢN LÝ GIAO DIỆN (VIEW) ---
function setView(view) {
    currentView = view;
    editingId = null;
    render();
}

function render() {
    loadData();
    const content = document.getElementById('content-area');
    const title = document.getElementById('page-title');
    const createBtn = document.querySelector('.id-create-btn');

    // Reset nav styles và set active nav
    document.querySelectorAll('aside nav button').forEach(b => b.classList.remove('bg-slate-800', 'border-l-4', 'border-military-red'));
    const activeNav = document.getElementById(currentView === 'DASHBOARD' ? 'nav-dashboard' : 'nav-articles');
    if(activeNav) activeNav.classList.add('bg-slate-800', 'border-l-4', 'border-military-red', 'text-white');
    
    // Ẩn/Hiện nút Thêm Bài Mới
    if (currentView === 'ARTICLES') {
        createBtn.classList.remove('hidden');
    } else {
        createBtn.classList.add('hidden');
    }

    // Render nội dung chính
    if (currentView === 'DASHBOARD') {
        title.innerText = 'Tổng Quan Hệ Thống';
        content.innerHTML = renderDashboard();
    } else if (currentView === 'ARTICLES') {
        title.innerText = 'Danh Sách Tin Tức';
        content.innerHTML = renderArticleList();
    } else if (currentView === 'EDITOR') {
        title.innerText = editingId ? 'Chỉnh Sửa Bài Viết' : 'Soạn Thảo Bài Mới';
        content.innerHTML = renderEditor();
    }
}

// --- RENDER CÁC VIEW ---

function renderDashboard() {
    return `
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <div class="text-gray-500 text-sm font-bold uppercase tracking-wider mb-2">Tổng Số Bài Viết</div>
                <div class="text-4xl font-black text-military-red">${Articles.length}</div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <div class="text-gray-500 text-sm font-bold uppercase tracking-wider mb-2">Lượt Truy Cập (Demo)</div>
                <div class="text-4xl font-black text-slate-800">Running</div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <div class="text-gray-500 text-sm font-bold uppercase tracking-wider mb-2">Người dùng (Demo)</div>
                <div class="text-4xl font-black text-slate-800">5</div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <h3 class="font-bold mb-4 uppercase text-sm text-gray-500">Tin Mới Nhất</h3>
            <ul class="space-y-3">
                ${Articles.slice(0, 5).map(a => `
                    <li class="flex justify-between items-center border-b border-gray-100 pb-2">
                        <span class="font-bold text-gray-700 truncate w-2/3">${a.title}</span>
                        <span class="text-xs text-gray-400">${a.timestamp}</span>
                    </li>
                `).join('')}
            </ul>
            <button onclick="setView('ARTICLES')" class="mt-4 text-military-red text-sm font-bold hover:underline">Xem tất cả →</button>
        </div>
    `;
}

function renderArticleList() {
    return `
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4 border-b border-gray-200 flex justify-end">
                <button onclick="createNew()" class="bg-military-red hover:bg-red-800 text-white px-4 py-2 text-sm font-bold uppercase tracking-wider rounded shadow transition">+ Thêm Bài Mới</button>
            </div>
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold tracking-wider">
                    <tr>
                        <th class="p-4 border-b">ID</th>
                        <th class="p-4 border-b">Tiêu đề</th>
                        <th class="p-4 border-b">Danh mục</th>
                        <th class="p-4 border-b text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    ${Articles.length === 0 ? `
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">Chưa có bài viết nào được tạo.</td>
                        </tr>
                    ` : Articles.map(a => `
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 border-b text-gray-500 font-mono text-xs max-w-[80px] truncate">${a.id}</td>
                            <td class="p-4 border-b font-bold text-gray-800 max-w-md truncate">${a.title}</td>
                            <td class="p-4 border-b"><span class="bg-gray-100 px-2 py-1 rounded text-xs font-bold">${a.category}</span></td>
                            <td class="p-4 border-b text-right">
                                <button onclick="editItem('${a.id}')" class="text-blue-600 font-bold text-xs uppercase hover:underline mr-3">Sửa</button>
                                <button onclick="deleteItem('${a.id}')" class="text-red-600 font-bold text-xs uppercase hover:underline">Xóa</button>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
    `;
}

function renderEditor() {
    const item = editingId ? Articles.find(a => a.id === editingId) : {
        title: '', category: 'Quốc Tế', author: 'Admin', imageUrl: 'https://picsum.photos/800/600', excerpt: '', content: '<p>Nội dung bài viết...</p>'
    };

    return `
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 max-w-4xl mx-auto">
            <form onsubmit="handleSave(event)">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1 uppercase">Tiêu đề</label>
                        <input type="text" name="title" value="${item.title}" required class="w-full border border-gray-300 p-2 rounded focus:border-military-red focus:outline-none" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1 uppercase">Danh mục</label>
                            <select name="category" class="w-full border border-gray-300 p-2 rounded focus:border-military-red">
                                <option value="Lục Quân" ${item.category === 'Lục Quân' ? 'selected' : ''}>Lục Quân</option>
                                <option value="Hải Quân" ${item.category === 'Hải Quân' ? 'selected' : ''}>Hải Quân</option>
                                <option value="Không Quân" ${item.category === 'Không Quân' ? 'selected' : ''}>Không Quân</option>
                                <option value="Công Nghệ QP" ${item.category === 'Công Nghệ QP' ? 'selected' : ''}>Công Nghệ QP</option>
                                <option value="Quốc Tế" ${item.category === 'Quốc Tế' ? 'selected' : ''}>Quốc Tế</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1 uppercase">Tác giả</label>
                            <input type="text" name="author" value="${item.author}" class="w-full border border-gray-300 p-2 rounded focus:border-military-red" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1 uppercase">URL Hình ảnh</label>
                        <input type="text" name="imageUrl" value="${item.imageUrl}" class="w-full border border-gray-300 p-2 rounded focus:border-military-red" />
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1 uppercase">Tóm tắt (Sapo)</label>
                        <textarea name="excerpt" rows="3" class="w-full border border-gray-300 p-2 rounded focus:border-military-red">${item.excerpt}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1 uppercase">Nội dung (HTML)</label>
                        <textarea name="content" rows="10" class="w-full border border-gray-300 p-2 rounded font-mono text-sm focus:border-military-red">${item.content}</textarea>
                        <p class="text-xs text-gray-400 mt-1">Hỗ trợ các thẻ HTML cơ bản.</p>
                    </div>
                    <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
                        <button type="button" onclick="setView('ARTICLES')" class="px-4 py-2 text-gray-600 font-bold uppercase text-sm hover:bg-gray-100 rounded">Hủy</button>
                        <button type="submit" class="bg-military-red hover:bg-red-800 text-white px-6 py-2 font-bold uppercase text-sm rounded shadow">Lưu Lại</button>
                    </div>
                </div>
            </form>
        </div>
    `;
}

// --- HÀNH ĐỘNG ---
function createNew() {
    editingId = null;
    setView('EDITOR');
}

function editItem(id) {
    editingId = id;
    setView('EDITOR');
}

function deleteItem(id) {
    if(confirm('Bạn có chắc chắn muốn xóa bài viết này?')) {
        Articles = Articles.filter(a => a.id !== id);
        saveData();
    }
}

function handleSave(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = {
        title: formData.get('title'),
        category: formData.get('category'),
        author: formData.get('author'),
        imageUrl: formData.get('imageUrl'),
        excerpt: formData.get('excerpt'),
        content: formData.get('content'),
        timestamp: new Date().toLocaleDateString('vi-VN') // Cập nhật thời gian thực
    };

    if (editingId) {
        const idx = Articles.findIndex(a => a.id === editingId);
        if (idx !== -1) Articles[idx] = { ...Articles[idx], ...data };
    } else {
        const newId = Date.now().toString();
        Articles.unshift({ id: newId, ...data });
    }
    
    saveData();
    setView('ARTICLES');
}

// Khởi tạo ứng dụng
render();
    </script>
</body>
</html>