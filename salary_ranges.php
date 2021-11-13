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
</style>
<body>
    <div id="heading">
        <h1>Charlotte Pharmaceutical Company</h1>
    </div>

    <a href="index.html" id="home_button">Return to the Home Page</a>

    <h2>Out of Range Salary Report</h2>

    <?php

        // Gives access to the usernames and passwords needed
        include("/var/www/db_settings.php"); 

        // Create connection to a database server called $conn
        $conn = mysqli_connect($db_host, $db_user_09, $db_pw_09, "team09");
    
        // Always check your connection before you try to do anything else!
        if (!$conn) {die( "Connection failed: " . mysqli_connect_error());}

        // Get the input from the form in team_report.html
        // $enteredManagerID = $_POST['manager_id'];
        $query = "SELECT e.FirstName, e.LastName, e.Title, e.CurrentSalary
                    FROM EMPLOYEE AS e
                    INNER JOIN JOB AS j
                    ON e.Title = j.Title
                    WHERE e.CurrentSalary > j.MaximumSalary or e.CurrentSalary < j.MinimumSalary
                    ;";

        // Store the results of the select query in this variable
        $result = mysqli_query($conn, $query);

        if (mysqli_error($conn)) 
	        {die("MySQL error: ".mysqli_error($conn));}

        // If the query returned any results...
        if (mysqli_num_rows($result) > 0) {
            echo "<p>All of the employees with out-of-range salaries:</p>";

            // Creating a table to display employee info
            echo "<table>";
            echo "<tr><th>First Name</th><th>Last Name</th><th>Title</th>
                    <th>Current Salary</th></tr>";

            /*
                Then loop through the output of the query,
                creating a row in the HTML table for each row
                in $result. 
             */
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>".$row["FirstName"]."</td><td>".
                    $row["LastName"]."</td><td>".
                    $row["Title"]."</td><td>".
                    $row["CurrentSalary"]."</td></tr>";
            }

            // After you're done adding the rows, end the table.
            echo "</table>";
            
        }
        else {
            echo "All employee salaries are in range for their position";
        }


        // Close the open connection named $conn
        mysqli_close($conn);


    ?>

    
    
</body>
</html>