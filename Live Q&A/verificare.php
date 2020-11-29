<!--The purpose of this page is to check if messages do not contain bad language before displaying them on Q&A page. -->
<?php 
include('cfg/config.php');
$query=$db->prepare("SELECT * FROM  messages ");
$query->execute();

$rs=$query->fetchAll(PDO::FETCH_OBJ);

 ?>

 <!DOCTYPE html>
 <html>
 <link rel="stylesheet" type="text/css" href="css/style.css">
 <head>
 	<title>Pagina de verificare</title>
 	<script
	  src="https://code.jquery.com/jquery-3.4.1.js"
	  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
	  crossorigin="anonymous">
	 </script>
 </head>
 <body>
 
 	
 	<div class="wrapper">

 		<?php 
 		$chat='';
 		foreach($rs as $message){
 			$id=$message->id;
 			$verificat=$message->verificat;
 			
 			if($verificat!=1){
			$chat.= "<div class='box'>".$message->message."<form method='POST' action=' ".$_SERVER['PHP_SELF']."'><input type='hidden' name='id' value='".$id."'><input type='submit' name='delete' value='delete' id='delete'><input type='submit' name='oky' value='oky' id='oky'></form>"."</div>";}}
			echo $chat;
		 ?>	

	</div>

	<script >
		function LoadChat(){
			$.post('handlers/messages.php?action=verifyMessage',function(response){	
				$('.wrapper').html(response);
			});
		}
		setInterval(LoadChat,1000);
	</script>


 </body>
 </html>
<?php 
if(isset($_POST['delete'])){
	$id=(int) $_POST['id'];
	$query=$db->prepare(" DELETE  FROM messages WHERE id=? ");
	$query->execute([$id]);
	header("Refresh:0");
}
if(isset($_POST['oky'])){
	$id=(int) $_POST['id'];
	$query=$db->prepare("UPDATE messages SET verificat=1 WHERE id=?");
	$query->execute([$id]);
	header("Refresh:0");
}

 ?>

