<?php

include 'libraries/instructors.class.php';
$instructorsObj = new instructors();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $instructorsObj->getInstructorListCount();

// sukuriame puslapiavimo klasės objektą
include 'utils/paging.class.php';
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

$data = $instructorsObj->getInstructorList($paging->size, $paging->first);

// įtraukiame šabloną
include 'templates/instructor_list.tpl.php';

?>