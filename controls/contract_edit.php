<?php

include 'libraries/contracts.class.php';
$contractsObj = new contracts();

include 'libraries/branches.class.php';
$branchesObj = new branches();

include 'libraries/students.class.php';
$studentsObj = new students();

include 'libraries/gear_boxes.class.php';
$gearBoxesObj = new gearBoxes();

include 'libraries/contract_types.class.php';
$contractTypesObj = new contractTypes();

include 'libraries/contract_status.class.php';
$contractStatusObj = new contractStatus();

$formErrors = null;
$data = array();

// nustatome privalomus laukus
$required = array('sudarymo_data', 'suma', 'tipas', 'busena', 'fk_FILIALAS_id', 'fk_MOKSLEIVIS_id');

// vartotojas paspaudė išsaugojimo mygtuką
if(!empty($_POST['submit'])) {
	include 'utils/validator.class.php';

	// nustatome laukų validatorių tipus
	$validations = array (
		'sudarymo_data' => 'datetime',
		'pasirasymo_data' => 'datetime',
		'suma' => 'price',
		'tipas' => 'int',
		'busena' => 'int',
		'automobilio_pavaru_deze' => 'int',
		'fk_FILIALAS_id' => 'int',
		'fk_MOKSLEIVIS_id' => 'int'
    );

	// sukuriame laukų validatoriaus objektą
	$validator = new validator($validations, $required);
	$data = $_POST;

	// laukai įvesti be klaidų
	if($validator->validate($_POST)) {
		if (isset($data['automobilio_pavaru_deze']) && $data['automobilio_pavaru_deze'] != '' && $data['tipas'] == '1') {
            // sudarome klaidų pranešimą
            $formErrors = "Negalima pasirinkti automobilio pavarų dėžės teoriniams mokymams.";
        } elseif ((!isset($data['automobilio_pavaru_deze']) || $data['automobilio_pavaru_deze'] == '') && $data['tipas'] != '1') {
			// sudarome klaidų pranešimą
			$formErrors = "Turite pasirinkti automobilio pavarų dėžę.";
		} else {
		    // suformuojame laukų reikšmių masyvą SQL užklausai
            $dataPrepared = $validator->preparePostFieldsForSQL();

			// įrašome naują sutartį
			$contractsObj->updateContract($dataPrepared);
		}

		// nukreipiame vartotoją į sutarčių puslapį
		if($formErrors == null) {
			common::redirect("index.php?module={$module}&action=list");
			die();
		}
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
	}
} else {
    $data = $contractsObj->getContract($id);
}

// įtraukiame šabloną
include 'templates/contract_form.tpl.php';

?>