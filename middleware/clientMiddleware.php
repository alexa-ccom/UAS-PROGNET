<?php

include(__DIR__ . '/../functions/reuseableFunction.php');


if (!isset($_SESSION['auth'])) {
    redirect("login.php", "Login to continue");
}
?>