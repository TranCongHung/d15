<!-- MODAL: THÊM/SỬA NHÂN SỰ -->
<div id="modal-user" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <h3 id="modal-user-title">Thông tin nhân sự</h3>
            <button onclick="closeModal('modal-user')" style="background:none; border:none; cursor:pointer"><i data-lucide="x"></i></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="user-id">
            <div class="form-group full">
                <label>Họ và tên</label>
                <input type="text" id="user-name" class="form-control" placeholder="Họ tên cán bộ...">
            </div>
            <div class="form-group">
                <label>Cấp bậc</label>
                <select id="user-rank" class="form-control">
                    <option>Đại tá</option>
                    <option>Thượng tá</option>
                    <option>Trung tá</option>
                    <option>Thiếu tá</option>
                    <option>Đại úy</option>
                    <option>Trung úy</option>
                    <option>Thiếu úy</option>
                </select>
            </div>
            <div class="form-group">
                <label>Vai trò hệ thống</label>
                <select id="user-role" class="form-control">
                    <option>Quản trị viên</option>
                    <option>Biên tập viên</option>
                    <option>Người xem</option>
                </select>
            </div>
            <div class="form-group full">
                <label>Email liên hệ (Nội bộ)</label>
                <input type="email" id="user-email" class="form-control" placeholder="email@qdnd.vn">
            </div>
            <div class="form-group">
                <label>Ngày bổ nhiệm/gia nhập</label>
                <input type="text" id="user-joined" class="form-control" value="26/10/2024">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-action" onclick="closeModal('modal-user')">Hủy</button>
            <button class="btn-action btn-primary" onclick="saveUser()">Cập nhật hồ sơ</button>
        </div>
    </div>
</div>