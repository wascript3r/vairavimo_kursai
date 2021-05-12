<ul id="reportInfo">
	<li class="title">Sudarytų sutarčių ataskaita</li>
	<li>Sudarymo data: <span><?php echo date("Y-m-d"); ?></span></li>
	<li style="margin-top: 5px;">Sutarčių sudarymo laikotarpis:
		<span>
		<?php
			if(!empty($data['dataNuo'])) {
				if(!empty($data['dataIki'])) {
					echo "nuo {$data['dataNuo']} iki {$data['dataIki']}";
				} else {
					echo "nuo {$data['dataNuo']}";
				}
			} else {
				if(!empty($data['dataIki'])) {
					echo "iki {$data['dataIki']}";
				} else {
					echo "nenurodyta";
				}
			}
		?>
		</span>
	</li>
    <li style="margin-top: 5px;">Sutarties tipas:
		<span>
		<?php
			if (!empty($data['tipas'])) {
				$contractTypes = $contractTypesObj->getContractTypeList();
                foreach ($contractTypes as $key => $val) {
                    if ($val['id'] == $data['tipas']) {
                        echo $val['name'];
                        break;
                    }
                }
			} else {
				echo "nenurodyta";
			}
		?>
		</span>
	</li>
    <li style="margin-top: 5px;">Sutarties būsena:
		<span>
		<?php
			if (!empty($data['busena'])) {
				$contractStatuses = [
                    1 => 'apmokėta',
                    2 => 'neapmokėta'
                ];
                foreach ($contractStatuses as $key => $val) {
                    if ($key == $data['busena']) {
                        echo $val;
                        break;
                    }
                }
			} else {
				echo "nenurodyta";
			}
		?>
		</span>
	</li>
</ul>



<?php
	if(sizeof($contractData) > 1) { ?>
		<table class="reportTable">
			<tr>
				<th>Sutartis</th>
				<th>Sudarymo data</th>
				<th>Pasirašymo data</th>
				<th>Tipas</th>
				<th>Būsena</th>
				<th class="width150">Sudarytų sutarčių vertė</th>
			</tr>

			<?php
				// suformuojame lentelę
				for($i = 1; $i < sizeof($contractData); $i++) {
					
					if($i == 1 || $contractData[$i]['moksleivio_id'] != $contractData[$i-1]['moksleivio_id']) {
						echo
							  "<tr>"
								. "<td class='groupSeparator' colspan='6'>{$contractData[$i]['moksleivis']}</td>"
							. "</tr>";
					}

					echo
						"<tr>"
							. "<td>#{$contractData[$i]['sutarties_id']}</td>"
							. "<td>{$contractData[$i]['sudarymo_data']}</td>"
							. "<td>{$contractData[$i]['pasirasymo_data']}</td>"
							. "<td>{$contractData[$i]['tipas']}</td>"
							. "<td>{$contractData[$i]['busena']}</td>"
							. "<td>{$contractData[$i]['suma']} &euro;</td>"
						. "</tr>";
					if($i == (sizeof($contractData) - 1) || $contractData[$i]['moksleivio_id'] != $contractData[$i+1]['moksleivio_id']) {
					    $style1 = ($contractData[$i]['instruktorius'] == 'dar nepasirinktas') ? ' font-weight: initial; font-style: italic;' : '';
					    $style2 = ($contractData[$i]['ivertinimu_vidurkis'] == 'nėra duomenų') ? ' font-weight: initial; font-style: italic;' : '';

					    if ($contractData[$i]['ivertinimu_vidurkis'] != 'nėra duomenų') {
					        $contractData[$i]['ivertinimu_vidurkis'] .= "&starf;";
                        }

						echo 
							"<tr><td colspan='6'><hr></td></tr><tr class='aggregate'>"
								. "<td colspan='3' style='text-align: right;'>"
                                . "Pasirinktas instruktorius:<br>"
                                . "Moksleivio paliktų atsiliepimų įvertinimų vidurkis:</td>"
								. "<td colspan='2' style='text-align: left;'>"
                                . "<span style='{$style1}'>{$contractData[$i]['instruktorius']}</span><br>"
                                . "<span style='{$style2}'>{$contractData[$i]['ivertinimu_vidurkis']}</span></td>"
								. "<td class='border'>{$contractData[$i]['kainu_suma']} &euro;<br>(sutarčių kiekis: {$contractData[$i]['sutarciu_kiekis']})</td>"
							. "</tr><tr><td colspan='6'><br></td></tr>";
					}
				}
			?>
			

		  	<tr>
				<td class='groupSeparator' colspan='6'>Bendra suma</td>
			</tr>

            <?php
                $style3 = ($contractData[0]['ivertinimu_vidurkis'] == 'nėra duomenų') ? ' font-weight: initial; font-style: italic;' : '';

                if ($contractData[0]['ivertinimu_vidurkis'] != 'nėra duomenų') {
                    $contractData[0]['ivertinimu_vidurkis'] .= "&starf;";
                }

                echo
                    "<tr class='aggregate'>"
                        . "<td colspan='3' style='text-align: right;'>"
                        . "Moksleivių paliktų atsiliepimų įvertinimų vidurkis:</td>"
                        . "<td colspan='2' style='text-align: left;'>"
                        . "<span style='{$style3}'>{$contractData[0]['ivertinimu_vidurkis']}</span></td>"
                        . "<td class='border'>{$contractData[0]['kainu_suma']} &euro;<br>(sutarčių kiekis: {$contractData[0]['sutarciu_kiekis']})</td>"
                    . "</tr>";
            ?>
		</table>
		<a href="index.php?module=contract&action=report" title="Nauja ataskaita" style="margin-bottom: 15px" class="button large float-right">nauja ataskaita</a>
<?php   
	} else {
?>
		<div class="warningBox">
			Pagal nustatytus kriterijus sutarčių nerasta.
		</div>
<?php
	}
?>