<?php

include 'libraries/instructors.class.php';
$instructorsObj = new instructors();

if(!empty($id)) {
	$instructorsObj->deleteReview($id);

	// nukreipiame į automobilių puslapį
	common::redirect("index.php?module=instructor&action=edit&id=" . $_GET["instructorId"]);
	die();
}

?>