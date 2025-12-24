<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản trị - QĐNDVN</title>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @once
<script>
window.REAL_STATS = {
  totalArticles: {{ (int)($articleCount ?? 0) }},
  totalUsers: {{ (int)($userCount ?? 0) }},
  totalComments: {{ (int)($commentCount ?? 0) }},
  failedJobs: {{ (int)($failedCount ?? 0) }}
};
window.REAL_ARTICLES = @json($articles ?? []);
window.REAL_USERS = @json($users ?? []);
window.REAL_CATEGORIES = @json($categories ?? []);
window.REAL_COMMENTS = @json($comments ?? []);
window.REAL_LOGS = @json($logs ?? []);
</script>
@endonce

    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>
<style>
    #stats-chart {
        max-width: 100% !important;
        height: auto !important;
    }
    .chart-container {
        position: relative;
        min-height: 300px;
    }
</style>
<body class="bg-gray-50">

    @yield('content')

    @include('admin.article-modal')
    @include('admin.user-modal')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) lucide.createIcons();
        });
    </script>
</body>
</html>