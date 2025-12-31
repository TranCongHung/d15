// Dữ liệu từ PHP sang JS (không chứa Blade trực tiếp)
const REAL_STATS = window.REAL_STATS || {
    totalArticles: 0,
    totalUsers: 0,
    totalComments: 0,
    failedJobs: 0
};
let REAL_ARTICLES = window.REAL_ARTICLES || [
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
    },
    {
        id: 2,
        title: 'Đảm bảo kỹ thuật tăng thiết giáp',
        cat: 'Hậu cần - Kỹ thuật',
        user: 'Thiếu tá Trần Thị B',
        status: 'draft',
        views: 890,
        content: 'Nội dung bài viết về kỹ thuật...',
        created_at: '2024-12-02T10:00:00Z',
        updated_at: '2024-12-02T10:00:00Z'
    }
]; // Changed to let for reassignment
let REAL_USERS = window.REAL_USERS || [
    {
        id: 1,
        name: 'Đại tá Nguyễn Văn A',
        rank: 'Đại tá',
        role: 'Quản trị viên',
        email: 'nguyenvana@qdnd.vn',
        joined: '15/01/2020'
    },
    {
        id: 2,
        name: 'Thiếu tá Trần Thị B',
        rank: 'Thiếu tá',
        role: 'Biên tập viên',
        email: 'tranthib@qdnd.vn',
        joined: '22/03/2021'
    }
]; // Changed to let for reassignment
const REAL_CATEGORIES = window.REAL_CATEGORIES || [];
const REAL_LOGS = window.REAL_LOGS || [];

document.addEventListener('DOMContentLoaded', () => {
    renderDashboard(REAL_STATS);
    renderStatsChart(REAL_STATS);
    renderSystemLogs();
    renderArticles(REAL_ARTICLES);
    renderUsers(REAL_USERS);

    // --- Populate Categories if needed (Fallback) ---
    const categorySelect = document.getElementById('article-cat'); // Updated ID for modal
    if (categorySelect && categorySelect.options.length <= 1 && REAL_CATEGORIES.length > 0) {
        // Clear existing options first if only default is present
        if (categorySelect.options[0].value === "") { // Assuming first option is a placeholder
            categorySelect.innerHTML = '';
        }
        REAL_CATEGORIES.forEach(cat => {
            const option = document.createElement('option');
            option.value = cat.name; // Assuming 'name' is the value to display
            option.textContent = cat.name;
            categorySelect.appendChild(option);
        });
    }

    if (window.lucide) lucide.createIcons();

    // Hook up save buttons from modals
    // Updated to use local data extraction matching test.php interface
    const articleSaveButton = document.querySelector('#modal-article .btn-primary');
    if (articleSaveButton) {
        articleSaveButton.onclick = onSaveArticle;
    }

    const userSaveButton = document.querySelector('#modal-user .btn-primary');
    if (userSaveButton) {
        userSaveButton.onclick = onSaveUser;
    }

    // --- Original Create Article Form submission (keep for reference or remove if no longer needed) ---
    const createArticleForm = document.getElementById('create-article-form');
    if (createArticleForm) {
        createArticleForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // This part might be superseded by modal save logic
            console.warn("Legacy create article form submitted. Consider integrating with new modal save logic.");
        });
    }
});

// ---------- Dashboard stats ----------
function renderDashboard(stats) {
    const elements = {
        'count-articles': stats.totalArticles, // Updated ID
        'count-users': stats.totalUsers,       // Updated ID
        'stat-comments': stats.totalComments,
        'stat-failed': stats.failedJobs
    };

    for (const [id, value] of Object.entries(elements)) {
        const el = document.getElementById(id);
        if (el) el.innerText = Number(value || 0).toLocaleString();
    }
}

// ---------- Chart ----------
let mainChart; // Declare mainChart at a higher scope if it was originally global
function renderStatsChart(stats) {
    const ctx = document.getElementById('mainChart');
    if (!ctx) return;

    if (mainChart) mainChart.destroy(); // Use the global mainChart variable

    const labels = ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'];
    const data = [
        Number(stats.weeklyViews?.[0] || 120),
        Number(stats.weeklyViews?.[1] || 190),
        Number(stats.weeklyViews?.[2] || 300),
        Number(stats.weeklyViews?.[3] || 500),
        Number(stats.weeklyViews?.[4] || 200),
        Number(stats.weeklyViews?.[5] || 300),
        Number(stats.weeklyViews?.[6] || 450)
    ];

    mainChart = new Chart(ctx.getContext('2d'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Lượt xem bài viết',
                data: data,
                borderColor: '#48602a',
                backgroundColor: 'rgba(72, 96, 42, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
}

// ---------- System logs ----------
function renderSystemLogs() {
    const logList = document.getElementById('log-list');
    if (!logList) return;

    const logs = REAL_LOGS.length ? REAL_LOGS : [{
        time: '14:32:15',
        type: 'success',
        message: 'Cập nhật bài viết thành công'
    }, {
        time: '14:28:42',
        type: 'info',
        message: 'Người dùng mới đăng ký'
    }, {
        time: '14:15:08',
        type: 'warning',
        message: 'Dung lượng storage sắp đầy'
    }, {
        time: '13:45:21',
        type: 'error',
        message: 'Lỗi kết nối database'
    }, ];

    logList.innerHTML = logs.map(log => `
        <div style="display:flex; gap:12px; padding:8px; background:#fff; border-radius:6px; border-left:3px solid ${
            log.type === 'success' ? '#10b981' :
            log.type === 'info' ? '#3b82f6' :
            log.type === 'warning' ? '#f59e0b' :
            '#ef4444'
        }">
            <span style="font-size:12px; color:#6b7280; min-width:70px">${log.time}</span>
            <span style="flex:1; color:#111">${log.message}</span>
        </div>
    `).join('');
}


// ---------- Articles table & CRUD ----------
function renderArticles(articles = REAL_ARTICLES) {
    const tbody = document.getElementById('articles-table');
    if (!tbody) return;

    tbody.innerHTML = articles.map(article => `
        <tr>
            <td style="padding:12px; text-align:left; font-weight:600; color:#374151;">#${article.id}</td>
            <td style="padding:12px; text-align:left; font-weight:600; color:#111827;">${escapeHtml(article.title || '')}</td>
            <td style="padding:12px; text-align:left; color:#6b7280;">${escapeHtml(article.user || '')}</td>
            <td style="padding:12px; text-align:left;">
                <span class="badge ${article.status === 'published' ? 'badge-success' : 'badge-warning'}">
                    ${article.status === 'published' ? 'Đã đăng' : 'Bản nháp'}
                </span>
            </td>
            <td style="padding:12px; text-align:center; color:#6b7280;">${formatNumber(article.views || 0)}</td>
            <td style="padding:12px; text-align:center;">
                <button class="btn-table" onclick="populateAndOpenArticleModal(${article.id})" title="Chỉnh sửa">
                    <i data-lucide="edit-2" style="width:14px; color:#48602a;"></i>
                </button>
                <button class="btn-table" onclick="handleDeleteArticle(${article.id})" title="Xóa">
                    <i data-lucide="trash" style="width:14px; color:#dc2626;"></i>
                </button>
            </td>
        </tr>
    `).join('');

    // Re-render icons for new content
    if (window.lucide) lucide.createIcons();
}

// ---------- Articles table & CRUD ----------

function populateAndOpenArticleModal(id = null) {
    console.log('populateAndOpenArticleModal called with id:', id);
    const modal = document.getElementById('modal-article');
    console.log('Modal element:', modal);
    modal.classList.add('flex');
    modal.style.display = 'flex'; // Force display for testing
    console.log('Modal classes after adding flex:', modal.className);
    console.log('Modal style.display:', modal.style.display);
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
            document.getElementById('article-excerpt').value = article.excerpt || '';
            document.getElementById('article-content').value = article.content || '';
            // Note: File input cannot be pre-filled for security reasons
            if(title) title.innerText = "Chỉnh sửa bài viết #" + id;
        }
    } else {
        // Clear form fields for new article
        document.getElementById('article-id').value = "";
        document.getElementById('article-title').value = "";
        document.getElementById('article-cat').value = "";
        document.getElementById('article-user').value = "Đại tá Nguyễn Văn A"; // Default
        document.getElementById('article-status').value = "draft"; // Default
        document.getElementById('article-views').value = 0;
        document.getElementById('article-excerpt').value = "";
        document.getElementById('article-content').value = "";
        document.getElementById('article-image').value = "";
        if(title) title.innerText = "Thêm bài viết mới";
    }
    document.getElementById('modal-article').classList.add('flex');
}

function openCreateArticle() {
    console.log('openCreateArticle called from admin page');
    populateAndOpenArticleModal(); // Call without ID to create new article
}

function onSaveArticle() {
    // Validation trước khi submit
    const title = document.getElementById('article-title').value.trim();
    const category = document.getElementById('article-cat').value;
    const content = document.getElementById('article-content').value.trim();

    if (!title) {
        alert('Vui lòng nhập tiêu đề bài viết!');
        document.getElementById('article-title').focus();
        return;
    }

    if (!category) {
        alert('Vui lòng chọn chuyên mục!');
        document.getElementById('article-cat').focus();
        return;
    }

    if (!content) {
        alert('Vui lòng nhập nội dung bài viết!');
        document.getElementById('article-content').focus();
        return;
    }

    // Disable button và show loading
    const saveBtn = document.getElementById('save-article-btn');
    const saveText = document.getElementById('save-text');
    const savingText = document.getElementById('saving-text');

    saveBtn.disabled = true;
    saveText.style.display = 'none';
    savingText.style.display = 'inline';

    const id = document.getElementById('article-id').value;
    // Extract data from DOM với tất cả trường
    const data = {
        id: id,
        title: title,
        cat: category,
        user: document.getElementById('article-user').value,
        status: document.getElementById('article-status').value,
        excerpt: document.getElementById('article-excerpt').value.trim(),
        content: content
    };

    // Handle image file
    const imageInput = document.getElementById('article-image');
    if (imageInput.files && imageInput.files[0]) {
        data.image = imageInput.files[0];
        data.imageName = imageInput.files[0].name;
    }

    handleSaveArticle(data, () => {
        // Re-enable button sau khi hoàn thành
        saveBtn.disabled = false;
        saveText.style.display = 'inline';
        savingText.style.display = 'none';
    });
}

// Updated handleSaveArticle function with full API integration
function handleSaveArticle(data, onComplete = null) {
    // Map category name to category ID
    const categoryMap = {
        'Quốc phòng toàn dân': 1,
        'Hậu cần - Kỹ thuật': 2,
        'Huấn luyện chiến đấu': 3,
        'Công tác Đảng': 4
    };

    const categoryId = categoryMap[data.cat] || 1;

    // Map status from Vietnamese to English
    const statusMap = {
        'Đã xuất bản': 'published',
        'Bản nháp': 'draft'
    };

    const apiData = {
        title: data.title,
        category_id: categoryId,
        body: data.content || '',
        excerpt: data.excerpt || (data.content ? data.content.substring(0, 150) + '...' : ''),
        image_url: data.imageName ? `/images/articles/${data.imageName}` : null,
        status: statusMap[data.status] || 'draft'
    };

    // Close modal first
    const modal = document.getElementById('modal-article');
    if (modal) {
        modal.classList.remove('flex');
    }

    if (data.id && !isNaN(data.id) && data.id < 1000000000000) { // Check if it's a real database ID
        // Edit existing article via API
        fetch(`/admin/articles/${data.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify(apiData)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert(result.message);
                // Update local array
                const index = REAL_ARTICLES.findIndex(a => a.id == data.id);
                if (index !== -1) {
                    REAL_ARTICLES[index] = result.article;
                }
                renderArticles(REAL_ARTICLES);
                updateStats();
                if (onComplete) onComplete();
            } else {
                alert('Lỗi: ' + (result.message || 'Không thể cập nhật bài viết'));
                if (onComplete) onComplete();
            }
        })
        .catch(error => {
            console.error('Error updating article:', error);
            alert('Có lỗi xảy ra khi cập nhật bài viết');
            if (onComplete) onComplete();
        });
    } else {
        // Create new article via API
        fetch('/admin/articles', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify(apiData)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert(result.message + '\nID: ' + result.article.id);
                // Add to local array
                REAL_ARTICLES.unshift(result.article);
                renderArticles(REAL_ARTICLES);
                updateStats();

                // Đảm bảo modal được đóng sau khi thành công
                const modal = document.getElementById('modal-article');
                if (modal) {
                    modal.classList.remove('flex');
                    modal.style.display = 'none';
                }

                if (onComplete) onComplete();
            } else {
                alert('Lỗi: ' + (result.message || 'Không thể tạo bài viết'));
                // Mở lại modal nếu có lỗi
                const modal = document.getElementById('modal-article');
                if (modal) {
                    modal.classList.add('flex');
                    modal.style.display = 'flex';
                }
                if (onComplete) onComplete();
            }
        })
        .catch(error => {
            console.error('Error creating article:', error);
            alert('Có lỗi xảy ra khi tạo bài viết');
            // Mở lại modal nếu có lỗi
            const modal = document.getElementById('modal-article');
            if (modal) {
                modal.classList.add('flex');
                modal.style.display = 'flex';
            }
            if (onComplete) onComplete();
        });
    }
}

// End of file
function handleSaveArticle_old(data) {
    if (data.id) {
        // Edit existing article
        const index = REAL_ARTICLES.findIndex(a => a.id == data.id);
        if (index !== -1) {
            // Update existing article
            REAL_ARTICLES[index] = {
                ...REAL_ARTICLES[index],
                ...data,
                updated_at: new Date().toISOString()
            };
            alert('Bài viết đã được cập nhật thành công!');
        }
    } else {
        // Create new article via API
        const categoryMap = {
            'Quốc phòng toàn dân': 1,
            'Hậu cần - Kỹ thuật': 2,
            'Huấn luyện chiến đấu': 3,
            'Công tác Đảng': 4
        };

        const categoryId = categoryMap[data.cat] || 1;

        const apiData = {
            title: data.title,
            category_id: categoryId,
            body: data.content || '',
            excerpt: data.content ? data.content.substring(0, 150) + '...' : '',
            image_url: data.imageName ? `/images/articles/${data.imageName}` : null,
            status: data.status
        };

        fetch('/admin/articles', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify(apiData)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert(result.message + '\nID: ' + result.article.id);
                // Add to local array
                REAL_ARTICLES.unshift(result.article);
                renderArticles(REAL_ARTICLES);
                updateStats();
            } else {
                alert('Lỗi: ' + (result.message || 'Không thể tạo bài viết'));
            }
        })
        .catch(error => {
            console.error('Error creating article:', error);
            alert('Có lỗi xảy ra khi tạo bài viết');
        });
    }

    // Close modal and refresh table
    const modal = document.getElementById('modal-article');
    if (modal) {
        modal.classList.remove('flex');
    }

    renderArticles(REAL_ARTICLES);
    updateStats();
}

function handleDeleteArticle(id) {
    if(confirm('Bạn có chắc chắn muốn xóa bài viết này?')) {
        // Create a form and submit it to properly handle CSRF and method spoofing
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/articles/${id}`;

        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
        form.appendChild(csrfToken);

        // Add method spoofing for DELETE
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);

        document.body.appendChild(form);
        form.submit();
    }
}

// ---------- Users table & CRUD ----------
function renderUsers(users = REAL_USERS) {
    const tbody = document.getElementById('users-table');
    if (!tbody) return;

    tbody.innerHTML = users.map(user => `
        <tr>
            <td style="padding:12px; text-align:left; font-weight:600; color:#374151;">${user.id}</td>
            <td style="padding:12px; text-align:left; font-weight:600; color:#111827;">${escapeHtml(user.name || '')}</td>
            <td style="padding:12px; text-align:left; color:#6b7280;">${escapeHtml(user.email || '')}</td>
            <td style="padding:12px; text-align:left; color:#6b7280;">${escapeHtml(user.role || '')}</td>
            <td style="padding:12px; text-align:center;">
                <button class="btn-table" onclick="populateAndOpenUserModal(${user.id})" title="Chỉnh sửa">
                    <i data-lucide="user-cog" style="width:14px; color:#48602a;"></i>
                </button>
                <button class="btn-table" onclick="handleDeleteUser(${user.id})" title="Xóa">
                    <i data-lucide="user-minus" style="width:14px; color:#dc2626;"></i>
                </button>
            </td>
        </tr>
    `).join('');

    // Re-render icons for new content
    if (window.lucide) lucide.createIcons();
}

// ---------- Users table & CRUD ----------

function populateAndOpenUserModal(id = null) {
    const title = document.getElementById('modal-user-title');
    if (id) {
        const user = REAL_USERS.find(x => x.id == id);
        if (user) {
            document.getElementById('user-id').value = user.id;
            document.getElementById('user-name').value = user.name;
            document.getElementById('user-rank').value = user.rank;
            document.getElementById('user-role').value = user.role;
            document.getElementById('user-email').value = user.email;
            document.getElementById('user-joined').value = user.joined;
            if(title) title.innerText = "Cập nhật hồ sơ nhân sự #" + id;
        }
    } else {
        // Clear form fields for new user
        document.getElementById('user-id').value = "";
        document.getElementById('user-name').value = "";
        document.getElementById('user-rank').value = "";
        document.getElementById('user-role').value = "";
        document.getElementById('user-email').value = "";
        document.getElementById('user-joined').value = "26/10/2024"; // Default
        if(title) title.innerText = "Thêm nhân sự mới";
    }
    document.getElementById('modal-user').classList.add('flex');
}

function onSaveUser() {
    const id = document.getElementById('user-id').value;
    const data = {
        id: id,
        name: document.getElementById('user-name').value,
        rank: document.getElementById('user-rank').value,
        role: document.getElementById('user-role').value,
        email: document.getElementById('user-email').value,
        joined: document.getElementById('user-joined').value
    };
    handleSaveUser(data);
}

function handleSaveUser(data) {
    const isNew = !data.id;
    const method = isNew ? 'POST' : 'PUT';
    const url = isNew ? '/admin/users' : `/admin/users/${data.id}`;

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            if (isNew) {
                REAL_USERS.push(response.user); // Add new user
            } else {
                const index = REAL_USERS.findIndex(u => u.id == data.id);
                if (index !== -1) {
                    REAL_USERS[index] = { ...REAL_USERS[index], ...response.user }; // Update existing
                }
            }
            renderUsers(REAL_USERS);
            updateStats();
            document.getElementById('modal-user').classList.remove('flex');
            alert(response.message || 'Hồ sơ nhân sự đã được lưu.');
        } else {
            alert(response.message || 'Lỗi khi lưu hồ sơ nhân sự.');
        }
    })
    .catch(error => {
        console.error('Error saving user:', error);
        alert('Có lỗi xảy ra khi giao tiếp với server.');
    });
}

function handleDeleteUser(id) {
    if(confirm('Xóa nhân sự này?')) {
        fetch(`/admin/users/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                REAL_USERS = REAL_USERS.filter(u => u.id != id);
                renderUsers(REAL_USERS);
                updateStats();
                alert(response.message || 'Nhân sự đã được xóa.');
            } else {
                alert(response.message || 'Lỗi khi xóa nhân sự.');
            }
        })
        .catch(error => {
            console.error('Error deleting user:', error);
            alert('Có lỗi xảy ra khi giao tiếp với server.');
        });
    }
}

// ---------- Helpers ----------
function truncate(text, length) {
    return text && text.length > length ? text.substring(0, length) + '...' : text || '';
}

function formatNumber(num) {
    return new Intl.NumberFormat('vi-VN').format(num || 0);
}

function escapeHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

// ---------- View switching ----------
function switchView(viewName) {
    const views = document.querySelectorAll('div[id^="view-"]');
    views.forEach(v => v.classList.add('hidden'));

    const target = document.getElementById(`view-${viewName}`);
    if (target) target.classList.remove('hidden');

    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => item.classList.remove('active'));
    const activeNav = document.getElementById(`nav-${viewName}`);
    if (activeNav) activeNav.classList.add('active');

    if (viewName === 'dashboard') {
        renderDashboard(REAL_STATS);
        renderStatsChart(REAL_STATS);
        renderSystemLogs();
    } else if (viewName === 'articles') {
        // Render immediately
        renderArticles(REAL_ARTICLES);

        // Render articles
    } else if (viewName === 'users') {
        // Delay render to ensure DOM is updated
        setTimeout(() => renderUsers(REAL_USERS), 100);
    }
}

// Test function
window.testModal = function() {
    console.log('TEST MODAL: Function called');
    const modal = document.getElementById('modal-article');
    console.log('TEST MODAL: Modal element:', modal);
    if (modal) {
        console.log('TEST MODAL: Adding flex class');
        modal.classList.add('flex');
        console.log('TEST MODAL: Modal should be visible now');
    } else {
        console.error('TEST MODAL: Modal element not found!');
        alert('Modal không tồn tại trong DOM!');
    }
};

// Export functions to global scope used by inline onclicks
window.switchView = switchView;
window.closeModal = (id) => {
    const el = document.getElementById(id);
    if(el) el.classList.remove('flex');
};
// Alias open functions to match test.php interface if needed
window.openArticleModal = populateAndOpenArticleModal;
window.openUserModal = populateAndOpenUserModal;
window.populateAndOpenArticleModal = populateAndOpenArticleModal;
window.handleDeleteArticle = handleDeleteArticle;
window.populateAndOpenUserModal = populateAndOpenUserModal;
window.handleDeleteUser = handleDeleteUser;
window.updateStats = () => { // Create a simple updateStats that calls renderDashboard
    renderDashboard(REAL_STATS);
};
window.saveArticle = onSaveArticle;
window.saveUser = onSaveUser;
window.deleteArticle = handleDeleteArticle;
window.deleteUser = handleDeleteUser;
window.renderArticles = renderArticles;
window.renderUsers = renderUsers;
window.openCreateArticle = openCreateArticle;

// ---------- Form đăng bài viết trong trang quản lý ----------
function toggleArticleForm() {
    const formContainer = document.getElementById('article-create-form-container');
    if (formContainer) {
        formContainer.classList.toggle('hidden');
        
        // Reset form khi ẩn
        if (formContainer.classList.contains('hidden')) {
            document.getElementById('article-create-form').reset();
        } else {
            // Scroll đến form khi hiển thị
            formContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            // Focus vào input đầu tiên
            setTimeout(() => {
                const firstInput = document.getElementById('form-article-title');
                if (firstInput) firstInput.focus();
            }, 100);
        }
        
        // Re-render icons
        if (window.lucide) lucide.createIcons();
    }
}

function submitArticleForm() {
    const form = document.getElementById('article-create-form');
    if (!form) return;

    // Lấy dữ liệu từ form
    const title = document.getElementById('form-article-title').value.trim();
    const categoryId = document.getElementById('form-article-category').value;
    const body = document.getElementById('form-article-body').value.trim();
    const excerpt = document.getElementById('form-article-excerpt').value.trim();
    const imageUrl = document.getElementById('form-article-image').value.trim();
    const status = document.querySelector('input[name="status"]:checked')?.value || 'draft';

    // Validation
    if (!title) {
        alert('Vui lòng nhập tiêu đề bài viết!');
        document.getElementById('form-article-title').focus();
        return;
    }

    if (!categoryId) {
        alert('Vui lòng chọn chuyên mục!');
        document.getElementById('form-article-category').focus();
        return;
    }

    if (!body) {
        alert('Vui lòng nhập nội dung bài viết!');
        document.getElementById('form-article-body').focus();
        return;
    }

    // Disable button và show loading
    const submitBtn = document.getElementById('submit-article-btn');
    const submitText = document.getElementById('submit-text');
    const submitLoading = document.getElementById('submit-loading');

    submitBtn.disabled = true;
    submitText.style.display = 'none';
    submitLoading.style.display = 'inline';

    // Chuẩn bị dữ liệu gửi lên API
    const apiData = {
        title: title,
        category_id: parseInt(categoryId),
        body: body,
        excerpt: excerpt || null,
        image_url: imageUrl || null,
        status: status
    };

    // Gọi API để tạo bài viết
    fetch('/admin/articles', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify(apiData)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert(result.message || 'Bài viết đã được tạo thành công!');
            
            // Thêm bài viết mới vào danh sách
            if (result.article) {
                REAL_ARTICLES.unshift(result.article);
                renderArticles(REAL_ARTICLES);
                
                // Cập nhật stats
                if (REAL_STATS) {
                    REAL_STATS.totalArticles = REAL_ARTICLES.length;
                }
                updateStats();
            }
            
            // Reset form và ẩn form
            form.reset();
            toggleArticleForm();
        } else {
            alert('Lỗi: ' + (result.message || 'Không thể tạo bài viết'));
        }
    })
    .catch(error => {
        console.error('Error creating article:', error);
        alert('Có lỗi xảy ra khi tạo bài viết. Vui lòng thử lại.');
    })
    .finally(() => {
        // Re-enable button
        submitBtn.disabled = false;
        submitText.style.display = 'inline';
        submitLoading.style.display = 'none';
    });
}

// Export functions to global scope
window.toggleArticleForm = toggleArticleForm;
window.submitArticleForm = submitArticleForm;