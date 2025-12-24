// Dữ liệu từ PHP sang JS (không chứa Blade trực tiếp)
const REAL_STATS = window.REAL_STATS || {
    totalArticles: 0,
    totalUsers: 0,
    totalComments: 0,
    failedJobs: 0
};
let REAL_ARTICLES = window.REAL_ARTICLES || []; // Changed to let for reassignment
let REAL_USERS = window.REAL_USERS || []; // Changed to let for reassignment
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
function renderArticles(articlesData) { // Renamed parameter to avoid confusion with global REAL_ARTICLES
    const tbody = document.getElementById('articles-table');
    if (!tbody) return;

    if (!articlesData || articlesData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="padding:20px; text-align:center; color:#999;">Không có dữ liệu</td></tr>';
        return;
    }

    tbody.innerHTML = articlesData.map(a => `
        <tr>
            <td>#${a.id}</td>
            <td style="font-weight:600">${a.title}</td>
            <td>${a.cat || 'N/A'}</td>
            <td>${a.user || 'N/A'}</td>
            <td><span class="badge ${a.status === 'published' ? 'badge-success' : 'badge-warning'}">${a.status === 'published' ? 'Đã đăng' : 'Bản nháp'}</span></td>
            <td>
                <button class="btn-table" onclick="populateAndOpenArticleModal(${a.id})"><i data-lucide="edit-2" style="width:14px; color:var(--army-600)"></i></button>
                <button class="btn-table" onclick="handleDeleteArticle(${a.id})"><i data-lucide="trash" style="width:14px; color:var(--vn-red)"></i></button>
            </td>
        </tr>
    `).join('');
    if (window.lucide) lucide.createIcons();
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
        if(title) title.innerText = "Thêm bài viết mới";
    }
    document.getElementById('modal-article').style.display = 'flex';
}

function onSaveArticle() {
    const id = document.getElementById('article-id').value;
    // Extract data from DOM matching test.php logic
    const data = {
        id: id,
        title: document.getElementById('article-title').value,
        cat: document.getElementById('article-cat').value,
        user: document.getElementById('article-user').value,
        status: document.getElementById('article-status').value,
        views: parseInt(document.getElementById('article-views').value) || 0
    };
    handleSaveArticle(data);
}

function handleSaveArticle(data) {
    const isNew = !data.id;
    const method = isNew ? 'POST' : 'PUT';
    const url = isNew ? '/admin/articles' : `/admin/articles/${data.id}`;

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // Assuming CSRF token meta tag
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            if (isNew) {
                REAL_ARTICLES.unshift(response.article); // Add new article
            } else {
                const index = REAL_ARTICLES.findIndex(a => a.id == data.id);
                if (index !== -1) {
                    REAL_ARTICLES[index] = { ...REAL_ARTICLES[index], ...response.article }; // Update existing
                }
            }
            renderArticles(REAL_ARTICLES);
            updateStats();
            document.getElementById('modal-article').style.display = 'none';
            alert(response.message || 'Bài viết đã được lưu.');
        } else {
            alert(response.message || 'Lỗi khi lưu bài viết.');
        }
    })
    .catch(error => {
        console.error('Error saving article:', error);
        alert('Có lỗi xảy ra khi giao tiếp với server.');
    });
}

function handleDeleteArticle(id) {
    if(confirm('Xóa bài viết này?')) {
        fetch(`/admin/articles/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                REAL_ARTICLES = REAL_ARTICLES.filter(a => a.id != id);
                renderArticles(REAL_ARTICLES);
                updateStats();
                alert(response.message || 'Bài viết đã được xóa.');
            } else {
                alert(response.message || 'Lỗi khi xóa bài viết.');
            }
        })
        .catch(error => {
            console.error('Error deleting article:', error);
            alert('Có lỗi xảy ra khi giao tiếp với server.');
        });
    }
}

// ---------- Users table & CRUD ----------
function renderUsers(usersData) { // Renamed parameter
    const tbody = document.getElementById('users-table');
    if (!tbody) return;

    if (!usersData || usersData.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="padding:20px; text-align:center; color:#999;">Không có dữ liệu</td></tr>';
        return;
    }

    tbody.innerHTML = usersData.map(u => `
        <tr>
            <td>${u.name}</td>
            <td>${u.rank || 'N/A'}</td>
            <td>${u.role || 'N/A'}</td>
            <td>${u.email}</td>
            <td>${u.joined}</td>
            <td>
                <button class="btn-table" onclick="populateAndOpenUserModal(${u.id})"><i data-lucide="user-cog" style="width:14px; color:var(--army-600)"></i></button>
                <button class="btn-table" onclick="handleDeleteUser(${u.id})"><i data-lucide="user-minus" style="width:14px; color:var(--vn-red)"></i></button>
            </td>
        </tr>
    `).join('');
    if (window.lucide) lucide.createIcons();
}

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
    document.getElementById('modal-user').style.display = 'flex';
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
            document.getElementById('modal-user').style.display = 'none';
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

    if (viewName === 'articles') renderArticles(REAL_ARTICLES);
    else if (viewName === 'users') renderUsers(REAL_USERS);
    else if (viewName === 'dashboard') {
        renderDashboard(REAL_STATS);
        renderStatsChart(REAL_STATS);
        renderSystemLogs();
    }
}

// Export functions to global scope used by inline onclicks
window.switchView = switchView;
window.closeModal = (id) => {
    const el = document.getElementById(id);
    if(el) el.style.display = 'none';
};
// Alias open functions to match test.php interface if needed
window.openArticleModal = populateAndOpenArticleModal;
window.openUserModal = populateAndOpenUserModal;
window.populateAndOpenArticleModal = populateAndOpenArticleModal;
window.handleDeleteArticle = handleDeleteArticle;
window.populateAndOpenUserModal = populateAndOpenUserModal;
window.handleDeleteUser = handleDeleteUser;
window.renderArticles = renderArticles;
window.renderUsers = renderUsers;
window.updateStats = () => { // Create a simple updateStats that calls renderDashboard
    renderDashboard(REAL_STATS);
};
window.saveArticle = onSaveArticle;
window.saveUser = onSaveUser;
window.deleteArticle = handleDeleteArticle;
window.deleteUser = handleDeleteUser;