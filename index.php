<?php
    session_start();

    if(isset($_REQUEST["dangnhap"]))
        include_once("view/dangnhap/index.php");
    elseif(isset($_REQUEST["dangky"])){
        include_once("view/dangky/index.php");
    }else{
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hệ Thống Quản Lý Giao Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fa;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .hero {
            background-color: #4e73df;
            color: white;
            padding: 120px 0;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .hero h1 {
            font-size: 50px;
            margin-bottom: 20px;
        }
        .hero p {
            font-size: 20px;
            margin-bottom: 40px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 12px 30px;
            font-size: 18px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        footer {
            background-color: #f8f9fc;
            padding: 20px 0;
            text-align: center;
        }
        footer p {
            color: #6c757d;
            font-size: 16px;
        }
    </style>
</head>

<body>

    <div class="hero">
        <h1>Chào mừng đến với Hệ Thống Giao Hàng</h1>
        <p>Quản lý đơn hàng, nhân viên giao hàng, kho và COD nhanh chóng, hiệu quả</p>
        <?php
            if(!isset($_SESSION["dn"])){
                echo '<a href="index.php?dangnhap" class="btn btn-primary">Đăng Nhập</a>';
                echo '<a href="index.php?dangky" class="btn btn-primary">Đăng Ký</a>';
            }else{
                echo '<a href="index.php?dangxuat" class="btn btn-primary">Đăng xuất</a>';
            }
        ?>
    </div>

    <footer>
        <p>&copy; 2025 Hệ Thống Quản Lý Giao Hàng. All rights reserved.</p>
    </footer>

<?php
    if(isset($_REQUEST["dangxuat"]))
        include_once("view/dangxuat/index.php");
?>

</body>
</html>
<?php
    }
?>
