
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý kho - Giao diện kho hàng</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            background: #f7f9fb;
        }

        .sidebar {
            width: 240px;
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
            border-radius: 6px;
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
            background: #2980b9;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .tabs button.active {
            background: #1f6391;
        }

        .content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #ecf0f1;
        }

        .form {
            margin-top: 20px;
        }

        .form input, .form select {
            padding: 8px;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .form button {
            padding: 8px 15px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
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
            document.getElementById('tonkho').style.display = (tab === 'tonkho') ? 'block' : 'none';
            document.getElementById('xuatnhap').style.display = (tab === 'xuatnhap') ? 'block' : 'none';

            document.getElementById('btn-tonkho').classList.toggle('active', tab === 'tonkho');
            document.getElementById('btn-xuatnhap').classList.toggle('active', tab === 'xuatnhap');
        }
    </script>
</head>
<body>

<div class="sidebar">
    <h2>Kho hàng</h2>
    <a href="#" onclick="showTab('tonkho')">📦 Kiểm tra tồn kho</a>
    <a href="#" onclick="showTab('xuatnhap')">📑 Xuất / Nhập kho</a>
    <div class="logout">
        <a href="dashboard_kho.php?dangxuat">Đăng xuất</a>
    </div>
</div>

<div class="main">
    <div class="header">Xin chào, Nhân viên kho!</div>

    <div class="tabs">
        <button id="btn-tonkho" class="active" onclick="showTab('tonkho')">Tồn kho</button>
        <button id="btn-xuatnhap" onclick="showTab('xuatnhap')">Xuất / Nhập kho</button>
    </div>

    <!-- Tồn kho -->
    <div id="tonkho" class="content">
        <h3>Danh sách hàng tồn kho</h3>
        <table>
            <tr>
                <th>Mã hàng</th>
                <th>Tên hàng</th>
                <th>Đơn vị</th>
                <th>Số lượng tồn</th>
            </tr>
            <tr>
                <td>SP001</td>
                <td>Áo thun nam</td>
                <td>Cái</td>
                <td>150</td>
            </tr>
            <tr>
                <td>SP002</td>
                <td>Quần jean nữ</td>
                <td>Cái</td>
                <td>120</td>
            </tr>
            <!-- Thêm dữ liệu động -->
        </table>
    </div>

    <!-- Xuất / Nhập kho -->
    <div id="xuatnhap" class="content" style="display: none;">
        <h3>Tạo phiếu xuất / nhập kho</h3>
        <div class="form">
            <select name="loaiphieu">
                <option value="nhap">Nhập kho</option>
                <option value="xuat">Xuất kho</option>
            </select>
            <input type="text" placeholder="Mã hàng">
            <input type="number" placeholder="Số lượng">
            <input type="text" placeholder="Lý do / ghi chú">
            <button>Thêm phiếu</button>
        </div>

        <h4>Danh sách phiếu gần đây</h4>
        <table>
            <tr>
                <th>Loại</th>
                <th>Mã hàng</th>
                <th>Số lượng</th>
                <th>Ghi chú</th>
                <th>Ngày</th>
            </tr>
            <tr>
                <td>Nhập</td>
                <td>SP003</td>
                <td>50</td>
                <td>Nhập bổ sung hàng</td>
                <td>2025-04-10</td>
            </tr>
            <tr>
                <td>Xuất</td>
                <td>SP001</td>
                <td>30</td>
                <td>Giao cho đơn #123</td>
                <td>2025-04-09</td>
            </tr>
        </table>
    </div>
</div>
<?php
    if(isset($_REQUEST["dangxuat"]))
        include_once("view/dangxuat/index.php");
?>
</body>
</html>
