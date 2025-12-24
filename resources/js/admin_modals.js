// MODAL HELPERS
window.closeModal = (id) => document.getElementById(id).style.display = 'none';

window.openArticleModal = (id = null) => {
    const title = document.getElementById('modal-article-title');
    // Data population will be handled by admin.js based on REAL_ARTICLES
    if(id) {
        title.innerText = "Chỉnh sửa bài viết #" + id;
    } else {
        document.getElementById('article-id').value = "";
        document.getElementById('article-title').value = "";
        document.getElementById('article-user').value = "Đại tá Nguyễn Văn A"; // Default author
        document.getElementById('article-views').value = 0;
        document.getElementById('article-status').value = "draft"; // Default status
        document.getElementById('article-cat').value = ""; // Clear category
        title.innerText = "Thêm bài viết mới";
    }
    document.getElementById('modal-article').style.display = 'flex';
};

window.openUserModal = (id = null) => {
    const title = document.getElementById('modal-user-title');
    // Data population will be handled by admin.js based on REAL_USERS
    if(id) {
        title.innerText = "Cập nhật hồ sơ nhân sự #" + id;
    } else {
        document.getElementById('user-id').value = "";
        document.getElementById('user-name').value = "";
        document.getElementById('user-email').value = "";
        document.getElementById('user-joined').value = "26/10/2024"; // Default joined date
        document.getElementById('user-rank').value = ""; // Clear rank
        document.getElementById('user-role').value = ""; // Clear role
        title.innerText = "Thêm nhân sự mới";
    }
    document.getElementById('modal-user').style.display = 'flex';
};

// CRUD LOGIC - These functions now collect data and trigger callbacks
window.saveArticle = (onSuccess) => {
    const id = document.getElementById('article-id').value;
    const data = {
        id: id, // Include ID for update operations
        title: document.getElementById('article-title').value,
        cat: document.getElementById('article-cat').value,
        user: document.getElementById('article-user').value,
        status: document.getElementById('article-status').value,
        views: parseInt(document.getElementById('article-views').value) || 0
    };
    closeModal('modal-article');
    if (onSuccess) onSuccess(data);
};

window.saveUser = (onSuccess) => {
    const id = document.getElementById('user-id').value;
    const data = {
        id: id, // Include ID for update operations
        name: document.getElementById('user-name').value,
        rank: document.getElementById('user-rank').value,
        role: document.getElementById('user-role').value,
        email: document.getElementById('user-email').value,
        joined: document.getElementById('user-joined').value
    };
    closeModal('modal-user');
    if (onSuccess) onSuccess(data);
};

window.deleteArticle = (id, onSuccess) => { 
    if(confirm('Xóa bài viết này?')) { 
        if (onSuccess) onSuccess(id); 
    } 
};

window.deleteUser = (id, onSuccess) => { 
    if(confirm('Xóa nhân sự này?')) { 
        if (onSuccess) onSuccess(id); 
    } 
};

export { openArticleModal, openUserModal, saveArticle, saveUser, deleteArticle, deleteUser, closeModal };
