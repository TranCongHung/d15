<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Form - QĐNDVN</title>

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .btn-ai {
            background: #48602a;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-ai:hover {
            background: #3a4e22;
            transform: translateY(-1px);
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-overlay.flex {
            display: flex;
        }

        .modal-box {
            background: white;
            border-radius: 8px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
        }

        .modal-header button {
            background: none;
            border: none;
            cursor: pointer;
            color: #6b7280;
            padding: 4px;
            border-radius: 4px;
        }

        .modal-header button:hover {
            background: #f3f4f6;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1.5rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            color: #374151;
            margin-bottom: 4px;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-control:focus {
            outline: none;
            border-color: #48602a;
            box-shadow: 0 0 0 3px rgba(72, 96, 42, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .btn-action {
            padding: 8px 16px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-action:hover {
            background: #f9fafb;
        }

        .btn-primary {
            background: #48602a;
            color: white;
            border-color: #48602a;
        }

        .btn-primary:hover {
            background: #3a4e22;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Test Form - Thêm Bài Viết Mới</h1>
            <p>Click nút "Thêm bài mới" để test form nhập liệu</p>
            <br>
            <button class="btn-ai" onclick="openCreateArticle()">
                <i data-lucide="plus"></i> Thêm bài mới
            </button>
        </div>
    </div>

    <!-- MODAL: THÊM/SỬA BÀI VIẾT -->
    <div id="modal-article" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3 id="modal-article-title">Thêm bài viết mới</h3>
                <button onclick="closeModal('modal-article')">
                    <i data-lucide="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="article-id">

                <div class="form-group full">
                    <label>Tiêu đề bài viết</label>
                    <input type="text" id="article-title" class="form-control" placeholder="Nhập tiêu đề...">
                </div>

                <div class="form-group">
                    <label>Chuyên mục</label>
                    <select id="article-cat" class="form-control">
                        <option>Quốc phòng toàn dân</option>
                        <option>Hậu cần - Kỹ thuật</option>
                        <option>Huấn luyện chiến đấu</option>
                        <option>Công tác Đảng</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Người soạn / Tác giả</label>
                    <input type="text" id="article-user" class="form-control" value="Đại tá Nguyễn Văn A">
                </div>

                <div class="form-group">
                    <label>Trạng thái</label>
                    <select id="article-status" class="form-control">
                        <option value="published">Đã xuất bản</option>
                        <option value="draft">Bản nháp</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Lượt xem</label>
                    <input type="number" id="article-views" class="form-control" value="0">
                </div>

                <div class="form-group full">
                    <label>Nội dung bài viết</label>
                    <textarea id="article-content" class="form-control" rows="6" placeholder="Nhập nội dung bài viết..."></textarea>
                </div>

                <div class="form-group full">
                    <label>Ảnh bài viết</label>
                    <input type="file" id="article-image" class="form-control" accept="image/*">
                    <small style="color: #6b7280; font-size: 12px;">Chọn ảnh cho bài viết (không bắt buộc)</small>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-action" onclick="closeModal('modal-article')">Hủy</button>
                <button class="btn-action btn-primary" onclick="saveArticle()">Lưu bài viết</button>
            </div>
        </div>
    </div>

    <script>
        // Dữ liệu mẫu
        let REAL_ARTICLES = [
            {
                id: 1,
                title: 'Nâng cao chất lượng huấn luyện năm 2024',
                cat: 'Huấn luyện chiến đấu',
                user: 'Đại tá Nguyễn Văn A',
                status: 'published',
                views: 1250,
                content: 'Nội dung bài viết mẫu về huấn luyện...',
                created_at: '2024-12-01T10:00:00Z',
                updated_at: '2024-12-01T10:00:00Z'
            }
        ];

        // Khởi tạo Lucide icons
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) lucide.createIcons();
        });

        function openCreateArticle() {
            console.log('openCreateArticle called');
            populateAndOpenArticleModal();
        }

        function populateAndOpenArticleModal(id = null) {
            const title = document.getElementById('modal-article-title');
            if (id) {
                const article = REAL_ARTICLES.find(x => x.id == id);
                if (article) {
                    document.getElementById('article-id').value = article.id;
                    document.getElementById('article-title').value = article.title;
                    document.getElementById('article-cat').value = article.cat;
                    document.getElementById('article-user').value = article.user;
                    document.getElementById('article-status').value = article.status;
                    document.getElementById('article-views').value = article.views;
                    document.getElementById('article-content').value = article.content || '';
                    if(title) title.innerText = "Chỉnh sửa bài viết #" + id;
                }
            } else {
                // Clear form fields for new article
                document.getElementById('article-id').value = "";
                document.getElementById('article-title').value = "";
                document.getElementById('article-cat').value = "";
                document.getElementById('article-user').value = "Đại tá Nguyễn Văn A";
                document.getElementById('article-status').value = "draft";
                document.getElementById('article-views').value = 0;
                document.getElementById('article-content').value = "";
                document.getElementById('article-image').value = "";
                if(title) title.innerText = "Thêm bài viết mới";
            }
            document.getElementById('modal-article').classList.add('flex');
        }

        function closeModal(id) {
            const el = document.getElementById(id);
            if(el) el.classList.remove('flex');
        }

        function saveArticle() {
            const id = document.getElementById('article-id').value;
            const data = {
                id: id,
                title: document.getElementById('article-title').value,
                cat: document.getElementById('article-cat').value,
                user: document.getElementById('article-user').value,
                status: document.getElementById('article-status').value,
                views: parseInt(document.getElementById('article-views').value) || 0,
                content: document.getElementById('article-content').value
            };

            // Handle image file
            const imageInput = document.getElementById('article-image');
            if (imageInput.files && imageInput.files[0]) {
                data.image = imageInput.files[0];
                data.imageName = imageInput.files[0].name;
            }

            if (id) {
                // Edit existing article
                const index = REAL_ARTICLES.findIndex(a => a.id == id);
                if (index !== -1) {
                    REAL_ARTICLES[index] = {
                        ...REAL_ARTICLES[index],
                        ...data,
                        updated_at: new Date().toISOString()
                    };
                    alert('Bài viết đã được cập nhật thành công!');
                }
            } else {
                // Create new article
                const newArticle = {
                    ...data,
                    id: Date.now(),
                    created_at: new Date().toISOString(),
                    updated_at: new Date().toISOString()
                };

                // Remove image file from data before storing
                if (newArticle.image) {
                    delete newArticle.image;
                    newArticle.image_url = `/images/articles/${newArticle.imageName}`;
                }

                REAL_ARTICLES.push(newArticle);
                alert('Bài viết mới đã được tạo thành công!\n\nTiêu đề: ' + newArticle.title + '\nID: ' + newArticle.id);
            }

            // Close modal
            document.getElementById('modal-article').classList.remove('flex');
        }
    </script>
</body>
</html>

