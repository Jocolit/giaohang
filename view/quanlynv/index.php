<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
          .section {
            margin-top: 40px;
            padding: 20px;
        }

        .section h4 {
            margin-bottom: 20px;
            font-size: 28px;
            color: #2c3e50;
            text-align: center;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }

        td {
            font-size: 14px;
            color: #2c3e50;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .themnv {
            padding: 10px 20px;
            margin: 10px 0;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        .themnv:hover {
            background-color: #2980b9;
        }

        .button {
            padding: 6px 15px;
            border-radius: 5px;
            color: white;
            background-color: #2980b9;
            text-decoration: none;
            cursor: pointer;
            margin-right: 5px;
        }

        .button:hover {
            background-color: #2c3e50;
        }

        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .button:active {
            transform: translateY(2px);
        }

        .action-buttons {
            display: flex;
            justify-content: space-around;
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
        <a href="dashboard_admin.php?them" class="themnv">Thêm Nhân Viên</a>

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
                    if ($con) {
                        while ($r = $con->fetch_assoc()) {
                            echo '
                                <tr>
                                    <td>' . $r["tennv"] . '</td>
                                    <td>' . $r["tencv"] . '</td>
                                    <td>' . $r["sdt"] . '</td>
                                    <td><img src="uploads/' . $r["hinhanh"] . '" alt="Hình ảnh" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;"></td>
                                    <td class="action-buttons">
                                        <a href="dashboard_admin.php?sua&matk=' . $r["matk"] . '" class="button">Sửa</a>
                                        <form method="POST" style="display:inline;">
                                            <button class="button btn-danger" onclick="return confirm(\'Bạn có chắc muốn xóa không?\')" type="submit" name="btnxoa" value="' . $r["manv"] . '">Xóa</button>
                                        </form>
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
<?php
    if(isset($_REQUEST["btnxoa"])){
        $manv = $_REQUEST["btnxoa"];
        $trangthai = "Nghỉ";
        $xoa = $p->get_xoanv($manv, $trangthai);
        if($xoa){
            echo "<script>alert('Cập nhật thông tin nhân viên thành công');</script>";
            echo '<script>window.location.href="dashboard_admin.php?qlnv"</script>';
        }
    }
?>
