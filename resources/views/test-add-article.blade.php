<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Add Article - QĐNDVN</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .test-section { margin: 20px 0; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        .btn { padding: 10px 20px; margin: 5px; border: none; border-radius: 4px; cursor: pointer; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .result { margin-top: 20px; padding: 10px; background: #f8f9fa; border-radius: 4px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Test Chức Năng Thêm Bài Viết</h1>

    <div class="test-section">
        <h2>Test Thêm Bài Viết</h2>
        <button class="btn btn-primary" onclick="addTestArticle()">Thêm Bài Viết Test</button>
        <button class="btn btn-success" onclick="showArticles()">Hiển Thị Danh Sách Bài Viết</button>
        <button class="btn" onclick="clearArticles()">Xóa Tất Cả Bài Viết</button>

        <div class="result" id="result"></div>
    </div>

    <div class="test-section">
        <h2>Danh Sách Bài Viết Hiện Tại</h2>
        <div id="articles-list"></div>
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
                content: 'Nội dung bài viết mẫu...',
                created_at: '2024-12-01T10:00:00Z',
                updated_at: '2024-12-01T10:00:00Z'
            },
            {
                id: 2,
                title: 'Đảm bảo kỹ thuật tăng thiết giáp',
                cat: 'Hậu cần - Kỹ thuật',
                user: 'Thiếu tá Trần Thị B',
                status: 'draft',
                views: 890,
                content: 'Nội dung bài viết mẫu...',
                created_at: '2024-12-02T10:00:00Z',
                updated_at: '2024-12-02T10:00:00Z'
            }
        ];

        function handleSaveArticle(data) {
            console.log('handleSaveArticle called with:', data);

            if (data.id) {
                // Edit existing article
                const index = REAL_ARTICLES.findIndex(a => a.id == data.id);
                if (index !== -1) {
                    REAL_ARTICLES[index] = {
                        ...REAL_ARTICLES[index],
                        ...data,
                        updated_at: new Date().toISOString()
                    };
                    console.log('Article updated successfully');
                    return 'Article updated successfully';
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
                console.log('New article added:', newArticle);
                return 'Article added successfully with ID: ' + newArticle.id;
            }
        }

        function renderArticles(articles = REAL_ARTICLES) {
            const container = document.getElementById('articles-list');
            if (articles.length === 0) {
                container.innerHTML = '<p>Chưa có bài viết nào.</p>';
                return;
            }

            let html = '<table><thead><tr><th>ID</th><th>Tiêu đề</th><th>Chuyên mục</th><th>Tác giả</th><th>Trạng thái</th><th>Lượt xem</th></tr></thead><tbody>';

            articles.forEach(article => {
                html += `<tr>
                    <td>${article.id}</td>
                    <td>${article.title}</td>
                    <td>${article.cat}</td>
                    <td>${article.user}</td>
                    <td>${article.status}</td>
                    <td>${article.views}</td>
                </tr>`;
            });

            html += '</tbody></table>';
            container.innerHTML = html;
        }

        function addTestArticle() {
            const testData = {
                title: 'Bài viết test mới - ' + new Date().toLocaleTimeString(),
                cat: 'Huấn luyện chiến đấu',
                user: 'Đại tá Nguyễn Văn A',
                status: 'published',
                views: Math.floor(Math.random() * 1000),
                content: 'Đây là nội dung bài viết test được tạo tự động lúc ' + new Date().toLocaleString()
            };

            console.log('Adding test article:', testData);
            const result = handleSaveArticle(testData);

            document.getElementById('result').innerHTML = `
                <h3>Kết quả:</h3>
                <p>${result}</p>
                <p>Tổng số bài viết hiện tại: ${REAL_ARTICLES.length}</p>
            `;

            renderArticles();
        }

        function showArticles() {
            console.log('Current REAL_ARTICLES:', REAL_ARTICLES);
            renderArticles();
        }

        function clearArticles() {
            REAL_ARTICLES = [];
            console.log('All articles cleared');
            document.getElementById('result').innerHTML = '<p>Đã xóa tất cả bài viết.</p>';
            renderArticles();
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            renderArticles();
            console.log('Test page initialized with', REAL_ARTICLES.length, 'articles');
        });
    </script>
</body>
</html>

