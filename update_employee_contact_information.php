<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Employee Salary</title>
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

    <h2>Change Employee Contact Information</h2>

    <?php

        // Gives access to the usernames and passwords needed
        include("/var/www/db_settings.php"); 

        // Create connection to a database server called $conn
        $conn = mysqli_connect($db_host, $db_user_09, $db_pw_09, "team09");
    
        // Always check your connection before you try to do anything else!
        if (!$conn) {die( "Connection failed: " . mysqli_connect_error());}

    ?>

    <?php
        // If employee has already been submitted, show form to change their info
        if ($_SERVER['REQUEST_METHOD'] == 'POST'):

            $selectedEmployee = $_POST['employee_id'];
            $query = "SELECT * FROM Employee WHERE EmployeeID = $selectedEmployee;";
            $result = mysqli_query($conn, $query);

            // Getting the full name of the selected employee
            $employeeName = "SELECT CONCAT(FirstName, ' ', LastName) AS FullName FROM EMPLOYEE WHERE EmployeeID = $selectedEmployee;";
            $result2 = mysqli_query($conn, $employeeName);
            $name = mysqli_fetch_assoc($result2);

            if (mysqli_error($conn)) 
	            {die("No employee was selected");}

            // Displaying the employee's full name
            echo "<p>Employee: ".$name["FullName"];

            $row = mysqli_fetch_assoc($result);
    ?>

    <?php
        // If the form has not been submitted yet, select an employee
        else:

            $query = "SELECT EmployeeID, CONCAT(FirstName, ' ', LastName) AS FullName FROM EMPLOYEE ORDER BY LastName;";
            $result = mysqli_query($conn, $query);

            if (mysqli_error($conn)) 
	            {die("MySQL error: ".mysqli_error($conn));}

    ?>
    <p>Select an employee</p>
    <form name="select_employee" method="POST" action="change_employee_contact_info.php">
        <table>

            <tr><td>
                <select name="employee_id">
                <option value="ERROR" selected>Select the employee...</option>

                <?php

                    while($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="'.$row["EmployeeID"].'">'.$row["FullName"].'</option>';
                    }

                ?>
  
                </select></td><td></td></tr>
	        </table>
        
        <p><input type="submit" value="next>>" /></p>

    </form>


    <?php endif;

        mysqli_close($conn);

    ?>

    
    
</body>
</html>