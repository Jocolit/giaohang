<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Chi tiết đơn hàng #1</title>
    <style>
        
        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            border-radius: 12px;
            padding: 30px 40px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #222;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 16px;
        }
        .info-label {
            font-weight: 600;
            color: #555;
            width: 180px;
        }
        .info-value {
            flex-grow: 1;
            color: #333;
        }
        .status {
            padding: 6px 14px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 14px;
            display: inline-block;
            color: white;
        }
        .waiting { background-color: #fbbf24; color: #92400e; }
        .processing { background-color: #f97316; color: #7c2d12; }
        .delivered { background-color: #22c55e; color: #14532d; }
        .canceled { background-color: #ef4444; color: #7f1d1d; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 15px;
        }
        th {
            background-color: #2563eb;
            color: white;
            text-transform: uppercase;
            font-weight: 600;
        }
        .btn-back {
            display: inline-block;
            margin-top: 30px;
            background-color: #3b82f6;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(59,130,246,0.5);
            transition: background-color 0.3s ease;
        }
        .btn-back:hover {
            background-color: #2563eb;
        }
        @media (max-width: 600px) {
            .info-row {
                flex-direction: column;
                margin-bottom: 15px;
            }
            .info-label {
                width: 100%;
                margin-bottom: 4px;
            }
        }
    </style>
</head>

<?php
    include_once("control/c_dangnhap.php");
    $p = new C_dangnhap();
    if(isset($_REQUEST["madhct"])){
        $donhang = [];
        $dssp = [];
        $madh = $_REQUEST["madhct"];
        $con = $p->get_laydonhang($madh);
        if($con){
            while($ctdh = $con->fetch_assoc()){
                if (empty($donhang)) {
                    $donhang = $ctdh;
                }
                $dssp[] = [
                    'mactdh' => $ctdh['mactdh'],
                    'tensp' => $ctdh['tenhang'],
                    'soluong' => $ctdh['soluong'],
                    'trongluong' => $ctdh['trongluong']
                ];
            }
           

            }
        }
?>
<body>
<div class="container">
    <h1>Chi tiết đơn hàng <?= $donhang["madh"]?></h1>

    <div class="info-row">
        <div class="info-label">Khách hàng:</div>
        <div class="info-value"><?= $donhang["tenkh"]?></div>
    </div>
    <div class="info-row">
        <div class="info-label">Ngày đặt:</div>
        <div class="info-value"><?= $donhang["ngaydat"]?></div>
    </div>
    <div class="info-row">
        <div class="info-label">Trạng thái đơn hàng:</div>
        <div class="info-value">
            <span class="status delivered"><?= $donhang["tinhtrangdh"]?></span>
        </div>
    </div>
    <div class="info-row">
        <div class="info-label">Phí giao hàng:</div>
        <div class="info-value"><?= $donhang["shipping_fee"]?></div>
    </div>
    <div class="info-row">
        <div class="info-label">Tiền thu hộ:</div>
        <div class="info-value"><?= $donhang["thuho"]?></div>
    </div>
    <div class="info-row">
        <div class="info-label">Người thanh toán:</div>
        <div class="info-value"><?= $donhang["nguoitratien"]?></div>
    </div>
    <div class="info-row">
        <div class="info-label">Hình thức thanh toán:</div>
        <div class="info-value"><?= $donhang["hinhthuctt"]?></div>
    </div>
    <div class="info-row">
        <div class="info-label">Trạng thái thanh toán:</div>
        <div class="info-value"><?= $donhang["thanhtoan"]?></div>
    </div>

    <h2>Danh sách sản phẩm</h2>
    <table>
        <thead>
            <tr>
                <th>Mã sản phẩm</th>
                <th>Tên hàng</th>
                <th>Số lượng</th>
                <th>Trọng lượng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dssp as $sp): ?>
                <tr>
                    <td><?= htmlspecialchars($sp['mactdh']) ?></td>
                    <td><?= htmlspecialchars($sp['tensp']) ?></td>
                    <td><?= htmlspecialchars($sp['soluong']) ?></td>
                    <td><?= htmlspecialchars($sp['trongluong']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- hàm quay về trang trước -->
    <a href="javascript:history.back()" class="btn-back">← Quay lại danh sách đơn hàng</a>
</div>
</body>
</html>
