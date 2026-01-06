@extends('admin.layouts.app')

@section('content')
<div style="max-width:800px;margin:auto">

    <h2>Thêm bài viết mới</h2>

    <form method="POST" 
          action="{{ route('admin.articles.store') }}" 
          enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom:12px">
            <label>Tiêu đề *</label>
            <input type="text" name="title" required class="form-control">
        </div>

        <div style="margin-bottom:12px">
            <label>Tóm tắt</label>
            <textarea name="excerpt" rows="3" class="form-control"></textarea>
        </div>

        <div style="margin-bottom:12px">
            <label>Nội dung *</label>
            <textarea name="body" rows="10" required class="form-control"></textarea>
        </div>

        <div style="margin-bottom:12px">
            <label>Chuyên mục</label>
            <select name="category_id" class="form-control">
                <option value="">-- Chọn --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom:12px">
            <label>Ảnh đại diện</label>
            <input type="file" name="thumbnail">
        </div>

        <button type="submit" class="btn btn-primary">
            Đăng bài
        </button>
    </form>
</div>
@endsection
