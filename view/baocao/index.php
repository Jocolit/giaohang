<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo Cáo Thống Kê</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
        }

        .section {
            margin: 40px;
            padding: 20px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        .section h4 {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .stat-card {
            background: #ecf0f1;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin: 10px;
            text-align: center;
        }

        .stat-card h3 {
            font-size: 24px;
            color: #2980b9;
        }

        .stat-card p {
            font-size: 18px;
            color: #2c3e50;
        }

        canvas {
            margin-top: 30px;
            width: 90% !important; /* Giảm chiều rộng của biểu đồ */
            max-width: 700px; /* Giới hạn chiều rộng của biểu đồ */
            height: 300px !important; /* Đặt chiều cao biểu đồ */
            margin: 0 auto; /* Căn giữa biểu đồ */
        }
    </style>
</head>

<body>
    <div class="section">
        <h4>Báo Cáo Thống Kê</h4>

        <!-- Tổng đơn hàng và doanh thu -->
        <div class="stat-card">
            <h3>Tổng số đơn hàng</h3>
            <p>150 đơn</p>
        </div>
        <div class="stat-card">
            <h3>Doanh thu</h3>
            <p>5,000,000 VNĐ</p>
        </div>

        <!-- Biểu đồ doanh thu theo ngày -->
        <canvas id="revenueChart"></canvas>

        <!-- Biểu đồ trạng thái đơn hàng -->
        <canvas id="statusChart"></canvas>

    </div>

    <script>
        // Dữ liệu giả lập cho biểu đồ doanh thu theo ngày
        var revenueData = {
            labels: ['2025-05-01', '2025-05-02', '2025-05-03', '2025-05-04', '2025-05-05'],
            datasets: [{
                label: 'Doanh thu',
                data: [500000, 700000, 600000, 750000, 800000],
                borderColor: 'rgba(46, 204, 113, 1)',
                backgroundColor: 'rgba(46, 204, 113, 0.2)',
                fill: true
            }]
        };

        // Dữ liệu giả lập cho biểu đồ trạng thái đơn hàng
        var statusData = {
            labels: ['Chờ lấy', 'Đang giao', 'Đã giao', 'Đã hủy'],
            datasets: [{
                data: [50, 30, 60, 10],
                backgroundColor: ['#f1c40f', '#f39c12', '#2ecc71', '#e74c3c']
            }]
        };

        // Biểu đồ doanh thu theo ngày
        var ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        var revenueChart = new Chart(ctxRevenue, {
            type: 'line',
            data: revenueData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Biểu đồ trạng thái đơn hàng
        var ctxStatus = document.getElementById('statusChart').getContext('2d');
        var statusChart = new Chart(ctxStatus, {
            type: 'pie',
            data: statusData,
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>
</html>
