<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-.]/', '', $string); // Removes special chars.
}

function uploadFileRaw() {
	$folder = 'uploads/';
	$name = time().".png";//$_GET['type'];
	$file = file_get_contents('php://input');
	if(file_put_contents($folder.$name, $file)) {
		return ['file_name' => $name, 'file_path' => "http://localhost:8100/$folder$name"];
	} else {
		return ['file_name' => '', 'file_path' => ''];
	}
}


function uploadFile() {
	$folder = 'uploads/';
	$name = time().clean($_FILES['userfile']['name']);
	if(move_uploaded_file($_FILES['userfile']['tmp_name'], $folder.$name)){
		return ['file_name' => $name, 'file_path' => 'http://localhost:8100/'.$folder.$name];
	} else {
		return ['file_name' => '', 'file_path' => ''];
	}
}


// userfile
if (! empty($_FILES)) {
	if ($_FILES['userfile']['tmp_name']) {
		$saved = uploadFile();
	  	echo json_encode($saved);
	}
} else if($_SERVER['REQUEST_METHOD'] === 'POST') {
	$saved = uploadFileRaw();
	echo json_encode($saved);
}


//echo json_encode($uploadedFiles);
// {"file_name":"image.png","file_path":"uploads/3aa898a98ae833c309fbe4783e8f2a1c/image.png","branch":"master","link":{"url":"uploads/3aa898a98ae833c309fbe4783e8f2a1c/image.png","markdown":"![image](uploads/3aa898a98ae833c309fbe4783e8f2a1c/image.png)"}}
?>