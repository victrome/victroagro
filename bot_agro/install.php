<?php

$victro_robot->name("BotAgro");
$victro_robot->try_route("agro");
$victro_robot->try_route("Agro");
$victro_robot->author("Helen Dias");
$victro_robot->description("Agro");
$victro_robot->version(1.0);
$victro_robot->icon("fa fa-heart-o");
$victro_robot->update("http://victrobot.com/update/[KEY]");

//TABLE INFORMATION
$victro_robot->table("bot_agro")->engine("INNODB")->if_table("NOT EXISTS");
$victro_robot->column("ID")->type("INT")->value("11")->autoincrement(true)->index("PRIMARY KEY");
$victro_robot->column("name")->type("varchar")->value("100");
$victro_robot->column("family")->type('INT')->value('10');
$victro_robot->column("genus")->type('varchar')->value('150');
$victro_robot->column("species")->type('varchar')->value('200');
$victro_robot->column("soil_humidity")->type('INT')->value('5');
$victro_robot->column("air_humidity")->type('double')->value('');
$victro_robot->column("air_temperature")->type('double')->value('');
$victro_robot->column("deleted")->type('boolean')->value('');

//var_dump($_SESSION['debug_create_tables']);

//TABLE CAD CLASS INFORMATION
$victro_robot->table("agro_cad_class")->engine("INNODB")->if_table("NOT EXISTS");
$victro_robot->column("ID")->type("INT")->value("11")->autoincrement(true)->index("PRIMARY KEY");
$victro_robot->column("name_class")->type("varchar")->value("60");
$victro_robot->column("deleted")->type('boolean')->value('');


//TABLE CAD ORDER INFORMATION
$victro_robot->table("agro_cad_order")->engine("INNODB")->if_table("NOT EXISTS");
$victro_robot->column("ID")->type("INT")->value("11")->autoincrement(true)->index("PRIMARY KEY");
$victro_robot->column("name_order")->type("varchar")->value("60");
$victro_robot->column("id_class")->type("INT")->value("11");
$victro_robot->column("deleted")->type('boolean')->value('');
$victro_robot->foreignkey("id_class")->from("agro_cad_class")->field("ID");

//TABLE CAD FAMILY INFORMATION
$victro_robot->table("agro_cad_family")->engine("INNODB")->if_table("NOT EXISTS");
$victro_robot->column("ID")->type("INT")->value("11")->autoincrement(true)->index("PRIMARY KEY");
$victro_robot->column("name_family")->type("varchar")->value("60");
$victro_robot->column("id_order")->type("INT")->value("11");
$victro_robot->column("deleted")->type('boolean')->value('');
$victro_robot->foreignkey("id_order")->from("agro_cad_order")->field("ID");

//MENU INFORMATION
$victro_robot->menu("Agro Plants", "3", "fa fa-leaf")->submenu('List Class', '3')->submenu('List Order', '3')->submenu('List Family', '3')->submenu('List Plant', '3');
?>
