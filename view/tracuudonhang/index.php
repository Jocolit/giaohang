<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đơn hàng</title>
    <style>
        /* CSS như bạn đã có trước đó, không thay đổi */
        .order-list-container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 30px 40px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        h2 {
            margin-bottom: 30px;
            font-size: 32px;
            color: #1f2937;
            font-weight: 700;
            letter-spacing: 1px;
            text-align: center;
        }

        .filter-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            gap: 20px;
        }

        .filter-bar input,
        .filter-bar select {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1.8px solid #cbd5e1;
            font-size: 16px;
            color: #334155;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        .filter-bar input:focus,
        .filter-bar select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 8px rgba(59, 130, 246, 0.3);
        }

        .order-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .order-table th,
        .order-table td {
            padding: 14px 18px;
            text-align: left;
        }

        .order-table th {
            background-color: #2563eb;
            color: #f9fafb;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .order-table tr {
            background-color: #f9fafb;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
            transition: background-color 0.25s ease;
        }

        .order-table tr:hover {
            background-color: #e0e7ff;
        }

        .status {
            padding: 6px 14px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 14px;
            white-space: nowrap;
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

        .btn-view {
            background-color: #3b82f6;
            color: white;
            padding: 5px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 3px 6px rgb(59 130 246 / 0.4);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-view:hover {
            background-color: #2563eb;
            box-shadow: 0 5px 12px rgb(37 99 235 / 0.6);
        }

        .btn-danger {
            background-color: #ef4444;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 3px 6px rgb(239 68 68 / 0.4);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #dc2626;
            box-shadow: 0 5px 12px rgb(220 38 38 / 0.6);
        }

        .button:active {
            transform: translateY(2px);
        }
    </style>
</head>

<?php
    include_once("control/c_dangnhap.php");
    $p = new C_dangnhap();
    $matkkh = $_SESSION["tk"];
    $donhang = $p->get_donhang_kh($matkkh);
?>

<body>
<div class="order-list-container">
    <h2>Danh sách đơn hàng</h2>

    <div class="filter-bar">
        <input type="text" id="search" placeholder="Tìm kiếm theo khách hàng hoặc mã đơn..." oninput="filterOrders()">
        <select id="statusFilter" onchange="filterOrders()">
            <option value="">Tất cả trạng thái</option>
            <option value="waiting">Chờ lấy</option>
            <option value="processing">Đang giao</option>
            <option value="delivered">Đã giao</option>
            <option value="canceled">Đã hủy</option>
        </select>
    </div>

    <table class="order-table">
        <thead>
            <tr>
                <th>Mã Đơn Hàng</th>
                <th>Khách Hàng</th>
                <th>Trạng Thái</th>
                <th>Ngày Đặt</th>
                <th>Phí giao hàng</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody id="orderList">
        <?php
            if($donhang){
                while($row = $donhang->fetch_assoc()){
                    $statusClass = '';
                    if ($row["tinhtrangdh"] == 'Chờ lấy') $statusClass = 'waiting';
                    elseif ($row["tinhtrangdh"] == 'Đang giao') $statusClass = 'processing';
                    elseif ($row["tinhtrangdh"] == 'Đã giao') $statusClass = 'delivered';
                    elseif ($row["tinhtrangdh"] == 'Đã hủy') $statusClass = 'canceled';

                    echo '
                        <tr class="order-row">
                            <td>'.$row["madh"].'</td>
                            <td>'.$row["tenkh"].'</td>
                            <td><span class="status '.$statusClass.'">'.$row["tinhtrangdh"].'</span></td>
                            <td>'.$row["ngaydat"].'</td>
                            <td>'.$row["shipping_fee"].'</td>
                            <td>
                                <a href="?madhct='.$row["madh"].'" class="btn-view">Xem chi tiết</a>
                                <form method="POST" style="display:inline;">
                                    <button class="button btn-danger" onclick="return confirm(\'Bạn có chắc muốn hủy không?\')" type="submit" name="btnxoadh" value="' . $row["madh"] . '">Hủy</button>
                                </form>
                            </td>
                        </tr>
                    ';
                }
            }
        ?>
        </tbody>
    </table>

    <div id="pagination" style="text-align: center; margin-top: 20px;"></div>
</div>

<script>
const rowsPerPage = 5;
let currentPage = 1;

function paginateOrders() {
    const rows = document.querySelectorAll(".order-row");
    const totalPages = Math.ceil(rows.length / rowsPerPage);

    rows.forEach((row, index) => {
        row.style.display = (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage)
            ? ""
            : "none";
    });

    renderPaginationControls(totalPages);
}

function renderPaginationControls(totalPages) {
    const paginationDiv = document.getElementById("pagination");
    paginationDiv.innerHTML = "";

    for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement("button");
        btn.textContent = i;
        btn.className = (i === currentPage ? "active" : "");
        btn.style.margin = "0 6px";
        btn.style.padding = "8px 14px";
        btn.style.border = "1px solid #ccc";
        btn.style.borderRadius = "6px";
        btn.style.cursor = "pointer";
        btn.style.backgroundColor = (i === currentPage ? "#2563eb" : "#f3f4f6");
        btn.style.color = (i === currentPage ? "white" : "#1f2937");

        btn.onclick = function () {
            currentPage = i;
            filterOrders(); // Reapply filter + pagination
        };

        paginationDiv.appendChild(btn);
    }
}

function filterOrders() {
    const searchValue = document.getElementById("search").value.toLowerCase();
    const statusFilter = document.getElementById("statusFilter").value.toLowerCase();
    const rows = document.querySelectorAll(".order-row");

    let visibleRows = [];

    rows.forEach(row => {
        const orderId = row.cells[0].textContent.toLowerCase();
        const customerName = row.cells[1].textContent.toLowerCase();
        const statusClass = row.cells[2].querySelector(".status").classList[1];

        const matchesSearch = orderId.includes(searchValue) || customerName.includes(searchValue);
        const matchesStatus = statusFilter === "" || statusClass === statusFilter;

        if (matchesSearch && matchesStatus) {
            visibleRows.push(row);
        }
    });

    // Reset page
    currentPage = 1;
    paginateFilteredRows(visibleRows);
}

function paginateFilteredRows(rows) {
    const totalPages = Math.ceil(rows.length / rowsPerPage);

    document.querySelectorAll(".order-row").forEach(row => row.style.display = "none");

    rows.forEach((row, index) => {
        row.style.display = (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage)
            ? ""
            : "none";
    });

    renderPaginationControls(totalPages);
}

window.addEventListener("load", () => {
    paginateOrders();
});
</script>

</body>
</html>

<?php
    if(isset($_REQUEST["btnxoadh"])){
        $madh = $_REQUEST["btnxoadh"];
        $ktradh = $p->get_dsdonhang($madh);
        if($ktradh){
            $dh = $ktradh->fetch_assoc();
            if($dh["tinhtrangdh"] === "Chờ lấy"){
                $tinhtrangdh = "Đã hủy";
                $rs = $p->get_capnhat_trangthai($madh, $tinhtrangdh);
                if($rs){
                    echo "<script>alert('Hủy đơn hàng thành công');</script>";
                    echo '<script>window.location.href="customer_home.php?tracuu"</script>';
                }
            }else{
                echo "<script>alert('Đơn hàng không hủy được');</script>";
            }
        }
    }
?>
