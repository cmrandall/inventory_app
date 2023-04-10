<?php
    // PHP file for connection to SQL DB
    include 'sqlConnection.php';

    // Check for connection error
    if(mysqli_connect_error()) {
        die('Connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
    } 

	if(isset($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}

	$num_per_page = 5;
	$start_from = ($page-1)*5;

	if(isset($_POST['search'])) {
		// get data based on user search input to display in table
		$category = $_POST['column'];
		$valueToSearch = $_POST['valueToSearch'];
		

		switch ($category) {
			case "item":
				$sql ="SELECT id, descript, loc, depart, manufacturer, model, quantity, inventoried, own, cost, stat, tag, expiration FROM main WHERE '".$category."' = 'Item' AND descript LIKE '%".$valueToSearch."%' LIMIT $start_from, $num_per_page";
				break;
			case "location":
				$sql ="SELECT id, descript, loc, depart, manufacturer, model, quantity, inventoried, own, cost, stat, tag, expiration FROM main WHERE '".$category."' = 'Location' AND loc LIKE '%".$valueToSearch."%' LIMIT $start_from, $num_per_page";
				break;
			case "department":
				$sql ="SELECT id, descript, loc, depart, manufacturer, model, quantity, inventoried, own, cost, stat, tag, expiration FROM main WHERE '".$category."' = 'department' AND depart LIKE '%".$valueToSearch."%' LIMIT $start_from, $num_per_page";
				break;
			case "asset":
				$sql ="SELECT id, descript, loc, depart, manufacturer, model, quantity, inventoried, own, cost, stat, tag, expiration FROM main WHERE '".$category."' = 'asset' AND tag LIKE '%".$valueToSearch."%' LIMIT $start_from, $num_per_page";
				break;
		}


		$search_result = filterTable($sql);
	}else {
		// default data to display in table
		$sql = "SELECT id, descript, loc, depart, manufacturer, model, quantity, inventoried, own, cost, stat, tag, expiration FROM main LIMIT $start_from, $num_per_page";
		$search_result = filterTable($sql);
	}

	function filterTable($sql) {
		// Create Connection
		$conn = new mysqli("localhost", "root", "b7QIPrAke?", "inventorydb");
		/* check connection */
		if(mysqli_connect_error()) {
			die('Connect Error ('.mysqli_connect_errno().')'.mysqli_connect_error());
		}

		$filter_Result = $conn->query($sql);
		$conn->close();
		return $filter_Result;
	}


	

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- Stylesheets -->
			<!-- Bootstrap CSS -->
			<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
            <!-- jQuery UI CSS for datepicker-->
            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

            <!-- Custom CSS -->
			<link rel="stylesheet" href="css/custom.css">

			<!-- Update JS file -->
			<script type="text/javascript" src="js/update.js"></script>
	
		<title> Medical Equipment Inventory </title>
	
	</head>
	
	<body>
		<header class="site-header row text-center" role="banner">
			<div class="col-lg-12">
				<h1> Medical Equipment Inventory</h1>
			</div>
		</header>
		
		<!-- Add Button to bring up Modal -->
		<section id="addButton">
			<div class="row">
				<div class="col-lg-2 offset-lg-1">
					<button class="btn btn-primary" data-toggle="modal" data-target="#myModal"> Add New Item</button>
				</div>
			</div>
		</section>
		
		
		<!-- Search DB -->
		<section>
			<div class="row">
				<div class="col-sm-4 col-md-4 col-lg-4 offset-sm-1 offset-md-1 offset-lg-1">
					<h3> Inventory Database </h3>
				</div>
				<div class="col-sm-4 col-md-5 col-lg-5 offset-md-1 offset-lg-2">
					<form class="form-inline mr-auto" action="index.php" method="POST">
						<label for="column" style="margin-right: 1.5%;">Search: </label>
						<select name="column" id="column" style="margin-right: 2%;">
							<option value="select">Select</option>
							<option value="item">Item</option>
							<option value="location">Location</option>
							<option value="department">Department</option>
							<option value="asset">Asset</option>
						</select>
						<input type="text" name="valueToSearch" placeholder="Search Keyword" style="margin-right: 1.5%; padding-left:1%;">
						<input class="btn btn-primary btn-rounded btn-sm my-0" type="submit" name="search" value="Search">
					</form>
				</div>
			</div>
			<div class="col-sm-10 col-med-10 col-lg-10 offset-sm-1 offset-med-1 offset-lg-1">
				<hr /> 
			</div>
        </section>
        

        <!-- Display DB data -->
        <section>
            <div class="row">
                <div class="col-lg-8 col-md-10 offset-md-1 offset-lg-2 tableDiv">
                    
					<table class='table table-striped table-bordered'> 
                        <tr>
                            <thead class='thead-light text-center my-auto'>
								<th>Asset Tag</th>
                                <th>Item</th>
                                <th>Location</th>
                                <th>Department</th>
								<th>Owner</th>
                                <th>Manufacturer</th>
                                <th>Model</th>
								<th>Quantity</th>
                                <th>Cost</th>
                                <th>Date Inventoried</th>
								<th>Warranty Expire</th>
                                <th>Status</th>
								<th>Update</th>
                            </thead>
						</tr>
						<?php while($row = mysqli_fetch_array($search_result)): ?>
							<tr>
								<td><?php echo $row['tag'];?></td>
								<td><?php echo $row['descript'];?></td>
								<td><?php echo $row['loc'];?></td>
								<td><?php echo $row['depart'];?></td>
								<td><?php echo $row['own'];?></td>
								<td><?php echo $row['manufacturer'];?></td>
								<td><?php echo $row['model'];?></td>
								<td><?php echo $row['quantity'];?></td>
								<td><?php echo $row['cost'];?></td>
								<td><?php echo $row['inventoried'];?></td>
								<td><?php echo $row['expiration'];?></td>
								<td><?php echo $row['stat'];?></td>
								<td>
									<button type="button" class="btn btn-success shadow-none updateBtn"  onclick="update()"> Update</button>
								</td>
							</tr>
						<?php endwhile;?>
					</table>
					<div class="pagination">
						<?php
							$pag_query = "SELECT * FROM main";
							$pag_result = mysqli_query($conn, $pag_query);
							$total_records = mysqli_num_rows($pag_result);
							$total_pages = ceil($total_records/$num_per_page);
							
							// Go to start of pages
							if($page > 1) {
								echo "<a href='index.php?page=1' class='pagin btn btn-info'> << </a>";
							}
							// Go to next page
							if($page > 1) {
								echo "<a href='index.php?page=".($page-1)."' class='pagin btn btn-info'> < </a>";
							}
							
							// Generates page number links
							for($i = 1 ; $i < $total_pages ; $i++){
								echo "<a href='index.php?page=".$i."' class='pagin btn btn-primary' >$i</a>";
							}

							if($i > $page) {
								echo "<a href='index.php?page=".($page+1)."' class='pagin btn btn-info' > > </a>";
							}

							if($page < $total_pages) {
								echo "<a href='index.php?page=".($total_pages)."' class='pagin btn btn-info' > >> </a>";
							}
						?>
					</div>
                </div>
            </div>
        </section>

		<!-- 

			Item Addition Modal 

		-->

		<section class="entryForm">
			<div class="row modal fade" id="myModal">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="addLabel">Add Inventory Item</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="connection.php" method="POST" >
								<div class="form-group row">
									<div class="col-sm-5">
										<div class="label">
											<label for="item"> Item Description: </label>
										</div>
										<div class="input">
											<input type="text" id="item" name="descript" autofocus required>
										</div>
									</div>
									<div class="col-sm-5 offset-sm-1">
										<div class="label">
											<label for="assetTag"> Asset Tag: </label>
										</div>
										<div class="input">
											<input type="text" id="assetTag" name="tag" required>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-5">
										<div class="label">
											<label for="manufacturer"> Manufacturer: </label>
										</div>
										<div class="input">
											<input type="text" id="manufacturer" name="manufacturer" required>
										</div>
									</div>
									<div class="col-sm-5 offset-sm-1">
										<div class="label">
											<label for="model"> Model: </label>
										</div>
										<div class="input">
											<input type="text" id="model" name="model" required>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-5">
										<div class="label">
											<label for="quantity"> Quantity: </label>
										</div>
										<div class="input">
											<input type="text" id="quantity" name="quantity" required>
										</div>
									</div>
									<div class="col-sm-5 offset-sm-1">
										<div class="label">
											<label for="cost"> Cost: </label>
										</div>
										<div class="input">
											<input type="text" id="cost" name="cost" required>
										</div>
									</div>
								</div>
								
								<div class="form-group row">
									<div class="col-sm-5">
										<div class="label">
											<label for="owner"> Owner: </label>
										</div>
										<div class="input">
											<input type="text" id="owner" name="own" required>
										</div> 
									</div>
									<div class="col-sm-5 offset-sm-1">
										<div class="label">
											<label for="stat"> Status: </label>
										</div>
										<div class="input">
											<select name="stat" id="stat">
												<option value="active">Active</option>
												<option value="inactive">Inactive</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-5">
										<div class="label">
											<label for="loc">Location: </label>
										</div>
										<div class="input">
											<select name="location" id="loc"  required>
												<!-- Function call to populate is in custom.js populateLocations() -->
											</select>
										</div>
									</div>
									<div class="col-sm-5 offset-sm-1">
										<div class="label">
											<label for="depart"> Department: </label>
										</div>
										<div class="input">
											<select name="department" id="depart" required>
												<!-- Function call to populate is in custom.js populateDepartments() -->
											</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-5">
										<div class="label">
											<label for="inventoried"> Date Inventoried: </label>
										</div>
										<div class="input">
											<input type="date" class="dateInventoried" id="inventoried" name="inventoried" required>
										</div>
									</div>
									<div class="col-sm-5 offset-sm-1">
										<div class="label">
											<label for="expiration"> Warranty End: </label>
										</div>
										<div class="input">
											<input type="date" class="dateInventoried" id="inventoried" name="expired" required>
										</div>
									</div>
								</div>
                                <div class="modal-footer">    
                                    <button type="submit" id="submit" class="btn btn-primary">Add Item</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
		

		<!-- 

			Edit Modal 
	
		-->

		<section class="editForm">
			<div class="row modal fade" id="editModal">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="addLabel">Update Entry</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="connection.php" method="POST" >
								<div class="form-group row">
									<div class="col-sm-5">
										<div class="label">
											<label for="item"> Item Description: </label>
										</div>
										<div class="input">
											<input type="text" id="item" name="descript" autofocus required>
										</div>
									</div>
									<div class="col-sm-5 offset-sm-1">
										<div class="label">
											<label for="assetTag"> Asset Tag: </label>
										</div>
										<div class="input">
											<input type="text" id="assetTag" name="tag" required>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-5">
										<div class="label">
											<label for="manufacturer"> Manufacturer: </label>
										</div>
										<div class="input">
											<input type="text" id="manufacturer" name="manufacturer" required>
										</div>
									</div>
									<div class="col-sm-5 offset-sm-1">
										<div class="label">
											<label for="model"> Model: </label>
										</div>
										<div class="input">
											<input type="text" id="model" name="model" required>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-5">
										<div class="label">
											<label for="quantity"> Quantity: </label>
										</div>
										<div class="input">
											<input type="text" id="quantity" name="quantity" required>
										</div>
									</div>
									<div class="col-sm-5 offset-sm-1">
										<div class="label">
											<label for="cost"> Cost: </label>
										</div>
										<div class="input">
											<input type="text" id="cost" name="cost" required>
										</div>
									</div>
								</div>
								
								<div class="form-group row">
									<div class="col-sm-5">
										<div class="label">
											<label for="owner"> Owner: </label>
										</div>
										<div class="input">
											<input type="text" id="owner" name="own" required>
										</div> 
									</div>
									<div class="col-sm-5 offset-sm-1">
										<div class="label">
											<label for="stat"> Status: </label>
										</div>
										<div class="input">
											<select name="stat" id="stat">
												<option value="active">Active</option>
												<option value="inactive">Inactive</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-5">
										<div class="label">
											<label for="loc">Location: </label>
										</div>
										<div class="input">
											<select name="location" id="loc"  required>
												<!-- Function call to populate is in custom.js populateLocations() -->
											</select>
										</div>
									</div>
									<div class="col-sm-5 offset-sm-1">
										<div class="label">
											<label for="depart"> Department: </label>
										</div>
										<div class="input">
											<select name="department" id="depart" required>
												<!-- Function call to populate is in custom.js populateDepartments() -->
											</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-5">
										<div class="label">
											<label for="inventoried"> Date Inventoried: </label>
										</div>
										<div class="input">
											<input type="date" class="dateInventoried" id="inventoried" name="inventoried" required>
										</div>
									</div>
									<div class="col-sm-5 offset-sm-1">
										<div class="label">
											<label for="expiration"> Warranty End: </label>
										</div>
										<div class="input">
											<input type="date" class="dateInventoried" id="inventoried" name="expired" required>
										</div>
									</div>
								</div>
                                <div class="modal-footer">    
                                    <button type="submit" id="submit" class="btn btn-primary">Update Item</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- <footer style="height: 50px; background: #223473; margin-top: 3%;"></footer> -->
		
		<!-- JavaScript -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <!-- Custom JS -->
        <script type="text/javascript" src="js/custom.js"></script>
		
	</body>
</html>