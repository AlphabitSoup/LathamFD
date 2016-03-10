<?php
/**
 * functions for adding, editing, deleting, connecting to
 * Alphabit Soup database. Also functions to make forms
 * that will add and edit the database. And functions to
 * verify login information.
 *
 *@author Alphabit Soup
 */
require "DBConnect.php";
session_start();

/**
 * function to create a text box to apply within a form
 *
 * @param string $id the name of the attribute in the database
 * @param string $label the name of the text to display
 *				for the text box
 * @param int $size the length of the text field
 *
 * @return the text field on the form 
 */
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

/**
 * function to create a check box to apply within a form
 *
 * @param string $id the name of the array the attributes 
 *				are stored in
 * @param string $value the name of the attribute in the 
 *				database
 * @param string $label the name of the text to display
 *				for the check box
 *
 * @return the check box on the form 
 */
function createCheckBox($id, $value, $label) {
 return '	
  <div class="checkbox">
    <label>
      <input type="checkbox" name="'.$id.'[]" id="'.$id.'" value="'.$value.'" > '.$label.'
    </label>
  </div> ';
}

/**
 * function to connect to Alphabit Soup's database with 
 *			a message to tell whether connection was successful
 *
 * @return $mysqli the success or failure of connecting
 *				  to the database  
 */
function databaseConnect() {
	$mysqli = new mysqli("oraserv.cs.siena.edu", "perm_alphabit", "dour=punish-guild", "perm_alphabit");
	if ($mysqli->connect_errno) {
		die("Database connection failed");
	}
	else {
		return $mysqli;
	}
}	



/**
 * function to check if users password is in the database
 *
 * @return boolean true if the password entered matches the 
 *				  stored password, false otherwise
 */
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

/**
 * function to create a form with text fields and check boxes
 * 			to add a fire fighter to the database
 *
 * @return HTML the form to enter a fire fighter with all his/her 
 *				current credentials
 */
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
	createCheckBox("type", "Driver", "Driver").
	createCheckBox("type", "EMS", "EMS").
	createCheckBox("type", "Exterior", "Exterior").
	createCheckBox("type", "Hazardous", "Hazardous").
	createCheckBox("type", "Hurst Tools", "Hurst Tools").
	createCheckBox("type", "Interior", "Interior").
	createCheckBox("type", "Paramedic", "Paramedic").
	createCheckBox("type", "Pump", "Pump Operator").
	'<button type= "submit" class = "btn btn-success">Submit</button>
	
	</div>';
}

/**
 * function to insert a fire fighter into the Alphabit Soup
 *			database
 */
function insertFirefighter(){
	//var_dump($_POST);
	$mysqli = databaseConnect();
	$type = implode(", ", $_POST['type']);
	
	//echo "here1";

	if (!($stmt = $mysqli->prepare("INSERT INTO `Firefighter` VALUES (DEFAULT,?,?,?,'0')"))) {
		die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
	}

   // echo "here2";
	
	$stmt->bind_param("sss", 
		$_POST['fname'],
		$_POST['lname'],
		$_POST['rank']
	);
	
	//echo "here3";
	
	if (!$stmt->execute()) {
  	die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
	}
	$stmt->close();
	
	//echo "Got here";
	
	if (!($stmt2 = $mysqli->prepare("SELECT ffid FROM `Firefighter` WHERE fname = ? and lname = ? and rank = ? and active = '0'"))) {
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
	$stmt2->close();
	
	//echo ("Got here2");
	
	foreach ($_POST["type"] as $t) {
		
		// $ffid.",";
		//echo $t;
		if (!($stmt3 = $mysqli->prepare("INSERT INTO `Has` VALUES (?,?, NULL, NULL)"))) {
			die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		$stmt3->bind_param("ss", 
			$ffid,
			$t		
		);

		if (!$stmt3->execute()) {
		die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		$stmt3->close();
	}
	
	
	
	
	$mysqli->close();
}

/**
 * function to check if the correct information is inputted
 *			within the add fire fighter form and then is inserted
 *			into the Alphabit Soup database
 *
 * @return function addFirefighterForm if there is a field missing or
 *		  function insertFirefighter if all information is correct
 */
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

/**
 * function to display all the fire fighters within the Alphabit
 *			Soup database
 *
 * @return HTML a nicely manufactured table of all the fire fighters
 */
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
		$output .= '<tr><td><a class = "btn btn-danger" href="deleteFirefighter.php?id='.$row[0].'"><span class = "glyphicon glyphicon-remove"></span></a>';
		$output .= '<a class = "btn btn-sm btn-warning" href="editFirefighter.php?id='.$row[0].'">edit</a></td>';
		
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

/**
 * function to delete a fire fighter from the Alphabit Soup 
 *			database
 *
 * @param int $id the id number of the fire fighter
 */
function deleteFirefighter($id){
	$mysqli = databaseConnect();
	
	//foreach ($_POST["type"] as $t) {

		if (!($stmt3 = $mysqli->prepare("DELETE FROM `Has` WHERE ffid=?"))) {
			die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		$stmt3->bind_param("i", 
			$id
		);

		if (!$stmt3->execute()) {
		die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		$stmt3->close();
		
	//}
	
	$query = "DELETE FROM `Firefighter` WHERE ffid=?";
	echo $id;
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

/**
 * function to retrieve a fire fighter from the Alphabit Soup 
 *			database
 *
 * @param int $id the id number of the fire fighter
 *
 * @return string the array of that fire fighter's information
 *			and credentials 
 */
function getFirefighter($id){
	$mysqli = databaseConnect();
	$query1 = "SELECT * from `Firefighter` AS F where F.ffid =?";
	if (!($stmt = $mysqli->prepare($query1))) {
		die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
	}
	$stmt->bind_param("s", $id);
	if (!$stmt->execute()) {
  		die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
	}

	$stmt->bind_result( 
		$row['ffid'],
		$row['fname'],
		$row['lname'],
		$row['rank'],
		$row['active']
		//$row['type']		
	);
	$stmt->fetch();
	//$row['type'] = explode(", ", $row['type']);

	$stmt->close();
	$mysqli->close();

	return $row;
}

/**
 * function to update a fire fighter in the Alphabit Soup 
 *			database
 *
 * @param int $id the id number of the fire fighter
 */
function updateFirefighter($id){
	$mysqli = databaseConnect();
	
	//$type = implode(", ", $row['type']);

	$query2 = "UPDATE `Firefighter` SET fname = ?, lname=?, rank=? WHERE ffid = ?";
	if (!($stmt = $mysqli->prepare($query2))) {
		die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
	}
		
	$stmt->bind_param("ssss",
		$_POST['fname'],
		$_POST['lname'],
		$_POST['rank'],
		$id
	);
	
		
	if (!$stmt->execute()) {
  		die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
	}

	$stmt->close();


	if (!($stmt2 = $mysqli->prepare("DELETE FROM `Has` WHERE ffid=?"))) {
			die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		$stmt2->bind_param("i", 
			$id
		);

		if (!$stmt2->execute()) {
		die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		$stmt2->close();

	//var_dump($_POST["type"]);
	foreach ($_POST["type"] as $t) {

		if (!($stmt3 = $mysqli->prepare("INSERT INTO `Has` VALUES (?,?,NULL,NULL)"))) {
			die("Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		
		$stmt3->bind_param("ss", 
			$id,
			$t
		);

		if (!$stmt3->execute()) {
		die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
		}
		$stmt3->close();
	}
	
	$mysqli->close();
}

/**
 * function to create an edited form with text fields retrieved
 *			from the database and check boxes to update a fire 
 *			fighter's information to the database
 *
 * @return HTML the form to update a fire fighter with all his/her 
 *				current credentials
 */
function createEditForm(){
	return 
		'
		<form method="post" action="editFirefighter.php?action=submit&id='.$_GET[id].'">
		<h2>Firefighter Edit Form</h2>
		<div class="row">'.		
		createTextField("fname", "First Name", 256).
		createTextField("lname", "Last name", 256).
		createTextField("rank", "Firefighter Rank", 256).
		'<label class="control-label" >Firefighter Credentials</label>'.
		createCheckBox("type", "Driver", "Driver").
		createCheckBox("type", "EMS", "EMS").
		createCheckBox("type", "Exterior", "Exterior").
		createCheckBox("type", "Hazardous", "Hazardous").
		createCheckBox("type", "Hurst Tools", "Hurst Tools").
		createCheckBox("type", "Interior", "Interior").
		createCheckBox("type", "Paramedic", "Paramedic").
		createCheckBox("type", "Pump", "Pump Operator").
		'<button type= "submit" class = "btn btn-success">Submit</button>
	
		</div>';
}

/**
 * function to create an edited text box to apply within a form
 *
 * @param string $name the name of the attribute in the database
 * @param string $label the name of the text to display
 *				for the text box
 * @param int $size the length of the text field
 * @param string $value the value of that attribute
 *
 * @return the edited text field on the form 
 */
function createEditedTextField($name, $label, $size, $value){
	//error handling - styles the text fields using Bootstrap if the $id field is equal to !missing! 
	$errorClass = null;
	$errorSpan = null;
	if($_POST[$id] == "!missing!"){
		$errorClass = " has-error";
		$errorSpan = '<span class="help-block">Field must not be blank.</span>';
	}

  	return '
  	<div class="col-sm-'.$size.'">	
    <div class="form-group'.$errorClass.'">
     <label class="control-label" for="'.$id.'">'.$label.$errorSpan.'</label>
     <input type="text" class="form-control" id="'.$name.'" name="'.$name.'" value="'.$value.'">
    </div>
   	</div>';	
}

/**
 * function to make the credentials of the fire fighter false
 *			so the editor can update the fire fighter's credentials
 *
 * @return the check boxes blanked out
 */
function createCredentialsCheckBox(){
	$possibleValues['Driver'] = false;
	$possibleValues['EMS'] = false;
	$possibleValues['Exterior'] = false;
	$possibleValues['Hazardous'] = false;
	$possibleValues['Hurst Tools'] = false;
	$possibleValues['Interior'] = false;
	$possibleValues['Paramedic'] = false;
	$possibleValues['Pump Operator'] = false;
	$selectedValues = explode(", ", $_POST["type"]);

	foreach ($selectedValues as $s) {
  		$possibleValues[$s] = true;
	}

	foreach ($possibleValues as $key => $value) {
  		$selected = "";
  		if ($value == true){
    		$selected = "checked";
		}
  		$output .= createEditedCheckBox("type", $key, $key, $selected);
	}
	return $output;	
}

/**
 * function to create the edited text box to apply within a form
 *
 * @param string $id the name of the array the attributes 
 *				are stored in
 * @param string $value the name of the attribute in the 
 *				database
 * @param string $label the name of the text to display
 *				for the check box
 * @param string $selected the value if the check box is selected
 *
 * @return the check boxes on the form 
 */
function createEditedCheckBox($id, $value, $label, $selected){
	return '	
  <div class="checkbox">
    <label>
      <input type="checkbox" name="'.$id.'[]" id="'.$id.'" value="'.$value.'" '.$selected.' > '.$label.'
    </label>
  </div> ';	
}


/* FUNCTIONS NOT USED CURRENTLY
function createEditedForm($id){
	return '
   <form method="post" action="updateAdmin.php?action=submit&id='.$id.'">
   <h2>Firefighter Info</h2>
   <div class="row">'.	   
   createEditedTextField("fname", "First Name", 256, $_POST["fname"]).
   createEditedTextField("lname", "Last name", 256, $_POST["lname"]).
   createEditedTextField("rank", "Firefighter Rank", 256, $_POST["rank"]).
   '</div>
   
   <div class="row"><div class="col-sm-4"><h2>Credentials</h2>'.
   createCredentialsCheckBox().
   '</div>
      
   
   <button type="submit" class = "btn btn-success">Update</button>
   </form>';

}

/*
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
*/


// stuff for call table
/**
 * Returns a string of HTML that displays a table containing information from the CallInfo table
 * @return string
 */
function displayCallTable() {

    $mysqli = databaseConnect();
    $query = "SELECT * FROM CallInfo ORDER BY time_of_call";

    // 3. Run the query.  Prepared queries must be executed.  But hardcoded queries can be run with one function call
    // $results is a pointer to the query's output
    $result = $mysqli->query($query);

    // 4. Fetch the fields that the query returned
    // $finfo is an object that stores all the field information

    $finfo = $result->fetch_fields();

    $output = '<table border="1">';

    $output .= '<thead><tr>';
    foreach ($finfo as $field) {
	$output .= '<th>&nbsp'.$field->name.'&nbsp</th>';
    }
    $output .= '</tr></thead><tbody>';

    // 7. Fetch each row of the query result to make an HTML row

    while ($row = $result->fetch_row()) {
	$output .= '<tr>';

	// 8. Loop for each column and make an HTML table data column
	foreach ($row as $val) {
	    $output .= '<td>&nbsp'.$val.'&nbsp</td>';
	}
	$output .= '</tr>';
    }
    $output .= '</tbody></table>';

    $result->free();
    $mysqli->close();
    return $output;
}

/**
 * Adds call information to the CallInfo table.
 * @param string $address Where the fire takes place
 * @param string $fire_type Type of fire (structure, etc)
 * @param string $time_of_call When the call was recieved
 * @param string $responding_unit Unit that responds to the call
 * @param string $truck_leaves Time the truck leaves the firehouse
 *               Format: YYYY-MM-DD HH:MM:SS
 * @param string $truck_arrives Time the truck arrives at the fire
 *               Format: YYYY-MM-DD HH:MM:SS
 *
 */
function addToCallTable($address, $fire_type, $time_of_call,
                        $responding_unit, $truck_leaves,
                        $truck_arrives) {

    $mysqli = databaseConnect();

    $insert_query = "INSERT INTO CallInfo VALUES (" . $address
                  . ", " . $fire_type . ", " . $time_of_call
                  . ", " . $responding_unit . ", "
                  . $truck_leaves . ", " . $truck_arrives . ")";

    if (!$mysqli->query($insert_query)) {
        echo 'Table insert failed: (' . $mysqli->errno . ') ' . $mysqli->error;
    }
}



// end stuff for call info
?>