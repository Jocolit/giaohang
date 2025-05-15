
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
.order-list-container {
    padding: 30px;
    background-color: #f4f6f9;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

h2 {
    margin-bottom: 20px;
    font-size: 28px;
    color: #2c3e50;
}

.filter-bar {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.filter-bar input {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ddd;
    width: 45%;
}

.filter-bar select {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ddd;
    width: 45%;
}

.order-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.order-table th,
.order-table td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ddd;
}

.order-table th {
    background-color: #34495e;
    color: white;
    font-weight: bold;
}

.order-table td {
    background-color: white;
}

.status {
    padding: 6px 12px;
    border-radius: 4px;
    font-weight: bold;
    color: white;
}

.waiting {
    background-color: #f1c40f; /* Màu vàng cho Chờ lấy */
}

.processing {
    background-color: #f39c12; /* Màu vàng đậm cho Đang giao */
}

.delivered {
    background-color: #2ecc71; /* Màu xanh lá cho Đã giao */
}

.canceled {
    background-color: #e74c3c; /* Màu đỏ cho Đã hủy */
}


.btn-view {
    background-color: #3498db;
    color: white;
    padding: 8px 16px;
    border-radius: 5px;
    text-decoration: none;
    transition: background 0.3s ease;
}

.btn-view:hover {
    background-color: #2980b9;
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
                <th>Tổng Tiền</th>
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
                        <td>'.$row["tongtien"].'</td>
                        <td><a href="dashboard_admin.php?madh='.$row["madh"].'" class="btn-view">Xem chi tiết</a></td>
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