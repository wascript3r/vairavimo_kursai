<?php

include 'libraries/students.class.php';
$studentsObj = new students();

if(!empty($id)) {
	$studentsObj->deleteReviews($id);
	$studentsObj->deleteLessons($id);
	$studentsObj->deleteContracts($id);
	$studentsObj->deleteStudent($id);

	common::redirect("index.php?module={$module}&action=list");
    die();
}

?>