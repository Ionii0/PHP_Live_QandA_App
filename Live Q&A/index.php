

<!DOCTYPE html>
<html>
<head>
	<title>Q&A app</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
</head>
<body>
	<div id="wrapper">
		<h1>         Aeroconsult Q&A live</h1>
		<div class="chat_wrapper">
			<div id="chat">
			<?php 
				include('cfg/config.php');
				$query=$db->prepare("SELECT * FROM  messages WHERE verificat=1 ");
						$query->execute();

						$rs=$query->fetchAll(PDO::FETCH_OBJ);
						$chat='';
						foreach($rs as $message){
							
							$chat.='<div class="single-message">'.$message->message.'</div>';
						}
					echo $chat;  
				?>

			</div>

			<form method="POST" id="msg_form">
				<textarea name="message" cols="30" rows="10" class="textarea"></textarea>
				
			</form>


		</div>


	</div>


<script>
	function LoadChat(){
		$.post('handlers/messages.php?action=getMessage',function(response){
		var scrollpos=$('#chat').scrollTop();
		var scrollpos=parseInt(scrollpos)+520;
		var scrollHeight=$('#chat').prop('scrollHeight');		



			$('#chat').html(response);

			if(scrollpos<scrollHeight){}else{$('#chat').scrollTop($('#chat').prop('scrollHeight'));}
		});
	}



	$('.textarea').keyup(function(e){
		if(e.keyCode == 13){
			$('form').submit();
			
		}
	});
	$('form').submit(function(){
		
		var message=$('.textarea').val();
		$.post('handlers/messages.php?action=sendMessage&message='+message , function(response){

			if( response==1 ){
				LoadChat();
				document.getElementById('msg_form').reset();
				
			}
		

		});
		return false;
	});

setInterval(LoadChat,1000);


</script>

</body>
</html>