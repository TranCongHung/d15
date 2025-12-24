<div id="view-articles" class="hidden">
    <div class="view-header">
        <div class="view-title">
            <h2>Quản lý Bài viết</h2>
            <p>Danh sách tin bài, văn bản và các chỉ thị quân sự</p>
        </div>
        <button class="btn-ai" style="background: var(--army-600)" onclick="openCreateArticle()">
            <i data-lucide="plus"></i> Thêm bài mới
        </button>
    </div>

    <div class="data-table-container" style="margin-top:16px;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f7fafc; border-bottom:1px solid #e6edf3;">
                    <th style="padding:12px; text-align:left; font-weight:600; width:80px;">MÃ SỐ</th>
                    <th style="padding:12px; text-align:left; font-weight:600;">TIÊU ĐỀ</th>
                    <th style="padding:12px; text-align:left; font-weight:600; width:180px;">TÁC GIẢ</th>
                    <th style="padding:12px; text-align:left; font-weight:600; width:140px;">TRẠNG THÁI</th>
                    <th style="padding:12px; text-align:center; font-weight:600; width:120px;">LƯỢT XEM</th>
                    <th style="padding:12px; text-align:center; font-weight:600; width:140px;">THAO TÁC</th>
                </tr>
            </thead>
            <tbody id="articles-table">
                <!-- Rendered by admin.js -->
            </tbody>
        </table>
    </div>
</div> <!-- Đảm bảo thẻ này đóng view-articles trước khi mở create-article-view -->

