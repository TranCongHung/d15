<!DOCTYPE html>
<html>
<head>
    <title>Debug Admin Stats</title>
</head>
<body>
    <h1>Debug Admin Stats</h1>

    <div id="stat-articles">0</div>
    <div id="stat-users">0</div>
    <div id="stat-comments">0</div>
    <div id="stat-failed">0</div>

    <script>
        // Dữ liệu từ PHP
        window.REAL_STATS = {
            totalArticles: 4,
            totalUsers: 5,
            totalComments: 0,
            failedJobs: 0
        };

        // Test function
        function renderDashboard(stats) {
            console.log('renderDashboard called with stats:', stats);

            const elements = {
                'stat-articles': stats.totalArticles,
                'stat-users': stats.totalUsers,
                'stat-comments': stats.totalComments,
                'stat-failed': stats.failedJobs
            };

            console.log('Elements mapping:', elements);

            for (const [id, value] of Object.entries(elements)) {
                const el = document.getElementById(id);
                console.log(`Element ${id}:`, el, 'Value:', value);
                if (el) {
                    el.innerText = Number(value || 0).toLocaleString();
                    console.log(`Updated ${id} to:`, el.innerText);
                } else {
                    console.warn(`Element with ID '${id}' not found`);
                }
            }
        }

        // Call function
        document.addEventListener('DOMContentLoaded', () => {
            console.log('DOM loaded, calling renderDashboard');
            renderDashboard(window.REAL_STATS);
        });
    </script>
</body>
</html>

