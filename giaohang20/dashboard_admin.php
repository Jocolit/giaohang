<?php
session_start();

// Kiểm tra đăng nhập (demo thôi, bạn có thể thay bằng kiểm tra thực tế)

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý - Hệ thống giao hàng</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            height: 100vh;
            background: #f4f6f9;
        }

        .sidebar {
            width: 240px;
            background: #34495e;
            color: #ecf0f1;
            padding: 20px;
            position: fixed;
            height: 100%;
        }

        .sidebar h2 {
            margin-bottom: 30px;
            text-align: center;
        }

        .sidebar a {
            display: block;
            padding: 12px 10px;
            margin-bottom: 10px;
            color: #ecf0f1;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background: #2c3e50;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            color: #2c3e50;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .main {
            flex-grow: 1;
            padding: 30px;
            margin-left: 240px;
        }

        .header {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            margin-bottom: 10px;
            font-size: 20px;
            color: #2c3e50;
        }

        .card p {
            font-size: 18px;
            font-weight: bold;
            color: #2980b9;
        }

        .section {
            margin-top: 40px;
        }

        .section h4 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #2c3e50;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background: #ecf0f1;
            font-weight: bold;
        }

        .button {
            padding: 10px 20px;
            margin: 10px 0;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #2980b9;
        }

        .logout {
            margin-top: 40px;
            text-align: center;
        }

        .logout a {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
        }

        .logout a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<?php
    include_once("control/c_dangnhap.php");
    $p = new C_dangnhap();

    $con = $p->get_nhanvien();
    $conn = $p->get_nhanvien($_SESSION["tk"]);
    
    if($conn)
        $rr = $conn->fetch_assoc();
    else
        echo 'Có lỗi';
?>

<body>

<div class="sidebar">
    <h2><a href="dashboard_admin.php"><?= $rr["tennv"]; ?></a></h2>
    <a href="dashboard_admin.php?qldh">📦 Quản lý đơn hàng</a>
    <div class="dropdown">
        <a href="dashboard_admin.php?qlnv">🚚 Quản lý nhân viên</a>
        <div class="dropdown-content">
            <a href="dashboard_admin.php?them">Thêm nhân viên</a>
            
        </div>
    </div>
    <a href="#">🏬 Quản lý kho</a>
    <a href="#">💰 Quản lý COD</a>
    <a href="dashboard_admin.php?baocao">📊 Báo cáo thống kê</a>
    <a href="javascript:void(0);" onclick="openAdminChatbox()" style="position: relative;">
  📩 Tin nhắn
  <span id="admin-badge" style="display:none; position:absolute; top:0px; right:-5px; background:red; color:white; font-size:11px; padding:2px 6px; border-radius:10px;">!</span>
</a>


    <div class="logout">
        <a href="dashboard_admin.php?dangxuat">Đăng xuất</a>
    </div>
</div>

<div class="main">
    <div class="header">Trang quản trị hệ thống</div>

    <div class="card-container">
        <div class="card">
            <h3>Tổng số đơn hàng trong ngày</h3>
            <p>98 đơn</p>
        </div>
        <div class="card">
            <h3>Số lượng nhân viên hoạt động</h3>
            <p>30 nugười</p>
        </div>
        <div class="card">
            <h3>Tổng đơn hàng trong kho</h3>
            <p>12 người</p>
        </div>
        <div class="card">
            <h3>Doanh thu trong ngày</h3>
            <p>500000k</p>
        </div>
    </div>
        <br>
    <?php
        if(isset($_REQUEST["qlnv"]))
            include_once("view/quanlynv/index.php");
        elseif(isset($_REQUEST["them"]))
            include_once("view/themnv/index.php");
        elseif(isset($_REQUEST["qldh"]))
            include_once("view/quanlydonhang/index.php");
        elseif(isset($_REQUEST["sua"]))
            include_once("view/capnhatnv/index.php");
        elseif(isset($_REQUEST["baocao"]))
            include_once("view/baocao/index.php");
    ?>

</div>

<?php
    if(isset($_REQUEST["dangxuat"]))
        include_once("view/dangxuat/index.php");
?>
<?php include_once("view/chatbox/embed_admin.php"); ?>
</body>
</html>
