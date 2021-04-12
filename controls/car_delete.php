<?php

include 'libraries/branches.class.php';
$branchesObj = new branches();

if(!empty($id)) {
	$branchesObj->deleteLessons($id);
	$branchesObj->deleteCar($id);

	// nukreipiame į automobilių puslapį
	common::redirect("index.php?module=branch&action=edit&id=" . $_GET["branchId"]);
	die();
}

?>