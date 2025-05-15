<?php
    session_start();

    if(isset($_REQUEST["dangnhap"]))
        include_once("view/dangnhap/index.php");
    elseif(isset($_REQUEST["dangky"])){
        include_once("view/dangky/index.php");
    }elseif(isset($_SESSION["dn"]) && $_SESSION["loaitk"] == 3){
        echo " <script>window.location.href='customer_home.php'</script>";
    }elseif(isset($_SESSION["dn"]) && $_SESSION["loaitk"] == 1){
        echo " <script>window.location.href='dashboard_admin.php'</script>";
    }elseif(isset($_SESSION["dn"]) && $_SESSION["loaitk"] == 2){
        if($_SESSION["macv"] == 1)
            echo " <script>window.location.href='dashboard_shipper.php'</script>";
        elseif($_SESSION["macv"] == 2)
            echo " <script>window.location.href='dashboard_dieuphoi.php'</script>";
        elseif($_SESSION["macv"] == 3)
            echo " <script>window.location.href='dashboard_kho.php'</script>";
    }
    else{
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Quản Lý Giao Hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        /* Navbar */
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: white;
        }
        .navbar-nav .nav-link:hover {
            color: #f1f1f1;
        }
        /* Hero Section */
        .hero {
            background-image: url('image/hinh_index/bg.jpg'); /* Thay bằng hình nền thực tế */
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0;
            text-align: center;
            box-shadow: inset 0 0 0 1000px rgba(0, 0, 0, 0.5);
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
            padding: 14px 30px;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        /* Service Section */
        .service-box {
            text-align: center;
            padding: 40px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        .service-box i {
            font-size: 50px;
            color: #007bff;
            margin-bottom: 20px;
        }
        .service-box h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .service-box p {
            font-size: 16px;
            color: #555;
        }
        /* Footer */
        footer {
            background-color: #f1f1f1;
            padding: 20px 0;
            text-align: center;
            margin-top: 50px;
        }
        footer p {
            color: #6c757d;
            font-size: 16px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Hệ Thống Giao Hàng</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Trang Chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Dịch Vụ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Giới Thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Liên Hệ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <h1 data-aos="fade-up">Chào mừng đến với Hệ Thống Giao Hàng</h1>
        <p data-aos="fade-up" data-aos-delay="100">Quản lý đơn hàng, nhân viên giao hàng, kho và COD nhanh chóng, hiệu quả</p>
        <?php
            if(!isset($_SESSION["dn"])){
                echo '<a href="index.php?dangnhap" class="btn btn-primary" data-aos="fade-up" data-aos-delay="200">Đăng Nhập</a>';
                echo '<a href="index.php?dangky" class="btn btn-primary" data-aos="fade-up" data-aos-delay="300">Đăng Ký</a>';
            }else{
                echo '<a href="index.php?dangxuat" class="btn btn-primary" data-aos="fade-up" data-aos-delay="200">Đăng xuất</a>';
            }
        ?>
    </div>

    <!-- Service Section -->
    <div class="container" data-aos="fade-up" data-aos-delay="400">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="service-box" data-aos="zoom-in" data-aos-delay="500">
                    <i class="bx bx-truck"></i>
                    <h3>Giao Hàng Nhanh</h3>
                    <p>Chúng tôi đảm bảo giao hàng đúng hẹn, nhanh chóng và an toàn.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="service-box" data-aos="zoom-in" data-aos-delay="600">
                    <i class="bx bx-package"></i>
                    <h3>Quản Lý Đơn Hàng</h3>
                    <p>Giúp bạn dễ dàng theo dõi và quản lý trạng thái đơn hàng của mình.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="service-box" data-aos="zoom-in" data-aos-delay="700">
                    <i class="bx bx-home"></i>
                    <h3>Dịch Vụ Kho</h3>
                    <p>Giúp bạn quản lý kho bãi và hàng hóa hiệu quả, tiết kiệm chi phí.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="service-box" data-aos="zoom-in" data-aos-delay="800">
                    <i class="bx bx-credit-card"></i>
                    <h3>COD An Toàn</h3>
                    <p>Cung cấp dịch vụ COD đảm bảo an toàn và minh bạch cho mọi giao dịch.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Hệ Thống Quản Lý Giao Hàng. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
<?php
    }
?>
