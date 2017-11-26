<!DOCTYPE html>
<!--
The MIT License

Copyright 2017

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
-->
	<style>
		.header-line{
			border-top-color: #23527c !important;
			border-top: 2px solid;
			position: relative;
			border-radius: 0;
			padding-bottom: 20px;
			padding-top: 10px;
			margin-top: 10px;
		}
	</style>
		<form id="cadPlant">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-7">
							<div class="form-group">
								<label for="name"><?php bot_translate("Popular name"); ?></label>
								<input type="text" class="form-control nn" name="name" id="name" placeholder="<?php bot_translate("Popular name"); ?>" value="<?php echo isset($bot_dataEdit) ? $bot_dataEdit->name : '';?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="family"><?php bot_translate("Family"); ?></label>
								<select class="form-control nn" name="family" id="family" placeholder="<?php bot_translate("Family") ?>">
									<?php
										foreach($bot_family as $bot_famVar){
											$bot_selected = "";
											if(isset($bot_dataEdit) && $bot_dataEdit->family == $bot_famVar->ID){
												$bot_selected = "selected";
											}
											echo "<option {$bot_selected} value='{$bot_famVar->ID}'>{$bot_famVar->name_family}</option>";
										}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="genus"><?php bot_translate("Genus"); ?></label>
								<input type="text" class="form-control nn" name="genus" id="genus" placeholder="<?php bot_translate("Genus") ?>" value="<?php echo isset($bot_dataEdit) ? $bot_dataEdit->genus : '';?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="species"><?php bot_translate("Species"); ?></label>
								<input type="text" class="form-control nn" name="species" id="species" placeholder="<?php bot_translate("Species") ?>" value="<?php echo isset($bot_dataEdit) ? $bot_dataEdit->species : '';?>">
							</div>
						</div>
					</div>
					<div class="with-border header-line">
						<h4>Informations</h4>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="soilHumidity"><?php bot_translate("Soil Humidity"); ?></label>
								<input type="text" class="form-control nn" name="soilHumidity" id="soilHumidity" placeholder="<?php bot_translate("Soil Humidity") ?>" value="<?php echo isset($bot_dataEdit) ? $bot_dataEdit->soil_humidity : '';?>">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="airHumidity"><?php bot_translate("Air Humidity"); ?></label>
								<input type="text" class="form-control nn" name="airHumidity" id="airHumidity" placeholder="<?php bot_translate("Air Humidity") ?>" value="<?php echo isset($bot_dataEdit) ? $bot_dataEdit->air_humidity : '';?>">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="airTemperature"><?php bot_translate("Air Temperature"); ?></label>
								<input type="text" class="form-control nn" name="airTemperature" id="airTemperature" placeholder="<?php bot_translate("Air Temperature") ?>" value="<?php echo isset($bot_dataEdit) ? $bot_dataEdit->air_temperature : '';?>">
							</div>
						</div>
					</div>

					<?php
						if(isset($bot_dataEdit)){
							echo "<input type='hidden' value='{$bot_dataEdit->ID}' name='id'>";
						} else {
							echo "<input type='hidden' value='0' name='id'>";
						} ?>
					<div class="row">
						<div class="pull-right" style="margin-right: 15px !important">
							<button type="button" class="btn btn-submit " onclick="salvar()"><?php bot_translate("Send"); ?> <i class="fa fa-send"></i></button>
						</div>
					</div>
				</div>
			</div>
		</form>
	<script>
		function salvar(){
			var error = false;
			var i = 0;
			var inputclass = '.nn';
			var inputCount = $(inputclass).length;
			$(inputclass).each(function(){
				if($(this).val() == ''){
					$(this).parent('.form-group').addClass('has-error');
					i++;
					console.log(this);
				} else {
					$(this).parent('.form-group').removeClass('has-error');
				}
			});
			if(i > 0){
				error = true;
			}
			if(!error){
				$( ".close" ).trigger( "click" );
				$.ajax({
					url: '<?php echo $bot_link; ?>cadPlantSave',
					data: $('#cadPlant').serialize(),
					method: "POST",
					success: function(data){
						refresh();
						$(inputclass).each(function(){
							if($(this).parent('.form-group').hasClass('has-error')){
								$(this).parent('.form-group').removeClass('has-error');
							}
							$(this).parent('.form-group').addClass('active');
						});

					}
				});
			}
		}
	</script>
