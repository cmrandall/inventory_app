<?php
    // PHP file for connection to SQL DB
    include 'sqlConnection.php';

    // Check for connection error
    if(mysqli_connect_error()) {
        die('Connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
    } 

	// find number of pages and how many results to display per page
	if (isset($_GET['pageno'])) {
		$pageno = $_GET['pageno'];
	} else {
		$pageno = 1;
	}
	$no_of_records_per_page = 10;
	$offset = ($pageno-1) * $no_of_records_per_page;

	//Select the number of rows
	$total_pages_sql = "SELECT COUNT(*) FROM main";
	$pages = mysqli_query($conn,$total_pages_sql);
	$total_rows = mysqli_fetch_array($pages)[0];
	$total_pages = ceil($total_rows / $no_of_records_per_page);	

	if(isset($_POST['search'])) {
		// get data based on user search input to display in table
		$valueToSearch = $_POST['valueToSearch'];
		$sql = "SELECT id, descript, loc, depart, manufacturer, model, quantity, inventoried, own, cost, stat, tag FROM main WHERE CONCAT(`id`, `descript`, `loc`, `depart`, `manufacturer`, `model`, `quantity`, `inventoried`, `own`, `cost`, `stat`, `tag`) LIKE '%".$valueToSearch."%'LIMIT $offset, $no_of_records_per_page";
		$search_result = filterTable($sql);
	}else {
		// default data to display in table
		$sql = "SELECT id, descript, loc, depart, manufacturer, model, quantity, inventoried, own, cost, stat, tag FROM main LIMIT $offset, $no_of_records_per_page";
		$search_result = filterTable($sql);
	}

	function filterTable($sql) {
		// Create Connection
		$conn = new mysqli("localhost", "root", "password here" , "Name of DB");
		/* check connection */
		if(mysqli_connect_error()) {
			die('Connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
		}

		$filter_Result = $conn->query($sql);
		$conn->close();
		return $filter_Result;
	}

?>