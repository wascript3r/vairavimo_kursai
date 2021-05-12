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
			<legend>Įveskite ataskaitos kriterijus</legend>
			<p><label class="field" for="dataNuo">Laikotarpis nuo</label><input type="text" id="dataNuo" name="dataNuo" class="textbox textbox-100 date" value="<?php echo isset($fields['dataNuo']) ? $fields['dataNuo'] : ''; ?>" /></p>
			<p><label class="field" for="dataIki">Laikotarpis iki</label><input type="text" id="dataIki" name="dataIki" class="textbox textbox-100 date" value="<?php echo isset($fields['dataIki']) ? $fields['dataIki'] : ''; ?>" /></p>
            <p>
                <label class="field" for="tipas">Sutarties tipas</label>
				<select id="tipas" name="tipas">
					<option value="">---------------</option>
					<?php
						$contractTypes = $contractTypesObj->getContractTypeList();
						foreach($contractTypes as $key => $val) {
							echo "<option value='{$val['id']}'>{$val['name']}</option>";
						}
					?>
				</select>
            </p>
            <p>
                <label class="field" for="tipas">Sutarties būsena</label>
				<select id="busena" name="busena">
					<option value="">---------------</option>
					<option value='1'>apmokėta</option>
					<option value='2'>neapmokėta</option>
				</select>
            </p>
		</fieldset>
		<p><input type="submit" class="submit button float-right" name="submit" value="Sudaryti ataskaitą"></p>
	</form>
</div>