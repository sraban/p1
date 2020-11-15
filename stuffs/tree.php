<?php
//print_r($_REQUEST);
/*
	index.php?operation=get_node&id=webapp
*/
$operation = @$_REQUEST['operation'];
$id = @$_REQUEST['id'];
$parent = @$_REQUEST['parent'];
$text = @$_REQUEST['text'];
$type = @$_REQUEST['type'];
$output = [];

if($operation == "move_node") {
	//$parent
	$output["id"] = $id;
	echo json_encode($output);
} else if($operation == "create_node") {
	// $parent_id = $id
	// $text
	$output["id"] = rand(20,100);
	echo json_encode($output);
} else if($operation == "rename_node") {
	// $id
	// $text
	$output["id"] = rand(20,100);
	echo json_encode($output);
} else if($operation == "select_node") {
	
} else if($operation == "get_nodes") {
	$output = Array(["id"=> 3,"parent_group_id"=> 1,"is_public"=> true,"name"=> "333333333333"],["id"=> 2,"parent_group_id"=> null,"is_public"=> false,"name"=> "222222222222"], ["id"=> 1,"parent_group_id"=> null,"is_public"=> true,"name"=> "11111111111"], ["id"=> 6,"parent_group_id"=> 3,"is_public"=> true,"name"=> "66666666666"], ["id"=> 7,"parent_group_id"=> 3,"is_public"=> true,"name"=> "7777777777"], ["id"=> 4,"parent_group_id"=> 2,"is_public"=> true,"name"=> "444444444"], ["id"=> 5,"parent_group_id"=> 2,"is_public"=> true,"name"=> "5555555555"]);
	echo json_encode($output);
}

?>