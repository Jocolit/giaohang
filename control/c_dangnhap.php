<?php
    include("model/m_dangnhap.php");

    class C_dangnhap{
        public function get_dangnhap($tendn, $mk){
            $p = new M_dangnhap();
            $con = $p->dangnhap($tendn, $mk);
            if($con){
                if($con->num_rows>0)
                    return $con;
                else
                    return 0;
            }else
                return false;
        }

        // ds nhân viên
        public function get_nhanvien($matk = null){
            $p = new M_dangnhap();
            $con = $p->nhanvien($matk);
            if($con){
                if($con->num_rows>0)
                    return $con;
                else
                    return 0;
            }else
                return false;
        }


        
        // lấy kh
        public function get_lay1kh($matk = null){
            $p = new M_dangnhap();
            $con = $p->lay1kh($matk);
            if($con){
                if($con->num_rows>0)
                    return $con;
                else
                    return 0;
            }else
                return false;
        }

        public function get_dsdonhang(){
            $p = new M_dangnhap();
            $con = $p-> dsdonhang();
            if($con){
                if($con->num_rows>0)
                    return $con;
                else
                    return 0;
            }else
                return false;
        }

        // đơn hàng theo nhân viên
        public function get_donhangnvlay($manv){
            $p = new M_dangnhap();
            $con = $p-> donhangnvlay($manv);
            if($con){
                if($con->num_rows>0)
                    return $con;
                else
                    return 0;
            }else
                return false;
        }

        public function get_donhangnvgiao($manv){
            $p = new M_dangnhap();
            $con = $p-> donhangnvgiao($manv);
            if($con){
                if($con->num_rows>0)
                    return $con;
                else
                    return 0;
            }else
                return false;
        }

        // tạo đơn hàng
        public function get_taodonhang($makh, $ngaydat, $tennn, $sdtnn, $diachinn, $tinhtrangdh, $tongtien, $cod){
            $p = new M_dangnhap();
            $con = $p-> taodonhang($makh, $ngaydat, $tennn, $sdtnn, $diachinn, $tinhtrangdh, $tongtien, $cod);
            if($con){
                if($con)
                    return $con;
                else
                    return 0;
            }else
                return false;
        }

        // cập nhật đơn hàng
        public function get_capnhatdh($madh, $tongtien){
            $p = new M_dangnhap();
            $con = $p-> capnhatdh($madh, $tongtien);
            if($con){
                if($con)
                    return $con;
                else
                    return 0;
            }else
                return false;
        }
        // tạo chi tiết đơn hàng
        public function get_taochitietdh($madh, $tenhang, $soluong, $dvi, $gia){
            $p = new M_dangnhap();
            $con = $p-> taochitietdh($madh, $tenhang, $soluong, $dvi, $gia);
            if($con){
                if($con)
                    return $con;
                else
                    return 0;
            }else
                return false;
        }
        
        // đăng ký
        public function get_dangky($tendn, $mk, $mota, $loaitk){
            $p = new M_dangnhap();
            $con = $p-> dangky($tendn, $mk, $mota, $loaitk);
            if($con){
                if($con)
                    return $con;
                else
                    return 0;
            }else
                return false;
        }

        // thêm khách hàng
        public function get_taokhachhang($ten, $sdt, $dc, $hinh, $matk){
            $p = new M_dangnhap();
            $con = $p-> taokhachhang($ten, $sdt, $dc, $hinh, $matk);
            if($con){
                if($con)
                    return $con;
                else
                    return 0;
            }else
                return false;
        }
    }
?>