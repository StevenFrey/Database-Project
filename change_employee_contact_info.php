<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enter Employee Contact Information</title>
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

    <?php

        // Gives access to the usernames and passwords needed
        include("/var/www/db_settings.php"); 

        // Create connection to a database server called $conn
        $conn = mysqli_connect($db_host, $db_user_09, $db_pw_09, "team09");
    
        // Always check your connection before you try to do anything else!
        if (!$conn) {die( "Connection failed: " . mysqli_connect_error());}

        ?>


    <h3>Enter Employee Contact Information Below</h3> <br>

    <p>Employee: <!--Display employee's full name-->
    
    <form name= "change_employee_contact_info_form" method="POST" action="update_employee_contact_information.php">
        <label for= "EmployeeID">Employee ID Number</label><br>
        <input type = "number"  id = "EmployeeID" name = "EmployeeID" min="999" max= "9999"><br><br>
        <label for= "">Email</label><br>
        <input type = "email"  id = "email" name = "email"><br><br>
        <label for="phone">Phone Number</label><br>
        <input type="tel" id="phone" name="phone" placeholder="123-456-7891" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required><br><br>
        <label for="houseNumber">House Number</label><br>
        <input type="number" id="houseNumber" name="number"><br><br>
        <label for="streetName">Street Name</label><br>
        <input type="text" id="streetName" name="streetName"><br><br>
        <label for="city">City</label><br>
        <input type="text" id="city" name="city"><br><br>
        <label for="state">State</label><br>
        <input type="text" id="state" name="state"><br><br>
        <label for="zip">Zip Code</label><br>
        <input type="number" id="zipcode" name="zipcode"><br><br>
        <input type = "submit" value="Submit">
    </form>


</body>
</html>