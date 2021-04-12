<?php

include 'libraries/instructors.class.php';
$instructorsObj = new instructors();

include 'libraries/branches.class.php';
$branchesObj = new branches();

include 'libraries/students.class.php';
$studentsObj = new students();

$formErrors = null;
$data = array();

// nustatome privalomus laukus
$required = array('vardas', 'pavarde', 'el_pastas', 'tel_nr', 'adresas', 'aprasymas', 'darbo_pradzios_data', 'vairavimo_stazas', 'fk_FILIALAS_id', 'ids', 'moksleiviai', 'ivertinimai', 'komentarai', 'datos');

// maksimalūs leidžiami laukų ilgiai
$maxLengths = array (
	'vardas' => 25,
	'pavarde' => 25,
	'el_pastas' => 100,
	'tel_nr' => 20,
	'adresas' => 100,
	'aprasymas' => 255,
	'vairavimo_stazas' => 6
);

// paspaustas išsaugojimo mygtukas
if(!empty($_POST['submit'])) {
	// nustatome laukų validatorių tipus
	$validations = array (
		'vardas' => 'alfanum',
		'pavarde' => 'alfanum',
		'el_pastas' => 'email',
		'tel_nr' => 'phone',
		'adresas' => 'anything',
		'aprasymas' => 'anything',
		'darbo_pradzios_data' => 'date',
		'vairavimo_stazas' => 'int',
		'fk_FILIALAS_id' => 'int',
        'ids' => 'int',
        'moksleiviai' => 'int',
        'ivertinimai' => 'int',
        'komentarai' => 'anything',
        'datos' => 'datetime'
    );

	// sukuriame validatoriaus objektą
	include 'utils/validator.class.php';
	$validator = new validator($validations, $required, $maxLengths);
	$data = $_POST;

	if($validator->validate($_POST)) {
		// suformuojame laukų reikšmių masyvą SQL užklausai
		$dataPrepared = $validator->preparePostFieldsForSQL();

		// atnaujiname duomenis
		$instructorsObj->updateInstructor($dataPrepared);

		$instructorsObj->updateReviews($dataPrepared);

		// nukreipiame į markių puslapį
		common::redirect("index.php?module={$module}&action=list");
		die();
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
	}

	if (isset($_POST['ids']) && sizeof($_POST['ids']) > 0) {
        $i = 0;
        foreach($_POST['ids'] as $key => $val) {
            $data['instruktoriaus_atsiliepimai'][$i]['id'] = $val;
            $i++;
        }
    }

    if (isset($_POST['moksleiviai']) && sizeof($_POST['moksleiviai']) > 0) {
        $i = 0;
        foreach($_POST['moksleiviai'] as $key => $val) {
            $data['instruktoriaus_atsiliepimai'][$i]['fk_MOKSLEIVIS_id'] = $val;
            $i++;
        }
    }

    if (isset($_POST['ivertinimai']) && sizeof($_POST['ivertinimai']) > 0) {
        $i = 0;
        foreach($_POST['ivertinimai'] as $key => $val) {
            $data['instruktoriaus_atsiliepimai'][$i]['ivertinimas'] = $val;
            $i++;
        }
    }

    if (isset($_POST['komentarai']) && sizeof($_POST['komentarai']) > 0) {
        $i = 0;
        foreach($_POST['komentarai'] as $key => $val) {
            $data['instruktoriaus_atsiliepimai'][$i]['komentaras'] = $val;
            $i++;
        }
    }

    if (isset($_POST['datos']) && sizeof($_POST['datos']) > 0) {
        $i = 0;
        foreach($_POST['datos'] as $key => $val) {
            $data['instruktoriaus_atsiliepimai'][$i]['data'] = $val;
            $i++;
        }
    }
} else {
	// išrenkame elemento duomenis ir jais užpildome formos laukus.
	$data = $instructorsObj->getInstructor($id);
	$data['instruktoriaus_atsiliepimai'] = $instructorsObj->getReviews($id);
}

// įtraukiame šabloną
include 'templates/instructor_form.tpl.php';

?>