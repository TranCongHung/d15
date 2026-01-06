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
                @foreach($articles as $article)
                <tr style="border-bottom:1px solid #e6edf3;">
                    <td style="padding:12px;">{{ $article->id }}</td>
                    <td style="padding:12px;">
                        <div style="font-weight:600;">{{ $article->title }}</div>
                        <div style="font-size:12px; color:#666;">{{ Str::limit($article->excerpt, 100) }}</div>
                    </td>
                    <td style="padding:12px;">{{ $article->author->name ?? 'N/A' }}</td>
                    <td style="padding:12px;">
                        <span class="status-badge" style="background:#10b981; color:white; padding:4px 8px; border-radius:4px; font-size:12px;">
                            Xuất bản
                        </span>
                    </td>
                    <td style="padding:12px; text-align:center;">{{ $article->view_count }}</td>
                    <td style="padding:12px; text-align:center;">
                        <button class="action-btn" onclick="populateAndOpenArticleModal({{ $article->id }})" style="margin-right:8px; color:#3b82f6;" title="Chỉnh sửa">
                            <i data-lucide="edit" style="width:16px; height:16px;"></i>
                        </button>
                        <button class="action-btn" onclick="handleDeleteArticle({{ $article->id }})" style="color:#ef4444;" title="Xóa">
                            <i data-lucide="trash" style="width:16px; height:16px;"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
