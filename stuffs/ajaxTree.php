<?php
#print_r($_REQUEST);
//https://thebestdayiseveryday.blogspot.com/2019/01/sample-code-for-jstree-ajax-call-and.html
//https://everyething.com/Example-of-simple-jsTree-with-Search
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json;charset=utf-8');
/*
	index.php?operation=get_node&id=webapp
*/

$servername = "mysql";
$username = "root";
$password = "root";
$dbname = "badcase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

function get_parent($id, $ids = [], $conn) {
	if($id){
		array_push($ids, $id);
		$sql = "SELECT parent_group_id FROM report_group where id = $id";
		$result = $conn->query($sql);
		$output = [];
		if ($result->num_rows > 0) {
			$output = $result->fetch_assoc();
			$id = $output['parent_group_id'];
			return get_parent($id, $ids, $conn);
		}			
	}
	return $ids;
}


$operation = @$_REQUEST['operation'];
$id = @$_REQUEST['id'];
$parent = @$_REQUEST['parent'];
$text = @$_REQUEST['text'];
$type = @$_REQUEST['type'];
$output = [];

if($operation == "delete_node") {
	//$parent
	$sql = "delete from report_group WHERE id = $id";
	$result = $conn->query($sql);
	$output["id"] = $id;
	echo json_encode($output);
} else if($operation == "move_node") {
	//$parent
	$sql = "update report_group set parent_group_id = $parent WHERE id = $id";
	$result = $conn->query($sql);
	$output["id"] = $id;
	echo json_encode($output);
} else if($operation == "create_node") {
	// $parent_id = $id
	// $text

	$is_public = 1;
	$sql = "insert into report_group(parent_group_id, group_name, is_public) values($id,'$text',$is_public)";
	$conn->query($sql);
	$output["id"] = $conn->insert_id;
	echo json_encode($output);
} else if($operation == "rename_node") {
	// $id
	// $text
	$sql = "update report_group set group_name = '$text' WHERE id = $id";
	$result = $conn->query($sql);
	$output["id"] = $id;
	echo json_encode($output);
} else if($operation == "get_content") {
	$sql = "SELECT * FROM report_group where id = $id";
	$result = $conn->query($sql);
	$output = [];
	if ($result->num_rows > 0) {
		$output = $result->fetch_assoc();

	}
	echo json_encode($output);
} else if($operation == "get_nodes---------------") {
	$output = Array(["id"=> 3,"parent_group_id"=> 1,"is_public"=> true,"name"=> "333333333333"],["id"=> 2,"parent_group_id"=> null,"is_public"=> false,"name"=> "222222222222"], ["id"=> 1,"parent_group_id"=> null,"is_public"=> true,"name"=> "11111111111"], ["id"=> 6,"parent_group_id"=> 3,"is_public"=> true,"name"=> "66666666666"], ["id"=> 7,"parent_group_id"=> 3,"is_public"=> true,"name"=> "7777777777"], ["id"=> 4,"parent_group_id"=> 2,"is_public"=> true,"name"=> "444444444"], ["id"=> 5,"parent_group_id"=> 2,"is_public"=> true,"name"=> "5555555555"]);
	echo json_encode($output);


} else if($operation == "get_node") {


	if($id == "#") {
		$sql = "SELECT * FROM report_group WHERE parent_group_id  IS NULL";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$folder = [];
			while($row = $result->fetch_assoc()) {
		    //echo "id: " . $row["id"]. " - Name: " . $row["group_name"]. " " . $row["parent_group_id"]. " " . $row["is_public"]. "<br>";
		     $node = [
			    "id" => $row["id"],
			    "text" => $row["group_name"],
			    "children" => true,
			    "icon" => "folder"
			  ];			
			  array_push($folder, $node);
		  }
		  $outputs = json_encode($folder);

echo <<<EOL
[
  {
    "text": "root",
    "children": $outputs,
    "id": "\/",
    "icon": "folder",
    "state": {
      "opened": true,
      "disabled": true
    }
  }
]
EOL;

		} else {
		  echo json_encode($output);
		}


	} else {

		$sql = "SELECT * FROM report_group where parent_group_id = $id";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		  // output data of each row
		  while($row = $result->fetch_assoc()) {
		    //echo "id: " . $row["id"]. " - Name: " . $row["group_name"]. " " . $row["parent_group_id"]. " " . $row["is_public"]. "<br>";
		    $node = [
			    "id" => $row["id"],
			    "text" => $row["group_name"],
			    "children" => true,
			    "icon" => "folder"
			  ];

			$leaf = [
			    "id" => 'q_'.$row["id"],
			    "text" => 'q_'.$row["group_name"],
			    "children" => false,
			    "type" => "file",
			    "icon" => "file file-2"
			  ];

			  array_push($output, $node);
			  array_push($output, $leaf);
		  }
		  echo json_encode($output);
		} else {
		  echo json_encode($output);
		}

		

	}

} else if(@$_GET['str']) {
	$search = @$_GET['str'];
	$sql = "SELECT id FROM report_group where group_name like '%$search%'";
	$result = $conn->query($sql);
	$output = Array();
	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
	  	$output = array_merge($output,  get_parent($row["id"], [], $conn));
	  }
	}

	echo json_encode($output);
}





// $sql = "SELECT * FROM report_group";
// $result = $conn->query($sql);
// if ($result->num_rows > 0) {
//   // output data of each row
//   while($row = $result->fetch_assoc()) {
//     echo "id: " . $row["id"]. " - Name: " . $row["group_name"]. " " . $row["parent_group_id"]. " " . $row["is_public"]. "<br>";
//   }
// } else {
//   echo "0 results";
// }

$conn->close();
?>