// Dữ liệu thống kê hệ thống
export const MOCK_STATS = {
    totalArticles: 142,
    totalUsers: 12,
    totalComments: 856,
    failedJobs: 0
};

// Danh sách bài viết mẫu
export const MOCK_ARTICLES = [
    { id: 1, title: "Diễn tập phương án cứu hộ cứu nạn 2024", status: "Đã xuất bản", date: "2024-03-15" },
    { id: 2, title: "Nâng cao năng lực tác chiến điện tử", status: "Chờ duyệt", date: "2024-03-14" },
    { id: 3, title: "Khai mạc hội thao toàn quân vùng 3", status: "Đã xuất bản", date: "2024-03-13" }
];

// Nhật ký hệ thống
export const MOCK_SYSTEM_LOGS = [
    { id: 1, job_name: "Cào tin quốc tế", status: "Hoàn thành", time: "5 phút trước" },
    { id: 2, job_name: "Dọn dẹp cache", status: "Hoàn thành", time: "1 giờ trước" },
    { id: 3, job_name: "Gửi thông báo", status: "Hoàn thành", time: "2 giờ trước" }
];