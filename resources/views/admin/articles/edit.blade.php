@extends('layouts.admin')

@section('content')
<div class="view-header">
    <div class="view-title">
        <h2>Chỉnh Sửa Bài Viết</h2>
        <p>Cập nhật nội dung bài viết: {{ $article->title }}</p>
    </div>
    <a href="{{ route('admin.articles.index') }}" class="btn-ai" style="background: var(--gray-500)">
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

<form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data" style="margin-top:24px;">
    @csrf
    @method('PUT')

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        <!-- Cột trái: Nội dung chính -->
        <div>
            <div style="margin-bottom: 16px;">
                <label for="title" style="display:block; font-weight:600; margin-bottom:8px;">Tiêu đề <span style="color:red">*</span></label>
                <input type="text" id="title" name="title" required
                       value="{{ old('title', $article->title) }}"
                       style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-size:16px; font-weight:600;">
            </div>

            <div style="margin-bottom: 16px;">
                <label for="excerpt" style="display:block; font-weight:600; margin-bottom:8px;">Tóm tắt</label>
                <textarea name="excerpt" id="excerpt" rows="3"
                          style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-size:14px;"
                          placeholder="Mô tả ngắn gọn nội dung...">{{ old('excerpt', $article->excerpt) }}</textarea>
            </div>

            <div style="margin-bottom: 16px;">
                <label for="body" style="display:block; font-weight:600; margin-bottom:8px;">Nội dung chi tiết <span style="color:red">*</span></label>
                <textarea name="body" id="body" rows="20" required
                          style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px; font-size:14px; font-family:monospace;">{{ old('body', $article->body) }}</textarea>
            </div>
        </div>

        <!-- Cột phải: Thông tin bổ sung -->
        <div>
            <div style="margin-bottom: 16px;">
                <label for="category_id" style="display:block; font-weight:600; margin-bottom:8px;">Chuyên mục</label>
                <select name="category_id" id="category_id" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:6px;">
                    <option value="">-- Chọn chuyên mục --</option>
                    @if(isset($categories))
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div style="margin-bottom: 16px;">
                <label for="image" style="display:block; font-weight:600; margin-bottom:8px;">Ảnh đại diện</label>
                @if($article->image_url)
                    <div style="margin-bottom: 8px;">
                        <img src="{{ asset($article->image_url) }}" alt="Current image" style="max-width: 100%; height: 150px; object-fit: cover; border-radius: 6px;">
                    </div>
                @endif
                <input type="file" name="image" id="image" accept="image/*"
                       style="width:100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 6px;">
                <small style="color: #666; font-size: 12px;">Để trống nếu không muốn thay đổi ảnh. Định dạng: JPG, PNG, GIF. Kích thước tối đa: 4MB.</small>
            </div>

            <div style="margin-bottom: 16px; background: #f8f9fa; padding: 12px; border-radius: 6px; border: 1px solid #e9ecef;">
                <label style="display:block; font-weight:600; margin-bottom:8px;">Thông tin bổ sung</label>

                <div style="margin-bottom: 12px;">
                    <strong>Tác giả:</strong> {{ $article->author->name ?? 'N/A' }}
                </div>

                <div style="margin-bottom: 12px;">
                    <strong>Lượt xem:</strong> {{ $article->view_count }}
                </div>

                <div style="margin-bottom: 12px;">
                    <strong>Ngày tạo:</strong> {{ $article->created_at->format('d/m/Y H:i') }}
                </div>

                <div style="margin-bottom: 12px;">
                    <strong>Cập nhật:</strong> {{ $article->updated_at->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>
    </div>

    <div style="border-top: 1px solid #eee; padding-top: 20px; margin-top: 24px;">
        <button type="submit" class="btn-ai" style="background: var(--army-600)">
            <i data-lucide="save"></i> Cập nhật bài viết
        </button>
        <a href="{{ route('admin.articles.index') }}" class="btn-ai" style="background: var(--gray-500); margin-left: 12px;">
            Hủy
        </a>
    </div>
</form>
@endsection





