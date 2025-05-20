
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
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
    border-spacing: 0 10px; /* Tạo khoảng cách giữa các dòng */
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
    background-color: #fbbf24; /* vàng */
    color: #92400e;
}

.processing {
    background-color: #f97316; /* cam */
    color: #7c2d12;
}

.delivered {
    background-color: #22c55e; /* xanh lá */
    color: #14532d;
}

.canceled {
    background-color: #ef4444; /* đỏ */
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

    <!-- Bộ lọc và tìm kiếm -->
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

    <!-- Bảng danh sách đơn hàng -->
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
                // Xác định lớp CSS tương ứng với trạng thái
                $statusClass = '';
                if ($row["tinhtrangdh"] == 'Chờ lấy') {
                    $statusClass = 'waiting'; // Chờ lấy
                } elseif ($row["tinhtrangdh"] == 'Đang giao') {
                    $statusClass = 'processing'; // Đang giao
                } elseif ($row["tinhtrangdh"] == 'Đã giao') {
                    $statusClass = 'delivered'; // Đã giao
                } elseif ($row["tinhtrangdh"] == 'Đã hủy') {
                    $statusClass = 'canceled'; // Đã hủy
                }

                echo'
                    <tr class="order-row">
                        <td>'.$row["madh"].'</td>
                        <td>'.$row["tenkh"].'</td>
                        <td><span class="status '.$statusClass.'">'.$row["tinhtrangdh"].'</span></td>
                        <td>'.$row["ngaydat"].'</td>
                        <td>'.$row["shipping_fee"].'</td>
                        <td><a href="dashboard_admin.php?madh='.$row["madh"].'" class="btn-view">Xem chi tiết</a>
                            <form method="POST" style="display:inline;">
                                            <button class="button btn-danger" onclick="return confirm(\'Bạn có chắc muốn hủy không?\')" type="submit" name="btnxoadh" value="' . $row["madh"] . '">Hủy</button>
                                        </form>
                        </td>
                    </tr>
                ';
            }
        }
    ?>
            
            <!-- Thêm các đơn hàng khác ở đây -->
        </tbody>
    </table>
</div>

<script>
   // Lọc các đơn hàng theo tìm kiếm (ID hoặc Khách hàng) và trạng thái
function filterOrders() {
    const searchValue = document.getElementById("search").value.toLowerCase();
    const statusFilter = document.getElementById("statusFilter").value.toLowerCase();

    // Lấy tất cả các hàng trong bảng
    const rows = document.querySelectorAll(".order-row");

    rows.forEach(row => {
        const orderId = row.cells[0].textContent.toLowerCase();  // Mã đơn hàng
        const customerName = row.cells[1].textContent.toLowerCase();  // Tên khách hàng
        const statusClass = row.cells[2].querySelector(".status").classList[1];  // Lớp trạng thái (ví dụ: "waiting", "processing", "delivered", "canceled")

        // Kiểm tra điều kiện tìm kiếm (ID hoặc khách hàng)
        const matchesSearch = orderId.includes(searchValue) || customerName.includes(searchValue);

        // Kiểm tra điều kiện lọc trạng thái
        const matchesStatus = statusFilter === "" || statusClass === statusFilter;

        // Hiển thị hoặc ẩn hàng dựa trên kết quả kiểm tra
        if (matchesSearch && matchesStatus) {
            row.style.display = "";  // Hiển thị hàng
        } else {
            row.style.display = "none";  // Ẩn hàng
        }
    });
}



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
        // kiểm tra nếu trạng thái chờ lấy thì mới cho khách hàng hủy đơn hàng
        
                $rs = $p->get_capnhat_trangthai($madh, $tinhtrangdh);
                if($rs){
                    echo "<script>alert('Hủy đơn hàng thành công');</script>";
                    echo '<script>window.location.href="customer_home.php?tracuu"</script>';
                }
            }else{
                echo "<script>alert('Đơn hàng không hủy được');</script>";
                return;
            }
        }
        
    }
?>