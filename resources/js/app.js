import './bootstrap';
document.addEventListener('DOMContentLoaded', function () {
    // 1. Lấy ra nút bấm (Hamburger)
    const button = document.getElementById('mobile-menu-button');
    
    // 2. Lấy ra menu (Phần div chứa các danh mục)
    const menu = document.getElementById('mobile-menu');

    if (button && menu) {
        button.addEventListener('click', function () {
            // 3. Sử dụng toggle để thêm/xóa lớp 'hidden'
            // Khi có 'hidden', menu ẩn. Khi không có 'hidden', menu hiện (theo block)
            menu.classList.toggle('hidden'); 
        });
    }
});