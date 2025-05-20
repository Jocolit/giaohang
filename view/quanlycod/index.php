<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
<style>
    .cod-container {
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        font-family: 'Segoe UI', sans-serif;
    }

    .cod-container h2 {
        margin-bottom: 25px;
        font-size: 26px;
        font-weight: 700;
        color: #1e293b;
    }

    .cod-filters {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .cod-filters input, .cod-filters select {
        padding: 10px 14px;
        font-size: 15px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        flex: 1 1 200px;
    }

    .btn-primary {
        padding: 10px 20px;
        background-color: #3b82f6;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: #2563eb;
    }

    .cod-table-container {
        overflow-x: auto;
    }

    .cod-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cod-table th, .cod-table td {
        padding: 12px 14px;
        border: 1px solid #e2e8f0;
        text-align: left;
        white-space: nowrap;
    }

    .cod-table thead {
        background-color: #f1f5f9;
    }

    .tag {
        display: inline-block;
        padding: 4px 10px;
        font-size: 13px;
        border-radius: 999px;
        font-weight: 500;
        white-space: nowrap;
    }

    .tag.warning {
        background-color: #fde68a;
        color: #92400e;
    }

    .tag.success {
        background-color: #bbf7d0;
        color: #166534;
    }

    .btn-confirm, .btn-export {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        cursor: pointer;
        border: none;
        margin-right: 6px;
    }

    .btn-confirm {
        background-color: #10b981;
        color: white;
    }

    .btn-confirm:hover {
        background-color: #059669;
    }

    .btn-export {
        background-color: #f97316;
        color: white;
    }

    .btn-export:hover {
        background-color: #ea580c;
    }

    @media (max-width: 768px) {
        .cod-filters {
            flex-direction: column;
        }
    }
</style>

</head>
<?php
    include_once("control/c_dangnhap.php");
    $p = new C_dangnhap();
    $con = $p->get_dsdonhang();
?>
<body>
<div class="cod-container">
    <h2>Quản lý COD</h2>

    <!-- Bộ lọc -->
    <div class="cod-filters">
        <select id="filter-status">
            <option value="">Tất cả trạng thái</option>
            <option value="chua">Chưa đối soát</option>
            <option value="daxacnhan">Đã xác nhận</option>
            <option value="dagiaiquyet">Đã giải quyết</option>
        </select>
        <input type="text" id="filter-shipper" placeholder="Tìm theo tên shipper hoặc mã đơn...">
        <button class="btn-primary">Lọc</button>
    </div>

    <!-- Bảng COD -->
    <div class="cod-table-container">
        <table class="cod-table">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Shipper</th>
                    <th>SĐT</th>
                    <th>COD thu hộ</th>
                    <th>Ngày giao</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <!-- Demo -->
                 <?php
                    if($con){
                        while($r = $con->fetch_assoc()){
                            echo'
                                <tr>
                                    <td>'.$r["madh"].'</td>
                                    <td>'.$r["tennv"].'</td>
                                    <td>'.$r["sdtnv"].'</td>
                                    <td>'.$r["thuho"].'</td>
                                    <td>2025-05-18</td>
                                    <td><span class="tag warning">Chưa đối soát</span></td>
                                    <td>
                                        <button class="btn-confirm">Xác nhận</button>
                                        <button class="btn-export">Xuất</button>
                                    </td>
                                </tr>
                            ';
                        }
                    }
                 ?>
                
                
            </tbody>
        </table>
    </div>
</div>
</body>
</html>


