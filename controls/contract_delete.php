<?php

include 'libraries/contracts.class.php';
$contractsObj = new contracts();

if(!empty($id)) {
	// šaliname sutartį
	$contractsObj->deleteContract($id);

	// nukreipiame į sutarčių puslapį
	common::redirect("index.php?module={$module}&action=list");
	die();
}

?>