<?php

include 'libraries/branches.class.php';
$branchesObj = new branches();

if(!empty($id)) {
    // Car
	$count = $branchesObj->getCarCountOfBranch($id);

	$removeErrorParameter = '';
	if($count != 0) {
	    $removeErrorParameter = '&remove_error1=1';
		common::redirect("index.php?module={$module}&action=list{$removeErrorParameter}");
        die();
	}

	// Instructor
	$count = $branchesObj->getInstructorCountOfBranch($id);

	$removeErrorParameter = '';
	if($count != 0) {
	    $removeErrorParameter = '&remove_error2=1';
		common::redirect("index.php?module={$module}&action=list{$removeErrorParameter}");
        die();
	}

	// Contract
	$count = $branchesObj->getContractCountOfBranch($id);

	$removeErrorParameter = '';
	if($count != 0) {
	    $removeErrorParameter = '&remove_error3=1';
		common::redirect("index.php?module={$module}&action=list{$removeErrorParameter}");
        die();
	}

	$branchesObj->deleteBranch($id);

	common::redirect("index.php?module={$module}&action=list");
    die();
}

?>