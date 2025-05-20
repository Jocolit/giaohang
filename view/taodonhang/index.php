<?php
// session_start();
include_once("control/c_dangnhap.php");
$p = new C_dangnhap();
$con = $p->get_lay1kh($_SESSION["tk"]);
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
            body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f7fa;
}

.container {
    display: flex;
    flex-grow: 1;
    height: 100vh; /* Đảm bảo chiều cao chiếm toàn bộ màn hình */
    margin: 0;
    padding: 0;
}

.sidebar {
    width: 400px; /* Chiều rộng sidebar có thể thay đổi tùy theo yêu cầu */
    background-color: #fff;
    padding: 20px;
    border-right: 2px solid #ddd;
    overflow-y: auto;
    box-sizing: border-box; /* Đảm bảo tính đúng kích thước */
}

.card {
    background: white;
    padding: 25px;
    margin-bottom: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.card h3 {
    margin-top: 0;
    color: #333;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
}

input, select, textarea {
    width: 100%;
    height: 40px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    color: #333;
}

.btn {
    background: #3498db;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    margin-top: 10px;
}

.btn:hover {
    background: #2980b4;
}

/* Điều chỉnh bản đồ */
#map {
    flex-grow: 1; /* Đảm bảo bản đồ chiếm toàn bộ không gian còn lại */
    height: 100%;
    min-width: 0; /* Đảm bảo bản đồ không bị nhỏ lại quá */
    margin: 0;
    box-sizing: border-box; /* Đảm bảo tính đúng kích thước */
}

/* Media query cho các màn hình nhỏ */
@media (max-width: 768px) {
    .container {
        flex-direction: column; /* Khi màn hình nhỏ, chuyển thành dạng cột */
    }

    .sidebar {
        width: 100%; /* Sidebar chiếm toàn bộ chiều rộng trên màn hình nhỏ */
    }

    #map {
        width: 100%; /* Bản đồ chiếm toàn bộ chiều rộng trên màn hình nhỏ */
        height: 400px; /* Giảm chiều cao bản đồ khi trên màn hình nhỏ */
    }
}



    </style>
    <!-- Link Mapbox -->
    <!-- Nạp Mapbox GL JS -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.3.0/mapbox-gl.js"></script>
    <!-- Nạp CSS của Mapbox GL JS -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.3.0/mapbox-gl.css" rel="stylesheet" />
    <!-- Nạp apbox-gl-geocoder -->
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.3/mapbox-gl-geocoder.min.js"></script>
    <!-- Nạp CSS của mapbox-gl-geocoder -->
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.3/mapbox-gl-geocoder.css" type="text/css">

</head>

<body>
<div class="container">
    <!-- Sidebar bên trái chứa form nhập liệu -->
    <div class="sidebar">
        <form action="" method="POST" id="orderForm">
            <!-- Card thông tin người gửi -->
            <div class="card">
                <h3>Thông Tin Người Gửi</h3>
                <div class="form-group">
                    <label>Họ và Tên</label>
                    <input type="text" name="txttenng" value="<?php echo $r['tenkh']?>" readonly>
                </div>
                <div class="form-group">
                    <label>Số Điện Thoại</label>
                    <input type="text" name="txtsdtng" value="<?php echo $r['sdt']?>" readonly>
                </div>
                <div class="form-group">
                    <label>Địa Chỉ</label>
                    <!-- Div này sẽ chứa Geocoder -->
                    <div id="pickup_geocoder"></div>
                    <input id="pickup_address" type="text" name="txtdiaching" value="<?php echo $r['diachi']?>" placeholder="Nhập địa chỉ người gửi" >
                   
                </div>
            </div>

            <!-- Card thông tin người nhận -->
            <div class="card">
                <h3>Thông Tin Người Nhận</h3>
                <div class="form-group">
                    <label>Họ và Tên</label>
                    <input type="text" name="txttennn" required placeholder="Nhập họ và tên người nhận">
                </div>
                <div class="form-group">
                    <label>Số Điện Thoại</label>
                    <input type="text" name="txtsdtnn" required placeholder="Nhập số điện thoại người nhận">
                </div>
                <div class="form-group">
                    <label>Địa Chỉ</label>
                    <!-- Div này sẽ chứa Geocoder -->
                    <div id="delivery_geocoder"></div>
                    <input id="delivery_address" type="text" name="txtdiachinn" required placeholder="Nhập địa chỉ giao hàng" >
                </div>
                <div class="form-group">
                    <label>Khoảng Cách (Km)</label>
                    <input type="text" id="distance" name="distance" readonly>
                </div>
                <div class="form-group">
                    <label>Phí Giao Hàng (VNĐ)</label>
                    <input type="text" id="shipping_fee" name="shipping_fee" readonly>
                </div>
                
                <!-- <button type="button" onclick="calculateDistance()" class="btn">🔎 Tính Khoảng Cách & Phí Ship</button> -->
            </div>

            <!-- Card thông tin sản phẩm -->
            <div class="card">
                <h3>Thông Tin Sản Phẩm</h3>
                <div id="products-container">
                    <div class="product-row">
                        <div class="form-group">
                            <label>Sản Phẩm</label>
                            <input type="text" name="txtsp[]" placeholder="Nhập tên sản phẩm" required>
                        </div>
                        <div class="form-group">
                            <label>Số Lượng</label>
                            <input type="number" name="txtsl[]" placeholder="Nhập số lượng" required>
                        </div>
                        <div class="form-group">
                            <label>Trọng Lượng</label>
                            <input type="text" name="txttrongluong[]" placeholder="Nhập trọng lượng" required>
                        </div>
                        
                    </div>
                </div>
                <button type="button" onclick="addProduct()" class="btn">Thêm sản phẩm</button>
                <div class="form-group">
                            <label>Thu Hộ</label>
                            <input type="number" name="txtthuho" placeholder="Nhập tiền thu hộ" >
                </div>
                <div class="form-group">
                    <label>Người trả tiền</label>
                    <select name="nguoitratien" required>
                        <option value="" selected disabled>-- Chọn người trả tiền --</option>
                        <option value="Người gửi">Người gửi trả tiền</option>
                        <option value="Người nhận">Người nhận trả tiền</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Hình Thức Thanh Toán</label>
                    <select name="payment_method" required>
                        <option value="" selected disabled>-- Chọn phương thức thanh toán --</option>
                        <option value="tienmat">Tiền mặt</option>
                        <option value="chuyenkhoan">Chuyển khoản</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn" name="btntaodh">🚀 Tạo Đơn Hàng</button>
        </form>
    </div>

    <!-- Map phần bên phải -->
    <div id="map"></div>
</div>

<script>
// JavaScript cho Mapbox và tính toán khoảng cách
mapboxgl.accessToken = 'pk.eyJ1IjoicGh1Y2xvYyIsImEiOiJjbWFtMWwwcWcwZzVwMmtxMHJoNWJieXRzIn0.Ub6AC90KY1yMOXFK5qwLYg';

// Tạo bản đồ
const map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: [106.6297, 10.8231], // Tọa độ Hồ Chí Minh
    zoom: 12
});

// Thêm điều khiển zoom
map.addControl(new mapboxgl.NavigationControl());

/// Tạo Geocoder cho người gửi
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

  // Đảm bảo rằng marker của người nhận sẽ giữ màu đỏ
let pickupMarker = null;  // Người gửi (màu xanh)
let deliveryMarker = null;  // Người nhận (màu đỏ)

// Khi người dùng chọn địa chỉ người gửi
pickupGeocoder.on('result', function (e) {
    const pickupCoords = e.result.center;

    // Nếu đã có marker người gửi, cập nhật lại tọa độ
    if (pickupMarker) {
        pickupMarker.setLngLat(pickupCoords);
    } else {
        // Tạo mới marker cho người gửi và thêm vào bản đồ
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




// chuyển địa chỉ chuỗi sang tọa độ
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

   // Kiểm tra xem marker của người gửi và người nhận đã được chọn chưa
    if (!pickupMarker || !deliveryMarker) {
        alert("Vui lòng chọn địa chỉ người gửi và người nhận.");
        return;
    }

      // Lấy tọa độ của người gửi và người nhận
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
            const duration = data.routes[0].duration / 60; // thời gian tính bằng phút
            const shippingFee = calculateShippingFee(distance);

            document.getElementById('distance').value = distance.toFixed(2);
            document.getElementById('shipping_fee').value = shippingFee;

            // Tính thời gian di chuyển (giờ)
            const travelTime = duration.toFixed(0); // Thời gian di chuyển (phút)
            console.log(`Thời gian di chuyển: ${travelTime} phút`);

            // Hiển thị thời gian di chuyển lên bản đồ
            const timeDisplay = new mapboxgl.Popup({ offset: 25 })
                .setLngLat([(pickupCoords.lng + deliveryCoords.lng) / 2, (pickupCoords.lat + deliveryCoords.lat) / 2])
                .setHTML(`<b>Thời gian di chuyển: </b>${travelTime} phút`)
                .addTo(map);

            // --- VẼ ĐƯỜNG ĐI TRÊN BẢN ĐỒ ---
            const route = data.routes[0].geometry;

            // Nếu đã có source thì update, chưa có thì add
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
            // Sau khi đã có route (GeoJSON LineString)
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

// Khi chọn người trả tiền, kiểm tra để ẩn hoặc hiện select hình thức thanh toán
document.querySelector('select[name="nguoitratien"]').addEventListener('change', function() {
    const paymentMethodSelect = document.querySelector('select[name="payment_method"]');
    if (this.value === "Người nhận") {
        // Nếu chọn Người nhận trả tiền, disable và reset select hình thức thanh toán
        paymentMethodSelect.value = "";
        paymentMethodSelect.disabled = true;
    } else {
        // Người gửi trả tiền thì cho phép chọn bình thường
        paymentMethodSelect.disabled = false;
    }
});

// Khi load trang, kiểm tra lại lần đầu (nếu có giá trị được chọn)
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
    // $shipping_fee = $_POST["shipping_fee"];
    $shipping_fee = 30;
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
        
        // Cập nhật tổng tiền cho đơn hàng
        // $p->get_capnhatdh($tao, $tongtien);

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
</body>
</html>




