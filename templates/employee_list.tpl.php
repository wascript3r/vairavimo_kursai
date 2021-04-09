<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li>Darbuotojai</li>
</ul>
<div id="actions">
	<a href='index.php?module=<?php echo $module; ?>&action=create'>Naujas darbuotojas</a>
</div>
<div class="float-clear"></div>

<?php if(isset($_GET['remove_error'])) { ?>
	<div class="errorBox">
		Klientas nebuvo pašalintas, nes turi užsakymą (-ų).
	</div>
<?php } ?>

<table class="listTable">
	<tr>
		<th>Tabelio nr.</th>
		<th>Vardas</th>
		<th>Pavardė</th>
		<th></th>
	</tr>
	<?php
		// suformuojame lentelę
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['tabelio_nr']}</td>"
					. "<td>{$val['vardas']}</td>"
					. "<td>{$val['pavarde']}</td>"
					. "<td>"
						. "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['tabelio_nr']}\"); return false;' title=''>šalinti</a>&nbsp;"
						. "<a href='index.php?module={$module}&action=edit&id={$val['tabelio_nr']}' title=''>redaguoti</a>"
					. "</td>"
				. "</tr>";
		}
	?>
</table>

<?php
	// įtraukiame puslapių šabloną
	include 'templates/paging.tpl.php';
?>