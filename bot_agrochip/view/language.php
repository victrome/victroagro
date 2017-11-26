<?php
if (!defined('PROTECT')) {
	exit('NO ACCESS');
}
/*
 * The MIT License
 *
 * Copyright 2017 Jean Victor Mendes dos Santos.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
?>
<style>
	.margin_r {
		margin-right: 4px;
	}</style>
<form id="form_new_edit" style="display:none;">
	<input type="HIDDEN" value="" id="ID">
	<div class="form-group">
		<label for="LANGUAGE"><?php bot_translate("Language"); ?></label>
		<input type="text" class="form-control nn" name="LANGUAGE" id="LANGUAGE" placeholder="<?php bot_translate("Language"); ?>">
	</div>
	<div class="form-group">
		<label for="SHORT_LANGUAGE"><?php bot_translate("Abbreviation"); ?></label>
		<input type="text" class="form-control nn" name="SHORT_LANGUAGE" id="SHORT_LANGUAGE" placeholder="<?php bot_translate("Abbreviation"); ?>">
	</div>
	<input type="button" class="btn btn-warning btn-sm pull-left clean" onclick="clean()" value="<?php bot_translate("Clean"); ?>">
	<input type="button" class="btn btn-success pull-right send" onclick="salvarRegistro(0, 'form_new_edit')" style="display:none; " value="<?php bot_translate("Save"); ?>">
</form>
<div class="row">
	<div class="col-md-12">
		<?php if (count($returned) > 0) { ?>
			<table id="data-table" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>ID</th>
						<th><?php bot_translate('Name'); ?></th>
						<th><?php bot_translate('Abbreviation'); ?></th>
						<th><?php bot_translate('actions'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($returned as $prof) { ?>
						<tr class="odd gradeA">
							<td><?php echo $prof->ID; ?></td>
							<td><?php echo $prof->LANGUAGE; ?></td>
							<td><?php echo $prof->SHORT_LANGUAGE; ?></td>
							<td>
								<button type="button" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></button>
								<button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php
			if ($pags > 1) {
				for ($i = 1; $i <= $pags; $i++) {
					echo "<a class='btn btn-success btn-sm margin_r' href='{$full_b_link_action}/{$i}'>" . $i . "</a>";
				}
			}
		} else {
			echo "<div id='data-table'>";
			bot_translate("Nothing found. Add a new register");
			echo "</div>";
		}
		?>
	</div>
</div>
<script>
	init();
	function init() {
		setTimeout(function () {
			blankInput();
			$(".nn").change(function () {
				blankInput();
			});
			$(".nn").keyup(function () {
				blankInput();
			});
			var headerBox = $('.box-header');
			headerBox.html('<input type="button" class="btn btn-success" id="SHOW" onclick="show_form(0)" value="<?php bot_translate("New"); ?>">');
		}, 500);
	}
	function blankInput() {
		var blank = false;
		$('.nn').each(function () {
			if ($(this).val() == "") {
				blank = true;
			}
		});
		if (blank == false) {
			$('.send').show();
		} else {
			$('.send').hide();
		}
	}
	function show_form(id) {
		var button_new = $('#SHOW');
		var formEN = $('#form_new_edit');
		var table = $('#data-table');
		$('#ID').val(id);
		if (button_new.val() == "<?php bot_translate("New"); ?>") {
			button_new.val('<?php bot_translate("Cancel"); ?>');
			button_new.removeClass('btn-success').addClass('btn-danger');
			//formEN.show();
			formEN.slideDown("slow", function () {
				// Animation complete.
			});
			table.slideUp("slow", function () {
				// Animation complete.
			});
		} else {
			button_new.val('<?php bot_translate("New"); ?>');
			button_new.addClass('btn-success').removeClass('btn-danger');
			//formEN.hide();
			formEN.slideUp("slow", function () {
				// Animation complete.
			});
			table.slideDown("slow", function () {
				// Animation complete.
			});
		}
	}
	function refresh() {
		$.ajax({
			type: "POST",
			url: 'language/2',
			success: function (response) {
				$('.box-body').html(response);
			},
			complete: function () {
			}
		});
	}
	function clean() {
		$('.form-control').each(function () {
			$(this).val('');
		});
	}
	function salvarRegistro(id, cForm) {
		var form = $('#' + cForm);
		$('#ID').val(id);
		$.ajax({
			type: "POST",
			url: 'saveData/',
			data: form.serialize(),
			beforeSend: function () {
				$('.send').val("<?php bot_translate("Saving"); ?>...");
				$('.send').attr("disabled", "disabled");
			},
			success: function (response) {
			},
			complete: function () {
				clean();
				$('.send').val("<?php bot_translate("Save"); ?>");
				$('.send').removeAttr("disabled");
				refresh();
			}
		});
	}
</script>


