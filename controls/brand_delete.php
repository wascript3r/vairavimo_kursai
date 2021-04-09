<?php

include 'libraries/brands.class.php';
$brandsObj = new brands();

if(!empty($id)) {
	$count = $brandsObj->getCarCountOfBrand($id);

	$removeErrorParameter = '';
	if($count == 0) {
		$brandsObj->deleteBrand($id);
	} else {
		// nepašalinome, nes markė priskirta automobiliui, rodome klaidos pranešimą
		$removeErrorParameter = '&remove_error=1';
	}

	// nukreipiame į markių puslapį
	common::redirect("index.php?module={$module}&action=list{$removeErrorParameter}");
	die();
}

?>