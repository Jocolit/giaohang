<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Danh sách đơn hàng</title>
    <style>
       
        .container {
            max-width: 100%px;
            margin: auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgb(0 0 0 / 0.1);
        }
        h2 {
            text-align: center;
            font-weight: 700;
            margin-bottom: 25px;
            font-size: 28px;
        }
        .filter-bar {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }
        .filter-bar input,
        .filter-bar select {
            flex: 1 1 300px;
            padding: 12px 15px;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            font-size: 16px;
            transition: 0.3s;
            color: #374151;
        }
        .filter-bar input:focus,
        .filter-bar select:focus {
            border-color: #2563eb;
            outline: none;
            box-shadow: 0 0 8px rgb(37 99 235 / 0.3);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead tr {
            background-color: #e2e8f0;
        }
        thead th {
            font-weight: 600;
            padding: 14px 12px;
            border: 1px solid #cbd5e1;
            font-size: 14px;
            color: #475569;
            text-transform: uppercase;
        }
        tbody tr:nth-child(odd) {
            background-color: #f9fafb;
        }
        tbody tr:hover {
            background-color: #e0e7ff;
        }
        tbody td {
            padding: 12px 12px;
            border: 1px solid #cbd5e1;
            font-size: 15px;
            vertical-align: middle;
            color: #334155;
            white-space: nowrap;
        }
        .status {
            padding: 6px 14px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 13px;
            color: white;
            display: inline-block;
        }
        .waiting {
            background-color: #fbbf24;
            color: #92400e;
        }
        .processing {
            background-color: #f97316;
            color: #7c2d12;
        }
        .delivered {
            background-color: #22c55e;
            color: #14532d;
        }
        .canceled {
            background-color: #ef4444;
            color: #7f1d1d;
        }
        .btn-view,
        .btn-danger {
            border-radius: 8px;
            font-weight: 600;
            padding: 9px 18px;
            cursor: pointer;
            border: none;
            font-size: 14px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 2px 6px rgb(0 0 0 / 0.12);
        }
        .btn-view {
            background-color: #3b82f6;
            color: white;
            margin-right: 10px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-view:hover {
            background-color: #2563eb;
            box-shadow: 0 4px 14px rgb(37 99 235 / 0.5);
        }
        .btn-danger {
            background-color: #ef4444;
            color: white;
        }
        .btn-danger:hover {
            background-color: #dc2626;
            box-shadow: 0 4px 14px rgb(220 38 38 / 0.5);
        }
        .button:active {
            transform: translateY(2px);
        }

        @media (max-width: 768px) {
            .filter-bar {
                flex-direction: column;
            }
            .filter-bar input,
            .filter-bar select {
                width: 100%;
            }
            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }
            thead tr {
                display: none;
            }
            tbody tr {
                margin-bottom: 15px;
                background-color: #fff;
                padding: 15px;
                border-radius: 10px;
                box-shadow: 0 3px 10px rgb(0 0 0 / 0.1);
            }
            tbody td {
                border: none;
                padding: 8px 0;
                text-align: right;
                position: relative;
            }
            tbody td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                font-weight: 600;
                color: #64748b;
                text-transform: uppercase;
                font-size: 13px;
                top: 8px;
            }
            .btn-view,
            .btn-danger {
                width: 48%;
                padding: 8px 0;
                font-size: 14px;
            }
            td:last-child {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Danh sách đơn hàng</h2>
        <div class="filter-bar">
            <input type="text" id="search" placeholder="Tìm kiếm theo khách hàng hoặc mã đơn..." oninput="filterOrders()" />
            <select id="statusFilter" onchange="filterOrders()">
                <option value="">Tất cả trạng thái</option>
                <option value="waiting">Chờ lấy</option>
                <option value="processing">Đang giao</option>
                <option value="delivered">Đã giao</option>
                <option value="canceled">Đã hủy</option>
            </select>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Mã Đơn Hàng</th>
                    <th>Khách Hàng</th>
                    <th>Trạng Thái</th>
                    <th>Ngày Đặt</th>
                    <th>Phí Giao Hàng</th>
                    <th>Tiền Thu Hộ</th>
                    <th>Người Thanh Toán</th>
                    <th>Hình thức thanh toán</th>
                    <th>Thanh Toán</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody id="orderList">
                <?php
                include_once("control/c_dangnhap.php");
                $p = new C_dangnhap();
                $donhang = $p->get_dsdonhang();
                if ($donhang) {
                    while ($row = $donhang->fetch_assoc()) {
                        $statusClass = '';
                        if ($row["tinhtrangdh"] == 'Chờ lấy') {
                            $statusClass = 'waiting';
                        } elseif ($row["tinhtrangdh"] == 'Đang giao') {
                            $statusClass = 'processing';
                        } elseif ($row["tinhtrangdh"] == 'Đã giao') {
                            $statusClass = 'delivered';
                        } elseif ($row["tinhtrangdh"] == 'Đã hủy') {
                            $statusClass = 'canceled';
                        }
                        echo '
                            <tr class="order-row">
                                <td data-label="Mã Đơn Hàng">' . htmlspecialchars($row["madh"]) . '</td>
                                <td data-label="Khách Hàng">' . htmlspecialchars($row["tenkh"]) . '</td>
                                <td data-label="Trạng Thái"><span class="status ' . $statusClass . '">' . htmlspecialchars($row["tinhtrangdh"]) . '</span></td>
                                <td data-label="Ngày Đặt">' . htmlspecialchars($row["ngaydat"]) . '</td>
                                <td data-label="Phí Giao Hàng">' . htmlspecialchars($row["shipping_fee"]) . '</td>
                                <td data-label="Tiền Thu Hộ">' . htmlspecialchars($row["thuho"]) . '</td>
                                <td data-label="Người Thanh Toán">' . htmlspecialchars($row["nguoitratien"]) . '</td>
                                <td data-label="Hình thức thanh toán">' . htmlspecialchars($row["hinhthuctt"]) . '</td>
                                <td data-label="Thanh Toán">' . htmlspecialchars($row["thanhtoan"]) . '</td>
                                <td data-label="Hành Động">
                                    <a href="dashboard_admin.php?madh=' . urlencode($row["madh"]) . '" class="btn-view">Xem chi tiết</a>
                                    <form method="POST" style="display:inline;">
                                        <button class="button btn-danger" onclick="return confirm(\'Bạn có chắc muốn hủy không?\')" type="submit" name="btnxoadon" value="' . htmlspecialchars($row["madh"]) . '">Hủy</button>
                                    </form>
                                </td>
                            </tr>
                        ';
                    }
                }
                ?>
            </tbody>
        </table>
        <div id="pagination" style="margin-top: 20px; text-align: center;"></div>

    </div>

    <script>
        function filterOrders() {
            const searchValue = document.getElementById("search").value.toLowerCase();
            const statusFilter = document.getElementById("statusFilter").value.toLowerCase();
            const rows = document.querySelectorAll(".order-row");

            rows.forEach(row => {
                const orderId = row.cells[0].textContent.toLowerCase();
                const customerName = row.cells[1].textContent.toLowerCase();
                const statusClass = row.cells[2].querySelector(".status").classList[1];
                const matchesSearch = orderId.includes(searchValue) || customerName.includes(searchValue);
                const matchesStatus = statusFilter === "" || statusClass === statusFilter;
                row.style.display = matchesSearch && matchesStatus ? "" : "none";
            });
        }

        const rowsPerPage = 10;
let currentPage = 1;

function showPage(page) {
    const rows = document.querySelectorAll(".order-row");
    const totalRows = rows.length;
    const totalPages = Math.ceil(totalRows / rowsPerPage);
    currentPage = page;

    rows.forEach((row, index) => {
        if (index >= (page - 1) * rowsPerPage && index < page * rowsPerPage) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });

    renderPagination(totalPages, page);
}

function renderPagination(totalPages, currentPage) {
    const pagination = document.getElementById("pagination");
    pagination.innerHTML = "";

    for(let i = 1; i <= totalPages; i++) {
        const btn = document.createElement("button");
        btn.innerText = i;
        btn.style.margin = "0 5px";
        btn.style.padding = "5px 10px";
        btn.style.border = "1px solid #2563eb";
        btn.style.backgroundColor = i === currentPage ? "#2563eb" : "white";
        btn.style.color = i === currentPage ? "white" : "#2563eb";
        btn.style.borderRadius = "5px";
        btn.style.cursor = "pointer";

        btn.onclick = () => showPage(i);
        pagination.appendChild(btn);
    }
}

function filterOrders() {
    const searchValue = document.getElementById("search").value.toLowerCase();
    const statusFilter = document.getElementById("statusFilter").value.toLowerCase();
    const rows = document.querySelectorAll(".order-row");

    rows.forEach(row => {
        const orderId = row.cells[0].textContent.toLowerCase();
        const customerName = row.cells[1].textContent.toLowerCase();
        const statusClass = row.cells[2].querySelector(".status").classList[1];
        const matchesSearch = orderId.includes(searchValue) || customerName.includes(searchValue);
        const matchesStatus = statusFilter === "" || statusClass === statusFilter;
        row.style.display = (matchesSearch && matchesStatus) ? "" : "none";
    });

    // Khi filter xong, reset phân trang, chỉ hiện trang 1 các kết quả filter được
    const filteredRows = Array.from(rows).filter(row => row.style.display !== "none");
    // Ẩn tất cả
    rows.forEach(row => row.style.display = "none");
    // Hiện 10 đầu tiên của kết quả filter
    filteredRows.slice(0, rowsPerPage).forEach(row => row.style.display = "");

    // Tính tổng trang dựa trên filteredRows
    const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
    renderPagination(totalPages, 1);
}

// Khi trang tải xong, hiển thị trang 1
window.onload = () => {
    showPage(1);
};

    </script>
</body>
</html>
<?php
    if(isset($_REQUEST["btnxoadon"])){
        $madh = $_REQUEST["btnxoadon"];
        $tinhtrang = "Đã hủy";
        $rs = $p->get_capnhat_trangthai($madh, $tinhtrang);
        if($rs){
            echo "<script>alert('Hủy đơn hàng thành công');</script>";
            echo '<script>window.location.href="dashboard_admin.php?qldh"</script>';
        }
    }
?>