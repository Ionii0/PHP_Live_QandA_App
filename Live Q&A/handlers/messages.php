<?php 

include('../cfg/config.php');
if(isset($_REQUEST['action'])){
switch($_REQUEST['action']){
	case "sendMessage":
		$query=$db->prepare("INSERT INTO messages SET message=?");
		$run=$query->execute([$_REQUEST['message']]);
		if($run)
			echo 1;
		exit;
	break;

	case "getMessage" :

		$query=$db->prepare("SELECT * FROM  messages WHERE verificat=1 ");
		$query->execute();

		$rs=$query->fetchAll(PDO::FETCH_OBJ);
		$chat='';
		foreach($rs as $message){
			
			$chat.='<div class="single-message">'.$message->message.'</div>';
		}
		echo $chat;

	break;

	case "verifyMessage":

		$query=$db->prepare("SELECT * FROM  messages  ");
		$query->execute();

		$rs=$query->fetchAll(PDO::FETCH_OBJ);
		$chat='';
		foreach($rs as $message){
 			$id=$message->id;
 			$verificat=$message->verificat;
 			
 			if($verificat!=1){
			$chat.= "<div class='box'>".$message->message."<form method='POST' action=' "."./verificare.php"."'><input type='hidden' name='id' value='".$id."'><input type='submit' name='delete' value='delete' id='delete'><input type='submit' name='oky' value='oky' id='oky'></form>"."</div>";}}
		echo $chat;

	break;
}}


 ?>