 
<?php

$servername = "it330serve130.mysql.database.azure.com";
$username = "johnryan@it330serve130";
$password = "Animalka123";
$dbname = "itazure";

$Rollno='';
$fname="";
$lname="";
$address="";
$email="";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//connect to mysql database
	try{

		$conn = mysqli_connect($servername,$username,$password,$dbname);
	}catch(mysqli_sql_Exeception $ex){
		echo "error in connecting";
	}



//get data
function getdata(){

	$data=array();
	$data[0]=$_POST['Rollno'];
	$data[1]=$_POST['fname'];
	$data[2]=$_POST['lname'];
	$data[3]=$_POST['address'];
	$data[4]=$_POST['email'];

	return $data;
}
//search
	
	if (isset($_POST['search'])) {
		# code...
		$info = getData();
		$search_query="SELECT * FROM `test` WHERE Rollno = '$info[0]'";
		$search_result=mysqli_query($conn,$search_query);
			if ($search_result) {
				# code...
				if (mysqli_num_rows($search_result)) {
					# code...
					while ($rows = mysqli_fetch_array($search_result)) {
						# code...
						$Rollno = $rows['Rollno'];
						$fname = $rows['fname'];
						$lname = $rows['lname'];
						$address = $rows['address'];
						$email = $rows['email'];
						
					}
				}else{
					echo "no data are available";
				}
			}else{
				echo "result error";
			}

	}

// insert
	if (isset($_POST['insert'])) {
		# code...
		$info = getData();
		$insert_query="INSERT INTO `test`( `fname`, `lname`, `address`, `email`) VALUES ('$info[1]','$info[2]','$info[3]','$info[4]')";
			try{
				$insert_result=mysqli_query($conn,$insert_query);
				if ($insert_query) {
					# code...
					if (mysqli_affected_rows($conn)>0) {
						# code...
						echo("data inserted successfully!");
					}else{
						echo "data are not inserted";
					}
				}
			}catch(Exception $ex){
				echo "error inserted",$ex->getMessage();
			}
	}

//delete
	if (isset($_POST['delete'])) {
		# code...
		$info = getData();
		$delete_query ="DELETE FROM `test` WHERE Rollno = '$info[0]'";

		try{
			$delete_result = mysqli_query($conn,$delete_query);
			if ($delete_result) {
				# code...
				if(mysqli_affected_rows($conn)>0){
					echo "data deleted";
				}else{
					echo "data not deleted";
				}
			}
		}catch(Exception $ex){
			echo "error in delete".$ex->getMessage();
		}
		
	}

	//edit
	if (isset($_POST['update'])) {
		# code...
		$info = getdata(); 
		$update_query= "UPDATE `test` SET `fname`='$info[1]',`lname`='$info[2]',`address`='$info[3]',`email`='$info[4]' WHERE Rollno ='$info[0]'";
		try{
			$update_result = mysqli_query($conn,$update_query);
			if ($update_result) {
				# code...
				if (mysqli_affected_rows($conn)>0) {
					# code...
					echo "data updated";
				}else{
					echo "data not updated";
				}
			}
		}catch(Exception $ex){
			echo "error in update".$ex->getMessage();
		}
	}
?>



<html>
<body>
  <h2 >Ycong John Ryan . Laboratory 1</div></h2>
<form method="post" action="idusnew.php">
  <h2>Azure Activity Payroll</h2>
	<table>
	<thead>
		<tr>
			<th>Roll NO: </th>
			<th>First Name: </th>
			<th>Last Name: </th>
			<th>Address: </th>
			<th>Email: </th>
		</tr>
	</thead>
	</table>
	<tbody>
	
	<?php
	


	//show result
	$sql = "SELECT Rollno, fname, lname, address, email  FROM test";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
		
			//echo "id: " . $row["Rollno"]. " - Name: " . $row["fname"]. "Last Name:" . $row["lname"].  "Address: " . $row["address"]. "Email: " . $row["email"]."<br>";
			echo '<td> '. $row['Rollno'].'</td>';
			echo '<td> '. $row['fname'].'</td>';
			echo '<td> '. $row['lname'].'</td>';
			echo '<td> '. $row['address'].'</td>';
			echo '<td>  '. $row['email'].'</td>';
			echo "<input type='submit' name='update' value='Update '>";
			echo "<input type='submit' name='delete' value='Delete '>";
			echo '<br>';
		
		}
	} else {
		echo "0 results";
	}
// echo ' <a  type="button" class="btn btn-xs btn-danger" href="del.php?type=people&delete & id=' . $row['people_id'] . '">DELETE </a> </td>';

?>
	
	</tbody>
	<br><br>
	<input type="number" name="Rollno" placeholder="Roll No" value="<?php echo ($Rollno);?>"><br><br>
	<input type="text" name="fname" placeholder="First Name" value="<?php echo ($fname);?>"><br><br>
	<input type="text" name="lname" placeholder="Last Name" value="<?php echo ($lname);?>"><br><br>
	<input type="text" name="address" placeholder="Address" value="<?php echo ($address);?>"><br><br>
	<input type="text" name="email" placeholder="Email@email.com" value="<?php echo ($email);?>"><br><br>

	<div>
		<input type="submit" name="insert" value="Add">
		<!--
		<input type="submit" name="update"	value="Update">
		<input type="submit" name="delete" value="Delete">
		-->
		<input type="submit" name="search" value="Search">
		
	</div>
</form>


</body>
</html>

