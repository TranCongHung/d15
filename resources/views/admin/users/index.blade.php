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
                @foreach($users as $user)
                <tr style="border-bottom:1px solid #e6edf3;">
                    <td style="padding:12px;">{{ $user->id }}</td>
                    <td style="padding:12px;">
                        <div style="font-weight:600;">{{ $user->name }}</div>
                        <div style="font-size:12px; color:#666;">
                            Đăng ký: {{ $user->created_at->format('d/m/Y') }}
                        </div>
                    </td>
                    <td style="padding:12px;">{{ $user->email }}</td>
                    <td style="padding:12px;">
                        <span class="status-badge" style="background:
                            @if($user->role === 'admin') #fef3c7; color: #d97706;
                            @elseif($user->role === 'editor') #dbeafe; color: #2563eb;
                            @else #d1fae5; color: #065f46;
                            @endif
                            padding:4px 8px; border-radius:4px; font-size:12px;">
                            @if($user->role === 'admin') Quản trị viên
                            @elseif($user->role === 'editor') Biên tập viên
                            @else Người dùng
                            @endif
                        </span>
                    </td>
                    <td style="padding:12px; text-align:center;">
                        <button class="action-btn" style="margin-right:8px; color:#3b82f6;" onclick="populateAndOpenUserModal({{ $user->id }})" title="Chỉnh sửa">
                            <i data-lucide="edit" style="width:16px; height:16px;"></i>
                        </button>
                        @if($user->id !== auth()->id())
                        <button class="action-btn" style="color:#ef4444;" onclick="handleDeleteUser({{ $user->id }})" title="Xóa">
                            <i data-lucide="trash" style="width:16px; height:16px;"></i>
                        </button>
                        @else
                        <span style="color:#9ca3af; cursor:not-allowed;" title="Không thể xóa tài khoản hiện tại">
                            <i data-lucide="trash" style="width:16px; height:16px;"></i>
                        </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($users->isEmpty())
        <div style="text-align:center; padding:40px; color:#666;">
            <i data-lucide="users" style="width:48px; height:48px; margin-bottom:16px; opacity:0.5;"></i>
            <p>Chưa có người dùng nào trong hệ thống</p>
        </div>
        @endif
    </div>
</div>
