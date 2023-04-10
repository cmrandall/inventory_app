<?php
    include 'sqlConnection.php';

    // find number of pages and how many results to display per page
    if (isset($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
    } else {
        $pageno = 1;
    }
    $no_of_records_per_page = 5;
    $offset = ($pageno-1) * $no_of_records_per_page;

    
    //Select the number of rows
    $total_pages_sql = "SELECT COUNT(*) FROM main";
    $pages = mysqli_query($conn,$total_pages_sql);
    $total_rows = mysqli_fetch_array($pages)[0];
    $total_pages = ceil($total_rows / $no_of_records_per_page);




?>