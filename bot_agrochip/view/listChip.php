<?php
if (!defined('PROTECT')) {
	exit('NO ACCESS');
}
$bot_modal_title_new = "New Plant";
$bot_modal_title_edit = "Edit Plant";
$bot_nothing = "Nothing found. add a new register";
$bot_title = "Plants";
$bot_formFunc = "cadPlant";
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
<div class="row">
    <div class="col-md-12">
		<?php if ($bot_dbdata->get_count() > 0) { ?>
			<table id="data-table" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>ID</th>
						<th><?php bot_translate('Local & Progress Plant'); ?></th>
						<th><?php bot_translate('Plant'); ?></th>
						<th><?php bot_translate('Status'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php $bot_list= array(); foreach ($bot_dbdata->get_fetch() as $row) { $bot_list[] = $row->ID; ?>
						<tr class="odd gradeA">
							<td><?php echo $row->ID; ?></td>
							<td><div class="progress">
									  <div class="progress-bar progress-bar-warning progress-bar-striped " id="bar<?php echo $row->ID; ?>" role="progressbar"
									  aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
									    <?php echo $row->LOCAL; ?>
									  </div>
								</div>
							</td>
							<td>
                <select onchange="changeplant(<?php echo $row->ID; ?>, this.value);" class="form-control" id="plant">
                  <?php
                      echo "<option>".bot_translate("Select a plant", 1, true)."</option>";
                      foreach($bot_plant->get_fetch() as $plant){
                        $selected = "";
                        if($row->ID_PLANT == $plant->ID){
                          $selected = "selected";
                        }
                        echo "<option {$selected} value='{$plant->ID}'>{$plant->name}</option>";
                      }
                  ?>
                </select>

              </td>
							<td class="text-center"><div id="status<?php echo $row->ID; ?>" class="loader" style="width: 18px; height: 18px;"></div></td>
						</tr>
					<?php }
          $bot_allChips = " var checkChipsId = [".implode(",", $bot_list)."]";
          ?>
				</tbody>
			</table>
			<?php
			/* if($pags > 1){
					for($i = 1; $i <= $pags; $i++){
							echo "<a class='btn btn-success btn-sm margin_r' href='{$bot_link}/{$i}'>".$i."</a>";
					}
			} */
		} else {
			echo "<div id='data-table'>";
			bot_translate("Nothing found");
			echo "</div>";
		}
		?>
    </div>
</div>
<script>
<?php echo $bot_allChips; ?>;
var timeCheck = 2;
initList();
function initList() {
	setTimeout(function(){
		$.getScript("<?php echo ROBOT_ASSETS; ?>timer.jquery.min.js", function() {
				initCount()
				setInterval(function () {
				  checkChip();
					var seconds = timeCheck * 60000
					setInterval(function() {
					    $('.Timer').text((new Date - start) / 1000 + " Seconds");
					}, 1000);
				}, timeCheck * 60000);
			}, 500);
		});
}
	function initCount(){
		$('.box-header').timer({
			countdown: true,
			 duration: timeCheck+'m',
			 format: '%M <?php bot_translate("minutes"); ?> %s <?php bot_translate("seconds"); ?>'
		});
	}
  function changeplant(id, value1){
    $.ajax({
      url: '<?php echo $bot_link; ?>saveChipPlant',
      data: {"ID_CHIP": id, "ID_PLANT": value1},
      method: "POST",
      success: function(data){

      }
    });
  }
  function checkChip(){
    $.ajax({
      url: '<?php echo $bot_link; ?>checkChips',
      method: "POST",
      success: function(data){
        var returnedData = $.parseJSON(data);
        for(i = 0; i < checkChipsId.length; i++){
					var bar = $("#bar"+checkChipsId[i]);
          if(returnedData[checkChipsId[i]]['ERROR'] == false){
            var returnVars = returnedData[checkChipsId[i]];
            $('#status'+checkChipsId[i]).removeClass();
            $('#status'+checkChipsId[i]).addClass("fa fa-check-circle-o")
						var percent_humity_soil = Math.abs(((parseInt(returnVars['ACTUAL_SOIL']) - parseInt(returnVars['SOIL'])) * 100) / parseInt(returnVars['SOIL']));
						var percent_humity_air = Math.abs(((parseInt(returnVars['ACTUAL_AIR_HUMITY']) - parseInt(returnVars['AIR_HUMITY'])) * 100) / parseInt(returnVars['AIR_HUMITY']));
						var percent_temperature_air = Math.abs(((parseInt(returnVars['ACTUAL_AIR_TEMPERATURE']) - parseInt(returnVars['AIR_TEMPERATURE'])) * 100) / parseInt(returnVars['AIR_TEMPERATURE']));
						var percent_bar = 100- Math.round((percent_humity_soil+percent_humity_air+percent_temperature_air)/3);
						if(percent_bar < 0){
							percent_bar = 0;
						}
						console.log(percent_humity_soil);
						console.log(percent_humity_air);
						console.log(percent_temperature_air);
						console.log(percent_bar);
						bar.addClass("progress-bar-success");
						bar.attr("aria-valuenow", percent_bar);
						bar.attr("style", "width:"+percent_bar+"%; color: #000;");
						bar.removeClass("progress-bar-warning");
						bar.removeClass("progress-bar-danger");
          } else {
            $('#status'+checkChipsId[i]).removeClass();
            $('#status'+checkChipsId[i]).addClass("fa fa-exclamation-triangle")
						bar.removeClass("progress-bar-success");
						bar.attr("aria-valuenow", "100");
						bar.attr("style", "width:100%");
						bar.removeClass("progress-bar-warning");
						bar.addClass("progress-bar-danger");
          }
        }
				$('.box-header').timer('remove');
				initCount();
      }
    });
  }
</script>
