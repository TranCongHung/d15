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
                          <div style="height: 300px"><canvas id="stats-chart"></canvas></div>
                        </div>
                        <div class="chart-container">
                            <h3 class="chart-title">Nhật ký Hệ thống</h3>
                            <div id="log-list" style="display:flex; flex-direction:column; gap:12px">
                                <!-- Injected -->
                            </div>
                        </div>
                    </div>
                </div>
