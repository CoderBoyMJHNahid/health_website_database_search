<?php
if (isset($_POST['html_table'])) {
    $htmlTable = $_POST['html_table'];

    // Set headers to download as an Excel file
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"table_data.xls\"");

    // Output the HTML content
    echo $htmlTable;
    exit;
} else {
    echo "No table data received!";
}
