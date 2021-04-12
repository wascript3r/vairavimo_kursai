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

        <fieldset style="width: 115%">
			<legend>Automobiliai</legend>
			<div class="childRowContainer">
				<div class="labelLeft<?php if(empty($data['filialo_automobiliai']) || sizeof($data['filialo_automobiliai']) == 0) echo ' hidden'; ?>">Valstybinis nr.</div>
				<div class="labelLeft<?php if(empty($data['filialo_automobiliai']) || sizeof($data['filialo_automobiliai']) == 0) echo ' hidden'; ?>">Metai</div>
				<div class="labelLeft<?php if(empty($data['filialo_automobiliai']) || sizeof($data['filialo_automobiliai']) == 0) echo ' hidden'; ?>">Rida</div>
				<div class="labelLeft<?php if(empty($data['filialo_automobiliai']) || sizeof($data['filialo_automobiliai']) == 0) echo ' hidden'; ?>">Įsigijimo data</div>
				<div class="labelLeft<?php if(empty($data['filialo_automobiliai']) || sizeof($data['filialo_automobiliai']) == 0) echo ' hidden'; ?>">Pavarų dėžė</div>
				<div class="labelLeft<?php if(empty($data['filialo_automobiliai']) || sizeof($data['filialo_automobiliai']) == 0) echo ' hidden'; ?>">Markė</div>
				<div class="float-clear"></div>

                <div class="childRow hidden">
                    <input type="text" name="valstybiniai_nr[]" class="textbox textbox-70" value="" disabled="disabled" />
                    <input type="text" name="metai[]" class="textbox textbox-30" value="" disabled="disabled" />
                    <input type="text" name="ridos[]" class="textbox textbox-70" value="" disabled="disabled" />
                    <input type="text" name="isigijimo_datos[]" class="textbox date textbox-70" value="" disabled="disabled" />
                    <select class="elementSelector" name="pavaru_dezes[]" disabled="disabled">
                        <?php
                            $gearBoxes = $gearBoxesObj->getGearBoxList();
                            foreach($gearBoxes as $key => $val) {
                                echo "<option value='{$val['id']}'>{$val['name']}</option>";
                            }
                        ?>
                    </select>
                    <select class="elementSelector" name="markes[]" disabled="disabled">
                        <?php
                            $brands = $brandsObj->getBrandList();
                            foreach($brands as $key => $val) {
                                echo "<option value='{$val['id']}'>{$val['pavadinimas']}</option>";
                            }
                        ?>
                    </select>
                    <input type="hidden" name="insertions[]" value="0" disabled="disabled" />
                    <a href="#" title="" class="removeChild">šalinti</a>
                </div>
                <div class="float-clear"></div>

				<?php
					if (!empty($data['filialo_automobiliai']) && sizeof($data['filialo_automobiliai']) > 0) {
						foreach($data['filialo_automobiliai'] as $key => $val) {
				?>
						<div class="childRow">
							<input type="text" name="valstybiniai_nr[]" class="textbox textbox-70" value="<?php echo isset($val['valstybinis_nr']) ? $val['valstybinis_nr'] : ''; ?>" <?= ($val['inserted'] == '1') ? 'readonly' : '' ?> />
							<input type="text" name="metai[]" class="textbox textbox-30" value="<?php echo isset($val['metai']) ? $val['metai'] : ''; ?>" />
							<input type="text" name="ridos[]" class="textbox textbox-70" value="<?php echo isset($val['rida']) ? $val['rida'] : ''; ?>" />
							<input type="text" name="isigijimo_datos[]" class="textbox date textbox-70" value="<?php echo isset($val['isigijimo_data']) ? $val['isigijimo_data'] : ''; ?>" />
                            <select class="elementSelector" name="pavaru_dezes[]">
                                <?php
                                    $gearBoxes = $gearBoxesObj->getGearBoxList();
                                    foreach($gearBoxes as $key2 => $val2) {
                                        $selected = "";
                                        if(isset($val['pavaru_deze']) && $val['pavaru_deze'] == $val2['id']) {
                                            $selected = " selected='selected'";
                                        }
                                        echo "<option{$selected} value='{$val2['id']}'>{$val2['name']}</option>";
                                    }
                                ?>
                            </select>
                            <select class="elementSelector" name="markes[]">
							<?php
                                $brands = $brandsObj->getBrandList();
                                foreach($brands as $key2 => $val2) {
                                    $selected = "";
                                    if(isset($val['fk_MARKE_id']) && $val['fk_MARKE_id'] == $val2['id']) {
                                        $selected = " selected='selected'";
                                    }
                                    echo "<option{$selected} value='{$val2['id']}'>{$val2['pavadinimas']}</option>";
                                }
                            ?>
						</select>
                        <input type="hidden" name="insertions[]" value="<?php echo $val['inserted']; ?>" />
                            <?php
                            if (isset($val['inserted']) && $val['inserted'] == '1') {
                            ?>
							<a href="#" title="" onclick="showConfirmDialog2('car', '<?= $data['id'] ?>', '<?= $val['valstybinis_nr'] ?>')">šalinti</a>
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