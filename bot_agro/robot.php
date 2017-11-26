<?php

class BotAgro extends controller_robot {
	public function __construct() {
		$this->language("");
    }
	public function cadPlantSave(){
		$bot_data = $this->global_robot();
		$bot_model = $this->model("plant"); // carrego o model na variavel

		//dados tab banco
		$id = $this->input("id");
		$name_plant = $this->input("name");
		$family_plant = $this->input("family");
		$genus_plant = $this->input("genus");
		$species_plant = $this->input("species");
		$soilHumidity_plant = $this->input("soilHumidity");
		$airHumidity_plant = $this->input("airHumidity");
		$airTemperature_plant = $this->input("airTemperature");

		$bot_insert['name'] = $name_plant;
		$bot_insert['family'] = $family_plant;
		$bot_insert['genus'] = $genus_plant;
		$bot_insert['species'] = $species_plant;
		$bot_insert['soil_humidity'] = $soilHumidity_plant;
		$bot_insert['air_humidity'] = $airHumidity_plant;
		$bot_insert['air_temperature'] = $airTemperature_plant;
		$bot_insert['deleted'] = 0;
		if($id == 0){
			$bot_model->insertPlant($bot_insert); // aqui voce chama pela sua função do model, inserindo os dados que voce passou
		} else {
			$bot_model->updatePlant($id, $bot_insert);
		}
	}

	public function cadClassSave(){

		$bot_data = $this->global_robot();
		$bot_model = $this->model("plant");

		$id = $this->input("id");
		$name_class = $this->input("class");
		$bot_insert['name_class'] = $name_class;
		$bot_insert['deleted'] = 0;

		if($id == 0){
			$bot_model->insertClass($bot_insert); // aqui voce chama pela sua função do model, inserindo os dados que voce passou
		} else {
			$bot_model->updateClass($id, $bot_insert);
		}

	}

	public function cadOrderSave(){

		$bot_data = $this->global_robot();
		$bot_model = $this->model("plant");

		$id = $this->input("id");
		$name_order = $this->input("order_p");
		$id_class = $this->input("class");
		$bot_insert['name_order'] = $name_order;
		$bot_insert['id_class'] = $id_class;
		$bot_insert['deleted'] = 0;

		if($id == 0){
			$bot_model->insertOrder($bot_insert); // aqui voce chama pela sua função do model, inserindo os dados que voce passou
		} else {
			$bot_model->updateOrder($id, $bot_insert);
		}
	}

	public function cadFamilySave(){

		$bot_data = $this->global_robot();
		$bot_model = $this->model("plant");

		$id = $this->input("id");
		$name_family = $this->input("family");
		$id_order = $this->input("order_p");
		$id_class = $this->input("class");
		$bot_insert['name_family'] = $name_family;
		$bot_insert['id_order'] = $id_order;
		$bot_insert['deleted'] = 0;

		if($id == 0){
			$bot_model->insertFamily($bot_insert); // aqui voce chama pela sua função do model, inserindo os dados que voce passou
		} else {
			$bot_model->updateFamily($id, $bot_insert);
		}
	}

	public function cadPlant($id) {
		$bot_data = $this->global_robot();
		$bot_model = $this->model("plant");
		$bot_family = $bot_model->selectFamily_plant();
		$bot_dataView['bot_family'] = $bot_family->get_fetch();
		$bot_dataView['bot_link'] = $bot_data['full_b_link'];
		if($id > 0){
			$bot_edit = $bot_model->selectPlantUnique($id);
			$bot_dataView['bot_dataEdit'] = $bot_edit->get_row();
		}
		$this->view('cadPlant', $bot_dataView);
	}

	public function cadClass($id) {
		$bot_data = $this->global_robot();
		$bot_model = $this->model("plant");
		$bot_dataView['bot_link'] = $bot_data['full_b_link'];
		if($id > 0){
			$bot_edit = $bot_model->selectClassUnique($id);
			$bot_dataView['bot_dataEdit'] = $bot_edit->get_row();
		}
		$this->view('cadClass', $bot_dataView);
	}

	public function cadOrder($id) {
		$bot_data = $this->global_robot();
		$bot_model = $this->model("plant");
		$bot_classes = $bot_model->selectClass_order();
		$bot_dataView['bot_classes'] = $bot_classes->get_fetch();
		$bot_dataView['bot_link'] = $bot_data['full_b_link'];
		if($id > 0){
			$bot_edit = $bot_model->selectOrderUnique($id);
			$bot_dataView['bot_dataEdit'] = $bot_edit->get_row();
		}
		$this->view('cadOrder', $bot_dataView);
	}

	public function cadFamily($id) {
		$bot_data = $this->global_robot();
		$bot_model = $this->model("plant");

		$bot_order = $bot_model->selectOrder_family();
		$bot_dataView['bot_order'] = $bot_order->get_fetch();
		$bot_dataView['bot_link'] = $bot_data['full_b_link'];
		if($id > 0){
			$bot_edit = $bot_model->selectFamilyUnique($id);
			$bot_dataView['bot_dataEdit'] = $bot_edit->get_row();
		}
		$this->view('cadFamily', $bot_dataView);
	}
	public function listplant($pag = 1, $modo = 1){
		$bot_data = $this->global_robot();
		$bot_model = $this->model("plant");
		$bot_dataView['bot_dbdata'] = $bot_model->selectPlant();
		$bot_dataView['bot_link'] = $bot_data['full_b_link'];
		$bot_dataView['bot_pag'] = $pag;
		$bot_dataView['bot_action'] = $bot_data['action'];
		/*
		$modo:	1 para carregar o design do sistema (chamado a primeira vez)
				2 para carregar sem design do sistema (chamado para atualizar a pagina via ajax)
		 */
		if($modo == 1){
			$this->system_view('listPlant', $bot_dataView);
		} else {
			$this->view('listPlant', $bot_dataView);
		}
	}
	public function listclass($pag = 1, $modo = 1){
		$bot_data = $this->global_robot();
		$bot_model = $this->model("plant");
		$bot_dataView['bot_dbdata'] = $bot_model->selectClass();
		$bot_dataView['bot_link'] = $bot_data['full_b_link'];
		$bot_dataView['bot_pag'] = $pag;
		$bot_dataView['bot_action'] = $bot_data['action'];
		/*
		$modo:	1 para carregar o design do sistema (chamado a primeira vez)
				2 para carregar sem design do sistema (chamado para atualizar a pagina via ajax)
		 */
		if($modo == 1){
			$this->system_view('listClass', $bot_dataView);
		} else {
			$this->view('listClass', $bot_dataView);
		}
	}
	public function listorder($pag = 1, $modo = 1){
		$bot_data = $this->global_robot();
		$bot_model = $this->model("plant");
		$bot_dataView['bot_dbdata'] = $bot_model->selectOrder();
		$bot_dataView['bot_link'] = $bot_data['full_b_link'];
		$bot_dataView['bot_pag'] = $pag;
		$bot_dataView['bot_action'] = $bot_data['action'];
		/*
		$modo:	1 para carregar o design do sistema (chamado a primeira vez)
				2 para carregar sem design do sistema (chamado para atualizar a pagina via ajax)
		 */
		if($modo == 1){
			$this->system_view('listOrder', $bot_dataView);
		} else {
			$this->view('listOrder', $bot_dataView);
		}
	}
	public function listfamily($pag = 1, $modo = 1){
		$bot_data = $this->global_robot();
		$bot_model = $this->model("plant");
		$bot_dataView['bot_dbdata'] = $bot_model->selectFamily();
		$bot_dataView['bot_link'] = $bot_data['full_b_link'];
		$bot_dataView['bot_pag'] = $pag;
		$bot_dataView['bot_action'] = $bot_data['action'];
		/*
		$modo:	1 para carregar o design do sistema (chamado a primeira vez)
				2 para carregar sem design do sistema (chamado para atualizar a pagina via ajax)
		 */
		if($modo == 1){
			$this->system_view('listFamily', $bot_dataView);
		} else {
			$this->view('listFamily', $bot_dataView);
		}
	}
	public function testAddon(){
			$bot_agro = $this->addon(1);
			$bot_agro2 = $this->addon(1);
			$bot_agro3 = $this->addon(1);
			//$bot_agro->hard("GPIO")->pin(2)->type("O")->Volt("H")->set();
			$bot_agro->hard("GPIO")->pin(2)->type("O")->Volt("H")->set();
			echo json_encode($bot_agro->send());
			$bot_agro2->hard("DHT11")->pin(1)->set();
			$bot_agro2->hard("ADC")->set();
			echo json_encode($bot_agro2->send());
			$bot_agro3->hard("GPIO")->pin(2)->type("O")->Volt("L")->set();
			$bot_agro3->hard("GPIO")->pin(5)->type("O")->Volt("H")->timer("25", "L")->set();
			echo json_encode($bot_agro3->send());

	}
}

?>
