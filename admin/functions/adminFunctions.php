<?php

include('../config/db-config.php');


    function getOrders(){
        global $con;
        $query = "SELECT * FROM tb_orders WHERE status='0'";

        return mysqli_query($con, $query);
    }

    function checkTrackingNoValidAdmin($trackingNo){
        global $con;
        $query = "SELECT * FROM tb_orders WHERE no_tracking='$trackingNo'";
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