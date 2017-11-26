<!DOCTYPE html>
<!--
The MIT License

Copyright 2017 Sammy Guergachi <sguergachi at gmail.com>.

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
								<label for="popName"><?php bot_translate("Popular name"); ?></label>
								<input type="text" class="form-control nn" name="popName" id="popName" placeholder="<?php bot_translate("Popular name"); ?>">
							</div>																								
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="order"><?php bot_translate("Order"); ?></label>
								<input type="text" class="form-control" name="order" id="order" placeholder="<?php bot_translate("Order") ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="family"><?php bot_translate("Family"); ?></label>
								<input type="text" class="form-control" name="family" id="order" placeholder="<?php bot_translate("Family") ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="genus"><?php bot_translate("Genus"); ?></label>
								<input type="text" class="form-control" name="genus" id="order" placeholder="<?php bot_translate("Genus") ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="species"><?php bot_translate("Species"); ?></label>
								<input type="text" class="form-control" name="species" id="order" placeholder="<?php bot_translate("Species") ?>">
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
								<input type="text" class="form-control" name="soilHumidity" id="order" placeholder="<?php bot_translate("Soil Humidity") ?>">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="airHumidity"><?php bot_translate("Ai Humidity"); ?></label>
								<input type="text" class="form-control" name="airHumidity" id="order" placeholder="<?php bot_translate("Air Humidity") ?>">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="genus"><?php bot_translate("Air Temperature"); ?></label>
								<input type="text" class="form-control" name="airTemperature" id="order" placeholder="<?php bot_translate("Air Temperature") ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-offset-11" style="width: 100px !important">
							<button type="submit" class="btn btn-submit "><?php bot_translate("Send"); ?><i class="fa fa-send"></i></button>
						</div>
					</div>
				</div>
			</div>
		</form>
	<script>
		init();
		function init() {
			setTimeout(function () {
				$('#cadPlant').on('submit', function(e){
					e.preventDefault();
					$('input').each ( function(index, value){
						if($(value).val() == ''){
							$(value).parents('.form-group').addClass('has-error');
						}
					});
					$.ajax({
						url: 'cadPlantSave',
						data: $('cadPlant').serialize(),
						method: "POST",
						dataType: 'JSON',
						success: function(data){
							
						}
					});
				});
				$('input').each(function(index, value){
					$(value).on('click', function(){
						$(value).parent('.form-group').removeClass('has-error');
					});
				});
			}, 500);			
		};
	</script>
