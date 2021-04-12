<?php

include 'libraries/instructors.class.php';
$instructorsObj = new instructors();

if(!empty($id)) {
	$instructorsObj->deleteReviews($id);
	$instructorsObj->deleteLessons($id);
	$instructorsObj->deleteInstructor($id);

	common::redirect("index.php?module={$module}&action=list");
    die();
}

?>