<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DefenseNews VN - Tin Tức Quân Sự')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700;900&family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">
    <script>
    // ... Dán toàn bộ Tailwind Config từ file HTML gốc vào đây ...
        tailwind.config = {
          theme: {
            extend: {
              colors: {
                military: {
                  red: '#8B0000', // Dark Red
                  lightRed: '#B22222',
                  gray: '#2F4F4F',
                  cream: '#F5F5DC',
                }
              },
              fontFamily: {
                sans: ['Roboto', 'sans-serif'],
                serif: ['Merriweather', 'serif'],
              }
            }
          }
        }
    </script>
    <script type="importmap">
    // ... Dán Importmap từ file HTML gốc vào đây ...
    {
      "imports": {
        "@google/genai": "https://esm.sh/@google/genai@^1.33.0"
      }
    }
    </script>
    
</head>
<body class="font-sans text-slate-800">
  <script src="{{ asset('js/app.js') }}"></script>
   
    <div id="app">
        {{-- HEADER (Sử dụng cú pháp Blade để nhúng partial) --}}
        @include('partials.header')
        
        <main>
            {{-- Vùng hiển thị nội dung chính của từng trang con --}}
            @yield('content')
        </main>

        {{-- FOOTER --}}
        @include('partials.footer')

       
    </div>
    
    {{-- Scripts JS/Logic AI (Sẽ được viết lại ở home.blade.php) --}}
    @yield('scripts')
</body>
</html>