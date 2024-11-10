<?php

include "../db/conn.php";

$data = json_decode(file_get_contents("php://input"), true);


$neigh = $data['neigh'];
$income = $data['income'];

// $neigh = [1,3];

// $income = [
//     "LICO AT",
//     "LIM AT"
// ];

$ids = implode(", ", $neigh);
// die(var_dump($ids));

// echo json_encode($income);

if (count($income) == 2) {

    $fetch_data = [];

    $sql = "SELECT * FROM licoat JOIN neighborhood ON licoat.neighbId = neighborhood.n_id WHERE neighbId IN ($ids)";

    $result = mysqli_query($conn, $sql) or die("Couldn't run first SQL query");

    $lico_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $fetch_data['licoat'] = $lico_data;

    $sql2 = "SELECT * FROM limat JOIN neighborhood ON limat.neighbId = neighborhood.n_id WHERE neighbId in ($ids)";

    $result2 = mysqli_query($conn, $sql2) or die("Couldn't run second SQL query");
    $lim_data = mysqli_fetch_all($result2, MYSQLI_ASSOC);
    $fetch_data['limat'] = $lim_data;

    echo json_encode(["data" => $fetch_data]);

} else {
    $fetch_data = [];

    $sql = "SELECT * FROM $income[0] JOIN neighborhood ON $income[0].neighbId = neighborhood.n_id WHERE neighbId IN ($ids)";

    $result = mysqli_query($conn, $sql) or die("Couldn't run first SQL query");

    $final_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $fetch_data[$income[0]] = $final_data;

    echo json_encode(["data" => $fetch_data]);

}



