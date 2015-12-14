<?php
require "DBConnect.php";
session_start();


function createHeader($title) {
  return '
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>'.$title.'</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
    	<h1>'.$title.'</h1>';
}	

function createFooter($title) {
  $year = date('Y');
  return '
    <footer>Copyright '.$year.' '.$title.'</footer>
    </div><!-- /.container -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
  </html>';
}

function createForm() {	
  return '
   <form method="post" action="form.php?action=submit">
   <h2>Customer Info</h2>
   <div class="row">'.		
   createTextField("cust_name", "Name", 8).
   createTextField("cust_phone", "Phone", 4).
   createTextField("cust_address", "Address", 12).
   createTextField("cust_city", "City", 6).
   createTextField("cust_state", "State", 2).
   createTextField("cust_zip", "Zip", 4).
   '</div>
   
   <div class="row"><div class="col-sm-4"><h2>Scoop Size</h2>'.
   createRadioButton("scoop", "small" , "One"). 
   createRadioButton("scoop", "med" , "Two"). 
   createRadioButton("scoop", "lg" , "Three"). 
   '</div>
   
   <div class="col-sm-4"><h2>Container Type</h2>'.
   createRadioButton("container", "cup" , "Cup"). 
   createRadioButton("container", "cone" , "Cone"). 
   '</div>
   
   <div class ="col-sm-2"><h2>Quantity</h2>'.	
   	createOptionSelect("drop", 1 , 10).
   '</div></div>
   
   <div class="row"><div class="col-sm-4"><h2>Sprinkles</h2>'.
   createCheckBox("Topping", "rainbow" , "Rainbow Sprinkles"). 
   createCheckBox("Topping", "chocolate" , "Chocolate Sprinkles"). 
   createCheckBox("Topping", "white" , "White Chocolate Sprinkles"). 
   '</div>
   
   <div class="col-sm-4"><h2>Candy Topping</h2>'.
   createCheckBox("Candy", "mm" , "M&amp;M's"). 
   createCheckBox("Candy", "pieces" , "Reeses Pieces"). 
   createCheckBox("Candy", "reeses" , "Reeses"). 
   createCheckBox("Candy", "oreos" , "Oreos"). 
   createCheckBox("Candy", "gummy" , "Gummy Bears"). 
   '</div></div>
   
   
   <button type="submit" class = "btn btn-success">Submit</button>
   </form>';
}



function createTextField($id, $label, $size) {
	//error handling - styles the text fields using Bootstrap if the $id field is equal to !missing! 
	$errorClass = null;
	$errorSpan = null;
	if($_POST[$id] == "!missing!"){
		$errorClass = " has-error";
		$errorSpan = '<span class="help-block">Field must not be blank.</span>';
	}
	else if (!empty ($_POST[$id])){
		$value = $_POST[$id];
	}
  return '
   <div class="col-sm-'.$size.'">	
    <div class="form-group'.$errorClass.'">
     <label class="control-label" for="'.$id.'">'.$label.$errorSpan.'</label>
     <input type="text" class="form-control" id="'.$id.'" name="'.$id.'" value="'.$value.'">
    </div>
   </div>';	
}

function createOptionSelect($id, $start, $end) {
	$output = '<select class="form-control" name="'.$id.'" id="'.$id.'">';
	for ($i = $start; $i <= $end; $i++)
		$output .= '<option value="'.$i.'">'.$i.'</option>';
	$output .= '</select>';
	return $output;
}



function createRadioButton($id, $value, $label) {
 $errorClass = null;
 $errorSpan = null;
 if ($_POST[$id] == "!missing!") {
  $errorClass = " has-error";
  $errorSpan = '<span class="help-block">'.$id.' Type must be entered.</span>';
 }
 return '
  <div class="form-group'.$errorClass.'">	
  <div class="radio">
    <label>
      <input type="radio" name="'.$id.'" id="'.$id.'" value="'.$value.'"> '.$label.
      $errorSpan.'
    </label>
  </div>
  </div> ';
}


function createCheckBox($id, $value, $label) {
 return '	
  <div class="checkbox">
    <label>
      <input type="checkbox" name="'.$id.'[]" id="'.$id.'" value="'.$value.'" > '.$label.'
    </label>
  </div> ';
}

function databaseConnect() {
	$mysqli = new mysqli("oraserv.cs.siena.edu", "perm_alphabit", "dour=punish-guild", "perm_alphabit");
	if ($mysqli->connect_errno) {
		die("Database connection failed");
	}
	else {
		return $mysqli;
	}
}	

function insertOrder($q) {

	// 1. We have to connect to the database.  $mysqli is a database connection object
	
	$mysqli = databaseConnect();
	
	// 2. We get the current date and time in the form 2015-10-30 8:30:59 
	
	$orderDate = date("Y-m-d H:i:s");
	
	// 3. We take the toppings array and convert it to a comma separated string
	
	$toppings = implode(", ", $_POST['Topping']);
	$Candy = implode(", ", $_POST['Candy']);
	
	// 4. We prepare the query.  We will insert a row into the table.
	// 5. The values have to be inserted in the defined order of the table
	// 6. My table has 11 fields, the first row is an auto-increment id used as the primary key
	// 7. The other 10 fields come from the posted form. They are all strings except for pizza_quantity
	
	if (!($stmt = $mysqli->prepare("INSERT INTO `am8orders` VALUES (DEFAULT,?,?,?,?,?,?,?,?,?,?,?,?,DEFAULT)"))) {
		die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
	}
	
	// 8. There are 10 parameter, the first 8 are strings, the 9th is an integer, the 10th is a string		
	
	$stmt->bind_param("sssssssissss", 
		$orderDate, 
		$_POST['cust_name'],
		$_POST['cust_phone'],
		$_POST['cust_address'],
		$_POST['cust_city'],
		$_POST['cust_state'],
		$_POST['cust_zip'],
		$_POST['drop'],
		$_POST['scoop'],
		$_POST['container'],		
		$toppings,
		$Candy
	);

  // 9. Once the query is prepared, we can execute it
  
  if (!$stmt->execute()) {
  	die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
	}
	else {
		// 10. If the query had no errors, we display the order
		return displayOrder();
	}
	$stmt->close();
	$mysqli->close();
}

function processForm() {
	$fieldMissing = false;
	foreach ($_POST as $key => $value) {
			if ($value == null)  {
				$_POST[$key] = "!missing!";
				$fieldMissing = true;
			}
	}
	if ($fieldMissing) {
		return createForm();
	}
	else {
		return insertOrder();
	}
  
  }
  


function displayOrder() {	
	$output = "";
	$output .= displayDate();
	foreach ($_POST as $key => $value) {
		if (is_array($value))
		{
			$value = implode(", ", $value);
		}
		$output .=  '
			<div class="panel panel-primary">
		  	<div class="panel-heading">'.$key.'</div>
				<div class="panel-body"><p>'.$value.'</p></div>	
			</div>';
	}
	$output .= '<a class="btn btn-primary" href="order.php">Back</a>';
	return $output;
}

function displayTable() {
	
	// 1. Connect to the database
	
	$mysqli = databaseConnect();
	
	// 2. Define the query as string
	// Note that we don't have to prepare it because there are no variables, i.e. the query is hardcoded and cannot be change by a user
	
	$query = "SELECT * FROM am8orders";
	
	// 3. Run the query.  Prepared queries must be executed.  But hardcoded queries can be run with one function call
	// $results is a pointer to the query's output
	
	$result = $mysqli->query($query);
	
	// 4. Fetch the fields that the query returned
	// $finfo is an object that stores all the field information
	
	$finfo = $result->fetch_fields();
		
	// 5. Create an HTML table
	
	$output = '<table class="table table-bordered">';

	// 6. Loop for all the fields and print them as table headers
	
	$output .= '<thead><tr>';
	foreach ($finfo as $field) {
		$output .= '<th>'.$field->name.'</th>';
	}
	$output .= '</tr></thead><tbody>';
	
	// 7. Fetch each row of the query result to make an HTML row
	
	while ($row = $result->fetch_row()) {
		$output .= '<tr>';
		
		// 8. Loop for each column and make an HTML table data column
		foreach ($row as $val) {
			$output .= '<td>'.$val.'</td>';
		}
		$output .= '</tr>';
	}
	$output .= '</tbody></table>';

	$result->free();
	$mysqli->close();
	return $output;
}	

function createAdminTable() {
  $mysqli = databaseConnect();
	$dropquery = "DROP TABLE IF EXISTS `Admin`";
	$createquery = "CREATE TABLE IF NOT EXISTS `Admin` (
		`userid` varchar(24) NOT NULL,
		`password` varchar(256) NOT NULL,
		`employee_type` int(2) NOT NULL,
		PRIMARY KEY (`userid`)
	)";
	if (!$mysqli->query($dropquery)) {
		echo 'Table drop failed: (' . $mysqli->errno . ') ' . $mysqli->error;
	}
	else if (!$mysqli->query($createquery)) {
		echo 'Table create failed: (' . $mysqli->errno . ') ' . $mysqli->error;
	}
	else {
		echo 'Table created';
	}	
}

function createAdminForm() {	
	$radio_id = "employee_type";
	$displayDate = displayDate();
	
	
	return 
	$displayDate.'
	<form method="post" action="order.php?action=submit">
	<h2>Admin Form</h2>
	<div class="row">'.		
	createTextField("userid", "userid", 24).
	createTextField("password", "passwd", 256).
	createRadioButton($radio_id, "employee", 0, $errorClass).
	createRadioButton($radio_id, "manager", 1, $errorClass).
	'<button type= "submit" class = "btn btn-success">Submit</button>
	</div>';
	
}



function processAdminForm() {
	$fieldMissing = false;
	foreach ($_POST as $key => $value) {
			if ($value == null)  {
				$_POST[$key] = "!missing!";
				$fieldMissing = true;
			}
	}
	if ($_POST['employee_type'] == null) {
		$_POST['employee_type'] = "!missing!";
		$fieldMissing = true;
	}
	if ($fieldMissing) {
		return createAdminForm();
	}
	else {
		return insertAdminOrder();
	}
}

function insertAdmin() {
	$mysqli = databaseConnect();
	

	if (!($stmt = $mysqli->prepare("INSERT INTO `Admin` VALUES (?,?,?)"))) {
		die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
	}		
	$stmt->bind_param("sss", 
		$_POST['userid'],
		$hashed_passwd = hash("sha256", $_POST['passwd']),
		$_POST['employee_type']
	);

  if (!$stmt->execute()) {
  	die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
	}
	
	$stmt->close();
	$mysqli->close();
}

function createLoginForm() {	

	
	
	return 
	'
	<form method="post" action="login.php?action=submit">
	<h2>Login Form</h2>
	<div class="row">'.		
	createTextField("userid", "userid", 24).
	createTextField("password", "passwd", 256).
	'<button type= "submit" class = "btn btn-success">Submit</button>
	
	</div>';
	
}

function processLoginForm() {
  $fieldMissing = false;
  foreach ($_POST as $key => $value) {
    $value = strval($value);
    if ($value == "")  {
      $_POST[$key] = "!missing!";
      $fieldMissing = true;
    }
  }
  if ($fieldMissing) {
    return createLoginForm();
  }
  else {
    checkPassword();
  }
}


function checkPassword() {
  $mysqli = databaseConnect();
  $submitted_passwd = hash('sha256', $_POST['passwd']);
  $submitted_userid = $_POST['userid'];
  if (!($stmt = $mysqli->prepare("SELECT passwd FROM `Admins` WHERE userid=?"))) {
    die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
  }
  $stmt->bind_param("s", $submitted_userid );
  if (!$stmt->execute()) {
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
  }
  $stored_passwd = null;
  if (!$stmt->bind_result($stored_passwd)) {
    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
  }
  if ($stmt->fetch()) {
    if ($stored_passwd == $submitted_passwd){
		//FOR STARTING A SESSION, TAKE OUT $_SESSION VARIABLES
		//$_SESSION['admin'] = $admin_type;
		//$_SESSION['userid'] = $user_id;
		//if ($admin_type == 1)
			//header("location: /proj2/addFirefighter.php");
      return true;
	}
    else
      return false;
  }
}

function addFirefighterForm(){
	return 
	'
	<form method="post" action="addFirefighter.php?action=submit">
	<h2>Firefighter Add Form</h2>
	<div class="row">'.		
	createTextField("fname", "First Name", 256).
	createTextField("lname", "Last name", 256).
	createTextField("rank", "Firefighter Rank", 256).
	'<label class="control-label" >Firefighter Credentials</label>'.
	createCheckBox("type", "driver", "Driver").
	createCheckBox("type", "ems", "EMS").
	createCheckBox("type", "exterior", "Exterior").
	createCheckBox("type", "hazardous", "Hazardous").
	createCheckBox("type", "hurst", "Hurst Tools").
	createCheckBox("type", "interior", "Interior").
	createCheckBox("type", "paramedic", "Paramedic").
	createCheckBox("type", "pump", "Pump Operator").
	'<button type= "submit" class = "btn btn-success">Submit</button>
	
	</div>';
}

function insertFirefighter(){
	var_dump($_POST);
	$mysqli = databaseConnect();
	$type = implode(", ", $_POST['type']);
	
	echo "here1";

	if (!($stmt = $mysqli->prepare("INSERT INTO `Firefighter` VALUES (DEFAULT,?,?,?)"))) {
		die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
	}

    echo "here2";
	
	$stmt->bind_param("sss", 
		$_POST['fname'],
		$_POST['lname'],
		$_POST['rank']
	);
	
	echo "here3";
	
	if (!$stmt->execute()) {
  	die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
	}
	
	die("Got here");
	
	if (!($stmt2 = $mysqli->prepare("SELECT ffid FROM `Firefighter` WHERE fname = ? and lname = ? and rank = ?"))) {
		die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
	}	
	
	$stmt2->bind_param("sss", 
		$_POST['fname'],
		$_POST['lname'],
		$_POST['rank']
	);
	
	if (!$stmt2->execute()) {
  	die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
	}
	
	$stmt2->bind_result($ffid);
	$stmt2->fetch();
	

	
	if (!($stmt3 = $mysqli->prepare("INSERT INTO `Has` VALUES (?,?, null, null)"))) {
		die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
	}
	
	$stmt3->bind_param("is", 
	    $ffid,
		$_POST[$type]		
	);

	if (!$stmt3->execute()) {
  	die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
	}
	
	$stmt->close();
	$stmt2->close();
	$stmt3->close();
	$mysqli->close();
}

function processFirefighter (){
	$fieldMissing = false;
	foreach ($_POST as $key => $value) {
			if ($value == null)  {
				$_POST[$key] = "!missing!";
				$fieldMissing = true;
			}
	}
	
	
	if ($fieldMissing) {
		return addFirefighterForm();
	}
	else {
		return insertFirefighter();
	}
}

function editTable(){
$mysqli = databaseConnect();
$query = "SELECT * FROM Firefighter";
	$result = $mysqli->query($query);
	$finfo = $result->fetch_fields();
		
	$output = '<table class="table table-bordered">';
	$output .= '<thead><tr><th>Actions</th>';
	foreach ($finfo as $field) {
		$output .= '<th>'.$field->name.'</th>';
	}
	$output .= '</tr></thead><tbody>';
	while ($row = $result->fetch_row()) {
		$output .= '<tr><td><a class = "btn btn-danger" href="deleteFirefighter.php?id='.$row[0].'">Delete</a></td>';
		
		
		foreach ($row as $val) {
			$output .= '<td>'.$val.'</td>';
		}
		$output .= '</tr>';
	}
	$output .= '</tbody></table>';

	$result->free();
	$mysqli->close();
	return $output;
}

function deleteFirefighter($id){
	$mysqli = databaseConnect();
	$query = "DELETE FROM `Firefighter` WHERE ffid=?";
	if (!($stmt = $mysqli->prepare($query))) {
		die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
	}
	
	$stmt->bind_param("i", 
	$id
	);

  if (!$stmt->execute()) {
  	die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
	}

	$stmt->close();
	$mysqli->close();

}
?>