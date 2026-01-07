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
   
    {{-- Audio element for music player --}}
    <audio id="music-player-audio" preload="none">
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
    
    {{-- Music Player Script with YouTube Integration --}}
    <script>
    // Load YouTube iframe API
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    // Official Military Songs Playlist - 15 Vietnamese Army Songs
    const MILITARY_SONGS = [
        {
            id: 1,
            title: "Quốc tế ca",
            artist: "Nhạc Cách Mạng",
            url: "https://www.youtube.com/watch?v=_DaDMvA_Gkw",
            videoId: "_DaDMvA_Gkw",
            duration: "4:15",
            category: "Quốc Tế"
        },
        {
            id: 2,
            title: "Tiến quân ca (Quốc ca)",
            artist: "Văn Cao",
            url: "https://www.youtube.com/watch?v=J0y6wM0aAgE",
            videoId: "J0y6wM0aAgE",
            duration: "2:45",
            category: "Quốc Ca"
        },
        {
            id: 3,
            title: "Ca ngợi Hồ Chủ tịch",
            artist: "Nhạc Cách Mạng",
            url: "https://www.youtube.com/watch?v=8F0eF0xY6nM",
            videoId: "8F0eF0xY6nM",
            duration: "3:30",
            category: "Lãnh Tụ"
        },
        {
            id: 4,
            title: "Chào mừng Đảng Cộng sản Việt Nam",
            artist: "Nhạc Đảng",
            url: "https://www.youtube.com/watch?v=Vq8gTyRE6wo",
            videoId: "Vq8gTyRE6wo",
            duration: "4:05",
            category: "Đảng"
        },
        {
            id: 5,
            title: "Vì Nhân dân quên mình",
            artist: "Nhạc Quân Đội",
            url: "https://www.youtube.com/watch?v=2kG8t1H5J9g",
            videoId: "2kG8t1H5J9g",
            duration: "3:55",
            category: "Quân Đội"
        },
        {
            id: 6,
            title: "Giải phóng Điện Biên",
            artist: "Nhạc Chiến Thắng",
            url: "https://www.youtube.com/watch?v=9ZK9Yk1z9WQ",
            videoId: "9ZK9Yk1z9WQ",
            duration: "4:20",
            category: "Chiến Thắng"
        },
        {
            id: 7,
            title: "Tiến bước dưới quân kỳ",
            artist: "Nhạc Quân Đội",
            url: "https://www.youtube.com/watch?v=Jz7h6kC5e0Q",
            videoId: "Jz7h6kC5e0Q",
            duration: "3:42",
            category: "Quân Đội"
        },
        {
            id: 8,
            title: "Bác đang cùng chúng cháu hành quân",
            artist: "Nhạc Thiếu Nhi",
            url: "https://www.youtube.com/watch?v=7yVvK1xvVZk",
            videoId: "7yVvK1xvVZk",
            duration: "3:15",
            category: "Thiếu Nhi"
        },
        {
            id: 9,
            title: "Thanh niên làm theo lời Bác",
            artist: "Nhạc Thanh Niên",
            url: "https://www.youtube.com/watch?v=5y6j7pQ9ZJQ",
            videoId: "5y6j7pQ9ZJQ",
            duration: "4:10",
            category: "Thanh Niên"
        },
        {
            id: 10,
            title: "Hát mãi khúc quân hành",
            artist: "Nhạc Quân Đội",
            url: "https://www.youtube.com/watch?v=G8z6V0Yq9Vg",
            videoId: "G8z6V0Yq9Vg",
            duration: "3:48",
            category: "Quân Đội"
        },
        {
            id: 11,
            title: "Như có Bác trong ngày vui đại thắng",
            artist: "Nhạc Chiến Thắng",
            url: "https://www.youtube.com/watch?v=Zqz6C7n8RzM",
            videoId: "Zqz6C7n8RzM",
            duration: "4:25",
            category: "Chiến Thắng"
        },
        {
            id: 12,
            title: "Trái tim chiến sĩ",
            artist: "Nhạc Quân Đội",
            url: "https://www.youtube.com/watch?v=H0wZq6s9m7E",
            videoId: "H0wZq6s9m7E",
            duration: "3:35",
            category: "Quân Đội"
        },
        {
            id: 13,
            title: "Cuộc đời vẫn đẹp sao",
            artist: "Nhạc Dân Ca",
            url: "https://www.youtube.com/watch?v=YF6Q2qv8K7Y",
            videoId: "YF6Q2qv8K7Y",
            duration: "4:02",
            category: "Dân Ca"
        },
        {
            id: 14,
            title: "Ước mơ chiến sĩ",
            artist: "Nhạc Quân Đội",
            url: "https://www.youtube.com/watch?v=8m6Yp5N3F4A",
            videoId: "8m6Yp5N3F4A",
            duration: "3:50",
            category: "Quân Đội"
        },
        {
            id: 15,
            title: "Tổ quốc trong tim",
            artist: "Nhạc Tổ Quốc",
            url: "https://www.youtube.com/watch?v=KJ4y9N0F8yE",
            videoId: "KJ4y9N0F8yE",
            duration: "4:18",
            category: "Tổ Quốc"
        }
    ];

    let currentSongIndex = 0;
    let isPlaying = false;
    let player = null;
    let songs = MILITARY_SONGS;

    // YouTube Player API callback
    function onYouTubeIframeAPIReady() {
        player = new YT.Player('youtube-player', {
            height: '100%',
            width: '100%',
            videoId: songs[0].videoId,
            playerVars: {
                'playsinline': 1,
                'controls': 0,
                'modestbranding': 1,
                'rel': 0,
                'showinfo': 0,
                'iv_load_policy': 3,
                'cc_load_policy': 0,
                'disablekb': 1,
                'fs': 0
            },
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }

    function onPlayerReady(event) {
        // Player is ready
        initializeMusicPlayer();

        // Check if music was previously playing (stored in localStorage)
        const savedSongIndex = localStorage.getItem('currentSongIndex');
        const savedIsPlaying = localStorage.getItem('musicPlaying') === 'true';

        if (savedSongIndex !== null) {
            currentSongIndex = parseInt(savedSongIndex);
            loadSong(currentSongIndex, false);
        }

        if (savedIsPlaying && player) {
            player.playVideo();
            isPlaying = true;
            updatePlayPauseButton();
        }
    }

    function onPlayerStateChange(event) {
        if (event.data === YT.PlayerState.ENDED) {
            playNext();
        } else if (event.data === YT.PlayerState.PLAYING) {
            isPlaying = true;
            updatePlayPauseButton();
        } else if (event.data === YT.PlayerState.PAUSED) {
            isPlaying = false;
            updatePlayPauseButton();
        }
    }

    function initializeMusicPlayer() {
        // Populate playlist
        const playlistContainer = document.querySelector('#music-player-modal .space-y-2');
        if (playlistContainer && songs.length > 0) {
            songs.forEach((song, index) => {
                const songElement = document.createElement('div');
                songElement.className = `flex items-center justify-between p-3 rounded-lg cursor-pointer transition-colors hover:bg-slate-50 border ${index === currentSongIndex ? 'border-military-red bg-red-50' : 'border-gray-100'}`;
                songElement.onclick = () => playSong(index);

                songElement.innerHTML = `
                    <div class="flex-1">
                        <div class="font-medium text-sm text-gray-900 truncate">${song.title}</div>
                        <div class="text-xs text-gray-500">${song.artist} • ${song.category}</div>
                    </div>
                    <div class="text-xs text-gray-400">${song.duration}</div>
                    ${index === currentSongIndex ? '<div class="w-2 h-2 bg-military-red rounded-full ml-2"></div>' : ''}
                `;
                playlistContainer.appendChild(songElement);
            });
        }
    }

    function loadSong(index, autoplay = true) {
        if (!songs[index] || !player) return;

        const song = songs[index];
        currentSongIndex = index;

        // Update current song display
        document.getElementById('current-song-title').textContent = song.title;
        document.getElementById('current-song-artist').textContent = song.artist;
        document.getElementById('current-song-category').textContent = song.category;
        document.getElementById('current-song-number').textContent = (index + 1);

        // Load YouTube video
        player.loadVideoById(song.videoId);

        if (!autoplay) {
            setTimeout(() => player.pauseVideo(), 100);
        }

        // Update playlist UI
        updatePlaylistUI();

        localStorage.setItem('currentSongIndex', index);
    }

    function playSong(index) {
        loadSong(index, true);
    }

    function togglePlayPause() {
        if (!player) return;

        if (isPlaying) {
            player.pauseVideo();
        } else {
            player.playVideo();
        }
        isPlaying = !isPlaying;
        updatePlayPauseButton();
        localStorage.setItem('musicPlaying', isPlaying);
    }

    function playNext() {
        currentSongIndex = (currentSongIndex + 1) % songs.length;
        playSong(currentSongIndex);
    }

    function playPrevious() {
        currentSongIndex = (currentSongIndex - 1 + songs.length) % songs.length;
        playSong(currentSongIndex);
    }

    function updatePlayPauseButton() {
        const playIcon = document.getElementById('play-icon');
        const pauseIcon = document.getElementById('pause-icon');

        if (isPlaying) {
            playIcon.classList.add('hidden');
            pauseIcon.classList.remove('hidden');
        } else {
            pauseIcon.classList.add('hidden');
            playIcon.classList.remove('hidden');
        }
    }

    function updatePlaylistUI() {
        const songElements = document.querySelectorAll('#music-player-modal .space-y-2 > div');
        songElements.forEach((element, index) => {
            if (index === currentSongIndex) {
                element.classList.add('border-military-red', 'bg-red-50');
                element.classList.remove('border-gray-100');
                if (!element.querySelector('.bg-military-red')) {
                    const indicator = document.createElement('div');
                    indicator.className = 'w-2 h-2 bg-military-red rounded-full ml-2';
                    element.appendChild(indicator);
                }
            } else {
                element.classList.remove('border-military-red', 'bg-red-50');
                element.classList.add('border-gray-100');
                const indicator = element.querySelector('.bg-military-red');
                if (indicator) {
                    indicator.remove();
                }
            }
        });
    }

    // Modal functions
    window.openMusicPlayer = function() {
        const modal = document.getElementById('music-player-modal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
    };

    window.closeMusicPlayer = function() {
        const modal = document.getElementById('music-player-modal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    };

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('music-player-modal');
        if (modal && e.target === modal) {
            closeMusicPlayer();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeMusicPlayer();
        }
    });
    </script>

    {{-- Scripts JS/Logic AI (Sẽ được viết lại ở home.blade.php) --}}
    @yield('scripts')
</body>
</html>