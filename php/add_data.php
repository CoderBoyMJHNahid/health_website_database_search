<?php 

    include "../db/conn.php";

    $path = "file:///D:/python/execl/neighbourhood_data.json";
    $file_data = file_get_contents($path);

    $data = json_decode($file_data, true);

    echo "<pre>";
    foreach($data as $val){
        $sql_fetch_neigh = "SELECT * FROM neighborhood";
        $result_neigh = mysqli_query($conn, $sql_fetch_neigh);
        
        while($row = mysqli_fetch_assoc($result_neigh)){
            if($row["name"] == $val['neighbourhoodName']){
                $sql_lico = "INSERT INTO `licoat`(`neighbId`, `totalPopulation`, `inLicoAt`, `inLicoAtPercentage`, `population0To17`, `inLicoAt0To17`, `inLicoAt0To17Percentage`, `population0To5`, `inLicoAt0To5`, `inLicoAt0To5Percentage`, `population18To64`, `inLicoAt18To64`, `inLicoAt18To64Percentage`, `population65Plus`, `inLicoAt65Plus`, `inLicoAt65PlusPercentage`) VALUES ('{$row['n_id']}','{$val['licoAt']['totalPopulation']}','{$val['licoAt']['inLicoAt']}','{$val['licoAt']['inLicoAtPercentage']}','{$val['licoAt']['population0To17']}','{$val['licoAt']['inLicoAt0To17']}','{$val['licoAt']['inLicoAt0To17Percentage']}','{$val['licoAt']['population0To5']}','{$val['licoAt']['inLicoAt0To5']}','{$val['licoAt']['inLicoAt0To5Percentage']}','{$val['licoAt']['population18To64']}','{$val['licoAt']['inLicoAt18To64']}','{$val['licoAt']['inLicoAt18To64Percentage']}','{$val['licoAt']['population65Plus']}','{$val['licoAt']['inLicoAt65Plus']}','{$val['licoAt']['inLicoAt65PlusPercentage']}')";

                $run_query_lico = mysqli_query($conn,$sql_lico) or die("Run query one failed");

                $sql_lim = "INSERT INTO `limat`(`neighbId`, `totalPopulation`, `inLimAt`, `inLimAtPercentage`, `population0To17`, `inLimAt0To17`, `inLimAt0To17Percentage`, `population0To5`, `inLimAt0To5`, `inLimAt0To5Percentage`, `population18To64`, `inLimAt18To64`, `inLimAt18To64Percentage`, `population65Plus`, `inLimAt65Plus`, `inLimAt65PlusPercentage`) VALUES ('{$row['n_id']}','{$val['limAt']['totalPopulation']}','{$val['limAt']['inLimAt']}','{$val['limAt']['inLimAtPercentage']}','{$val['limAt']['population0To17']}','{$val['limAt']['inLimAt0To17']}','{$val['limAt']['inLimAt0To17Percentage']}','{$val['limAt']['population0To5']}','{$val['limAt']['inLimAt0To5']}','{$val['limAt']['inLimAt0To5Percentage']}','{$val['limAt']['population18To64']}','{$val['limAt']['inLimAt18To64']}','{$val['limAt']['inLimAt18To64Percentage']}','{$val['limAt']['population65Plus']}','{$val['limAt']['inLimAt65Plus']}','{$val['limAt']['inLimAt65PlusPercentage']}')";

                $run_query_sql_lim = mysqli_query($conn,$sql_lim) or die("Run query two failed");
                break;

            }
        }

    }
    // print_r($data);

    echo "Successfully executed";
