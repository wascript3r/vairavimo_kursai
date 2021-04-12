<?php

include 'libraries/students.class.php';
$studentsObj = new students();

// suskaičiuojame bendrą įrašų kiekį
$elementCount = $studentsObj->getStudentListCount();

// sukuriame puslapiavimo klasės objektą
include 'utils/paging.class.php';
$paging = new paging(config::NUMBER_OF_ROWS_IN_PAGE);

// suformuojame sąrašo puslapius
$paging->process($elementCount, $pageId);

$data = $studentsObj->getStudentList($paging->size, $paging->first);

// įtraukiame šabloną
include 'templates/student_list.tpl.php';

?>