<?php

$victro_robot->name("BotAgroChip");
$victro_robot->try_route("agrochip");
$victro_robot->author("Jean Victor");
$victro_robot->description("This plugin will allow the framework to see the chip status about plugin bot_agro");
$victro_robot->version(1.0);
$victro_robot->icon("fa fa-heart-o");
$victro_robot->update("http://victrobot.com/update/[KEY]");

//TABLE INFORMATION
$victro_robot->table("chip_plant")->engine("INNODB")->if_table("NOT EXISTS");
$victro_robot->column("ID")->type("INT")->value("11")->autoincrement(true)->index("PRIMARY KEY");
$victro_robot->column("ID_CHIP")->type("INT")->value("11");
$victro_robot->column("ID_PLANT")->type('INT')->value('11');
$victro_robot->column("deleted")->type('boolean')->value('');

$victro_robot->table("chip_plant_hist")->engine("INNODB")->if_table("NOT EXISTS");
$victro_robot->column("ID")->type("INT")->value("11")->autoincrement(true)->index("PRIMARY KEY");
$victro_robot->column("ID_CHIP")->type("INT")->value("11");
$victro_robot->column("ID_PLANT")->type('INT')->value('11');
$victro_robot->column("HIST")->type('TEXT')->value('');
$victro_robot->column("DATE_HIST")->type('DATETIME')->value('');
$victro_robot->column("deleted")->type('boolean')->value('');

//MENU INFORMATION
$victro_robot->menu("Agro Chip", "3")->submenu('Chips', '3')->submenu('About', '3');
?>
