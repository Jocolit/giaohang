<?php
    include("model/m_dangnhap.php");

    class C_dangnhap{
        public function get_dangnhap($tendn = null, $mk = null){
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
        
        // Thêm nhân viên
        public function get_themnv($tennv, $sdt, $hinhanh, $trangthai, $matk, $macv){
            $p = new M_dangnhap();
            $con = $p->themnv($tennv, $sdt, $hinhanh, $trangthai, $matk, $macv);
            if($con){
                if($con)
                    return $con;
                else
                    return 0;
            }else
                return false;
        }

        // cập nhật nv
        public function get_capnhatnv($manv, $tennv, $sdt, $cv, $hinhanh){
            $p = new M_dangnhap();
            $con = $p->capnhatnv($manv, $tennv, $sdt, $cv, $hinhanh);
            if($con){
                if($con)
                    return $con;
                else
                    return 0;
            }else
                return false;
        }

        // chuyển trạng thái nhân viên
        public function get_xoanv($manv, $trangthai){
            $p = new M_dangnhap();
            $con = $p->xoanv($manv, $trangthai);
            if($con){
                if($con)
                    return $con;
                else
                    return 0;
            }else
                return false;
        }


        // chỉ lấy ds shiper
        public function get_dsshiper(){
            $p = new M_dangnhap();
            $con = $p->dsshiper();
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

        // danh sách đơn hàng chưa phân công
        public function get_dsdonhangpc(){
            $p = new M_dangnhap();
            $con = $p-> dsdonhangpc();
            if($con){
                if($con->num_rows>0)
                    return $con;
                else
                    return 0;
            }else
                return false;
        }

        //danh sách đơn hàng
        public function get_dsdonhang($madh = null){
            $p = new M_dangnhap();
            $con = $p-> dsdonhang($madh);
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

        // danh sách đơn hàng theo khách hàng
        public function get_donhang_kh($matk){
            $p = new M_dangnhap();
            $con = $p-> donhang_kh($matk);
            if($con){
                if($con->num_rows>0)
                    return $con;
                else
                    return 0;
            }else
                return false;
        }

        // phân công nhân viên
        public function get_phancong_tudong($madh, $manv){
            $p = new M_dangnhap();
            $con = $p->phancong_tudong($madh, $manv);
            if($con){
                return $con;
            }else{
                return false;
            }
        }
        
        // chọn nhân viết ít đơn nhất
        public function get_nhanvien_it_nhat(){
            $p = new M_dangnhap();
            return $p->lay_nhanvien_it_nhat();
        }
        
        // tạo đơn hàng
        public function get_taodonhang($makh, $ngaydat, $tennn, $sdtnn, $diachinn, $tinhtrangdh, $shipping_fee, $thuho, $nguoitratien, $hinhthuctt, $thanhtoan){
            $p = new M_dangnhap();
            $con = $p-> taodonhang($makh, $ngaydat, $tennn, $sdtnn, $diachinn, $tinhtrangdh, $shipping_fee, $thuho, $nguoitratien, $hinhthuctt, $thanhtoan);
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

        // cập nhật trạng thái đơn hàng 
        public function get_capnhat_trangthai($madh, $trangthai){
            $p = new M_dangnhap();
            return $p->capnhat_trangthai($madh, $trangthai);
        }
        
        // cập nhật thanh toán
        public function get_capnhat_thanhtoan($madh, $thanhtoan){
            $p = new M_dangnhap();
            return $p->capnhat_thanhtoan($madh, $thanhtoan);
        }

        // tạo chi tiết đơn hàng
        public function get_taochitietdh($madh, $tenhang, $soluong, $trongluong){
            $p = new M_dangnhap();
            $con = $p-> taochitietdh($madh, $tenhang, $soluong, $trongluong);
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

         // cập nhật khách hàng
         public function get_capnhatkh($makh,$ten, $sdt, $dc){
            $p = new M_dangnhap();
            $con = $p-> capnhatkh($makh,$ten, $sdt, $dc);
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