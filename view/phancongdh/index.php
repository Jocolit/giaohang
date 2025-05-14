<!-- Giao diện phân công đơn hàng (include vào layout cha) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    h2 {
        color: #2c3e50;
        margin-top: 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px;
        background-color: white;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }

    th, td {
        border: 1px solid #e0e0e0;
        padding: 12px 15px;
        text-align: center;
    }

    th {
        background-color: #3498db;
        color: white;
    }

    select, button {
        padding: 6px 10px;
        font-size: 15px;
    }

    button {
        background-color: #2ecc71;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #27ae60;
    }

    .form-inline {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }
</style>

</head>
<?php
    include_once("control/c_dangnhap.php");
    $p = new C_dangnhap();

    // lấy 
    $dsdon = $p->get_dsdonhangpc();
    $dsnv = $p->get_dsshiper();
// Xử lý phân công tay
if (isset($_POST['phancong'])) {
    $madh = $_POST['madh'];
    $manv = $_POST['manv'];
    $kq = $p->get_phancong_tudong($madh, $manv);
    if ($kq){
        echo "<script>alert('Phân công thành công!'); </script>";
        echo '<script>window.location.href="dashboard_dieuphoi.php?dsdh"</script>';
    } 
    else echo "<script>alert('Thất bại');</script>";
}

// Phân công tự động
if (isset($_POST['auto_assign'])) {
    if ($dsdon) {
        foreach ($dsdon as $row) {
            $nv = $p->get_nhanvien_it_nhat();
            if ($nv) {
                $p->get_phancong_tudong($row['madh'], $nv['manv']);
            }
        }
        echo "<script>alert('Phân công tự động xong'); </script>";
        echo '<script>window.location.href="dashboard_dieuphoi.php?dsdh"</script>';
    }
}
    
?>
<body>
    <div>
    <h2>Phân công nhân viên</h2>
    
    <form method="POST" style="margin-bottom: 15px; text-align:right;">
    <button type="submit" name="auto_assign" style="background:#f39c12;">Tự động phân công</button>
    </form>

<table>
    <thead>
        <tr>
            <th>Mã đơn</th>
            <th>Người nhận</th>
            <th>Địa chỉ</th>
            <th>Trạng thái</th>
            <th>Chọn nhân viên</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
    <?php if ($dsdon) {
        foreach ($dsdon as $row) { ?>
            <tr>
                <td><?= $row['madh'] ?></td>
                <td><?= $row['tennn'] ?></td>
                <td><?= $row['diachinn'] ?></td>
                <td><?= $row['tinhtrangdh'] ?></td>
                <td>
                    <form method="POST">
                        <select name="manv" required>
                            <option value="">-- Chọn --</option>
                            <?php if ($dsnv) {
                                foreach ($dsnv as $nv) {
                                    echo "<option value='{$nv['manv']}'>{$nv['tennv']}</option>";
                                }
                            } ?>
                        </select>
                </td>
                <td>
                    <input type="hidden" name="madh" value="<?= $row['madh'] ?>">
                    <button type="submit" name="phancong">Phân công</button>
                    </form>
                </td>
            </tr>
    <?php }} else { echo "<tr><td colspan='6'>Không có đơn chờ phân công</td></tr>"; } ?>
    </tbody>
</table>


    </div>
</body>
</html>