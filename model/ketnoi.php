<?php
    class Ketnoi{
        public function ketnoi(){
            return mysqli_connect("localhost", "root", "", "giaohang");
        }

        public function dongketnoi($con){
            $con -> close();
        }
    }
?>