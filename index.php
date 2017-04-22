<?php
$servername = "104.198.224.126";
$username = "root";
$password = "root";
$dbname = "todo";

function get_item_html($item_id, $item_description) {
    $html_list_item = file_get_contents(__DIR__ . '/list-item.html');
    return str_replace("%DESCRIPTION%", $item_description , $html_list_item);
}

if(isset($_POST['addTodo'])){ //check if form was submitted
  $input = $_POST['description']; //get input text
  $message = "Success! You entered: ".$input;
  echo($message);
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get items from db
$sql = "SELECT id, description FROM todo";
$result = $conn->query($sql);
// Use html template to display items
$html_list = "";
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
      $html_list = $html_list . get_item_html($row["id"], $row["description"]);
  }
} else {
    $html_list = "Empty list.";
}

// Get html and display it, replacing selected items from db
$html_index = file_get_contents(__DIR__ . '/index.html');
$html_index = str_replace("%LIST_ITEMS%", $html_list , $html_index);
echo($html_index);

$conn->close();
?>
