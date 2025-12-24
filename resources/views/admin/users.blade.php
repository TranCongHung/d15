<div id="view-users" class="hidden">
    <div class="view-header">
        <div class="view-title">
            <h2>Nhân sự</h2>
            <p>Danh sách tài khoản và thông tin liên quan</p>
        </div>
        <button class="btn-ai" style="background:var(--army-600)" onclick="openCreateUser()">
            <i data-lucide="user-plus"></i> Thêm nhân sự
        </button>
    </div>

    <div class="data-table-container" style="margin-top:16px;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f7fafc; border-bottom:1px solid #e6edf3;">
                    <th style="padding:12px; text-align:left; width:80px;">ID</th>
                    <th style="padding:12px; text-align:left;">Họ & Tên</th>
                    <th style="padding:12px; text-align:left; width:200px;">Email</th>
                    <th style="padding:12px; text-align:left; width:160px;">Chức vụ</th>
                    <th style="padding:12px; text-align:center; width:140px;">Hành động</th>
                </tr>
            </thead>
            <tbody id="users-table">
                <!-- Rendered by admin.js -->
            </tbody>
        </table>
    </div>
</div>