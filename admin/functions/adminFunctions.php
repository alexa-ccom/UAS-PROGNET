<?php

include('../config/db-config.php');


    function getOrders(){
        global $con;
        $query = "SELECT * FROM tb_orders WHERE status='0'";

        return mysqli_query($con, $query);
    }

    // function checkTrackingNoValidAdmin($trackingNo){
    //     global $con;
    //     $query = "SELECT * FROM tb_orders WHERE no_tracking='$trackingNo'";
    //     return mysqli_query($con, $query);

    // }

function checkTrackingNoValidAdmin($trackingNo) {
    global $con;
    
    $trackingNo = mysqli_real_escape_string($con, $trackingNo);
    
    $query = "
        SELECT 
            o.*,
            a.alamat AS alamat_lengkap,
            a.kota,
            a.provinsi
        FROM tb_orders o
        JOIN tb_alamat a ON o.alamat = a.id_alamat
        WHERE o.no_tracking = '$trackingNo'
        LIMIT 1
    ";
    
    return mysqli_query($con, $query);
}


    function getOrderHistory(){
        global $con;
        $query = "SELECT * FROM tb_orders WHERE status != '0'";

        return mysqli_query($con, $query);
    }

    function getAll($table){
        global $con;
        $query = "SELECT * FROM $table";
        return $query_run = mysqli_query($con, $query);
    }

    // Function fetch data by id
    function getById($table, $id, $column){
        global $con;
        $query = "SELECT * FROM $table WHERE $column = '$id'";
        return $query_run = mysqli_query($con, $query);
    }


?>