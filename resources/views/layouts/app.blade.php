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
{
  "imports": {
    "@google/genai": "https://esm.sh/@google/genai@^1.33.0"
  }
}
      "imports": {
        "react": "https://esm.sh/react@^19.2.3",
        "react-dom/client": "https://esm.sh/react-dom@^19.2.3/client",
        "recharts": "https://esm.sh/recharts@^3.6.0",
        "xlsx": "https://esm.sh/xlsx@0.18.5"
      }
    </script>
    
</head>
<body class="font-sans text-slate-800">
  <script src="{{ asset('js/app.js') }}"></script>
   
    {{-- Background Music Player --}}
    <audio id="background-music" loop preload="none">
        <source src="{{ asset('nhac/(273) CON RỒNG CHÁU TIÊN (SS Remix) - Hùng Min - NHẠC KỈ NIỆM 50 NĂM 30-4 GIẢI PHÓNG MIỀN NAM HÀO HÙNG - YouTube.mp3') }}" type="audio/mpeg">
        Trình duyệt của bạn không hỗ trợ phát âm thanh.
    </audio>

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
    
    {{-- Background Music Control Script --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const music = document.getElementById('background-music');
        const musicToggle = document.getElementById('music-toggle');
        const musicIcon = musicToggle.querySelector('svg');

        // Check if music was previously playing (stored in localStorage)
        const isMusicPlaying = localStorage.getItem('musicPlaying') === 'true';

        if (isMusicPlaying) {
            music.volume = 0.3; // Set volume to 30%
            music.play().catch(function(error) {
                console.log('Không thể tự động phát nhạc:', error);
            });
            updateMusicIcon(true);
        }

        // Music toggle function
        window.toggleMusic = function() {
            if (music.paused) {
                music.volume = 0.3; // Set volume to 30%
                music.play().then(function() {
                    localStorage.setItem('musicPlaying', 'true');
                    updateMusicIcon(true);
                }).catch(function(error) {
                    console.log('Không thể phát nhạc:', error);
                });
            } else {
                music.pause();
                localStorage.setItem('musicPlaying', 'false');
                updateMusicIcon(false);
            }
        };

        // Update music icon based on playing state
        function updateMusicIcon(isPlaying) {
            if (isPlaying) {
                // Playing icon (filled speaker)
                musicIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />';
                musicToggle.classList.add('text-green-400');
                musicToggle.classList.remove('text-slate-300');
            } else {
                // Paused icon (outline speaker)
                musicIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />';
                musicToggle.classList.remove('text-green-400');
                musicToggle.classList.add('text-slate-300');
            }
        }

        // Update icon when music starts/stops naturally
        music.addEventListener('play', function() {
            updateMusicIcon(true);
            localStorage.setItem('musicPlaying', 'true');
        });

        music.addEventListener('pause', function() {
            updateMusicIcon(false);
            localStorage.setItem('musicPlaying', 'false');
        });
    });
    </script>

    {{-- Scripts JS/Logic AI (Sẽ được viết lại ở home.blade.php) --}}
    @yield('scripts')
</body>
</html>