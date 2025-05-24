<?php
include_once("control/c_dangnhap.php");
$p = new C_dangnhap();

// Xử lý xóa nhân viên
if (isset($_REQUEST["btnxoa"])) {
    $manv = $_REQUEST["btnxoa"];
    $trangthai = "Nghỉ";
    $xoa = $p->get_xoanv($manv, $trangthai);
    if ($xoa) {
        echo "<script>alert('Cập nhật thông tin nhân viên thành công');</script>";
        echo '<script>window.location.href="dashboard_admin.php?qlnv"</script>';
        exit;
    }
}

// Lấy danh sách nhân viên full
$con = $p->get_nhanvien();

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Quản lý Nhân viên</title>
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
            display: inline-block;
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
        /* filter bar */
        .filter-bar {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .filter-bar input,
        .filter-bar select {
            flex: 1 1 250px;
            padding: 10px 12px;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            font-size: 16px;
            color: #374151;
        }
        /* pagination */
        #pagination {
            margin-top: 15px;
            text-align: center;
        }
        #pagination button {
            margin: 0 4px;
            padding: 5px 10px;
            border: 1px solid #2563eb;
            border-radius: 5px;
            cursor: pointer;
            background-color: white;
            color: #2563eb;
            font-weight: 600;
        }
        #pagination button.active {
            background-color: #2563eb;
            color: white;
        }
    </style>
</head>
<body>
    <div class="section">
        <h4>Quản lý Nhân viên</h4>
        <a href="dashboard_admin.php?them" class="themnv">Thêm Nhân Viên</a>

        <div class="filter-bar">
            <input type="text" id="searchInput" placeholder="Tìm theo tên nhân viên..." />
            <select id="filterCv">
                <option value="">-- Lọc theo chức vụ --</option>
                <option value="Giao hàng">Giao hàng</option>
                <option value="Điều phối">Điều phối</option>
                <option value="Quản lý kho">Quản lý kho</option>
            </select>
        </div>

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
                <tbody id="employeeTableBody">
                    <?php
                    if ($con) {
                        while ($r = $con->fetch_assoc()) {
                            echo '
                            <tr class="employee-row">
                                <td>' . htmlspecialchars($r["tennv"]) . '</td>
                                <td>' . htmlspecialchars($r["tencv"]) . '</td>
                                <td>' . htmlspecialchars($r["sdt"]) . '</td>
                                <td><img src="uploads/' . htmlspecialchars($r["hinhanh"]) . '" alt="Hình ảnh" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;"></td>
                                <td class="action-buttons">
                                    <a href="dashboard_admin.php?sua&matk=' . htmlspecialchars($r["matk"]) . '" class="button">Sửa</a>
                                    <form method="POST" style="display:inline;">
                                        <button class="button btn-danger" onclick="return confirm(\'Bạn có chắc muốn xóa không?\')" type="submit" name="btnxoa" value="' . htmlspecialchars($r["manv"]) . '">Xóa</button>
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
        <div id="pagination"></div>
    </div>

<script>
    const rowsPerPage = 5;
    let currentPage = 1;

    const searchInput = document.getElementById('searchInput');
    const filterCv = document.getElementById('filterCv');
    const tbody = document.getElementById('employeeTableBody');
    const rows = Array.from(tbody.querySelectorAll('.employee-row'));
    const paginationDiv = document.getElementById('pagination');

    function filterAndPaginate() {
        const searchValue = searchInput.value.toLowerCase();
        const filterValue = filterCv.value;

        const filteredRows = rows.filter(row => {
            const name = row.children[0].textContent.toLowerCase();
            const cv = row.children[1].textContent;
            const matchName = name.includes(searchValue);
            const matchCv = filterValue === '' || cv === filterValue;
            return matchName && matchCv;
        });

        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
        if (currentPage > totalPages) currentPage = totalPages || 1;

        rows.forEach(r => r.style.display = 'none');

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        filteredRows.slice(start, end).forEach(r => r.style.display = '');

        renderPagination(totalPages, currentPage);
    }

    function renderPagination(totalPages, current) {
        paginationDiv.innerHTML = '';
        for(let i = 1; i <= totalPages; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.classList.toggle('active', i === current);
            btn.addEventListener('click', () => {
                currentPage = i;
                filterAndPaginate();
            });
            paginationDiv.appendChild(btn);
        }
    }

    searchInput.addEventListener('input', () => {
        currentPage = 1;
        filterAndPaginate();
    });

    filterCv.addEventListener('change', () => {
        currentPage = 1;
        filterAndPaginate();
    });

    window.onload = () => {
        filterAndPaginate();
    };
</script>
</body>
</html>
