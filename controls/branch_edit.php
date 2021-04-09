<?php

include 'libraries/branches.class.php';
$branchesObj = new branches();

$formErrors = null;
$data = array();

// nustatome privalomus laukus
$required = array('adresas', 'kontaktinis_tel');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'adresas' => 100,
	'kontaktinis_tel' => 20
);

// paspaustas išsaugojimo mygtukas
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
	$validations = array (
		'adresas' => 'anything',
		'kontaktinis_tel' => 'anything'
    );

	// sukuriame validatoriaus objektą
	include 'utils/validator.class.php';
	$validator = new validator($validations, $required, $maxLengths);

	if($validator->validate($_POST)) {
		// suformuojame laukų reikšmių masyvą SQL užklausai
		$dataPrepared = $validator->preparePostFieldsForSQL();

		// atnaujiname duomenis
		$branchesObj->updateBranch($dataPrepared);

		// nukreipiame į markių puslapį
		common::redirect("index.php?module={$module}&action=list");
		die();
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// gauname įvestus laukus
		$data = $_POST;
	}
} else {
	// išrenkame elemento duomenis ir jais užpildome formos laukus.
	$data = $branchesObj->getBranch($id);
}

// įtraukiame šabloną
include 'templates/branch_form.tpl.php';

?>