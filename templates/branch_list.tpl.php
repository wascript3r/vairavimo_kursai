<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li>Filialai</li>
</ul>
<div id="actions">
	<a href='index.php?module=<?php echo $module; ?>&action=create'>Naujas filialas</a>
</div>
<div class="float-clear"></div>

<?php if(isset($_GET['remove_error1'])) { ?>
	<div class="errorBox">
		Filialas nebuvo pašalintas. Pirmiausia pašalinkite filialo automobilius.
	</div>
<?php } ?>

<?php if(isset($_GET['remove_error2'])) { ?>
	<div class="errorBox">
		Filialas nebuvo pašalintas. Pirmiausia pašalinkite filialo instruktorius.
	</div>
<?php } ?>

<?php if(isset($_GET['remove_error3'])) { ?>
	<div class="errorBox">
		Filialas nebuvo pašalintas. Pirmiausia pašalinkite filialo sutartis.
	</div>
<?php } ?>

<table class="listTable">
	<tr>
		<th>ID</th>
		<th>Adresas</th>
		<th>Kontaktinis tel.</th>
		<th></th>
	</tr>
	<?php
		// suformuojame lentelę
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['id']}</td>"
					. "<td>{$val['adresas']}</td>"
					. "<td>{$val['kontaktinis_tel']}</td>"
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