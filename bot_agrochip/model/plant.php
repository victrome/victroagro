<?php

class plant extends model_robot {
	public function selectChip(){
		$this->select("*");
		$this->from("victro_addon");
		$this->where("deleted = 0");
		$bot_query2 = $this->db_select();

		foreach($bot_query2->get_fetch() as $chip){
			$this->select("ID");
			$this->from("bot_chip_plant");
			$this->where("ID_CHIP = {$chip->ID}");
			$this->where("deleted = 0");
			$bot_query3 = $this->db_select();
			if($bot_query3->get_count() == 0){
				$bot_insert['ID_CHIP'] = $chip->ID;
				$bot_insert['ID_PLANT'] = 0;
				$bot_insert['deleted'] = 0;
				$this->db_insert("bot_chip_plant", $bot_insert);
			}
		}
		$this->select("VIC.*, BOT.ID_PLANT, BOT.ID as ID, BOT.ID_CHIP");
		$this->from("victro_addon VIC");
		$this->left_join("bot_chip_plant BOT", "VIC.ID = BOT.ID_CHIP");
		$this->where("VIC.deleted = 0 and BOT.deleted = 0");
		$bot_query = $this->db_select();
		return($bot_query);
	}
	public function selectPlant(){
		$this->select("*");
		$this->from("bot_agro");
		$this->where("deleted = 0");
		$bot_query = $this->db_select();
		return($bot_query);
	}
	public function insertChipPlant($bot_insert){
		$this->where("ID_CHIP = {$bot_insert['ID_CHIP']}");
		$this->db_update("bot_chip_plant", $bot_insert);
	}
	public function selectPlantChip(){
		$this->select("BOT.ID as ID_BACK, BOT.ID_CHIP, AGR.*");
		$this->from("bot_chip_plant BOT");
		$this->left_join("bot_agro AGR", "AGR.ID = BOT.ID_PLANT");
		$this->where("AGR.deleted = 0 and BOT.deleted = 0 and BOT.ID_PLANT > 0");
		$bot_query = $this->db_select();
		return $bot_query;
	}
	public function insertHist($values){
		return $this->db_insert("bot_chip_plant_hist", $values);
	}
}

?>
