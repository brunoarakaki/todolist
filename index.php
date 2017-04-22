<?php
$servername = "104.198.224.126";
$username = "root";
$password = "root";
$dbname = "todo";

function get_item_html($item_id, $item_description) {
    $html_list_item = file_get_contents(__DIR__ . '/list-item.html');
    return str_replace("%DESCRIPTION%", $item_description , $html_list_item);
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$sql = "SELECT id, description FROM todo";
$result = $conn->query($sql);

$html_list = "";
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
      $html_list = $html_list . get_item_html($row["id"], $row["description"]);
  }
} else {
    $html_list = "Empty list.";
}

$html_index = file_get_contents(__DIR__ . '/index.html');
$html_index = str_replace("%LIST_ITEMS%", $html_list , $html_index);
echo($html_index);

$conn->close();
?>
