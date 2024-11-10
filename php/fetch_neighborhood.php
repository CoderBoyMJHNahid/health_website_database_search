<?php

include "../db/conn.php";

$sql = "SELECT * FROM neighborhood";
$run_query = mysqli_query($conn, $sql) or die("Run query failed!!");

$data = mysqli_fetch_all($run_query);

echo json_encode($data);
