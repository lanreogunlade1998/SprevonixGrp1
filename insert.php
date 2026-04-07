<!DOCTYPE html>
<html>

<head>
	<title>Insert Page</title><head>
       <title>Alberta Tourism Contact Page</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
       
        <link rel = "stylesheet" href="css/contactstyle.css">
        <center><a href ="index.php"><img src ="img/logo.png" height = "160px"></a>&nbsp;&nbsp;&nbsp; <marquee>Email:info@comp166.ca; Phone Number: 782682767 </marquee></center> 
        <hr>
        <a href="index.php">Home</a>
        <a href="contact.php">Contact Us</a> <br><br><br>

</head>

<body>
	<center>
		<?php

		// servername => sql311.byetcluster.com
		// username => if0_36247731
		// password => bi0Sri5cu4
		// database name => if0_36247731_COMP166DB
        // table name = > Customer
        
		//$conn = mysqli_connect("sql311.byetcluster.com", "if0_36247731", "bi0Sri5cu4", "if0_36247731_COMP166DB");
		$conn = mysqli_connect("localhost", "root", "root", "test2");

		// Check connection
		if($conn === false){
			die("ERROR: Could not connect. "
				. mysqli_connect_error());
		}
		
		// Taking all 4 values from the form data(input)
		$name = $_REQUEST['name'];
		$email = $_REQUEST['email'];
		$phoneno = $_REQUEST['phoneno'];
		$message = $_REQUEST['message'];
       
		
		
		// Performing insert query execution
		// here our table name is Customer
        
		$sql = "INSERT INTO Customer VALUES ( customerid, '$name',
			'$email','$phoneno','$message')";
		
		if(mysqli_query($conn, $sql)){
			echo "<h3>data stored in a database successfully."
				. " Please browse your localhost php my admin"
				. " to view the updated data</h3>";

			//echo nl2br("\n$first_name\n $last_name\n "
				//. "$gender\n $address\n $email");
		} else{
			echo "ERROR: Hush! Sorry $sql. "
				. mysqli_error($conn);
		}
		
		// Close connection
		mysqli_close($conn);
		?>
	</center>
</body>

</html>
