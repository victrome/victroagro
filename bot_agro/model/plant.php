<?php

class plant extends model_robot {
	public function insertPlant($values) {
		$query = $this->db_insert("bot_agro", $values); 
		return($query);
	}
	public function insertClass($values) {
		$query = $this->db_insert("bot_agro_cad_class", $values); 
		return($query);
	}
	public function insertOrder($values) {
		$query = $this->db_insert("bot_agro_cad_order", $values); 
		return($query);
	}
	public function insertFamily($values) {
		$query = $this->db_insert("bot_agro_cad_family", $values); 
		return($query);
	}
	public function updatePlant($id, $values) {
		$this->where("ID = {$id}");
		$query = $this->db_update("bot_agro", $values, true); 
		return($query);
	}
	public function updateClass($id, $values) {
		$this->where("ID = {$id}");
		$query = $this->db_update("bot_agro_cad_class", $values, true); 
		return($query);
	}
	public function updateOrder($id, $values) {
		$this->where("ID = {$id}");
		$query = $this->db_update("bot_agro_cad_order", $values, true); 
		return($query);
	}
	public function updateFamily($id, $values) {
		$this->where("ID = {$id}");
		$query = $this->db_update("bot_agro_cad_family", $values, true); 
		return($query);
	}
	public function selectFamily_plant(){
		$this->select("ID");
		$this->select("name_family");
		$this->from("bot_agro_cad_family");
		$this->where("deleted = 0");
		$bot_query = $this->db_select();
		return($bot_query);
	}
	public function selectClass_order(){
		$this->select("ID");
		$this->select("name_class");
		$this->from("bot_agro_cad_class");
		$this->where("deleted = 0");
		$bot_query = $this->db_select();
		return($bot_query);
	}
	public function selectOrder_family(){
		$this->select("ID");
		$this->select("name_order");
		$this->from("bot_agro_cad_order");
		$this->where("deleted = 0");
		$bot_query = $this->db_select();
		return($bot_query);
	}
	public function selectPlant(){
		$this->select("*, bot_agro.ID as ID");
		$this->from("bot_agro");
		$this->left_join("bot_agro_cad_family", "bot_agro_cad_family.ID = bot_agro.family");
		$this->left_join("bot_agro_cad_order", "bot_agro_cad_order.ID = bot_agro_cad_family.id_order");
		$this->left_join("bot_agro_cad_class", "bot_agro_cad_class.ID = bot_agro_cad_order.id_class");
		$this->where("bot_agro.deleted = 0");
		$this->orderby("bot_agro.ID");
		$bot_query = $this->db_select();
		return($bot_query);
	}
	public function selectClass(){
		$this->select("*");
		$this->from("bot_agro_cad_class");
		$this->where("deleted = 0");
		$this->orderby("ID");
		$bot_query = $this->db_select();
		return($bot_query);
	}
	public function selectOrder(){
		$this->select("bot_agro_cad_order.*");
		$this->select("bot_agro_cad_class.name_class");
		$this->from("bot_agro_cad_order");
		$this->left_join("bot_agro_cad_class", "bot_agro_cad_class.ID = bot_agro_cad_order.id_class");
		$this->where("bot_agro_cad_order.deleted = 0");
		$this->orderby("bot_agro_cad_order.ID");
		$bot_query = $this->db_select();
		return($bot_query);
	}
	public function selectFamily(){
		$this->select("bot_agro_cad_family.*");
		$this->select("bot_agro_cad_order.name_order");
		$this->from("bot_agro_cad_family");
		$this->left_join("bot_agro_cad_order", "bot_agro_cad_order.ID = bot_agro_cad_family.id_order");
		$this->where("bot_agro_cad_family.deleted = 0");
		$this->orderby("bot_agro_cad_family.ID");
		$bot_query = $this->db_select();
		return($bot_query);
	}
	public function selectPlantUnique($id){
		$this->select("*");
		$this->from("bot_agro");
		$this->where("deleted = 0");
		$this->where("ID = {$id}");
		$bot_query = $this->db_select();
		return($bot_query);
	}
	public function selectClassUnique($id){
		$this->select("*");
		$this->from("bot_agro_cad_class");
		$this->where("deleted = 0");
		$this->where("ID = {$id}");
		$bot_query = $this->db_select();
		return($bot_query);
	}
	public function selectOrderUnique($id){
		$this->select("*");
		$this->from("bot_agro_cad_order");
		$this->where("deleted = 0");
		$this->where("ID = {$id}");
		$bot_query = $this->db_select();
		return($bot_query);
	}
	public function selectFamilyUnique($id){
		$this->select("*");
		$this->from("bot_agro_cad_family");
		$this->where("deleted = 0");
		$this->where("ID = {$id}");
		$bot_query = $this->db_select();
		return($bot_query);
	}
}

?>