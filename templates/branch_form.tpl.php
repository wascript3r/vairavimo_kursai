<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li><a href="index.php?module=<?php echo $module; ?>&action=list">Filialai</a></li>
	<li><?php if(!empty($id)) echo "Filialo redagavimas"; else echo "Naujas filialas"; ?></li>
</ul>
<div class="float-clear"></div>
<div id="formContainer">
	<?php if($formErrors != null) { ?>
		<div class="errorBox">
			Neįvesti arba neteisingai įvesti šie laukai:
			<?php 
				echo $formErrors;
			?>
		</div>
	<?php } ?>
	<form action="" method="post">
		<fieldset>
			<legend>Filialo informacija</legend>
			<p>
				<label class="field" for="name">Adresas<?php echo in_array('adresas', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="name" name="adresas" class="textbox textbox-150" value="<?php echo isset($data['adresas']) ? $data['adresas'] : ''; ?>">
				<?php if(key_exists('adresas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['adresas']} simb.)</span>"; ?>
			</p>
            <p>
				<label class="field" for="name">Kontaktinis tel.<?php echo in_array('kontaktinis_tel', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="name" name="kontaktinis_tel" class="textbox textbox-150" value="<?php echo isset($data['kontaktinis_tel']) ? $data['kontaktinis_tel'] : ''; ?>">
				<?php if(key_exists('kontaktinis_tel', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['kontaktinis_tel']} simb.)</span>"; ?>
			</p>
		</fieldset>
		<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>
		<p>
			<input type="submit" class="submit button" name="submit" value="Išsaugoti">
		</p>
		<?php if(isset($data['id'])) { ?>
			<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
		<?php } ?>
	</form>
</div>