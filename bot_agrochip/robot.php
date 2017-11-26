<?php
class BotAgroChip extends controller_robot {
    private $bot_pin_dht11_power = 2;
    private $bot_pin_dht11 = 1;
    private $bot_pin_water = 5;
    private $bot_pin_soil_power = 3;
    private $bot_percent_compare = 0.3;
    public function chips(){
      $bot_data = $this->global_robot();
      $bot_model = $this->model("plant");
      $bot_dataView['bot_dbdata'] = $bot_model->selectChip();
      $bot_dataView['bot_link'] = $bot_data['full_b_link'];
      $bot_dataView['bot_action'] = $bot_data['action'];
      $bot_dataView['bot_plant'] = $bot_model->selectPlant();

      $this->system_view('listChip', $bot_dataView);
    }
    public function saveChipPlant(){
      $bot_data = $this->global_robot();
      $bot_model = $this->model("plant");
      $bot_idChip = $this->input("ID_CHIP");
  		$bot_idPlant = $this->input("ID_PLANT");
  		$bot_insert['ID_CHIP'] = $bot_idChip;
  		$bot_insert['ID_PLANT'] = $bot_idPlant;
  		$bot_insert['deleted'] = 0;
      $bot_model->insertChipPlant($bot_insert);
    }
    public function checkChips(){
      $bot_data = $this->global_robot();
      $bot_model = $this->model("plant");
      $bot_chips = $bot_model->selectPlantChip();
      $bot_return = array();
      foreach($bot_chips->get_fetch() as $bot_chip){
        $bot_agro1 = $this->addon($bot_chip->ID_CHIP);
        $bot_agro1->hard("GPIO")->pin($this->bot_pin_soil_power)->type("O")->Volt("H")->timer("15", "L")->set();
        $bot_agro1->hard("TR")->reqs_time(20, 9)->set();
        $bot_on1 = $bot_agro1->send();
        $bot_return[$bot_chip->ID_BACK]['ERROR'] = false;
        $bot_return[$bot_chip->ID_BACK]['ID_CHIP'] = $bot_chip->ID_CHIP;
        $bot_return[$bot_chip->ID_BACK]['ID_PLANT'] = $bot_chip->ID;
        if($bot_on1->ERROR == false){
          $bot_agro = $this->addon($bot_chip->ID_CHIP);
          $bot_agro->hard("ADC")->set();
          $bot_agro->hard("GPIO")->pin($this->bot_pin_dht11_power)->type("O")->Volt("H")->timer("15", "L")->set();
    			$humi_soil = $bot_agro->send();
          if($humi_soil->ERROR == false){
            $bot_return[$bot_chip->ID_BACK]['ACTUAL_SOIL'] = $humi_soil->REQ1->VALUE;
            $bot_return[$bot_chip->ID_BACK]['SOIL'] = $bot_chip->soil_humidity;
            $bot_return[$bot_chip->ID_BACK]['COMPARE_SOIL'] = $bot_chip->soil_humidity + $bot_chip->soil_humidity * $this->bot_percent_compare;
            if($humi_soil->REQ1->VALUE > ($bot_chip->soil_humidity + $bot_chip->soil_humidity * $this->bot_percent_compare)){
              $bot_agro3 = $this->addon($bot_chip->ID_CHIP);
              $bot_agro3->hard("GPIO")->pin($this->bot_pin_water)->type("O")->Volt("H")->timer("10", "L")->set();
        			$bot_on2 = $bot_agro3->send();
              if($bot_on2->ERROR == false){
                $bot_return[$bot_chip->ID_BACK]['WATER'] = "WATER PUMP TURNED ON FOR 10 SEC";
              } else {
                $bot_return[$bot_chip->ID_BACK]['ERROR'] = true;
                $bot_return[$bot_chip->ID_BACK]['ERROR_TYPE'] = 3;
                $bot_return[$bot_chip->ID_BACK]['ERROR_MSG'] = "ERROR TRYING TO CONNECT AND TUNR ON WATER PUMP";
              }
            }
      			$bot_agro2 = $this->addon($bot_chip->ID_CHIP);
      			$bot_agro2->hard("DHT11")->pin($this->bot_pin_dht11)->set();
            $bot_agro2->hard("GPIO")->pin($this->bot_pin_dht11_power)->type("O")->Volt("L")->set();
            $bot_agro2->hard("GPIO")->pin($this->bot_pin_soil_power)->type("O")->Volt("L")->set();
      			$bot_on3 = $bot_agro2->send();
            if($bot_on3->ERROR == false){
              $bot_return[$bot_chip->ID_BACK]['ACTUAL_AIR_HUMITY'] = $bot_on3->REQ1->HUMIDITY;
              $bot_return[$bot_chip->ID_BACK]['AIR_HUMITY'] = $bot_chip->air_humidity;
              $bot_return[$bot_chip->ID_BACK]['ACTUAL_AIR_TEMPERATURE'] = $bot_on3->REQ1->TEMPERATURE;
              $bot_return[$bot_chip->ID_BACK]['AIR_TEMPERATURE'] = $bot_chip->air_temperature;
            } else {
              $bot_return[$bot_chip->ID_BACK]['ERROR'] = true;
              $bot_return[$bot_chip->ID_BACK]['ERROR_TYPE'] = 4;
              $bot_return[$bot_chip->ID_BACK]['ERROR_MSG'] = "ERROR TRYING TO CONNECT AND GET DHT11(AIR HUMITY AND TEMPERATURE) VALUE";
            }
          } else {
            $bot_return[$bot_chip->ID_BACK]['ERROR'] = true;
            $bot_return[$bot_chip->ID_BACK]['ERROR_TYPE'] = 2;
            $bot_return[$bot_chip->ID_BACK]['ERROR_MSG'] = "ERROR TRYING TO CONNECT, TURN ON DHT11 POWER PIN AND GET SOIL HUMITY VALUE";
          }
        } else {
          $bot_return[$bot_chip->ID_BACK]['ERROR'] = true;
          $bot_return[$bot_chip->ID_BACK]['ERROR_TYPE'] = 1;
          $bot_return[$bot_chip->ID_BACK]['ERROR_MSG'] = "ERROR TRYING TO CONNECT AND TURN ON SOIL HUMITY POWER PIN";
        }
      }
      $bot_returnJson = json_encode($bot_return);
      $bot_date = date('Y-m-d H:i:s');
      $bot_insertHist['ID_CHIP'] = $bot_chip->ID_CHIP;
      $bot_insertHist['ID_PLANT'] = $bot_chip->ID;
      $bot_insertHist['HIST'] = $bot_returnJson;
      $bot_insertHist['DATE_HIST'] = $bot_date;
      $bot_insertHist['deleted'] = 0;
      $bot_model->insertHist($bot_insertHist);
      echo $bot_returnJson;
    }
}

?>
