<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li>Sutartys</li>
</ul>
<div id="actions">
<!--	<a href='index.php?module=--><?php //echo $module; ?><!--&action=report_delayed_cars'>Vėluojamų grąžinti automobilių ataskaita</a>-->
<!--	<a href='index.php?module=--><?php //echo $module; ?><!--&action=report'>Sutarčių ataskaita</a>-->
	<a href='index.php?module=<?php echo $module; ?>&action=create'>Nauja sutartis</a>
</div>
<div class="float-clear"></div>

<table class="listTable">
	<tr>
		<th>ID</th>
        <th>Moksleivis</th>
		<th>Tipas</th>
		<th>Pavarų dėžė</th>
		<th>Suma</th>
		<th>Būsena</th>
		<th></th>
	</tr>
	<?php
		// suformuojame lentelę
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['id']}</td>"
                    . "<td>{$val['moksleivio_vardas']} {$val['moksleivio_pavarde']}</td>"
					. "<td>{$val['sutarties_tipas']}</td>"
					. "<td>" . (isset($val['pavaru_deze']) ? $val['pavaru_deze'] : '-') . "</td>"
					. "<td>{$val['suma']} €</td>"
                    . "<td>{$val['sutarties_busena']}</td>"
					. "<td>"
						. "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['id']}\"); return false;' title=''>šalinti</a>&nbsp;"
						. "<a href='index.php?module={$module}&action=edit&id={$val['id']}' title=''>redaguoti</a>"
					. "</td>"
				. "</tr>";
		}
	?>
</table>

<?php
	// įtraukiame puslapių šabloną
	include 'templates/paging.tpl.php';
?>