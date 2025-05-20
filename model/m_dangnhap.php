<?php
    include_once("ketnoi.php");
    class M_dangnhap{
        public function dangnhap($tendn = null, $mk = null){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con->set_charset("utf8");
        
            if ($con) {
                if ($tendn !== null && $mk !== null) {
                    // Nếu có tên đăng nhập và mật khẩu
                    $sql = "SELECT * FROM taikhoan WHERE tendn = '$tendn' AND matkhau = '$mk'";
                } else {
                    // Nếu không có tên đăng nhập và mật khẩu, lấy tất cả dữ liệu
                    $sql = "SELECT * FROM taikhoan";
                }
        
                $rs = $con->query($sql);
                $p->dongketnoi($con);
                return $rs;
            } else {
                echo "Lỗi kết nối";
                return false;
            }
        }
        
        // lấy danh sách nhân viên
        public function nhanvien($matk = null){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con->set_charset("utf8");
        
            if ($con) {
                if ($matk !== null) {
                    // Lấy một nhân viên theo mã tài khoản
                    $sql = "SELECT * FROM nhanvien nv 
                            JOIN chucvu cv ON nv.macv = cv.macv 
                            WHERE nv.matk = ?";
                    $stmt = $con->prepare($sql);
                    $stmt->bind_param("i", $matk);
                } else {
                    // Lấy toàn bộ danh sách nhân viên
                    $sql = "SELECT * FROM nhanvien nv 
                            JOIN chucvu cv ON nv.macv = cv.macv 
                            WHERE nv.macv != 4 AND nv.trangthai like N'Đang làm';";
                    $stmt = $con->prepare($sql);
                }
        
                $stmt->execute();
                $rs = $stmt->get_result();
                $p->dongketnoi($con);
                return $rs;
            } else {
                echo 'Lỗi kết nối';
                return false;
            }
        }
        
        // thêm nhân viên
        public function themnv($tennv, $sdt, $hinhanh, $trangthai, $matk, $macv){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con -> set_charset("utf8");
            if($con){
                $sql = "insert into nhanvien(tennv, sdt, hinhanh, trangthai, matk, macv)
                        values(N'$tennv', '$sdt', '$hinhanh', N'$trangthai', $matk, $macv)";
                $rs = $con->query($sql);
                $p->dongketnoi($con);
                return $rs;
            }else{
                echo "Lỗi kết nối";
                return false;
            }
        }

        // cập nhật nhân viên
        public function capnhatnv($manv, $tennv, $sdt, $cv, $hinhanh){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con -> set_charset("utf8");
            
            if($con){
                $sql = "update nhanvien 
                        set tennv = N'$tennv', sdt = '$sdt', macv = $cv, hinhanh = '$hinhanh'
                        where manv = $manv";
                $rs = $con->query($sql);
                $p->dongketnoi($con);
                return $rs;
            }else{
                echo "Lỗi kết nối";
                return false;
            }
        }

        // chuyển trạng thái nhân viên
        public function xoanv($manv, $trangthai){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con -> set_charset("utf8");
            
            if($con){
                $sql = "update nhanvien 
                        set trangthai = N'$trangthai'
                        where manv = $manv";
                $rs = $con->query($sql);
                $p->dongketnoi($con);
                return $rs;
            }else{
                echo "Lỗi kết nối";
                return false;
            }
        }

        // Chỉ lấy nhân viên là shipper
        public function dsshiper(){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con -> set_charset("utf8");
            
            if($con){
                $sql = "select * from nhanvien where macv = 1";
                $rs = $con->query($sql);
                $p->dongketnoi($con);
                return $rs;
            }else{
                echo "Lỗi kết nối";
                return false;
            }
        }
        // lấy khách hàng, nếu truyền mã thì lấy 1 theo mã tk
        public function lay1kh($matk = null){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con->set_charset("utf8");
        
            if($con){
                if ($matk !== null) {
                    // Lấy thông tin 1 khách hàng
                    $sql = "SELECT * FROM khachhang kh inner join taikhoan tk on kh.matk=tk.matk WHERE kh.matk = ?";
                    $stmt = $con->prepare($sql);
                    $stmt->bind_param("i", $matk);
                } else {
                    // Lấy danh sách toàn bộ khách hàng
                    $sql = "SELECT * FROM khachhang kh inner join taikhoan tk on kh.matk=tk.matk";
                    $stmt = $con->prepare($sql);
                }
        
                $stmt->execute();
                $rs = $stmt->get_result();
        
                $p->dongketnoi($con);
                return $rs;
            } else {
                echo 'Lỗi kết nối';
                return false;
            }
        }

        // danh sách đơn hàng, nếu truyền mã thì lấy chitiet
        public function dsdonhang($madh = null){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con->set_charset("utf8");
            
            if ($con) {
                if ($madh !== null) {
                    // Lấy đơn hàng theo mã đơn hàng
                    $sql = "SELECT * 
                            FROM donhang dh 
                            INNER JOIN chitietdh ct ON dh.madh = ct.madh 
                            WHERE dh.madh = ?";
                    $stmt = $con->prepare($sql);
                    $stmt->bind_param("i", $madh); // "i" cho integer
                } else {
                    // Lấy tất cả đơn hàng
                    $sql = "SELECT DISTINCT dh.*, kh.tenkh, kh.sdt, kh.diachi
                            FROM donhang dh
                            LEFT JOIN chitietdh ct ON dh.madh = ct.madh
                            LEFT JOIN khachhang kh ON dh.makh = kh.makh;";
                    $stmt = $con->prepare($sql);
                }
                
                $stmt->execute();
                $rs = $stmt->get_result();
                $p->dongketnoi($con);
                return $rs;
            } else {
                echo 'Lỗi kết nối';
                return false;
            }
        }        

        // danh sách đơn hàng chưa được phân công
        public function dsdonhangpc(){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con -> set_charset("utf8");
            
            if($con){
                $sql = "select * from donhang dh join khachhang kh on dh.makh=kh.makh where dh.manv IS NULL";
                $rs = $con->query($sql);
                $p->dongketnoi($con);
                return $rs;
            }else{
                echo "Lỗi kết nối";
                return false;
            }
        }

        // lấy đơn hàng theo nhân viên
        public function donhangnvlay($manv){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con -> set_charset("utf8");
            
            if($con){
                $sql = "select * from donhang dh inner join khachhang kh on dh.makh = kh.makh where dh.manv = $manv and tinhtrangdh like 'Chờ lấy'";
                $rs = $con->query($sql);
                $p->dongketnoi($con);
                return $rs;
            }else{
                echo "Lỗi kết nối";
                return false;
            }
        }

        // đơn hàng theo nhân viên giao
        public function donhangnvgiao($manv){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con -> set_charset("utf8");
            
            if($con){
                $sql = "select * from donhang dh inner join khachhang kh on dh.makh = kh.makh where dh.manv = $manv and tinhtrangdh like 'Đang giao'";
                $rs = $con->query($sql);
                $p->dongketnoi($con);
                return $rs;
            }else{
                echo "Lỗi kết nối";
                return false;
            }
        }

        // đơn hàng theo khách hàng 
        public function donhang_kh($matk){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con -> set_charset("utf8");
            
            if($con){
                $sql = "SELECT DISTINCT dh.*, kh.tenkh, kh.sdt, kh.diachi
                            FROM donhang dh
                            LEFT JOIN chitietdh ct ON dh.madh = ct.madh
                            LEFT JOIN khachhang kh ON dh.makh = kh.makh
                            where matk = $matk";
                $rs = $con->query($sql);
                $p->dongketnoi($con);
                return $rs;
            }else{
                echo "Lỗi kết nối";
                return false;
            }
        }

        //phân công nhân viên
        public function phancong_tudong($madh, $manv){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con->set_charset("utf8");
            if($con){
                $sql = "UPDATE donhang SET manv = $manv WHERE madh = $madh";
                $rs = $con->query($sql);
                $p->dongketnoi($con);
                return $rs;
            }else{
                echo "Lỗi kết nối";
                return false;
            }
        }
        
        // hàm chọn nhân viên có ít hóa đơn nhất
        public function lay_nhanvien_it_nhat(){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con->set_charset("utf8");
            if($con){
                $sql = "SELECT nv.manv, COUNT(dh.madh) AS tong_don
                        FROM nhanvien nv
                        LEFT JOIN donhang dh ON nv.manv = dh.manv AND dh.tinhtrangdh IN ('Chờ lấy')
                        WHERE nv.macv = 1
                        GROUP BY nv.manv
                        ORDER BY tong_don ASC
                        LIMIT 1";
                $rs = $con->query($sql);
                if ($rs && $rs->num_rows > 0) {
                    return $rs->fetch_assoc();
                }
                $p->dongketnoi($con);
                return false;
            }else{
                echo "Lỗi kết nối";
                return false;
            }
        }
        

        // tạo đơn hàng
        public function taodonhang($makh, $ngaydat, $tennn, $sdtnn, $diachinn, $tinhtrangdh, $shipping_fee, $thuho, $nguoitratien, $hinhthuctt, $thanhtoan){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con -> set_charset("utf8");
            if($con){
                $sql = "insert into donhang(makh, ngaydat, tennn, sdtnn, diachinn, tinhtrangdh, shipping_fee, thuho, nguoitratien, hinhthuctt, thanhtoan)
                        values($makh, '$ngaydat', N'$tennn', '$sdtnn', N'$diachinn', N'$tinhtrangdh', $shipping_fee, $thuho, N'$nguoitratien', N'$hinhthuctt', N'$thanhtoan')";
                $rs = $con->query($sql);
                if($rs){
                    $id = $con->insert_id;
                    $p->dongketnoi($con);
                    return $id;
                }else{
                    $p->dongketnoi($con);
                    return false;
                }
            }else{
                echo "Lỗi kết nối";
                return false;
            }
        }

        // cập nhật đơn hàng
        public function capnhatdh($madh, $tongtien){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con -> set_charset("utf8");
            if($con){
                $sql = "update donhang set tongtien=$tongtien where madh=$madh";
                $rs = $con->query($sql);
                $p->dongketnoi($con);
                return $rs;
            }else{
                echo "Lỗi kết nối";
                return false;
            }
        }

        // cập nhật trạng thái đơn hàng
        public function capnhat_trangthai($madh, $trangthai){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con->set_charset("utf8");
            if($con){
                $sql = "UPDATE donhang SET tinhtrangdh = ? WHERE madh = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("si", $trangthai, $madh);
                $stmt->execute();
                $p->dongketnoi($con);
                return true;
            } else {
                echo "Lỗi kết nối";
                return false;
            }
        }
        
        // cập nhật thanh toán
        public function capnhat_thanhtoan($madh, $thanhtoan){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con->set_charset("utf8");
            if($con){
                $sql = "UPDATE donhang SET thanhtoan = ? WHERE madh = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("si", $thanhtoan, $madh);
                $stmt->execute();
                $p->dongketnoi($con);
                return true;
            } else {
                echo "Lỗi kết nối";
                return false;
            }
        }

        // tạo chi tiết đơn hàng
        public function taochitietdh($madh, $tenhang, $soluong, $trongluong){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con -> set_charset("utf8");
            if($con){
                $sql = "insert into chitietdh(madh, tenhang, soluong, trongluong)
                        values($madh, N'$tenhang', $soluong, N'$trongluong')";
                $rs = $con->query($sql);
                $p->dongketnoi($con);
                return $rs;
            }else{
                echo "Lỗi kết nối";
                return false;
            }
        }
        // đăng ký
        public function dangky($tendn, $mk, $mota, $loaitk){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con -> set_charset("utf8");
            if($con){
                $sql = "insert into taikhoan(tendn, matkhau, mota, loaitk)
                        values('$tendn', '$mk', N'$mota', $loaitk)";
                $rs = $con->query($sql);
                if($rs){
                    $id = $con->insert_id;
                    $p->dongketnoi($con);
                    return $id;
                }else{
                    $p->dongketnoi($con);
                    return false;
                }
            }else{
                echo "Lỗi kết nối";
                return false;
            }
        }

        // thêm khách hàng mới
        public function taokhachhang($ten, $sdt, $dc, $hinh, $matk){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con -> set_charset("utf8");
            if($con){
                $sql = "insert into khachhang(tenkh, sdt, diachi, hinhanh, matk)
                        values(N'$ten', '$sdt', N'$dc', '$hinh', $matk)";
                $rs = $con->query($sql);
                $p->dongketnoi($con);
                return $rs;
            }else{
                echo "Lỗi kết nối";
                return false;
            }
        }

        // Cập nhật khách hàng
         public function capnhatkh($makh,$ten, $sdt, $dc){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con -> set_charset("utf8");
            if($con){
                $sql = "update khachhang set tenkh='$ten', sdt='$sdt', diachi='$dc' where makh='$makh'";
                $rs = $con->query($sql);
                $p->dongketnoi($con);
                return $rs;
            }else{
                echo "Lỗi kết nối";
                return false;
            }
        }
    }
?>