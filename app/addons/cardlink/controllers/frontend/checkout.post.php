<?php


if($_SERVER['REQUEST_METHOD']=='POST'){
	if($mode=='remove_cardlink_card'){
		db_query("DELETE FROM ?:cardlink_cards WHERE card_id=?i",$_REQUEST['card_id']);
		echo json_encode(['status'=>'ok']);
		exit;
	}
}

if($mode=='update_installments'){
	$_SESSION['cart']['installments'] = $_REQUEST['installments'];
	echo json_encode(['status'=>'ok']);
	exit;
}
