<?php
    include_once("ketnoi.php");
    class M_dangnhap{
        public function dangnhap($tendn, $mk){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con -> set_charset("utf8");
            
            if($con){
                $sql = "select * from taikhoan where tendn = '$tendn' and matkhau = '$mk' ";
                $rs = $con->query($sql);
                $p->dongketnoi($con);
                return $rs;
            }else{
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
                            JOIN chucvu cv ON nv.macv = cv.macv";
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

        public function dsdonhang(){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con -> set_charset("utf8");
            
            if($con){
                $sql = "select * from donhang dh inner join chitietdh ct on dh.madh = ct.madh";
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

        public function donhangnvgiao($manv){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con -> set_charset("utf8");
            
            if($con){
                $sql = "select * from donhang dh inner join khachhang kh on dh.makh = kh.makh where dh.manv = $manv and tinhtrangdh like 'Nhập kho'";
                $rs = $con->query($sql);
                $p->dongketnoi($con);
                return $rs;
            }else{
                echo "Lỗi kết nối";
                return false;
            }
        }

        // tạo đơn hàng
        public function taodonhang($makh, $ngaydat, $tennn, $sdtnn, $diachinn, $tinhtrangdh, $tongtien, $cod){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con -> set_charset("utf8");
            if($con){
                $sql = "insert into donhang(makh, ngaydat, tennn, sdtnn, diachinn, tinhtrangdh, tongtien, cod)
                        values($makh, '$ngaydat', N'$tennn', '$sdtnn', N'$diachinn', N'$tinhtrangdh', $tongtien, $cod)";
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
        // tạo chi tiết đơn hàng
        public function taochitietdh($madh, $tenhang, $soluong, $dvi, $gia){
            $p = new Ketnoi();
            $con = $p->ketnoi();
            $con -> set_charset("utf8");
            if($con){
                $sql = "insert into chitietdh(madh, tenhang, soluong, donvitinh, dongia)
                        values($madh, N'$tenhang', $soluong, N'$dvi', $gia)";
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
    }
?>