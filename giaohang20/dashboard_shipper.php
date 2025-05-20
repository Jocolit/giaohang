<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Shipper - Giao diện giao hàng</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            background: #ecf0f1;
        }

        .sidebar {
            width: 220px;
            background-color: #2c3e50;
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
            margin-bottom: 12px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #34495e;
        }

        .main {
            flex: 1;
            padding: 30px;
        }

        .header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .tabs {
            margin-bottom: 20px;
        }

        .tabs button {
            padding: 10px 15px;
            margin-right: 10px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .tabs button.active {
            background: #2980b9;
        }

        .order-list {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .order-card {
            background: #ecf0f1;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .order-card:hover {
            transform: scale(1.02);
        }

        .order-header {
            font-size: 18px;
            font-weight: bold;
        }

        .order-header p {
            color: #555;
        }

        .order-details p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        .status-btn {
            margin-top: 10px;
        }

        .status-btn button {
            margin-right: 8px;
            padding: 8px 15px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .status-btn .success {
            background-color: #2ecc71;
            color: white;
        }

        .status-btn .fail {
            background-color: #e74c3c;
            color: white;
        }

        .logout {
            text-align: center;
            margin-top: 30px;
        }

        .logout a {
            color: #e74c3c;
            text-decoration: none;
        }

        .logout a:hover {
            text-decoration: underline;
        }
    </style>

    <script>
        function showTab(tab) {
            document.getElementById('layhang').style.display = (tab === 'layhang') ? 'block' : 'none';
            document.getElementById('giaohang').style.display = (tab === 'giaohang') ? 'block' : 'none';

            document.getElementById('btn-layhang').classList.toggle('active', tab === 'layhang');
            document.getElementById('btn-giaohang').classList.toggle('active', tab === 'giaohang');
        }
    </script>
</head>
<?php
    $manv = $_SESSION["nv"];
    include_once("control/c_dangnhap.php");
    $p = new C_dangnhap();
    
    $con = $p->get_donhangnvlay($manv);
    $conn = $p->get_donhangnvgiao($manv);
    
?>
<body>

<div class="sidebar">
    <h2>Shipper</h2>
    <a href="#" onclick="showTab('layhang')">📦 Đơn cần lấy hàng</a>
    <a href="#" onclick="showTab('giaohang')">🚚 Đơn cần giao hàng</a>
    <div class="logout">
        <a href="dashboard_shipper.php?dangxuat">Đăng xuất</a>
    </div>
</div>

<div class="main">
    <div class="header">Chào mừng, Shipper!</div>

    <div class="tabs">
        <button id="btn-layhang" onclick="showTab('layhang')" class="active">Lấy hàng</button>
        <button id="btn-giaohang" onclick="showTab('giaohang')">Giao hàng</button>
    </div>

    <!-- Phần đơn cần lấy hàng -->
<div id="layhang" class="order-list">
    <h3>Danh sách đơn cần lấy hàng</h3>
    <?php
    if ($con) {
        while ($r = $con->fetch_assoc()) {
            $hasThuHo = ($r["thuho"] > 0);
            echo '<div class="order-card">
                <div class="order-header">
                    <h4>Mã đơn: ' . $r["madh"] . '</h4>
                    <p>Người gửi: ' . $r["tenkh"] . '</p>
                </div>
                <div class="order-details">
                    <p>Số điện thoại: ' . $r["sdt"] . '</p>
                    <p>Địa chỉ: ' . $r["diachi"] . '</p>';
            if ($hasThuHo) {
                echo '<p>Thu hộ: ' . number_format($r["thuho"]) . ' VNĐ</p>';
            }
            echo '</div>
                <div class="status-btn">
                    <form method="POST" style="display: inline;">';

            if ($hasThuHo) {
                // Thêm checkbox xác nhận đã trả tiền thu hộ cho shop
                echo '<label><input type="checkbox" name="thuho_paid" required> Đã trả tiền thu hộ cho shop</label><br>';
            }

            echo '<input type="hidden" name="madh_lay" value="' . $r["madh"] . '">
                    <button type="submit" class="success">Đã lấy hàng</button>
                    </form>';

            // Nút lỗi với form riêng để nhập lý do
            echo '<button class="fail" onclick="showReasonForm(\'lay\', ' . $r["madh"] . ')">Lỗi</button>
                </div>';

            // Form nhập lý do lỗi (ẩn ban đầu)
            echo '<form method="POST" class="reason-form" id="reason-lay-' . $r["madh"] . '" style="display:none; margin-top:10px;">
                    <input type="hidden" name="madh_error_lay" value="' . $r["madh"] . '">
                    <textarea name="reason" placeholder="Nhập lý do lỗi..." required style="width: 100%; height: 60px;"></textarea><br>
                    <button type="submit" class="fail">Gửi lý do</button>
                    <button type="button" onclick="hideReasonForm(\'lay\', ' . $r["madh"] . ')">Hủy</button>
                </form>';

            echo '</div>';
        }
    } else {
        echo 'Không có đơn hàng';
    }
    ?>
</div>

<!-- Phần đơn cần giao hàng -->
<div id="giaohang" class="order-list" style="display: none;">
    <h3>Danh sách đơn cần giao hàng</h3>
    <?php
    if ($conn) {
        while ($rr = $conn->fetch_assoc()) {
            $hasThuHo = ($rr["thuho"] > 0);
            echo '<div class="order-card">
                <div class="order-header">
                    <h4>Mã đơn: ' . $rr["madh"] . '</h4>
                    <p>Giao cho: ' . $rr["tennn"] . '</p>
                </div>
                <div class="order-details">
                    <p>Số điện thoại: ' . $rr["sdtnn"] . '</p>
                    <p>Địa chỉ: ' . $rr["diachinn"] . '</p>';
            if ($hasThuHo) {
                echo '<p>COD: ' . number_format($rr["thuho"]) . ' VNĐ</p>';
            }
            echo '</div>
                <div class="status-btn">
                    <form method="POST" style="display: inline;">';

            if ($hasThuHo) {
                // Checkbox xác nhận đã nhận tiền thu hộ từ khách hàng
                echo '<label><input type="checkbox" name="thuho_received" required> Đã nhận tiền thu hộ từ khách hàng</label><br>';
            }

            echo '<input type="hidden" name="madh_giao" value="' . $rr["madh"] . '">
                    <button type="submit" class="success">Giao thành công</button>
                    </form>';

            echo '<button class="fail" onclick="showReasonForm(\'giao\', ' . $rr["madh"] . ')">Lỗi</button>
                </div>';

            // Form nhập lý do lỗi ẩn
            echo '<form method="POST" class="reason-form" id="reason-giao-' . $rr["madh"] . '" style="display:none; margin-top:10px;">
                    <input type="hidden" name="madh_error_giao" value="' . $rr["madh"] . '">
                    <textarea name="reason" placeholder="Nhập lý do lỗi..." required style="width: 100%; height: 60px;"></textarea><br>
                    <button type="submit" class="fail">Gửi lý do</button>
                    <button type="button" onclick="hideReasonForm(\'giao\', ' . $rr["madh"] . ')">Hủy</button>
                </form>';

            echo '</div>';
        }
    } else {
        echo 'Không có đơn hàng';
    }
    ?>
</div>

</div>
<?php
    if(isset($_REQUEST["dangxuat"]))
        include_once("view/dangxuat/index.php");
?>

<script>
function showReasonForm(type, madh) {
    document.getElementById(`reason-${type}-${madh}`).style.display = 'block';
}

function hideReasonForm(type, madh) {
    document.getElementById(`reason-${type}-${madh}`).style.display = 'none';
}
</script>

</body>
</html>
<?php
    if (isset($_POST["madh_lay"])) {
        $madh = $_POST["madh_lay"];
        $p->get_capnhat_trangthai($madh, "Đang giao");
        // làm thêm cho shop nếu tiền mặt đợi shipper cập nhât thanh toán
        $ktra = $p->get_dsdonhang($madh);
        $k = $ktra->fetch_assoc();
        if($k["hinhthuctt"] === "tienmat"){
            $p->get_capnhat_thanhtoan($madh, "Đã thanh toán");
        }
        echo "<script>location.href='dashboard_shipper.php?lay';</script>";
    }
    if (isset($_POST["madh_giao"])) {
        $madh = $_POST["madh_giao"];
        $p->get_capnhat_trangthai($madh, "Đã giao");
        $ktra = $p->get_dsdonhang($madh);
        $k = $ktra->fetch_assoc();
        if($k["nguoitratien"] === "Người nhận"){
            $p->get_capnhat_thanhtoan($madh, "Hmmm");
        }
        echo "<script>location.href='dashboard_shipper.php?giao';</script>";
    } 
?>