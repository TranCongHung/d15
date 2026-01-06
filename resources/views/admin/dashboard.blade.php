                <div id="view-dashboard">
                    <div class="view-header">
                        <div class="view-title">
                            <h2>Trung tâm Chỉ huy</h2>
                            <p>Báo cáo tổng hợp tình hình tác chiến điện tử và nội dung</p>
                        </div>
                        <button class="btn-ai" style="background: var(--army-600)" onclick="openCreateArticle()">
                            <i data-lucide="plus"></i> Thêm bài mới
                        </button>
                    </div>

                    <div id="ai-report-box" class="ai-report-box">
                        <h3><i data-lucide="file-text" style="vertical-align: middle; margin-right: 8px"></i>Báo cáo Tình hình (SitRep)</h3>
                        <div id="ai-content"></div>
                        <button onclick="this.parentElement.style.display='none'" style="position:absolute; top:10px; right:10px; border:none; background:none; cursor:pointer">✕</button>
                    </div>

                    {{-- SIMPLE STATS DASHBOARD --}}
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div>
                                <p class="stat-label">Tổng bài viết</p>
                                <p class="stat-value" id="stat-articles">--</p>
                            </div>
                            <div class="stat-icon" style="background-color: #eef2ff; color: #4338ca">
                                <i data-lucide="file-text"></i>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div>
                                <p class="stat-label">Nhân sự trực</p>
                                <p class="stat-value" id="stat-users">--</p>
                            </div>
                            <div class="stat-icon" style="background-color: #f0fdf4; color: #15803d">
                                <i data-lucide="users"></i>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div>
                                <p class="stat-label">Lượt tương tác</p>
                                <p class="stat-value" id="stat-comments">--</p>
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
                          <div style="height: 300px"><canvas id="stats-chart" width="100%" height="300"></canvas></div>
                        </div>
                        <div class="chart-container">
                            <h3 class="chart-title">Nhật ký Hệ thống</h3>
                            <div id="log-list" style="display:flex; flex-direction:column; gap:12px">
                                <!-- Injected -->
                            </div>
                        </div>
                    </div>

                    {{-- SIMPLE DASHBOARD LOADER SCRIPT --}}
                    <script>
                    // Simple Chart.js renderer
                    function renderStatsChart(options = {}) {
                        const canvas = document.getElementById('stats-chart');
                        if (!canvas) {
                            console.warn('Chart canvas not found');
                            return;
                        }

                        const ctx = canvas.getContext('2d');
                        if (!ctx) return;

                        // Destroy existing chart if exists
                        if (window.mainChart) {
                            window.mainChart.destroy();
                        }

                        const categoryStats = options.categoryStats || [];

                        if (categoryStats.length === 0) {
                            console.warn('No category data available for chart');
                            return;
                        }

                        const labels = categoryStats.map(cat => cat.name);
                        const data = categoryStats.map(cat => cat.count);

                        // Military color scheme
                        const colors = [
                            '#48602a', '#1e40af', '#dc2626', '#f59e0b',
                            '#8b5cf6', '#06b6d4', '#84cc16', '#f97316'
                        ];

                        window.mainChart = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: labels,
                                datasets: [{
                                    data: data,
                                    backgroundColor: colors.slice(0, labels.length),
                                    borderWidth: 2,
                                    borderColor: '#ffffff'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            padding: 20,
                                            usePointStyle: true
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                const label = context.label || '';
                                                const value = context.raw || 0;
                                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                                return `${label}: ${value} bài viết (${percentage}%)`;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }

                    document.addEventListener('DOMContentLoaded', async () => {
                        console.log('Loading dashboard data...');

                        try {
                            const response = await fetch('/admin/stats');
                            const data = await response.json();

                            // Update stats
                            document.getElementById('stat-articles').textContent = data.articles;
                            document.getElementById('stat-users').textContent = data.users;
                            document.getElementById('stat-comments').textContent = data.comments;
                            document.getElementById('stat-failed').textContent = data.failed;

                            // Render chart with category data
                            if (data.categories) {
                                renderStatsChart({ categoryStats: data.categories });
                            }

                            console.log('Dashboard updated successfully');
                        } catch (error) {
                            console.error('Failed to load dashboard stats:', error);
                        }
                    });
                    </script>
                </div>
