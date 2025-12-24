<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hệ thống Quản trị - QĐNDVN</title>
    
    <!-- Icons: Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Chart Library: Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Google Gemini SDK -->
    <script type="importmap">
    {
      "imports": {
        "@google/genai": "https://esm.sh/@google/genai@^1.34.0"
      }
    }
    </script>

</head>
<body>
</head>
<body>

    <div class="app-container">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="brand-logo">★</div>
                <div class="brand-text"><h3>QĐNDVN</h3></div>
            </div>
            <nav class="sidebar-nav">
                <button onclick="switchView('dashboard')" id="nav-dashboard" class="nav-item active"><i data-lucide="layout-dashboard"></i> Tổng quan</button>
                <button onclick="switchView('articles')" id="nav-articles" class="nav-item"><i data-lucide="file-text"></i> Quản lý Bài viết</button>
                <button onclick="switchView('users')" id="nav-users" class="nav-item"><i data-lucide="users"></i> Nhân sự</button>
            </nav>
        </aside>

        <!-- MAIN -->
        <main class="main-content">
            <header class="header">
                <div class="search-bar"><i data-lucide="search"></i><input type="text" placeholder="Tìm kiếm..."></div>
                <div style="font-weight:bold">Đại tá Nguyễn Văn A</div>
            </header>

            <div class="content-scroll">
                
                <!-- DASHBOARD VIEW -->
                <div id="view-dashboard">
                    <div class="view-header">
                        <div class="view-title"><h2>Tổng quan Hệ thống</h2></div>
                    </div>
                    <div id="stats-summary" style="margin-bottom: 2rem; font-size: 0.9rem; color: var(--army-700)">
                        Chào mừng đồng chí trở lại. Hiện có <strong id="count-articles">0</strong> bài viết và <strong id="count-users">0</strong> nhân sự đang hoạt động.
                    </div>
                    <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: var(--shadow); height: 350px;">
                        <canvas id="mainChart"></canvas>
                    </div>
                </div>

                <!-- ARTICLES VIEW -->
                <div id="view-articles" class="hidden">
                    <div class="view-header">
                        <div class="view-title"><h2>Quản lý Bài viết</h2></div>
                        <button class="btn-action btn-primary" onclick="openArticleModal()"><i data-lucide="plus"></i> Thêm bài mới</button>
                    </div>
                    <div class="data-table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã bài</th>
                                    <th>Tiêu đề</th>
                                    <th>Chuyên mục</th>
                                    <th>Tác giả</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="articles-table"></tbody>
                        </table>
                    </div>
                </div>

                <!-- USERS VIEW -->
                <div id="view-users" class="hidden">
                    <div class="view-header">
                        <div class="view-title"><h2>Danh sách Nhân sự</h2></div>
                        <button class="btn-action btn-primary" onclick="openUserModal()"><i data-lucide="user-plus"></i> Thêm nhân sự</button>
                    </div>
                    <div class="data-table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Cán bộ</th>
                                    <th>Cấp bậc</th>
                                    <th>Vai trò</th>
                                    <th>Liên hệ</th>
                                    <th>Ngày tham gia</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="users-table"></tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script type="module">
        // DỮ LIỆU
        let articles = [
            { id: 101, title: 'Nâng cao chất lượng huấn luyện năm 2024', cat: 'Huấn luyện chiến đấu', user: 'Nguyễn Văn A', status: 'published', views: 1250 },
            { id: 102, title: 'Đảm bảo kỹ thuật tăng thiết giáp', cat: 'Hậu cần - Kỹ thuật', user: 'Trần Thị B', status: 'published', views: 890 }
        ];

        let users = [
            { id: 1, name: 'Nguyễn Văn A', rank: 'Đại tá', role: 'Quản trị viên', email: 'nguyenvana@qdnd.vn', joined: '15/01/2020' },
            { id: 2, name: 'Trần Thị B', rank: 'Thiếu tá', role: 'Biên tập viên', email: 'tranthib@qdnd.vn', joined: '22/03/2021' }
        ];

        let mainChart;

        // KHỞI TẠO
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
            refreshAll();
        });

        function refreshAll() {
            renderArticles();
            renderUsers();
            updateStats();
            initChart();
            lucide.createIcons();
        }

        function updateStats() {
            document.getElementById('count-articles').innerText = articles.length;
            document.getElementById('count-users').innerText = users.length;
        }

        // ĐIỀU HƯỚNG
        window.switchView = (id) => {
            ['dashboard', 'articles', 'users'].forEach(v => {
                document.getElementById('view-' + v).classList.add('hidden');
                document.getElementById('nav-' + v).classList.remove('active');
            });
            document.getElementById('view-' + id).classList.remove('hidden');
            document.getElementById('nav-' + id).classList.add('active');
        };

        // RENDER BÀI VIẾT
        function renderArticles() {
            const tbody = document.getElementById('articles-table');
            tbody.innerHTML = articles.map(a => `
                <tr>
                    <td>#${a.id}</td>
                    <td style="font-weight:600">${a.title}</td>
                    <td>${a.cat}</td>
                    <td>${a.user}</td>
                    <td><span class="badge ${a.status === 'published' ? 'badge-success' : 'badge-warning'}">${a.status === 'published' ? 'Đã đăng' : 'Bản nháp'}</span></td>
                    <td>
                        <button class="btn-table" onclick="openArticleModal(${a.id})"><i data-lucide="edit-2" style="width:14px; color:var(--army-600)"></i></button>
                        <button class="btn-table" onclick="deleteArticle(${a.id})"><i data-lucide="trash" style="width:14px; color:var(--vn-red)"></i></button>
                    </td>
                </tr>
            `).join('');
        }

        // RENDER NHÂN SỰ
        function renderUsers() {
            const tbody = document.getElementById('users-table');
            tbody.innerHTML = users.map(u => `
                <tr>
                    <td style="font-weight:600">${u.name}</td>
                    <td>${u.rank}</td>
                    <td>${u.role}</td>
                    <td>${u.email}</td>
                    <td>${u.joined}</td>
                    <td>
                        <button class="btn-table" onclick="openUserModal(${u.id})"><i data-lucide="user-cog" style="width:14px; color:var(--army-600)"></i></button>
                        <button class="btn-table" onclick="deleteUser(${u.id})"><i data-lucide="user-minus" style="width:14px; color:var(--vn-red)"></i></button>
                    </td>
                </tr>
            `).join('');
        }

        // MODAL HELPERS
        window.closeModal = (id) => document.getElementById(id).style.display = 'none';

        window.openArticleModal = (id = null) => {
            const title = document.getElementById('modal-article-title');
            if(id) {
                const a = articles.find(x => x.id === id);
                document.getElementById('article-id').value = a.id;
                document.getElementById('article-title').value = a.title;
                document.getElementById('article-cat').value = a.cat;
                document.getElementById('article-user').value = a.user;
                document.getElementById('article-status').value = a.status;
                document.getElementById('article-views').value = a.views;
                title.innerText = "Chỉnh sửa bài viết #" + id;
            } else {
                document.getElementById('article-id').value = "";
                document.getElementById('article-title').value = "";
                document.getElementById('article-user').value = "Đại tá Nguyễn Văn A";
                document.getElementById('article-views').value = 0;
                title.innerText = "Thêm bài viết mới";
            }
            document.getElementById('modal-article').style.display = 'flex';
        };

        window.openUserModal = (id = null) => {
            const title = document.getElementById('modal-user-title');
            if(id) {
                const u = users.find(x => x.id === id);
                document.getElementById('user-id').value = u.id;
                document.getElementById('user-name').value = u.name;
                document.getElementById('user-rank').value = u.rank;
                document.getElementById('user-role').value = u.role;
                document.getElementById('user-email').value = u.email;
                document.getElementById('user-joined').value = u.joined;
                title.innerText = "Cập nhật hồ sơ nhân sự #" + id;
            } else {
                document.getElementById('user-id').value = "";
                document.getElementById('user-name').value = "";
                document.getElementById('user-email').value = "";
                document.getElementById('user-joined').value = "26/10/2024";
                title.innerText = "Thêm nhân sự mới";
            }
            document.getElementById('modal-user').style.display = 'flex';
        };

        // CRUD LOGIC
        window.saveArticle = () => {
            const id = document.getElementById('article-id').value;
            const data = {
                title: document.getElementById('article-title').value,
                cat: document.getElementById('article-cat').value,
                user: document.getElementById('article-user').value,
                status: document.getElementById('article-status').value,
                views: parseInt(document.getElementById('article-views').value) || 0
            };
            if(id) {
                const i = articles.findIndex(x => x.id == id);
                articles[i] = { ...articles[i], ...data };
            } else {
                articles.unshift({ id: Date.now() % 1000, ...data });
            }
            closeModal('modal-article');
            refreshAll();
        };

        window.saveUser = () => {
            const id = document.getElementById('user-id').value;
            const data = {
                name: document.getElementById('user-name').value,
                rank: document.getElementById('user-rank').value,
                role: document.getElementById('user-role').value,
                email: document.getElementById('user-email').value,
                joined: document.getElementById('user-joined').value
            };
            if(id) {
                const i = users.findIndex(x => x.id == id);
                users[i] = { ...users[i], ...data };
            } else {
                users.push({ id: users.length + 1, ...data });
            }
            closeModal('modal-user');
            refreshAll();
        };

        window.deleteArticle = (id) => { if(confirm('Xóa bài viết này?')) { articles = articles.filter(x => x.id != id); refreshAll(); } };
        window.deleteUser = (id) => { if(confirm('Xóa nhân sự này?')) { users = users.filter(x => x.id != id); refreshAll(); } };

        function initChart() {
            const ctx = document.getElementById('mainChart').getContext('2d');
            if(mainChart) mainChart.destroy();
            mainChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],
                    datasets: [{
                        label: 'Lượt xem bài viết',
                        data: [120, 190, 300, 500, 200, 300, 450],
                        borderColor: '#48602a',
                        backgroundColor: 'rgba(72, 96, 42, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        }
    </script>
</body>
</html>