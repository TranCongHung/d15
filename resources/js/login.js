document.addEventListener('DOMContentLoaded', function() {
    // 1. KHAI BÁO BIẾN & LẤY ELEMENTS
    
    // Elements của Modal
    const authModal = document.getElementById('auth-modal');
    const loginTab = document.getElementById('login-tab');
    const registerTab = document.getElementById('register-tab');
    const submitButton = document.getElementById('auth-submit-button');
    
    // Các trường Đăng ký
    const nameGroup = document.getElementById('name-group');
    const passwordConfirmGroup = document.getElementById('password-confirm-group');

    // Kiểm tra các phần tử thiết yếu có tồn tại không
    if (!authModal || !loginTab || !registerTab || !submitButton || !nameGroup || !passwordConfirmGroup) {
        console.error("Auth Modal or its core elements not found in the DOM. Check your HTML structure.");
        return; 
    }

    // 2. KHAI BÁO CÁC HÀM TOÀN CỤC (Gán vào window)

    /**
     * Mở Modal và thiết lập chế độ
     */
    window.openAuth = function(mode) {
        authModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden'); 
        window.setAuthMode(mode);
    }

    /**
     * Đóng Modal
     */
    window.closeAuth = function() {
        authModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    /**
     * Thay đổi giữa giao diện Đăng nhập và Đăng ký (Tab switch)
     */
    window.setAuthMode = function(mode) {
        if (mode === 'LOGIN') {
            // Cập nhật UI Tabs
            loginTab.classList.add('text-military-red', 'border-military-red');
            loginTab.classList.remove('text-gray-400', 'border-transparent');
            registerTab.classList.remove('text-military-red', 'border-military-red');
            registerTab.classList.add('text-gray-400', 'border-transparent');
            submitButton.textContent = 'ĐĂNG NHẬP HỆ THỐNG';

            // Ẩn các trường Đăng ký và loại bỏ required
            nameGroup.classList.add('hidden');
            passwordConfirmGroup.classList.add('hidden');
            nameGroup.querySelector('input').removeAttribute('required');
            passwordConfirmGroup.querySelector('input').removeAttribute('required');

        } else if (mode === 'REGISTER') {
            // Cập nhật UI Tabs
            registerTab.classList.add('text-military-red', 'border-military-red');
            registerTab.classList.remove('text-gray-400', 'border-transparent');
            loginTab.classList.remove('text-military-red', 'border-military-red');
            loginTab.classList.add('text-gray-400', 'border-transparent');
            submitButton.textContent = 'ĐĂNG KÝ NGAY';

            // Hiển thị các trường Đăng ký và thêm required
            nameGroup.classList.remove('hidden');
            passwordConfirmGroup.classList.remove('hidden');
            nameGroup.querySelector('input').setAttribute('required', 'required');
            passwordConfirmGroup.querySelector('input').setAttribute('required', 'required');
        }
    }

    /**
     * Xử lý sự kiện gửi form (AJAX)
     */
    window.handleAuthSubmit = function(event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);
        const mode = submitButton.textContent.includes('ĐĂNG KÝ') ? 'REGISTER' : 'LOGIN';
        
        let url = mode === 'REGISTER' ? '/register-modal' : '/login-modal'; // Cần định nghĩa route này trong Laravel
        let method = 'POST';

        // Lấy CSRF token từ thẻ meta
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        if (csrfMeta) {
             formData.append('_token', csrfMeta.getAttribute('content'));
        } else {
             console.error('CSRF token not found.');
             alert('Lỗi bảo mật: Thiếu CSRF Token.');
             return;
        }

        // Gửi yêu cầu AJAX
        fetch(url, {
            method: method,
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                // Nếu status code là lỗi (4xx, 5xx), cố gắng đọc body lỗi
                return response.json().then(data => Promise.reject({ status: response.status, body: data }));
            }
            return response.json().then(data => ({ status: response.status, body: data }));
        })
        .then(({ status, body }) => {
            // Thành công (200, 201)
            alert(body.message); 
            window.closeAuth();
            window.location.href = body.redirect || '/';
        })
        .catch(error => {
            console.error('AJAX/Fetch Error:', error);
            
            let message = 'Có lỗi xảy ra.';
            if (error.status === 422 && error.body && error.body.errors) {
                // Xử lý lỗi xác thực Laravel
                const firstErrorKey = Object.keys(error.body.errors)[0];
                message = 'Lỗi xác thực: ' + error.body.errors[firstErrorKey][0];
            } else if (error.body && error.body.message) {
                 message = error.body.message;
            } else if (error.status) {
                 message = `Lỗi máy chủ (${error.status}).`;
            } else {
                message = "Không thể kết nối đến máy chủ. Vui lòng thử lại.";
            }
            alert(message);
        });
    }

    // 3. THÊM LISTENER ĐÓNG MODAL BẰNG ESC (Tùy chọn)
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !authModal.classList.contains('hidden')) {
            window.closeAuth();
        }
    });
});