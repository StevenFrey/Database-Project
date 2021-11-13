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

    <h2>Salary has been changed</h2>

    <?php

        // Gives access to the usernames and passwords needed
        include("/var/www/db_settings.php"); 

        // Create connection to a database server called $conn
        $conn = mysqli_connect($db_host, $db_user_09, $db_pw_09, "team09");
    
        // Always check your connection before you try to do anything else!
        if (!$conn) {die( "Connection failed: " . mysqli_connect_error());}

        //Get new salary and current salary variables from form in new_salary.php

        // Employee ID
        $selectEmployee = $_POST['selected_employee_id'];

        // Getting the employee's name
        $nameQuery = "select CONCAT(FirstName, ' ', LastName) AS FullName 
                        FROM EMPLOYEE WHERE EmployeeID = $selectEmployee;";
        $nameResult = mysqli_query($conn, $nameQuery);
        $name = mysqli_fetch_assoc($nameResult);

        // Selected employee's current salary
        $currSalaryQuery = "SELECT CurrentSalary FROM EMPLOYEE WHERE EmployeeID = $selectEmployee;";
        $currSalaryResult = mysqli_query($conn, $currSalaryQuery);
        $currSalary = mysqli_fetch_assoc($currSalaryResult);
        $prevSalary = $currSalary["CurrentSalary"];

        // Employee's new salary
        $newSalary = $_POST['new_salary'];

        $newRaisePercentage = 0.00;

        // If the employee's salary decreased...
        if (intval($prevSalary) > intval($newSalary)) {
            $decrease = intval($prevSalary) - intval($newSalary);
            $newRaisePercentage = -1 * ($decrease / intval($prevSalary) * 100) / 100;
        } elseif (intval($prevSalary) < intval($newSalary)) {
            // If the employee's salary has increased...
            $increase = intval($newSalary) - intval($prevSalary);
            $newRaisePercentage = (($increase / $prevSalary * 100) / 100);
        }

        $newRaisePercentage = number_format($newRaisePercentage, 2);

        // Update the employee's salary with an UPDATE statement
        $updateQuery = "UPDATE EMPLOYEE SET CurrentSalary = $newSalary, 
                        PreviousSalary = $prevSalary,
                        RaisePercentage = $newRaisePercentage
                        WHERE EmployeeID = $selectEmployee;
                        ";

        // Submit UPDATE statement
        mysqli_query($conn, $updateQuery);


        // CHECK FOR ERRORS
        if (mysqli_error($conn)) 
        {die("MySQL error: ".mysqli_error($conn));}


        echo "<p>Employee salary successfully changed. </p><br>";
        echo "<p>New salary for ".$name["FullName"].": $".$newSalary."</p>";
        echo "<p>Previous salary: $".$prevSalary."</p>";
        echo "<p>Salary percentage change: ".$newRaisePercentage."</p>";


        // Always remember to close the connection to the database when you're done!
        mysqli_close($conn); ?>


    
    
</body>
</html>