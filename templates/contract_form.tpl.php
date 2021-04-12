<ul id="pagePath">
	<li><a href="index.php">Pradžia</a></li>
	<li><a href="index.php?module=<?php echo $module; ?>&action=list">Sutartys</a></li>
	<li><?php if(!empty($id)) echo "Sutarties redagavimas"; else echo "Nauja sutartis"; ?></li>
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
			<legend>Sutarties informacija</legend>
            <p>
				<label class="field" for="fk_MOKSLEIVIS_id">Moksleivis<?php echo in_array('fk_MOKSLEIVIS_id', $required) ? '<span> *</span>' : ''; ?></label>
				<select id="fk_MOKSLEIVIS_id" name="fk_MOKSLEIVIS_id">
					<option value="">---------------</option>
					<?php
						$students = $studentsObj->getStudentList();
						foreach($students as $key => $val) {
							$selected = "";
							if(isset($data['fk_MOKSLEIVIS_id']) && $data['fk_MOKSLEIVIS_id'] == $val['id']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['id']}'>{$val['vardas']} {$val['pavarde']}</option>";
						}
					?>
				</select>
			</p>
            <p>
				<label class="field" for="sudarymo_data">Sudarymo data<?php echo in_array('sudarymo_data', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="sudarymo_data" name="sudarymo_data" class="textbox datetime textbox-100" value="<?php echo isset($data['sudarymo_data']) ? $data['sudarymo_data'] : ''; ?>">
			</p>
            <p>
				<label class="field" for="pasirasymo_data">Pasirašymo data<?php echo in_array('pasirasymo_data', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="pasirasymo_data" name="pasirasymo_data" class="textbox datetime textbox-100" value="<?php echo isset($data['pasirasymo_data']) ? $data['pasirasymo_data'] : ''; ?>">
			</p>
            <p>
				<label class="field" for="tipas">Tipas<?php echo in_array('tipas', $required) ? '<span> *</span>' : ''; ?></label>
				<select id="tipas" name="tipas">
					<option value="">---------------</option>
					<?php
						$contractTypes = $contractTypesObj->getContractTypeList();
						foreach($contractTypes as $key => $val) {
							$selected = "";
							if(isset($data['tipas']) && $data['tipas'] == $val['id']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['id']}'>{$val['name']}</option>";
						}
					?>
				</select>
			</p>
            <p>
				<label class="field" for="suma">Suma<?php echo in_array('suma', $required) ? '<span> *</span>' : ''; ?></label>
				<input type="text" id="suma" name="suma" class="textbox textbox-70" value="<?php echo isset($data['suma']) ? $data['suma'] : ''; ?>"> <span class="units">&euro;</span>
			</p>
            <p>
				<label class="field" for="busena">Sutarties būsena<?php echo in_array('busena', $required) ? '<span> *</span>' : ''; ?></label>
				<select id="busena" name="busena">
					<option value="">---------------</option>
					<?php
						$contractStatus = $contractStatusObj->getContractStatusList();
						foreach($contractStatus as $key => $val) {
							$selected = "";
							if(isset($data['busena']) && $data['busena'] == $val['id']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['id']}'>{$val['name']}</option>";
						}
					?>
				</select>
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

		<fieldset>
			<legend>Automobilio informacija</legend>
            <p>
				<label class="field" for="automobilio_pavaru_deze">Automobilio pavarų dėžė<?php echo in_array('automobilio_pavaru_deze', $required) ? '<span> *</span>' : ''; ?></label>
				<select id="automobilio_pavaru_deze" name="automobilio_pavaru_deze">
					<option value="">---------------</option>
					<?php
						$gearBoxes = $gearBoxesObj->getGearBoxList();
						foreach($gearBoxes as $key => $val) {
							$selected = "";
							if(isset($data['automobilio_pavaru_deze']) && $data['automobilio_pavaru_deze'] == $val['id']) {
								$selected = " selected='selected'";
							}
							echo "<option{$selected} value='{$val['id']}'>{$val['name']}</option>";
						}
					?>
				</select>
			</p>
		</fieldset>
		
		<p class="required-note">* pažymėtus laukus užpildyti privaloma</p>
		<p>
			<input type="submit" class="submit button" name="submit" value="Išsaugoti">
		</p>

		<input type="hidden" name="id" value="<?php echo isset($data['id']) ? $data['id'] : ''; ?>" />
	</form>
</div>