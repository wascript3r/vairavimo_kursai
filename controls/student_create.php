<?php

include 'libraries/students.class.php';
$studentsObj = new students();

$formErrors = null;
$data = array();

// nustatome privalomus laukus
$required = array('vardas', 'pavarde', 'el_pastas', 'tel_nr', 'adresas');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'vardas' => 25,
	'pavarde' => 25,
	'el_pastas' => 100,
	'tel_nr' => 20,
	'adresas' => 100
);

// paspaustas išsaugojimo mygtukas
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
	$validations = array (
		'vardas' => 'alfanum',
		'pavarde' => 'alfanum',
		'el_pastas' => 'email',
		'tel_nr' => 'phone',
		'adresas' => 'anything'
    );

	// sukuriame validatoriaus objektą
	include 'utils/validator.class.php';
	$validator = new validator($validations, $required, $maxLengths);

	if($validator->validate($_POST)) {
		// suformuojame laukų reikšmių masyvą SQL užklausai
		$dataPrepared = $validator->preparePostFieldsForSQL();

		// įrašome naują įrašą
		$studentsObj->insertStudent($dataPrepared);

		// nukreipiame į markių puslapį
		common::redirect("index.php?module={$module}&action=list");
		die();
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// gauname įvestus laukus
		$data = $_POST;
	}
}

// įtraukiame šabloną
include 'templates/student_form.tpl.php';

?>