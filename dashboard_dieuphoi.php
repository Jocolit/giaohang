

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Điều phối viên - Hệ thống giao hàng</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            margin: 0;
            height: 100vh;
            background-color: #f5f6fa;
        }

        .sidebar {
            width: 220px;
            background: #34495e;
            color: white;
            padding: 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background: #3d566e;
        }

        .main {
            flex: 1;
            padding: 30px;
        }

        .header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .card h3 {
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .logout {
            text-align: center;
            margin-top: 30px;
        }

        .logout a {
            color: #e74c3c;
            font-weight: bold;
            text-decoration: none;
        }

        .logout a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2><a href="dashboard_dieuphoi.php">Điều phối</a></h2>
    <a href="dashboard_dieuphoi.php?dsdh">📋 Danh sách đơn hàng</a>
    <a href="#">🧍‍♂️ Phân công shipper</a>
    <a href="#">💸 Quản lý COD</a>
    <a href="#">📊 Báo cáo hiệu suất</a>
    <a href="javascript:void(0);" onclick="openAdminChatbox()">📩 Tin nhắn</a>

    <div class="logout">
        <a href="dashboard_dieuphoi.php?dangxuat">Đăng xuất</a>
    </div>
</div>

<div class="main">
    <div class="header">Trang điều phối viên</div>

    <div class="card-container">
        <div class="card">
            <h3>Đơn hàng chờ phân công</h3>
            <p>42 đơn</p>
        </div>
        <div class="card">
            <h3>COD chưa đối soát</h3>
            <p>12.600.000đ</p>
        </div>
        <div class="card">
            <h3>Shipper đang hoạt động</h3>
            <p>15 người</p>
        </div>
        <div class="card">
            <h3>Hiệu suất giao hôm nay</h3>
            <p>87%</p>
        </div>
    </div>
    <br><br>
    <?php
        if(isset($_REQUEST["dsdh"]))
            include_once("view/phancongdh/index.php");
    ?>

</div>

<?php
    if(isset($_REQUEST["dangxuat"]))
        include_once("view/dangxuat/index.php");
?>
<?php include_once("view/chatbox/embed_admin.php"); ?>
</body>
</html>
