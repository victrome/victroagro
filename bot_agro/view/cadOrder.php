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
		<form id="cadOrder">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="order_p"><?php bot_translate("Order"); ?></label>
								<input type="text" class="form-control" name="order_p" id="order_p" placeholder="<?php bot_translate("Order") ?>" value="<?php echo isset($bot_dataEdit) ? $bot_dataEdit->name_order : '';?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="class"><?php bot_translate("Class"); ?></label>
								<select class="form-control nn" name="class" id="class" placeholder="<?php bot_translate("Class") ?>">
									<?php
										foreach($bot_classes as $bot_classVar){
											$bot_selected = "";
											if(isset($bot_dataEdit) && $bot_dataEdit->id_class == $bot_classVar->ID){
												$bot_selected = "selected";

											}
											echo "<option {$bot_selected} value='{$bot_classVar->ID}'>{$bot_classVar->name_class}</option>";
										}
									?>
								</select>
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
				$.ajax({
					url: '<?php echo $bot_link; ?>cadOrderSave',
					data: $('#cadOrder').serialize(),
					method: "POST",
					success: function(data){
						$('.modal').modal('hide');
						refresh();
						$('.modal').modal('hide');
						$('.modal-backdrop').hide();
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
