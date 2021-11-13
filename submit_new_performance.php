<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Performance Report</title>
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

    <h2>New Performance report created</h2>

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
        $nameQuery = "SELECT CONCAT(FirstName, ' ', LastName) AS FullName 
                        FROM EMPLOYEE WHERE EmployeeID = $selectEmployee;";
        $nameResult = mysqli_query($conn, $nameQuery);
        $name = mysqli_fetch_assoc($nameResult);

        // Get employee probation status
        $probationStatusQuery = "SELECT Probation FROM EMPLOYEE WHERE EmployeeID = $selectEmployee;";
        $probationStatusResult = mysqli_query($conn, $probationStatusQuery);
        $currProbationStatus = mysqli_fetch_assoc($probationStatusResult);

        // Get data from input tags in new_performance_report.php
        $date = strval($_POST['review_date']);
        $newScore = $_POST['new_score'];
        

        
        $newPerformanceQuery = "INSERT INTO REVIEW (EmployeeID, ReviewDate, Performance) 
                                VALUES ($selectEmployee, '$date', '$newScore');";
    
        
        mysqli_query($conn, $newPerformanceQuery);

        
        if (mysqli_error($conn)) 
        {die("MySQL error: ".mysqli_error($conn));}
                    
        
        $updateQuery = "UPDATE EMPLOYEE SET Performance = '$newScore' WHERE EmployeeID = $selectEmployee;";

        
        mysqli_query($conn, $updateQuery);

        
        if (mysqli_error($conn)) 
        {die("MySQL error: ".mysqli_error($conn));}


        // Check for poor performance score
        if (($newScore == 'Poor') and ($currProbationStatus['Probation'] == 0)) {
            $probationQuery = "UPDATE EMPLOYEE SET Probation = TRUE,
                                Performance = 'Poor' 
                                WHERE EmployeeID = $selectEmployee;";
            mysqli_query($conn, $probationQuery);

            if (mysqli_error($conn)) 
            {die("MySQL error: ".mysqli_error($conn));}


            echo "<br><b>NOTICE</b>: ".$name['FullName']." has been put on probation due to their recent poor performance score.<br>";
        } elseif (($currProbationStatus['Probation'] == 1) and ($newScore != 'Poor')) {
            $probationQuery = "UPDATE EMPLOYEE SET Probation = FALSE,
                                Performance = '$newScore' 
                                WHERE EmployeeID = $selectEmployee;";
            mysqli_query($conn, $probationQuery);

            if (mysqli_error($conn)) 
            {die("MySQL error: ".mysqli_error($conn));}

            echo "<br><b>NOTICE</b>: ".$name['FullName']." has been put off probation due to their recent performance score.<br>";
        } elseif (($currProbationStatus['Probation'] == 1) and ($newScore == 'Poor')) {
            $probationQuery = "UPDATE EMPLOYEE SET Probation = TRUE,
                                Performance = 'Poor' 
                                WHERE EmployeeID = $selectEmployee;";
            mysqli_query($conn, $probationQuery);

            if (mysqli_error($conn)) 
            {die("MySQL error: ".mysqli_error($conn));}
            
            echo "<br><b>NOTICE</b>: ".$name['FullName']." is still on probation due to their poor performance.<br>";
        }


        echo "<br>New performance report created for: ".$name['FullName'];
        echo "<br><br>On: ".$date;
        echo "<br><br>Performance score: ".$newScore;
        



        // Always remember to close the connection to the database when you're done!
        mysqli_close($conn); ?>


    
    
</body>
</html>