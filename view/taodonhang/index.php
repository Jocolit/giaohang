<?php

// if (!isset($_SESSION["dn"])) {
//     echo " <script>window.location.href='index.php'</script> ";
// }
include_once("control/c_dangnhap.php");
$p = new C_dangnhap();
$con = $p->get_lay1kh($_SESSION["tk"]);
if($con){
    $r = $con->fetch_assoc();
    $makh = $r["makh"];
}else{
    echo 'Có lỗi';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tạo Đơn Hàng - Hệ thống giao hàng</title>
     <!-- Liên kết tới CSS riêng -->
      <style>
        .container {
            padding: 30px;
            max-width: 800px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .card h3 {
            margin-top: 0;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            color: #333;
        }

        .form-group input:focus, .form-group select:focus {
            border-color: #3498db;
            outline: none;
        }

        .btn {
            background: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn:hover {
            background: #2980b4;
        }
      </style>
    <script>
        function addProduct() {
            const productRow = document.createElement('div');
            productRow.classList.add('product-row');
            
            productRow.innerHTML = `
                <div class="form-group">
                    <label for="sp">Sản Phẩm</label>
                    <input type="text" name="txtsp[]" id="sp" placeholder="Nhập tên sản phẩm" required>
                </div>
                <div class="form-group">
                    <label for="sl">Số Lượng</label>
                    <input type="number" name="txtsl[]" id="sl" placeholder="Nhập số lượng" required>
                </div>
                <div class="form-group">
                    <label for="dvi">Đơn vị tính</label>
                    <input type="text" name="txtdvi[]" id="dvi" placeholder="Nhập đơn vị tính" required>
                </div>
                <div class="form-group">
                    <label for="gia">Đơn Giá</label>
                    <input type="number" name="txtgia[]" id="gia" placeholder="Nhập đơn giá" required>
                </div>
            `;
            
            document.getElementById('products-container').appendChild(productRow);
        }
    </script>
</head>

<body>

<div class="container">
    <form action="" method="POST">

        <div class="card">
            <h3>Thông Tin Người Gửi</h3>
            <div class="form-group">
                <label for="sender_name">Họ và Tên</label>
                <input type="text" id="sender_name" name="txttennn" required placeholder="Nhập họ và tên">
            </div>

            <div class="form-group">
                <label for="sender_phone">Số Điện Thoại</label>
                <input type="text" id="sender_phone" name="txtsdtnn" required placeholder="Nhập số điện thoại">
            </div>

            <div class="form-group">
                <label for="sender_address">Địa Chỉ</label>
                <input type="text" id="sender_address" name="txtdiachinn" required placeholder="Nhập địa chỉ giao hàng">
            </div>
        </div>

        <!-- Đây là code để tạo dòng nhập chi tiết đơn hàng -->
        <div class="card">
            <h3>Chi Tiết Đơn Hàng</h3>
            
            <div id="products-container">
                <div class="product-row">
                    <div class="form-group">
                        <label for="sp">Sản Phẩm</label>
                        <input type="text" name="txtsp[]" id="sp" placeholder="Nhập tên sản phẩm" required>
                    </div>
                    <div class="form-group">
                        <label for="sl">Số Lượng</label>
                        <input type="number" name="txtsl[]" id="sl" placeholder="Nhập số lượng" required>
                    </div>
                    <div class="form-group">
                        <label for="dvi">Đơn vị tính</label>
                        <input type="text" name="txtdvi[]" id="dvi" placeholder="Nhập đơn vị tính" required>
                    </div>
                    <div class="form-group">
                        <label for="gia">Đơn Giá</label>
                        <input type="number" name="txtgia[]" id="gia" placeholder="Nhập đơn giá" required>
                    </div>
                </div>

            </div>
            
             <button type="button" onclick="addProduct()" class="btn">Thêm sản phẩm</button>
            
            <div class="form-group">
                <label for="payment_method">Hình Thức Thanh Toán</label>
                <select name="payment_method" id="payment_method" required>
                    <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                    <option value="Transfer">Chuyển khoản</option>
                </select>
            </div>
        </div> 

        <button type="submit" class="btn" name="btntaodh">Tạo Đơn Hàng</button>
    </form>
</div>
<?php
    if(isset($_REQUEST["btntaodh"])){
        $ngaydat = date('Y-m-d');
        $tennn = $_REQUEST["txttennn"];
        $sdtnn = $_REQUEST["txtsdtnn"];
        $diachinn = $_REQUEST["txtdiachinn"];
        $tinhtranghd = 'Chờ lấy';
        $thanhtoan = 'Chưa thanh toán';
        $tongtien = 0;
        $cod = 0;
        $tao = $p->get_taodonhang($makh, $ngaydat, $tennn, $sdtnn, $diachinn, $tinhtranghd, $tongtien, $cod, $thanhtoan);
        if($tao){
            foreach($_REQUEST["txtsp"] as $index => $tensp){
                $sl = $_REQUEST["txtsl"][$index];
                $dvi = $_REQUEST["txtdvi"][$index];
                $gia = $_REQUEST["txtgia"][$index];
                $thanhtien = $sl * $gia;
                $tongtien += $thanhtien;

                $p->get_taochitietdh($tao, $tensp, $sl, $dvi, $gia);

            }
            $p->get_capnhatdh($tao, $tongtien);
            // echo "<script>alert('Đơn hàng đã được tạo chờ shipper đến lấy hàng');</script>";
            // Xử lý theo phương thức thanh toán
            if ($_POST['payment_method'] == "Transfer") {
                echo "<script>window.location.href='view/thanh_toan/payment.php?madh={$tao}'</script>";
            } else {
                echo "<script>alert('Đơn hàng đã được tạo chờ shipper đến lấy hàng');</script>";
            }

        }
        else
            echo "<script>alert('Vui lòng tạo lại đơn hàng');</script>";

        
    }
?>
</body>
</html>
