<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
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
    </style>

</head>
<?php
    include_once("control/c_dangnhap.php");
    $p = new C_dangnhap();

    $con = $p->get_nhanvien();

?>
<body>
    <!-- Quản lý nhân viên -->
<div class="section">
        <h4>Quản lý Nhân viên</h4>
        <button class="button">Thêm Nhân Viên</button>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Tên nhân viên</th>
                        <th>Chức vụ</th>
                        <th>Số điện thoại</th>
                        <th>Hình ảnh</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($r = $con ->fetch_assoc()){
                            echo'
                                <tr>
                                    <td>'.$r["tennv"].'</td>
                                    <td>'.$r["tencv"].'</td>
                                    <td>'.$r["sdt"].'</td>
                                    <td>'.$r["hinhanh"].'</td>
                                    <td>
                                        <button class="button">Sửa</button>
                                        <button class="button" style="background-color: #e74c3c;">Xóa</button>
                                    </td>
                                </tr>
                            ';
                        }
                    ?>
                    
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
