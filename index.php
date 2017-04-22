<?php
$servername = "104.198.224.126";
$username = "root";
$password = "root";
$dbname = "todo";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$sql = "SELECT id, description FROM todo";
$result = $conn->query($sql);


while($row = $result->fetch_assoc()) {
    echo "id: " . $row["id"]. " - Description: " . $row["description"]. "<br>";
}

$html_index = file_get_contents(__DIR__ . '/index.html');
echo($html_index);

$conn->close();
?>
