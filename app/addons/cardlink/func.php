<?php



function fn_cardlink_get_cards(){
	$cards = db_get_array("SELECT * FROM ?:cardlink_cards WHERE user_id=?i",$_SESSION['auth']['user_id']);

	return $cards;
}

function fn_cardlink_install(){
	db_query("CREATE TABLE `?:cardlink_cards` (
  `card_id` int(11) NOT NULL,
  `token` varchar(120) NOT NULL,
  `last_four` varchar(4) NOT NULL,
  `expiry_year` varchar(4) NOT NULL,
  `expiry_month` varchar(2) NOT NULL,
  `card_type` varchar(120) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

	db_query("ALTER TABLE `?:cardlink_cards`
  ADD PRIMARY KEY (`card_id`),
  ADD KEY `user_id` (`user_id`);");

	db_query("ALTER TABLE `?:cardlink_cards`
  MODIFY `card_id` int(11) NOT NULL AUTO_INCREMENT;");


	$processor = [
		"processor" => 'Cardlink',
		"processor_script" => 'cardlink.php',
		"processor_template" => 'views/orders/components/payments/cc_outside.tpl',
		"admin_template" => 'cardlink.tpl',
		"callback" => 'N',
		"type" => 'P',
		"addon" => 'cardlink'
	];

	db_query("INSERT INTO `?:payment_processors` ?e",$processor);
}

function fn_cardlink_uninstall(){
	db_query("DROP TABLE IF EXISTS ?:cardlink_cards");

	db_query("DELETE FROM ?:payment_descriptions WHERE payment_id IN (SELECT payment_id FROM ?:payments WHERE processor_id IN (SELECT processor_id FROM ?:payment_processors WHERE processor_script IN ('cardlink.php')))");
	db_query("DELETE FROM ?:payments WHERE processor_id IN (SELECT processor_id FROM ?:payment_processors WHERE processor_script IN ('cardlink.php'))");
	db_query("DELETE FROM ?:payment_processors WHERE processor_script IN ('cardlink.php')");
}