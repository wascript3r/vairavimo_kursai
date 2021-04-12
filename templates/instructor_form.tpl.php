<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li><a href="index.php?module=<?php echo $module; ?>&action=list">Instruktoriai</a></li>
	<li><?php if(!empty($id)) echo "Instruktoriaus redagavimas"; else echo "Naujas instruktorius"; ?></li>
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
			<legend>Instruktoriaus informacija</legend>
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
            <p>
				<label class="field" for="name">Aprašymas<?php echo in_array('aprasymas', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="name" name="aprasymas" class="textbox textbox-200" value="<?php echo isset($data['aprasymas']) ? $data['aprasymas'] : ''; ?>">
				<?php if(key_exists('aprasymas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['aprasymas']} simb.)</span>"; ?>
			</p>
            <p>
				<label class="field" for="darbo_pradzios_data">Darbo pradžios data<?php echo in_array('darbo_pradzios_data', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="darbo_pradzios_data" name="darbo_pradzios_data" class="textbox date textbox-70" value="<?php echo isset($data['darbo_pradzios_data']) ? $data['darbo_pradzios_data'] : ''; ?>">
			</p>
            <p>
				<label class="field" for="name">Vairavimo stažas<?php echo in_array('vairavimo_stazas', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="name" name="vairavimo_stazas" class="textbox textbox-150" value="<?php echo isset($data['vairavimo_stazas']) ? $data['vairavimo_stazas'] : ''; ?>">
				<?php if(key_exists('vairavimo_stazas', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['vairavimo_stazas']} simb.)</span>"; ?>
			</p>
            <p>
				<label class="field" for="fk_FILIALAS_id">Filialas<?php echo in_array('fk_FILIALAS_id', $required) ? '<span> *</span>' : ''; ?></label>
				<select id="fk_FILIALAS_id" name="fk_FILIALAS_id">
					<option value="">---------------</option>
					<?php
						// išrenkame klientus
						$branches = $branchesObj->getBranchList();
						foreach($branches as $key => $val) {
							$selected = "";
							if(isset($data['fk_FILIALAS_id']) && $data['fk_FILIALAS_id'] == $val['id']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['id']}'>{$val['adresas']}</option>";
						}
					?>
				</select>
			</p>
		</fieldset>

        <fieldset style="width: 115%">
			<legend>Atsiliepimai</legend>
			<div class="childRowContainer">
				<div class="labelLeft<?php if(empty($data['instruktoriaus_atsiliepimai']) || sizeof($data['instruktoriaus_atsiliepimai']) == 0) echo ' hidden'; ?>">Moksleivis</div>
				<div class="labelLeft<?php if(empty($data['instruktoriaus_atsiliepimai']) || sizeof($data['instruktoriaus_atsiliepimai']) == 0) echo ' hidden'; ?>" style="margin-left: 80px;">Įvertinimas</div>
				<div class="labelLeft<?php if(empty($data['instruktoriaus_atsiliepimai']) || sizeof($data['instruktoriaus_atsiliepimai']) == 0) echo ' hidden'; ?>">Komentaras</div>
				<div class="labelLeft<?php if(empty($data['instruktoriaus_atsiliepimai']) || sizeof($data['instruktoriaus_atsiliepimai']) == 0) echo ' hidden'; ?>" style="margin-left: 80px;">Data</div>
				<div class="float-clear"></div>

                <div class="childRow hidden">
                    <select class="elementSelector" name="moksleiviai[]" disabled="disabled">
                        <option value=""></option>
                        <?php
                            $students = $studentsObj->getStudentList();
                            foreach($students as $key => $val) {
                                echo "<option value='{$val['id']}'>{$val['vardas']} {$val['pavarde']}</option>";
                            }
                        ?>
                    </select>
                    <select class="elementSelector" name="ivertinimai[]" disabled="disabled">
                        <option value=""></option>
                        <?php
                            for ($i = 1; $i <= 5; $i++) {
                                echo "<option value='{$i}'>{$i}</option>";
                            }
                        ?>
                    </select>
                    <input type="text" name="komentarai[]" class="textbox textbox-150" value="" disabled="disabled" />
                    <input type="text" name="datos[]" class="textbox datetime textbox-150" value="" disabled="disabled" />
                    <input type="hidden" name="ids[]" value="0" disabled="disabled" />
                    <a href="#" title="" class="removeChild">šalinti</a>
                </div>
                <div class="float-clear"></div>

				<?php
					if (!empty($data['instruktoriaus_atsiliepimai']) && sizeof($data['instruktoriaus_atsiliepimai']) > 0) {
						foreach($data['instruktoriaus_atsiliepimai'] as $key => $val) {
				?>
						<div class="childRow">
                            <select class="elementSelector" name="moksleiviai[]">
                                <option value=""></option>
                                <?php
                                    $students = $studentsObj->getStudentList();
                                    foreach($students as $key2 => $val2) {
                                        $selected = "";
                                        if(isset($val['fk_MOKSLEIVIS_id']) && $val['fk_MOKSLEIVIS_id'] == $val2['id']) {
                                            $selected = " selected='selected'";
                                        }
                                        echo "<option{$selected} value='{$val2['id']}'>{$val2['vardas']} {$val2['pavarde']}</option>";
                                    }
                                ?>
                            </select>
                            <select class="elementSelector" name="ivertinimai[]">
                                <option value=""></option>
                                <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        $selected = "";
                                        if(isset($val['ivertinimas']) && $val['ivertinimas'] == $i) {
                                            $selected = " selected='selected'";
                                        }
                                        echo "<option{$selected} value='{$i}'>{$i}</option>";
                                    }
                                ?>
                            </select>
							<input type="text" name="komentarai[]" class="textbox textbox-150" value="<?php echo isset($val['komentaras']) ? $val['komentaras'] : ''; ?>" />
							<input type="text" name="datos[]" class="textbox datetime textbox-150" value="<?php echo isset($val['data']) ? $val['data'] : ''; ?>" />
                            <input type="hidden" name="ids[]" value="<?php echo $val['id']; ?>" />
                            <?php
                            if (isset($val['id']) && $val['id'] != '0') {
                            ?>
							<a href="#" title="" onclick="showConfirmDialog3('review', '<?= $data['id'] ?>', '<?= $val['id'] ?>')">šalinti</a>
                            <?php
                            } else {
                            ?>
                            <a href="#" title="" class="removeChild">šalinti</a>
                            <?php
                            }
                            ?>
						</div>
						<div class="float-clear"></div>
				<?php
						}
					}
				?>
			</div>
			<p id="newItemButtonContainer">
				<a href="#" title="" class="addChild">Pridėti</a>
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