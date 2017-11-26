<?php
if (!defined('PROTECT')) {
	exit('NO ACCESS');
}
$bot_modal_title_new = "New Class";
$bot_modal_title_edit = "Edit Class";
$bot_nothing = "Nothing found. add a new register";
$bot_title = "Classes";
$bot_formFunc = "cadClass";
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
//plugincss_include('datatables/jquery.dataTables_themeroller.css');
?>
<style>
	.margin_r {
		margin-right: 4px;
	}</style>
<div class="row">
    <div class="col-md-12">
		<?php if ($bot_dbdata->get_count() > 0) { ?>
			<table id="tabClass" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>ID</th>
						<th><?php bot_translate('Name'); ?></th>
						<th><?php bot_translate('actions'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($bot_dbdata->get_fetch() as $row) { ?>
						<tr class="odd gradeA">
							<td><?php echo $row->ID; ?></td>
							<td><?php echo $row->name_class; ?></td>
							<td>
								<button type="button" data-toggle="modal" data-target="#modal-default" onclick="show_form(<?php echo $row->ID; ?>)" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></button>
								<button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php
			
		} else {
			echo "<div id='data-table'>";
			bot_translate("Nothing found. Add a new register");
			echo "</div>";
		}
		?>
    </div>
</div>
<div class="modal fade" id="modal-default" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
                <h4 class="modal-title botagro"></h4>
			</div>
			<div class="modal-body botagro">
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<script>
	initList();
	function initList() {
		setTimeout(function () {
			var headerBox = $('.box-header');
			headerBox.html('<input type="button" data-toggle="modal" data-target="#modal-default" class="btn btn-success pull-left" id="SHOW" onclick="show_form(0)" value="<?php bot_translate("New"); ?>"><center><B><?php bot_translate($bot_title); ?></b></center>');

			<?PHP load_plugin('datatables/jquery.dataTables.js','dataTab()'); ?>
		}, 800);
	}
	function dataTab(){
		$("#tabClass").DataTable({
			'dom': 'ftr',
			'order': ['1','asc']
		});
	}

	function show_form(id) {
		if (id > 0) {
			$('.modal-title.botagro').html("<?php bot_translate($bot_modal_title_edit) ?>");
		} else {
			$('.modal-title.botagro').html("<?php bot_translate($bot_modal_title_new) ?>");
		}
		$.ajax({
			type: "POST",
			url: '<?php echo $bot_link . $bot_formFunc; ?>/' + id,
			beforeSend: function () {
				$('.modal-body.botagro').html("<?php bot_translate("Loading"); ?>...");
			},
			success: function (response) {
				$('.modal-body.botagro').html(response);
			},
			complete: function () {

			}
		});
	}
	function refresh() {
		$.ajax({
			type: "POST",
			url: '<?php echo $bot_link . $bot_action . "/" . $bot_pag; ?>/2',
			success: function (response) {
				$('.box-body').html(response);
			},
			complete: function () {
			}
		});
	}
</script>
