@extends('layouts.admin')

@section('content')
<div class="view-header">
    <div class="view-title">
        <h2>Chỉnh Sửa Người Dùng</h2>
        <p>Cập nhật thông tin tài khoản: {{ $user->name }}</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn-ai" style="background: var(--gray-500)">
        <i data-lucide="arrow-left"></i> Quay lại
    </a>
</div>

@if($errors->any())
    <div class="alert alert-error" style="margin-top: 16px; padding: 12px; background: #fee2e2; border: 1px solid #ef4444; border-radius: 6px; color: #991b1b;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.users.update', $user) }}" method="POST" style="margin-top:24px; max-width:600px;">
    @csrf
    @method('PUT')

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div>
            <label for="name" style="display:block; font-weight:600; margin-bottom:8px;">Họ và tên <span style="color:red">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                   style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-size:14px;">
        </div>

        <div>
            <label for="email" style="display:block; font-weight:600; margin-bottom:8px;">Email <span style="color:red">*</span></label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                   style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-size:14px;">
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 16px;">
        <div>
            <label for="role" style="display:block; font-weight:600; margin-bottom:8px;">Chức vụ <span style="color:red">*</span></label>
            <select id="role" name="role" required style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-size:14px;">
                <option value="">-- Chọn chức vụ --</option>
                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Người dùng</option>
                <option value="editor" {{ old('role', $user->role) === 'editor' ? 'selected' : '' }}>Biên tập viên</option>
                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Quản trị viên</option>
            </select>
        </div>

        <div>
            <label for="phone" style="display:block; font-weight:600; margin-bottom:8px;">Số điện thoại</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                   style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-size:14px;"
                   placeholder="Ví dụ: 0987654321">
        </div>
    </div>

    <div style="margin-top: 16px; background: #fef3c7; padding: 16px; border-radius: 6px; border: 1px solid #f59e0b;">
        <h4 style="margin: 0 0 8px 0; color: #d97706; font-weight: 600;">Đổi mật khẩu (tùy chọn)</h4>
        <p style="margin: 0 0 12px 0; color: #92400e; font-size: 14px;">Để trống nếu không muốn đổi mật khẩu</p>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <label for="password" style="display:block; font-weight:600; margin-bottom:8px;">Mật khẩu mới</label>
                <input type="password" id="password" name="password"
                       style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-size:14px;"
                       placeholder="Ít nhất 8 ký tự">
            </div>

            <div>
                <label for="password_confirmation" style="display:block; font-weight:600; margin-bottom:8px;">Xác nhận mật khẩu mới</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-size:14px;">
            </div>
        </div>
    </div>

    <div style="border-top: 1px solid #eee; padding-top: 20px; margin-top: 24px;">
        <button type="submit" class="btn-ai" style="background: var(--army-600)">
            <i data-lucide="save"></i> Cập nhật tài khoản
        </button>
        <a href="{{ route('admin.users.index') }}" class="btn-ai" style="background: var(--gray-500); margin-left: 12px;">
            Hủy
        </a>
    </div>
</form>
@endsection





