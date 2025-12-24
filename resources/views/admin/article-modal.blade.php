<!-- MODAL: THÊM/SỬA BÀI VIẾT -->
<div id="modal-article" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <h3 id="modal-article-title">Soạn thảo văn bản</h3>
            <button onclick="closeModal('modal-article')" style="background:none; border:none; cursor:pointer"><i data-lucide="x"></i></button>
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
                <input type="text" id="article-user" class="form-control">
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
        </div>
        <div class="modal-footer">
            <button class="btn-action" onclick="closeModal('modal-article')">Hủy</button>
            <button class="btn-action btn-primary" onclick="saveArticle()">Lưu bài viết</button>
        </div>
    </div>
</div>