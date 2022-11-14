<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testing";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection Faild" . $conn->connect_error);
}

$sql = "SELECT * FROM students";

$result = $conn->query($sql);
var_dump($conn->affected_rows); // affected_rows / num_rows some works
exit();
// associative array
if ($result->num_rows > 0) {
	/*while ($row = $result->fetch_assoc()) {
		echo "Id : {$row["id"]} - Name : {$row["student_name"]} - Age : {$row["age"]}</br>";
	}*/

   // fetch_array array with ass array
	/*while ($row = $result->fetch_array()) {
		printf("ID: %s  Name: %s", $row[0], $row[1]);
	}*/

	// fetch_array only get array
	/*while ($row = $result->fetch_row()) {
		printf("ID: %s  Name: %s", $row[0], $row[1]);
	}*/

// fetch_array only get array
	/*while ($row = $result -> fetch_all(MYSQLI_ASSOC)) {
		foreach ($row as $value) {
			echo "Id : {$value["id"]} - Name : {$value["student_name"]} - Age : {$value["age"]}</br>";
		}
	}*/
} else {
 echo "Not result Found";
}

$conn->close();

?>