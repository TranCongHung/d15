<div id="create-article-view" class="hidden" style="max-width: 800px; margin: auto;">
    <div class="view-header">
        <div class="view-title">
            <h2>Thêm bài viết mới</h2>
            <p>Soạn thảo và xuất bản một tin bài mới</p>
        </div>
        <button class="btn-ai" style="background: var(--gray-500)" onclick="closeCreateArticle()">
            <i data-lucide="arrow-left"></i> Quay lại
        </button>
    </div>

    <form id="create-article-form" style="margin-top:16px;" enctype="multipart/form-data">
        @csrf
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
            <!-- Cột trái: Nội dung chính -->
            <div>
                <div style="margin-bottom: 16px;">
                    <label for="title" style="display:block; font-weight:600; margin-bottom:8px;">Tiêu đề <span style="color:red">*</span></label>
                    <input type="text" id="title" name="title" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;" placeholder="Nhập tiêu đề bài viết...">
                </div>
                
                <div style="margin-bottom: 16px;">
                    <label for="excerpt" style="display:block; font-weight:600; margin-bottom:8px;">Tóm tắt</label>
                    <textarea name="excerpt" id="excerpt" rows="3" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;" placeholder="Mô tả ngắn gọn nội dung..."></textarea>
                </div>

                <div style="margin-bottom: 16px;">
                    <label for="body" style="display:block; font-weight:600; margin-bottom:8px;">Nội dung chi tiết <span style="color:red">*</span></label>
                    <textarea name="body" id="body" rows="15" required style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"></textarea>
                </div>
            </div>

            <!-- Cột phải: Thông tin bổ sung -->
            <div>
                <div style="margin-bottom: 16px;">
                    <label for="category_id" style="display:block; font-weight:600; margin-bottom:8px;">Chuyên mục</label>
                    <select name="category_id" id="category_id" style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                        <option value="">-- Chọn chuyên mục --</option>
                        @if(isset($categories))
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div style="margin-bottom: 16px;">
                    <label for="thumbnail" style="display:block; font-weight:600; margin-bottom:8px;">Ảnh đại diện</label>
                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*" style="width:100%; padding: 4px; border: 1px solid #ccc; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 16px; background: #f8f9fa; padding: 12px; border-radius: 6px; border: 1px solid #e9ecef;">
                    <label style="display:block; font-weight:600; margin-bottom:8px;">Thiết lập</label>
                    
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer; margin-bottom:8px;">
                        <input type="checkbox" name="is_published" value="1" checked>
                        <span>Xuất bản ngay</span>
                    </label>
                    
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="checkbox" name="is_featured" value="1">
                        <span>Tin nổi bật</span>
                    </label>
                </div>
            </div>
        </div>

        <div style="border-top: 1px solid #eee; padding-top: 16px; margin-top: 8px;">
            <button type="submit" class="btn-ai" style="background: var(--army-600)">
                <i data-lucide="save"></i> Đăng bài
            </button>
        </div>
    </form>
</div>
