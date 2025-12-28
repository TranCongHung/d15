<div id="view-articles" class="hidden">
    <div class="view-header">
        <div class="view-title">
            <h2>Quản lý Bài viết</h2>
            <p>Danh sách tin bài, văn bản và các chỉ thị quân sự</p>
        </div>
        <button class="btn-ai" style="background: var(--army-600)" onclick="toggleArticleForm()">
            <i data-lucide="plus"></i> Thêm bài mới
        </button>
    </div>
<!-- MODAL: THÊM/SỬA BÀI VIẾT -->
<div id="modal-article" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <h3 id="modal-article-title">Thêm bài viết mới</h3>
            <button onclick="closeModal('modal-article')" style="background:none; border:none; cursor:pointer"><i data-lucide="x"></i></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="article-id">
            <div class="form-group full">
                <label>Tiêu đề bài viết <span style="color: #ef4444;">*</span></label>
                <input type="text" id="article-title" class="form-control" placeholder="Nhập tiêu đề bài viết..." required>
                <small style="color: #6b7280; font-size: 12px;">Tiêu đề sẽ được sử dụng để tạo URL thân thiện</small>
            </div>
            <div class="form-group">
                <label>Chuyên mục <span style="color: #ef4444;">*</span></label>
                <select id="article-cat" class="form-control" required>
                    <option value="">Chọn chuyên mục</option>
                    <option value="1">Quốc phòng toàn dân</option>
                    <option value="2">Hậu cần - Kỹ thuật</option>
                    <option value="3">Huấn luyện chiến đấu</option>
                    <option value="4">Công tác Đảng</option>
                </select>
            </div>
            <div class="form-group">
                <label>Người soạn / Tác giả</label>
                <input type="text" id="article-user" class="form-control" value="Đại tá Nguyễn Văn A" readonly>
                <small style="color: #6b7280; font-size: 12px;">Tác giả mặc định (có thể thay đổi sau)</small>
            </div>
            <div class="form-group">
                <label>Trạng thái</label>
                <select id="article-status" class="form-control">
                    <option value="draft">Bản nháp</option>
                    <option value="published">Đã xuất bản</option>
                </select>
            </div>
            <div class="form-group full">
                <label>Tóm tắt bài viết</label>
                <textarea id="article-excerpt" class="form-control" rows="3" placeholder="Nhập tóm tắt ngắn gọn về bài viết..."></textarea>
                <small style="color: #6b7280; font-size: 12px;">Tóm tắt sẽ hiển thị ở trang chủ và kết quả tìm kiếm</small>
            </div>
            <div class="form-group full">
                <label>Nội dung bài viết <span style="color: #ef4444;">*</span></label>
                <textarea id="article-content" class="form-control" rows="8" placeholder="Nhập nội dung chi tiết của bài viết..." required></textarea>
                <small style="color: #6b7280; font-size: 12px;">Nội dung đầy đủ của bài viết</small>
            </div>
            <div class="form-group full">
                <label>Ảnh bài viết</label>
                <input type="file" id="article-image" class="form-control" accept="image/*">
                <small style="color: #6b7280; font-size: 12px;">Chọn ảnh đại diện cho bài viết (không bắt buộc)</small>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-action" onclick="closeModal('modal-article')">Hủy</button>
            <button class="btn-action btn-primary" onclick="saveArticle()" id="save-article-btn">
                <span id="save-text">Lưu bài viết</span>
                <span id="saving-text" style="display: none;">Đang lưu...</span>
            </button>
        </div>
    </div>
</div>
    <!-- Form đăng bài viết -->
    <div id="article-create-form-container" class="hidden" style="margin-top: 24px; background: white; border-radius: 8px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #e6edf3; padding-bottom: 16px;">
            <h3 style="margin: 0; font-size: 20px; font-weight: 600; color: #111827;">Thêm bài viết mới</h3>
            <button onclick="toggleArticleForm()" style="background: none; border: none; cursor: pointer; color: #6b7280; font-size: 18px; padding: 4px 8px;">
                <i data-lucide="x"></i>
            </button>
        </div>

        <form id="article-create-form" style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
            @csrf
            <!-- Cột trái: Nội dung chính -->
            <div>
                <div style="margin-bottom: 20px;">
                    <label for="form-article-title" style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">
                        Tiêu đề bài viết <span style="color: #ef4444;">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="form-article-title" 
                        name="title" 
                        required 
                        style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; transition: border-color 0.2s;"
                        placeholder="Nhập tiêu đề bài viết..."
                        onfocus="this.style.borderColor='#48602a'"
                        onblur="this.style.borderColor='#d1d5db'"
                    >
                    <small style="color: #6b7280; font-size: 12px; display: block; margin-top: 4px;">Tiêu đề sẽ được sử dụng để tạo URL thân thiện</small>
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="form-article-excerpt" style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">
                        Tóm tắt bài viết
                    </label>
                    <textarea 
                        id="form-article-excerpt" 
                        name="excerpt" 
                        rows="3" 
                        style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; resize: vertical; font-family: inherit; transition: border-color 0.2s;"
                        placeholder="Nhập tóm tắt ngắn gọn về bài viết..."
                        onfocus="this.style.borderColor='#48602a'"
                        onblur="this.style.borderColor='#d1d5db'"
                    ></textarea>
                    <small style="color: #6b7280; font-size: 12px; display: block; margin-top: 4px;">Tóm tắt sẽ hiển thị ở trang chủ và kết quả tìm kiếm</small>
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="form-article-body" style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">
                        Nội dung chi tiết <span style="color: #ef4444;">*</span>
                    </label>
                    <textarea 
                        id="form-article-body" 
                        name="body" 
                        rows="15" 
                        required 
                        style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; resize: vertical; font-family: inherit; transition: border-color 0.2s;"
                        placeholder="Nhập nội dung chi tiết của bài viết..."
                        onfocus="this.style.borderColor='#48602a'"
                        onblur="this.style.borderColor='#d1d5db'"
                    ></textarea>
                    <small style="color: #6b7280; font-size: 12px; display: block; margin-top: 4px;">Nội dung đầy đủ của bài viết</small>
                </div>
            </div>

            <!-- Cột phải: Thông tin bổ sung -->
            <div>
                <div style="margin-bottom: 20px;">
                    <label for="form-article-category" style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">
                        Chuyên mục <span style="color: #ef4444;">*</span>
                    </label>
                    <select 
                        id="form-article-category" 
                        name="category_id" 
                        required
                        style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; background: white; cursor: pointer; transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#48602a'"
                        onblur="this.style.borderColor='#d1d5db'"
                    >
                        <option value="">-- Chọn chuyên mục --</option>
                        <option value="1">Quốc phòng toàn dân</option>
                        <option value="2">Hậu cần - Kỹ thuật</option>
                        <option value="3">Huấn luyện chiến đấu</option>
                        <option value="4">Công tác Đảng</option>
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="form-article-image" style="display: block; font-weight: 600; margin-bottom: 8px; color: #374151;">
                        URL ảnh đại diện
                    </label>
                    <input 
                        type="text" 
                        id="form-article-image" 
                        name="image_url" 
                        style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; transition: border-color 0.2s;"
                        placeholder="https://example.com/image.jpg"
                        onfocus="this.style.borderColor='#48602a'"
                        onblur="this.style.borderColor='#d1d5db'"
                    >
                    <small style="color: #6b7280; font-size: 12px; display: block; margin-top: 4px;">Nhập đường dẫn URL của ảnh đại diện</small>
                </div>

                <div style="margin-bottom: 20px; background: #f8f9fa; padding: 16px; border-radius: 6px; border: 1px solid #e9ecef;">
                    <label style="display: block; font-weight: 600; margin-bottom: 12px; color: #374151;">Thiết lập</label>
                    
                    <div style="margin-bottom: 12px;">
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input 
                                type="radio" 
                                name="status" 
                                value="published" 
                                id="form-status-published"
                                checked
                                style="width: 16px; height: 16px; cursor: pointer;"
                            >
                            <span style="color: #374151;">Xuất bản ngay</span>
                        </label>
                    </div>
                    
                    <div>
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input 
                                type="radio" 
                                name="status" 
                                value="draft" 
                                id="form-status-draft"
                                style="width: 16px; height: 16px; cursor: pointer;"
                            >
                            <span style="color: #374151;">Lưu bản nháp</span>
                        </label>
                    </div>
                </div>
            </div>
        </form>

        <div style="border-top: 1px solid #e6edf3; padding-top: 20px; margin-top: 20px; display: flex; justify-content: flex-end; gap: 12px;">
            <button 
                type="button" 
                onclick="toggleArticleForm()" 
                style="padding: 10px 20px; border: 1px solid #d1d5db; background: white; color: #374151; border-radius: 6px; cursor: pointer; font-weight: 500; transition: all 0.2s;"
                onmouseover="this.style.backgroundColor='#f9fafb'"
                onmouseout="this.style.backgroundColor='white'"
            >
                Hủy
            </button>
            <button 
                type="button" 
                onclick="submitArticleForm()" 
                id="submit-article-btn"
                style="padding: 10px 20px; background: #48602a; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 500; transition: background-color 0.2s; display: flex; align-items: center; gap: 8px;"
                onmouseover="this.style.backgroundColor='#3d4f23'"
                onmouseout="this.style.backgroundColor='#48602a'"
            >
                <i data-lucide="save" style="width: 16px; height: 16px;"></i>
                <span id="submit-text">Đăng bài</span>
                <span id="submit-loading" style="display: none;">Đang lưu...</span>
            </button>
        </div>
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
</div>

