<?php

include 'libraries/branches.class.php';
$branchesObj = new branches();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $branchesObj->getBranchListCount();

// sukuriame puslapiavimo klasės objektą
include 'utils/paging.class.php';
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

$data = $branchesObj->getBranchList($paging->size, $paging->first);

// įtraukiame šabloną
include 'templates/branch_list.tpl.php';

?>