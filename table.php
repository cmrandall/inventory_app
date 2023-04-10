<?php
    if(isset($_POST['search'])) {
        // get data based on user search input to display in table
        $category = $_POST['column'];
        $valueToSearch = $_POST['valueToSearch'];
        

        switch ($category) {
            case "item":
                $sql ="SELECT id, descript, loc, depart, manufacturer, model, quantity, inventoried, own, cost, stat, tag FROM main WHERE '".$category."' = 'Item' AND descript LIKE '%".$valueToSearch."%'";
                break;
            case "location":
                $sql ="SELECT id, descript, loc, depart, manufacturer, model, quantity, inventoried, own, cost, stat, tag FROM main WHERE '".$category."' = 'Location' AND loc LIKE '%".$valueToSearch."%'";
                break;
            case "department":
                $sql ="SELECT id, descript, loc, depart, manufacturer, model, quantity, inventoried, own, cost, stat, tag FROM main WHERE '".$category."' = 'department' AND depart LIKE '%".$valueToSearch."%'";
                break;
            case "asset":
                $sql ="SELECT id, descript, loc, depart, manufacturer, model, quantity, inventoried, own, cost, stat, tag FROM main WHERE '".$category."' = 'asset' AND tag LIKE '%".$valueToSearch."%'";
                break;
            
        }

        //fill table with search results
        $search_result = filterTable($sql);

    }else {
        // default data to display in table
        $sql = "SELECT id, descript, loc, depart, manufacturer, model, quantity, inventoried, own, cost, stat, tag FROM main LIMIT";
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