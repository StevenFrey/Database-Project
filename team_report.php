<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manager Team Report</title>
</head>
<style>
    html {
        font-family: Arial, Helvetica, sans-serif;
    }
    #heading {
        background-color: rgb(11, 226, 144);
        text-align: center;
    }
    #home_button {
        background-color: gray;
        text-decoration: none;
        color: white;
        padding: 10px;
        border-top-right-radius: 20px;
        position: relative;
        bottom: 48px;
    }
    team_report_back {
        background-color: gray;
        text-decoration: none;
        color: white;
        padding: 10px;
        border-radius: 20px;
        position: relative;
        bottom: 48px;
    }
</style>
<body>
    <div id="heading">
        <h1>Charlotte Pharmaceutical Company</h1>
        
    </div>

    <a href="index.html" id="home_button">Return to the Home Page</a>

    <h2>Generate Team Report</h2>

    <?php

        // Gives access to the usernames and passwords needed
        include("/var/www/db_settings.php"); 

        // Create connection to a database server called $conn
        $conn = mysqli_connect($db_host, $db_user_09, $db_pw_09, "team09");
    
        // Always check your connection before you try to do anything else!
        if (!$conn) {die( "Connection failed: " . mysqli_connect_error());}

        // Get the input from the form in team_report.html
        $enteredManagerID = $_POST['manager_id'];
        $query = "SELECT EmployeeID, FirstName, LastName, Title, BuildingID
                    FROM EMPLOYEE 
                    WHERE ManagerID = '$enteredManagerID'
                    ORDER BY BuildingID;";

        // Store the results of the select query in this variable
        $result = mysqli_query($conn, $query);

        if (mysqli_error($conn)) 
	        {die("MySQL error: ".mysqli_error($conn));}

        // If the query returned any results...
        if (mysqli_num_rows($result) > 0) {
            echo "<p>All of the employees that work under manager $enteredManagerID:</p>";

            // Creating a table to display employee info
            echo "<table>";
            echo "<tr><th>Employee ID</th><th>First Name</th><th>Last Name</th>
                    <th>Title</th><th>Building ID</th></tr>";

            /*
                Then loop through the output of the query,
                creating a row in the HTML table for each row
                in $result. 
             */
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>".$row["EmployeeID"]."</td><td>".
                    $row["FirstName"]."</td><td>".
                    $row["LastName"]."</td><td>".
                    $row["Title"]."</td><td>".
                    $row["BuildingID"]."</td></tr>";
            }

            // After you're done adding the rows, end the table.
            echo "</table>";
            
        }
        else {
            echo "No employees were found on your search for manager ID: $enteredManagerID";
        }


        // Close the open connection named $conn
        mysqli_close($conn);


    ?>

    <a href="team_report.html" id="team_report_back">Generate another team report</a>
    
</body>
</html>