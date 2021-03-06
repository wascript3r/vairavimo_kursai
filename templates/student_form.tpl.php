<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li><a href="index.php?module=<?php echo $module; ?>&action=list">Moksleiviai</a></li>
	<li><?php if(!empty($id)) echo "Moksleivio redagavimas"; else echo "Naujas moksleivis"; ?></li>
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
			<legend>Moksleivio informacija</legend>
			<p>
				<label class="field" for="name">Vardas<?php echo in_array('vardas', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="name" name="vardas" class="textbox textbox-150" value="<?php echo isset($data['vardas']) ? $data['vardas'] : ''; ?>">
				<?php if(key_exists('vardas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['vardas']} simb.)</span>"; ?>
			</p>
            <p>
				<label class="field" for="name">Pavardė<?php echo in_array('pavarde', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="name" name="pavarde" class="textbox textbox-150" value="<?php echo isset($data['pavarde']) ? $data['pavarde'] : ''; ?>">
				<?php if(key_exists('pavarde', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['pavarde']} simb.)</span>"; ?>
			</p>
            <p>
				<label class="field" for="name">El. paštas<?php echo in_array('el_pastas', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="name" name="el_pastas" class="textbox textbox-150" value="<?php echo isset($data['el_pastas']) ? $data['el_pastas'] : ''; ?>">
				<?php if(key_exists('el_pastas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['el_pastas']} simb.)</span>"; ?>
			</p>
            <p>
				<label class="field" for="name">Tel. numeris<?php echo in_array('tel_nr', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="name" name="tel_nr" class="textbox textbox-150" value="<?php echo isset($data['tel_nr']) ? $data['tel_nr'] : ''; ?>">
				<?php if(key_exists('tel_nr', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['tel_nr']} simb.)</span>"; ?>
			</p>
            <p>
				<label class="field" for="name">Adresas<?php echo in_array('adresas', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="name" name="adresas" class="textbox textbox-150" value="<?php echo isset($data['adresas']) ? $data['adresas'] : ''; ?>">
				<?php if(key_exists('adresas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['adresas']} simb.)</span>"; ?>
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