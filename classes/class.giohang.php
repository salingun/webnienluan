<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of class
 *
 * @author PCGAMINGCANTHO
 */
require 'myClass.php';
class Giohang {
//put your code here
    function dathang1($masp){
        if(isset($_SESSION["'".$masp."'"])){
            $_SESSION["'".$masp."'"]=$_SESSION["'".$masp."'"]+1;
        }
        else {
            $_SESSION["'".$masp."'"]=1;
        }
        echo "<meta  http-equiv='refresh' content='0, URL=?page=sanpham&action=index'/>";
        echo "<script>alert('Sản phẩm đã thêm vào giỏ hàng')</script>";

    }
    function dathang($masp, $soluong){
        $spClass = new Sanpham();
        $sp = $spClass->hienthi1SP($masp);
        $soluongkho = $sp['sp_soluong'];
        
        if(isset($_SESSION["'".$masp."'"])){
            $soluong = $_SESSION["'".$masp."'"]+$soluong;
            if($soluong>$soluongkho){
                echo "<script>alert('".$sp['sp_ten']." chỉ tồn kho ".$sp['sp_soluong']."');</script>";
                $soluong = $soluongkho;
            }
        }
        else {
            if($soluong>$soluongkho){
                echo "<script>alert('".$sp['sp_ten']." chỉ tồn kho ".$sp['sp_soluong']."');</script>";
                $soluong = $soluongkho;
            }
        }
        $_SESSION["'".$masp."'"]=$soluong;
        echo "<meta   http-equiv='refresh' content='0, URL=?page=sanpham&action=index'/>";
        echo "<script>alert('Đã thêm ".$soluong." ".$sp['sp_ten']." vào giỏ hàng')</script>";
    }
    
    function thanhtiensp($soluong,$dongia){
        return $soluong*$dongia;
    }
    
    function  tongtiendh($madh){
        $con = new MyConnection();
        $tongtien = 0;
        $sqlquery = "SELECT * FROM chitiet_donhang WHERE dh_ma=".$madh;
        $result = mysqli_query($con->getMyConnection(), $sqlquery);
        while($row=mysqli_fetch_array($result))
        {
            $tongtien += $this->thanhtiensp($row['ctdh_soluong'], $row['ctdh_dongia']);
        }
        return $tongtien;
    }
            
    function countSolgDh($madh){
        $con = new MyConnection();
        $count = 0;
        $sqlquery = "SELECT * FROM chitiet_donhang WHERE dh_ma=".$madh;
        $result = mysqli_query($con->getMyConnection(), $sqlquery);
        while($row=mysqli_fetch_array($result))
        {
            $count += $row['ctdh_soluong'];
        }
        return $count;
    }
    
    function capnhatSoluong($soluongcu,$soluongmoi,$soluongkho){
        $soluong = $soluongcu;
        if($soluongmoi!=$soluongcu){
            if($soluongmoi<=$soluongkho){
                $soluong = $soluongmoi;
            }else{
                $soluong = $soluongkho;
            }
        }
        return $soluong;
    }
    
    function capnhatSSGiohang(){
        $con = new MyConnection();
        $sqlquery = "SELECT * FROM sanpham".$dieukien;
        $result = mysqli_query($con->getMyConnection(), $sqlquery);
        while($row=mysqli_fetch_array($result))
        {
            if(isset($_SESSION["'".$row['sp_ma']."'"]))
            {
                    $x = "cnsl"."$spcn";
                    $soluongmoi = $_POST[$x];
                    $soluongcu = $_SESSION["'".$row['sp_ma']."'"];
                    $soluongkho = $row['sp_soluong'];
            }

        }
    }
    
    function themDonhang($ngaylap,$tennguoinhan,$noigiao,$dt,$ghichu,$trangthai,$httt_ma,$tendangnhap){
        $con = new MyConnection();
        $sqlquery = "INSERT INTO donhang (dh_ngaylap,dh_tennguoinhan,dh_noigiao,dh_dt,dh_ghichu,dh_trangthai,httt_ma,tv_tendangnhap) VALUES ('$ngaylap','$tennguoinhan','$noigiao','$dt','$ghichu','$trangthai','$httt_ma','$tendangnhap')";
        mysqli_query($con->getMyConnection(), $sqlquery);
    }
    
    function themChitietdonhang($dh_ma,$sp_ma,$ctdh_soluong,$ctdh_dongia){
        $con = new MyConnection();
        $sqlquery = "INSERT INTO chitiet_donhang (dh_ma,sp_ma,ctdh_soluong,ctdh_dongia) VALUES ('$dh_ma','$sp_ma','$ctdh_soluong','$ctdh_dongia')";
        mysqli_query($con->getMyConnection(), $sqlquery);
    }
    
    function suaSoluongSanpham($sp_ma,$sp_soluongmua){
        $con = new MyConnection();
        $sqlquery = "UPDATE sanpham set sp_soluong=sp_soluong-".$sp_soluongmua." where sp_ma='$sp_ma'";
        mysqli_query($con->getMyConnection(), $sqlquery);
    }
    
    function getMadhtutang(){
        $con = new MyConnection();
        $sqmadh = "SHOW TABLE STATUS LIKE 'donhang'";
        $rsmadh = mysqli_query($con->getMyConnection(),$sqmadh);
        $rowmadh = mysqli_fetch_array($rsmadh);
        $madh = $rowmadh['Auto_increment'];
        $_SESSION['Ma_dh']=$madh;
        return $madh;
    }
    
    function hienthiDSHttt(){
        $con = new MyConnection();
        $sqlquery = "SELECT httt_ma,httt_ten FROM hinhthucthanhtoan";
        $result = mysqli_query($con->getMyConnection(), $sqlquery);
        return $result;
    }
    
    function hienthi1Donhang($dh_ma){
        $con = new MyConnection();
        $sqlquery = "SELECT * FROM donhang WHERE dh_ma=".$dh_ma;
        $result = mysqli_query($con->getMyConnection(), $sqlquery);
        return mysqli_fetch_array($result,MYSQLI_ASSOC);
    }
    
    function hienthiChitietdonhang($dh_ma){
        $con = new MyConnection();
        $sqlquery = "SELECT * FROM chitiet_donhang WHERE dh_ma=".$dh_ma;
        $result = mysqli_query($con->getMyConnection(), $sqlquery);
        return $result;
    }
    
    function countGiohang(){
        $giohangClass = new Giohang();
        $spClass = new Sanpham();
        $dieukien = "";
        $spResult = $spClass->hienthiDSSP($dieukien);
        $countgh = 0;
        while ($row = mysqli_fetch_array($spResult, MYSQLI_ASSOC)) {
            if (isset($_SESSION["'" . $row['sp_ma'] . "'"])) {
                $countgh += $_SESSION["'" . $row['sp_ma'] . "'"];
            }
        }
        return $countgh;
    }
    
    function hienthiDSDhByUser($tendangnhap){
        $con = new MyConnection();
        $sqlquery = "SELECT * FROM donhang WHERE tv_tendangnhap=".$tendangnhap;
        $result = mysqli_query($con->getMyConnection(), $sqlquery);
        return $result;
    }
    
    function getTrangthaiByMaDh($dh_ma){
        $con = new MyConnection();
        $sqlquery = "SELECT dh_trangthai FROM donhang WHERE dh_ma=".$dh_ma;
        $result = mysqli_query($con->getMyConnection(), $sqlquery);
        $row = mysqli_fetch_array($result);
        return $row['dh_trangthai'];
    }
    
    function capnhatTrangthaiDh($dh_ma,$trangthaimoi){
        $con = new MyConnection();
        $sqlquery = "UPDATE donhang SET dh_trangthai='".$trangthaimoi."' WHERE dh_ma=".$dh_ma;
        mysqli_query($con->getMyConnection(), $sqlquery);
        if($_GET['action']=='donhang'){
            $thisurl = "?page=thanhvien&action=donhang";
        }
        if($_GET['action']=='chitietdonhang'){
            $thisurl = "?page=thanhvien&action=chitietdonhang&madh=".$dh_ma;
        }
        echo '<meta http-equiv="refresh" content="0;URL='.$thisurl.'">';
    }
    
    function getTrangthaiDh($dh_trangthai){
        $out = "";
        if($dh_trangthai=="xuly"){
            $out = "Đang xử lý";
        }
        if($dh_trangthai=="giao"){
            $out = "Đang giao";
        }
        if($dh_trangthai=="xong"){
            $out = "Đã xong";
        }
        if($dh_trangthai=="huy"){
            $out = "Đã hủy";
        }
        return $out;
    }
    
    function countDonhang($dieukien){
        $con = new MyConnection();
        $sqlquery = "SELECT dh_ma FROM donhang".$dieukien;
        $result = mysqli_query($con->getMyConnection(), $sqlquery);
        $count = mysqli_num_rows($result);
        return $count;
    }
    
    function hienthiDSDh($dieukien){
        $con = new MyConnection();
        $sqlquery = "SELECT * FROM donhang".$dieukien;
        $result = mysqli_query($con->getMyConnection(), $sqlquery);
        return $result;
    }
}
