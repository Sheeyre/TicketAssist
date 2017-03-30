<?php
require($_SERVER['DOCUMENT_ROOT'] . '/loginutils/SuperuserAuth.php');
require($_SERVER['DOCUMENT_ROOT'] . '/loginutils/connectdb.php');
//Called using confirmDelete() in /js/alerts.js
//Return 1 on success, 2 if trying to delete Other or Students, 3 if error when moving students
$to_delete = $_GET['id'];
//Do not allow group 'General' to be deleted.
if($to_delete < 2){
	echo "The group \"General\" cannot be deleted.";
}else{
	//First, move all contacts in the group to "Other"
	$move_sql = "UPDATE genericResponse SET grouping = 1 WHERE grouping = $to_delete;";
	$move_result = mysqli_query($con, $move_sql);
	if(!$move_result){
		echo "An error occurred while moving the group's users.";
	}else{
		$delete_sql = "DELETE FROM `genericResponseGroups` WHERE `genericResponseGroups`.`id` = $to_delete;";
		$delete_result = mysqli_query($con, $delete_sql);
		if(!$delete_result){
			echo "An error occurred while deleting the group.";
		}else{
			echo 1;
		}
	}
}