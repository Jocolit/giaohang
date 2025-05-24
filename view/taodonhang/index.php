<?php
// session_start(); // Bạn có thể bật session nếu cần
include_once("control/c_dangnhap.php");
$p = new C_dangnhap();
$con = $p->get_lay1kh($_SESSION["tk"]); // Lấy thông tin khách hàng theo session tk
if($con){
    $r = $con->fetch_assoc();
    $makh = $r["makh"];
}else{
    echo 'Có lỗi';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tạo Đơn Hàng - Hệ thống giao hàng</title>
    <style>
    /* Container chính cho toàn bộ trang tạo đơn hàng */
    .orderform-container {
        display: flex; /* Dùng flexbox để chia sidebar và map */
        flex-grow: 1;
        height: 100vh; /* Chiều cao toàn màn hình */
        margin: 0;
        padding: 0;
    }

    /* Sidebar bên trái chứa form nhập liệu */
    .orderform-sidebar {
        width: 400px; /* Chiều rộng cố định */
        background-color: #fff;
        padding: 20px;
        border-right: 2px solid #ddd;
        overflow-y: auto; /* Scroll dọc nếu nội dung dài */
        box-sizing: border-box;
    }

    /* Các card chứa từng phần form */
    .orderform-card {
        background: white;
        padding: 25px;
        margin-bottom: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    /* Tiêu đề các card */
    .orderform-card h3 {
        margin-top: 0;
        color: #333;
    }

    /* Nhóm form từng trường */
    .orderform-form-group {
        margin-bottom: 15px;
    }

    /* Nhãn cho các input */
    .orderform-form-group label {
        font-weight: bold;
        margin-bottom: 5px;
        display: block;
    }

    /* Input, select, textarea */
    .orderform-input, .orderform-select, .orderform-textarea {
        width: 100%;
        height: 40px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
        color: #333;
        box-sizing: border-box;
    }

    /* Nút bấm */
    .orderform-btn {
        background: #3498db;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        margin-top: 10px;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    /* Hiệu ứng hover cho nút */
    .orderform-btn:hover {
        background: #2980b4;
    }

    /* Khu vực bản đồ bên phải */
    #orderform-map {
        flex-grow: 1; /* Chiếm phần còn lại */
        height: 100%;
        min-width: 0;
        margin: 0;
        box-sizing: border-box;
    }

    /* Responsive cho màn hình nhỏ */
    @media (max-width: 768px) {
        .orderform-container {
            flex-direction: column; /* Chuyển thành cột */
        }

        .orderform-sidebar {
            width: 100%;
        }

        #orderform-map {
            width: 100%;
            height: 400px; /* Chiều cao cố định khi nhỏ */
        }
    }
    </style>
    <!-- Các link và script Mapbox -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.3.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.3.0/mapbox-gl.css" rel="stylesheet" />
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.3/mapbox-gl-geocoder.min.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.3/mapbox-gl-geocoder.css" type="text/css">
</head>

<body>
<div class="orderform-container">
    <!-- Sidebar chứa form -->
    <div class="orderform-sidebar">
        <form action="" method="POST" id="orderform-form">
            <!-- Thông tin người gửi -->
            <div class="orderform-card">
                <h3>Thông Tin Người Gửi</h3>
                <div class="orderform-form-group">
                    <label>Họ và Tên</label>
                    <input type="text" name="txttenng" class="orderform-input" value="<?php echo htmlspecialchars($r['tenkh']) ?>" readonly>
                </div>
                <div class="orderform-form-group">
                    <label>Số Điện Thoại</label>
                    <input type="text" name="txtsdtng" class="orderform-input" value="<?php echo htmlspecialchars($r['sdt']) ?>" readonly>
                </div>
                <div class="orderform-form-group">
                    <label>Địa Chỉ</label>
                    <!-- Geocoder Mapbox cho địa chỉ người gửi -->
                    <div id="pickup_geocoder"></div>
                    <input id="pickup_address" type="text" name="txtdiaching" class="orderform-input" value="<?php echo htmlspecialchars($r['diachi']) ?>" placeholder="Nhập địa chỉ người gửi" >
                </div>
            </div>

            <!-- Thông tin người nhận -->
            <div class="orderform-card">
                <h3>Thông Tin Người Nhận</h3>
                <div class="orderform-form-group">
                    <label>Họ và Tên</label>
                    <input type="text" name="txttennn" class="orderform-input" required placeholder="Nhập họ và tên người nhận">
                </div>
                <div class="orderform-form-group">
                    <label>Số Điện Thoại</label>
                    <input type="text" name="txtsdtnn" class="orderform-input" required placeholder="Nhập số điện thoại người nhận">
                </div>
                <div class="orderform-form-group">
                    <label>Địa Chỉ</label>
                    <!-- Geocoder Mapbox cho địa chỉ người nhận -->
                    <div id="delivery_geocoder"></div>
                    <input id="delivery_address" type="text" name="txtdiachinn" class="orderform-input" required placeholder="Nhập địa chỉ giao hàng" >
                </div>
                <div class="orderform-form-group">
                    <label>Khoảng Cách (Km)</label>
                    <input type="text" id="distance" name="distance" class="orderform-input" readonly>
                </div>
                <div class="orderform-form-group">
                    <label>Phí Giao Hàng (VNĐ)</label>
                    <input type="text" id="shipping_fee" name="shipping_fee" class="orderform-input" readonly>
                </div>
                <button type="button" onclick="calculateDistance()" class="orderform-btn">🔎 Tính Khoảng Cách & Phí Ship</button>
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="orderform-card">
                <h3>Thông Tin Sản Phẩm</h3>
                <div id="products-container">
                    <div class="product-row">
                        <div class="orderform-form-group">
                            <label>Sản Phẩm</label>
                            <input type="text" name="txtsp[]" class="orderform-input" placeholder="Nhập tên sản phẩm" required>
                        </div>
                        <div class="orderform-form-group">
                            <label>Số Lượng</label>
                            <input type="number" name="txtsl[]" class="orderform-input" placeholder="Nhập số lượng" required>
                        </div>
                        <div class="orderform-form-group">
                            <label>Trọng Lượng</label>
                            <input type="text" name="txttrongluong[]" class="orderform-input" placeholder="Nhập trọng lượng" required>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="addProduct()" class="orderform-btn">Thêm sản phẩm</button>
                <div class="orderform-form-group">
                    <label>Thu Hộ</label>
                    <input type="number" name="txtthuho" class="orderform-input" placeholder="Nhập tiền thu hộ" >
                </div>
                <div class="orderform-form-group">
                    <label>Người trả tiền</label>
                    <select name="nguoitratien" class="orderform-select" required>
                        <option value="" selected disabled>-- Chọn người trả tiền --</option>
                        <option value="Người gửi">Người gửi trả tiền</option>
                        <option value="Người nhận">Người nhận trả tiền</option>
                    </select>
                </div>

                <div class="orderform-form-group">
                    <label>Hình Thức Thanh Toán</label>
                    <select name="payment_method" class="orderform-select" required>
                        <option value="" selected disabled>-- Chọn phương thức thanh toán --</option>
                        <option value="tienmat">Tiền mặt</option>
                        <option value="chuyenkhoan">Chuyển khoản</option>
                    </select>
                </div>
            </div>

            <!-- Nút tạo đơn hàng -->
            <button type="submit" class="orderform-btn" name="btntaodh">🚀 Tạo Đơn Hàng</button>
        </form>
    </div>

    <!-- Bản đồ bên phải -->
    <div id="orderform-map"></div>
</div>

<script>
// JavaScript cho Mapbox và tính toán khoảng cách
mapboxgl.accessToken = 'pk.eyJ1IjoicGh1Y2xvYyIsImEiOiJjbWFtMWwwcWcwZzVwMmtxMHJoNWJieXRzIn0.Ub6AC90KY1yMOXFK5qwLYg';

// Tạo bản đồ
const map = new mapboxgl.Map({
    container: 'orderform-map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [106.6297, 10.8231], // Tọa độ Hồ Chí Minh
    zoom: 12
});

// Thêm điều khiển zoom
map.addControl(new mapboxgl.NavigationControl());

// Tạo Geocoder cho người gửi
const pickupGeocoder = new MapboxGeocoder({
    accessToken: mapboxgl.accessToken,
    types: 'address',
    placeholder: "Nhập địa chỉ người gửi",
    mapboxgl: mapboxgl
});
document.getElementById('pickup_geocoder').appendChild(pickupGeocoder.onAdd(map));

// Tạo Geocoder cho người nhận
const deliveryGeocoder = new MapboxGeocoder({
    accessToken: mapboxgl.accessToken,
    types: 'address',
    placeholder: "Nhập địa chỉ người nhận",
    mapboxgl: mapboxgl
});
document.getElementById('delivery_geocoder').appendChild(deliveryGeocoder.onAdd(map));

let pickupMarker = null;  // Người gửi (màu xanh)
let deliveryMarker = null;  // Người nhận (màu đỏ)

// Khi người dùng chọn địa chỉ người gửi
pickupGeocoder.on('result', function (e) {
    const pickupCoords = e.result.center;
    if (pickupMarker) {
        pickupMarker.setLngLat(pickupCoords);
    } else {
        pickupMarker = new mapboxgl.Marker({ color: 'blue' })
            .setLngLat(pickupCoords)
            .addTo(map);
    }
    document.getElementById('pickup_address').value = e.result.place_name;
});

// Khi người dùng chọn địa chỉ người nhận
deliveryGeocoder.on('result', function (e) {
    const deliveryCoords = e.result.center;
    if (deliveryMarker) {
        deliveryMarker.remove();
    }
    deliveryMarker = new mapboxgl.Marker({ color: 'red' })
        .setLngLat(deliveryCoords)
        .addTo(map);
    document.getElementById('delivery_address').value = e.result.place_name;
});

// Chuyển địa chỉ chuỗi sang tọa độ
async function getCoordinatesFromAddress(address) {
    const encodedAddress = encodeURIComponent(address);
    const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodedAddress}.json?access_token=${mapboxgl.accessToken}`;

    const res = await fetch(url);
    const data = await res.json();

    if (data.features && data.features.length > 0) {
        return data.features[0].center; // [lng, lat]
    } else {
        throw new Error("Không tìm thấy tọa độ cho địa chỉ: " + address);
    }
}

// Hàm tính khoảng cách
async function calculateDistance() {
    if (!pickupMarker || !deliveryMarker) {
        alert("Vui lòng chọn địa chỉ người gửi và người nhận.");
        return;
    }

    const pickupCoords = pickupMarker.getLngLat();
    const deliveryCoords = deliveryMarker.getLngLat();

    const originAddress = document.getElementById('pickup_address').value;
    const destinationAddress = document.getElementById('delivery_address').value;

    try {
        const originCoords = await getCoordinatesFromAddress(originAddress);
        const destinationCoords = await getCoordinatesFromAddress(destinationAddress);

        const directionsUrl = `https://api.mapbox.com/directions/v5/mapbox/driving/${originCoords[0]},${originCoords[1]};${destinationCoords[0]},${destinationCoords[1]}?alternatives=false&geometries=geojson&steps=true&access_token=${mapboxgl.accessToken}`;

        const res = await fetch(directionsUrl);
        const data = await res.json();

        if (data.routes && data.routes.length > 0) {
            const distance = data.routes[0].distance / 1000; // mét → km
            const duration = data.routes[0].duration / 60; // phút
            const shippingFee = calculateShippingFee(distance);

            document.getElementById('distance').value = distance.toFixed(2);
            document.getElementById('shipping_fee').value = shippingFee;

            const travelTime = duration.toFixed(0); // phút

            // Hiển thị thời gian di chuyển trên bản đồ
            const timeDisplay = new mapboxgl.Popup({ offset: 25 })
                .setLngLat([(pickupCoords.lng + deliveryCoords.lng) / 2, (pickupCoords.lat + deliveryCoords.lat) / 2])
                .setHTML(`<b>Thời gian di chuyển: </b>${travelTime} phút`)
                .addTo(map);

            // Vẽ đường đi trên bản đồ
            const route = data.routes[0].geometry;

            if (map.getSource('route')) {
                map.getSource('route').setData(route);
            } else {
                map.addSource('route', {
                    'type': 'geojson',
                    'data': route
                });
                map.addLayer({
                    'id': 'route',
                    'type': 'line',
                    'source': 'route',
                    'layout': {
                        'line-join': 'round',
                        'line-cap': 'round'
                    },
                    'paint': {
                        'line-color': '#3b9ddd',
                        'line-width': 6,
                        'line-opacity': 0.8
                    }
                });
            }

            // Điều chỉnh vùng bản đồ vừa với đường đi
            const coordinates = route.coordinates;
            const bounds = new mapboxgl.LngLatBounds(coordinates[0], coordinates[0]);
            for (const coord of coordinates) {
                bounds.extend(coord);
            }
            map.fitBounds(bounds, { padding: 40 });
        } else {
            alert("Không tìm được lộ trình.");
        }
    } catch (error) {
        console.error(error);
        alert("Lỗi khi tính khoảng cách: " + error.message);
    }
}

function calculateShippingFee(distance) {
    const rate = 5000; // 5.000 VNĐ/km
    return Math.round(distance * rate);
}

// Thêm sản phẩm mới
function addProduct() {
    const container = document.getElementById('products-container');
    const productRow = document.createElement('div');
    productRow.classList.add('product-row');

    productRow.innerHTML = `
        <div class="orderform-form-group">
            <label>Sản Phẩm</label>
            <input type="text" name="txtsp[]" class="orderform-input" placeholder="Nhập tên sản phẩm" required>
        </div>
        <div class="orderform-form-group">
            <label>Số Lượng</label>
            <input type="number" name="txtsl[]" class="orderform-input" placeholder="Nhập số lượng" required>
        </div>
        <div class="orderform-form-group">
            <label>Trọng Lượng</label>
            <input type="text" name="txttrongluong[]" class="orderform-input" placeholder="Nhập trọng lượng" required>
        </div>
    `;
    container.appendChild(productRow);
}

// Khi chọn người trả tiền, ẩn hiện select hình thức thanh toán
document.querySelector('select[name="nguoitratien"]').addEventListener('change', function() {
    const paymentMethodSelect = document.querySelector('select[name="payment_method"]');
    if (this.value === "Người nhận") {
        paymentMethodSelect.value = "";
        paymentMethodSelect.disabled = true;
    } else {
        paymentMethodSelect.disabled = false;
    }
});

// Kiểm tra trạng thái lúc load trang
window.addEventListener('DOMContentLoaded', function() {
    const nguoitratienSelect = document.querySelector('select[name="nguoitratien"]');
    const paymentMethodSelect = document.querySelector('select[name="payment_method"]');
    if (nguoitratienSelect.value === "Người nhận") {
        paymentMethodSelect.value = "";
        paymentMethodSelect.disabled = true;
    } else {
        paymentMethodSelect.disabled = false;
    }
});
</script>

<?php
// PHP xử lý đơn hàng
if (isset($_POST["btntaodh"])) {
    $tenng = $_POST["txttenng"];
    $sdtng = $_POST["txtsdtng"];
    $diaching = $_POST["txtdiaching"];
    $ngaydat = date('Y-m-d');
    $tennn = $_POST["txttennn"];
    $sdtnn = $_POST["txtsdtnn"];
    $diachinn = $_POST["txtdiachinn"];
    $distance = $_POST["distance"];
    $shipping_fee = $_POST["shipping_fee"];
    $tinhtranghd = 'Chờ lấy';
    $nguoitra = $_REQUEST["nguoitratien"];
    $hinhthuctt = $_REQUEST['payment_method'] ?? null;
    $thanhtoan = 'Chưa thanh toán';
    $thuho = $_REQUEST['txtthuho'] !== '' ? (float)$_REQUEST['txtthuho'] : 0;


    // Cập nhật thông tin người dùng
    $p->get_capnhatkh($makh, $tenng, $sdtng, $diaching);
    
    // Tạo đơn hàng
    $tao = $p->get_taodonhang($makh, $ngaydat, $tennn, $sdtnn, $diachinn, $tinhtranghd, $shipping_fee, $thuho, $nguoitra, $hinhthuctt, $thanhtoan);
    
    if ($tao) {
        // Lặp qua các sản phẩm và lưu vào chi tiết đơn hàng
        foreach ($_POST["txtsp"] as $index => $tensp) {
            $sl = $_POST["txtsl"][$index];
            $tl = $_POST["txttrongluong"][$index];
            
            $p->get_taochitietdh($tao, $tensp, $sl, $tl);
        }
        
        // Điều hướng tới trang thanh toán hoặc thông báo
        if ($_POST['payment_method'] == "chuyenkhoan") {
            echo "<script>window.location.href='customer_home.php?madh={$tao}'</script>";
        } else {
            echo "<script>alert('Đơn hàng đã được tạo chờ shipper đến lấy hàng'); window.location.href='customer_home.php';</script>";
        }
    } else {
        echo "<script>alert('Vui lòng tạo lại đơn hàng');</script>";
    }
}
?>
