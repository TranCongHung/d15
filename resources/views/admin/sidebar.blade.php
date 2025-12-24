  <div class="app-container">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-brand">
                <div class="brand-logo">★</div>
                <div class="brand-text">
                    <h1>QĐNDVN</h1>
                    <p>Hệ thống Quản trị</p>
                </div>
            </div>

            <nav class="sidebar-nav">
                <button onclick="switchView('dashboard')" id="nav-dashboard" class="nav-item active">
                    <i data-lucide="layout-dashboard"></i> Tổng quan
                </button>
                <button onclick="switchView('articles')" id="nav-articles" class="nav-item">
                    <i data-lucide="file-text"></i> Quản lý Bài viết
                </button>
                <button onclick="switchView('users')" id="nav-users" class="nav-item">
                    <i data-lucide="users"></i> Nhân sự
                </button>
                <button onclick="switchView('system')" id="nav-system" class="nav-item">
                    <i data-lucide="database"></i> Hệ thống
                </button>
                
                <div class="nav-label">Cấu hình</div>
                <button class="nav-item"><i data-lucide="settings"></i> Thiết lập</button>
                <button class="nav-item"><i data-lucide="shield"></i> Bảo mật</button>
            </nav>

            <div class="sidebar-footer">
               <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
        @csrf
    </form>

    <button class="logout-btn" 
            onclick="event.preventDefault(); if(confirm('Đồng chí có chắc chắn muốn đăng xuất?')) document.getElementById('logout-form').submit();"
            style="width: 100%; display: flex; align-items: center; gap: 10px; cursor: pointer;">
        <i data-lucide="log-out"></i> 
        <span>Đăng xuất</span>
    </button>
            </div>
        </aside>

        <!-- MAIN -->
        <main class="main-content">
            <header class="header">
                <div class="search-bar">
                    <i data-lucide="search" style="width:16px; color:#666"></i>
                    <input type="text" placeholder="Tìm kiếm tài liệu, chỉ thị..." />
                </div>

                <div class="header-actions">
                    <button style="background:none; border:none; cursor:pointer; position:relative">
                        <i data-lucide="bell"></i>
                        <span style="position:absolute; top:0; right:0; width:8px; height:8px; background:var(--vn-red); border-radius:50%"></span>
                    </button>
                    
                    <div class="profile-area">
                        <div class="profile-info">
                           <p class="profile-name">{{ Auth::user()->name ?? 'Chưa đăng nhập' }}</p>
        
        <p class="profile-rank">
            {{ Auth::user()->rank ?? 'Quản trị viên' }}
        </p>
                        </div>
                        <div class="avatar">
                            <i data-lucide="user"></i>
                        </div>
                    </div>
                </div>
            </header>

            <div class="content-scroll" id="content-area">
                
                <!-- ================= VIEW: DASHBOARD ================= -->
                <div id="view-dashboard">
                    <div class="view-header">
                        <div class="view-title">
                            <h2>Trung tâm Chỉ huy</h2>
                            <p>Báo cáo tổng hợp tình hình tác chiến điện tử và nội dung</p>
                        </div>
                        <button class="btn-ai" id="btn-ai">
                            <i data-lucide="sparkles"></i>
                            <span id="btn-ai-text">Báo cáo thông minh (AI)</span>
                        </button>
                    </div>

                    <div id="ai-report-box" class="ai-report-box">
                        <h3><i data-lucide="file-text" style="vertical-align: middle; margin-right: 8px"></i>Báo cáo Tình hình (SitRep)</h3>
                        <div id="ai-content"></div>
                        <button onclick="this.parentElement.style.display='none'" style="position:absolute; top:10px; right:10px; border:none; background:none; cursor:pointer">✕</button>
                    </div>

                    <div class="stats-grid">
                        <div class="stat-card">
                            <div>
                                <p class="stat-label">Tổng bài viết</p>
                                <p class="stat-value" id="stat-articles">0</p>
                            </div>
                            <div class="stat-icon" style="background-color: #eef2ff; color: #4338ca">
                                <i data-lucide="file-text"></i>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div>
                                <p class="stat-label">Nhân sự trực</p>
                                <p class="stat-value" id="stat-users">0</p>
                            </div>
                            <div class="stat-icon" style="background-color: #f0fdf4; color: #15803d">
                                <i data-lucide="users"></i>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div>
                                <p class="stat-label">Lượt tương tác</p>
                                <p class="stat-value" id="stat-comments">0</p>
                            </div>
                            <div class="stat-icon" style="background-color: #fff7ed; color: #c2410c">
                                <i data-lucide="message-square"></i>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div>
                                <p class="stat-label">Cảnh báo lỗi</p>
                                <p class="stat-value" id="stat-failed">0</p>
                            </div>
                            <div class="stat-icon" style="background-color: #fef2f2; color: #b91c1c">
                                <i data-lucide="alert-triangle"></i>
                            </div>
                        </div>
                    </div>

                    <div class="charts-grid">
                        <div class="chart-container">
                            <h3 class="chart-title">Thống kê Bài viết theo Chuyên mục</h3>
                            <div style="height: 300px"><canvas id="mainChart"></canvas></div>
                        </div>
                        <div class="chart-container">
                            <h3 class="chart-title">Nhật ký Hệ thống</h3>
                            <div id="log-list" style="display:flex; flex-direction:column; gap:12px">
                                <!-- Injected -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= VIEW: ARTICLES ================= -->
                <div id="view-articles" class="hidden">
                    <div class="view-header">
                        <div class="view-title">
                            <h2>Quản lý Bài viết</h2>
                            <p>Danh sách tin bài, văn bản và các chỉ thị quân sự</p>
                        </div>
                        <button class="btn-ai" style="background: var(--army-600)">
                            <i data-lucide="plus"></i> Thêm bài mới
                        </button>
                    </div>

                    <div class="data-table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã số</th>
                                    <th>Tiêu đề</th>
                                    <th>Tác giả</th>
                                    <th>Trạng thái</th>
                                    <th>Lượt xem</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="articles-table"></tbody>
                        </table>
                    </div>
                </div>

                <!-- ================= VIEW: USERS ================= -->
                <div id="view-users" class="hidden">
                    <div class="view-header">
                        <div class="view-title">
                            <h2>Danh sách Nhân sự</h2>
                            <p>Thông tin cán bộ, chiến sĩ và biên tập viên hệ thống</p>
                        </div>
                    </div>
                    <div class="data-table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Họ tên</th>
                                    <th>Liên hệ</th>
                                    <th>Vai trò</th>
                                    <th>Ngày tham gia</th>
                                </tr>
                            </thead>
                            <tbody id="users-table"></tbody>
                        </table>
                    </div>
                </div>

                <!-- ================= VIEW: SYSTEM ================= -->
                <div id="view-system" class="hidden">
                    <div class="view-header">
                        <div class="view-title">
                            <h2>Trạng thái Hệ thống</h2>
                            <p>Giám sát hạ tầng và dữ liệu</p>
                        </div>
                    </div>
                    <div class="charts-grid" style="grid-template-columns: 1fr 1fr">
                        <div class="chart-container">
                            <h3 class="chart-title">Tài nguyên Máy chủ</h3>
                            <div style="padding: 1rem">
                                <div style="margin-bottom:1rem">
                                    <div style="display:flex; justify-content:space-between; font-size:0.8rem"><span>CPU</span><span>12%</span></div>
                                    <div style="width:100%; height:8px; background:#eee; border-radius:4px; margin-top:4px"><div style="width:12%; height:8px; background:var(--army-600); border-radius:4px"></div></div>
                                </div>
                                <div style="margin-bottom:1rem">
                                    <div style="display:flex; justify-content:space-between; font-size:0.8rem"><span>RAM</span><span>45%</span></div>
                                    <div style="width:100%; height:8px; background:#eee; border-radius:4px; margin-top:4px"><div style="width:45%; height:8px; background:var(--army-300); border-radius:4px"></div></div>
                                </div>
                            </div>
                        </div>
                        <div class="chart-container">
                            <h3 class="chart-title">Dung lượng Dữ liệu</h3>
                            <div style="padding: 1rem">
                                <div style="text-align:center">
                                    <p style="font-size: 2rem; font-weight:bold; color:var(--army-700)">256 GB / 1 TB</p>
                                    <p style="font-size: 0.8rem; color:var(--gray-500)">Sử dụng 25% tổng dung lượng</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <footer>
                    <p>Hệ thống Quản trị QĐNDVN v1.0.2 - Bản quyền © 2024 Cục CNTT - Bộ Quốc phòng</p>
                </footer>
            </div>
        </main>
    </div>