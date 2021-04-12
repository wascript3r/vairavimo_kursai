<?php

include 'libraries/branches.class.php';
$branchesObj = new branches();

include 'libraries/gear_boxes.class.php';
$gearBoxesObj = new gearBoxes();

include 'libraries/brands.class.php';
$brandsObj = new brands();

$formErrors = null;
$data = array();

// nustatome privalomus laukus
$required = array('adresas', 'kontaktinis_tel', 'valstybiniai_nr', 'metai', 'ridos', 'isigijimo_datos', 'pavaru_dezes', 'markes');

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
		'kontaktinis_tel' => 'phone',
        'valstybiniai_nr' => 'alfanum',
        'metai' => 'int',
        'ridos' => 'int',
        'isigijimo_datos' => 'date',
        'pavaru_dezes' => 'int',
        'markes' => 'int'
    );

	// sukuriame validatoriaus objektą
	include 'utils/validator.class.php';
	$validator = new validator($validations, $required, $maxLengths);

	if($validator->validate($_POST)) {
		// suformuojame laukų reikšmių masyvą SQL užklausai
		$dataPrepared = $validator->preparePostFieldsForSQL();

		// įrašome naują įrašą
		$newId = $branchesObj->insertBranch($dataPrepared);

		$branchesObj->updateCars($dataPrepared, $newId);

		// nukreipiame į markių puslapį
//		common::redirect("index.php?module={$module}&action=list");
//		die();
	} else {
		// gauname klaidų pranešimą
		$formErrors = $validator->getErrorHTML();
		// gauname įvestus laukus
		$data = $_POST;

		if (isset($_POST['valstybiniai_nr']) && sizeof($_POST['valstybiniai_nr']) > 0) {
			$i = 0;
			foreach($_POST['valstybiniai_nr'] as $key => $val) {
				$data['filialo_automobiliai'][$i]['valstybinis_nr'] = $val;
				$i++;
			}
		}

		if (isset($_POST['metai']) && sizeof($_POST['metai']) > 0) {
			$i = 0;
			foreach($_POST['metai'] as $key => $val) {
				$data['filialo_automobiliai'][$i]['metai'] = $val;
				$i++;
			}
		}

		if (isset($_POST['ridos']) && sizeof($_POST['ridos']) > 0) {
			$i = 0;
			foreach($_POST['ridos'] as $key => $val) {
				$data['filialo_automobiliai'][$i]['rida'] = $val;
				$i++;
			}
		}

		if (isset($_POST['isigijimo_datos']) && sizeof($_POST['isigijimo_datos']) > 0) {
			$i = 0;
			foreach($_POST['isigijimo_datos'] as $key => $val) {
				$data['filialo_automobiliai'][$i]['isigijimo_data'] = $val;
				$i++;
			}
		}

		if (isset($_POST['pavaru_dezes']) && sizeof($_POST['pavaru_dezes']) > 0) {
			$i = 0;
			foreach($_POST['pavaru_dezes'] as $key => $val) {
				$data['filialo_automobiliai'][$i]['pavaru_deze'] = $val;
				$i++;
			}
		}

		if (isset($_POST['markes']) && sizeof($_POST['markes']) > 0) {
			$i = 0;
			foreach($_POST['markes'] as $key => $val) {
				$data['filialo_automobiliai'][$i]['fk_MARKE_id'] = $val;
				$i++;
			}
		}

		if (isset($_POST['insertions']) && sizeof($_POST['insertions']) > 0) {
			$i = 0;
			foreach($_POST['insertions'] as $key => $val) {
				$data['filialo_automobiliai'][$i]['inserted'] = $val;
				$i++;
			}
		}
	}
}

// įtraukiame šabloną
include 'templates/branch_form.tpl.php';

?>