<?php
$servername = "104.198.224.126";
$username = "root";
$password = "root";
$dbname = "todo";

function get_item_html($item_id, $item_description) {
    $html_list_item = file_get_contents(__DIR__ . '/list-item.html');
    $html_list_item = str_replace("%DESCRIPTION%", $item_description , $html_list_item);
    $html_list_item = str_replace("%ITEM_ID%", $item_id , $html_list_item);
    return $html_list_item;
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// CREATE NEW ITEM
if(isset($_POST['addTodo'])){ //check if form was submitted
  $description = $_POST['description']; //get input text
  $sql_add = "INSERT INTO todo (description) VALUES ('". $description ."')";
  $conn->query($sql_add);
}

// DELETE ITEM
if(isset($_POST['deleteTodo'])){ //check if form was submitted
  $item_id = $_POST['itemId']; //get input text
  $sql_add = "DELETE FROM todo WHERE id=". $item_id ;
  $conn->query($sql_add);
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
