<?php
if (isset($_POST) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
	if(!empty($_POST['nom']) && !empty($_POST['email']) && !empty($_POST['message'])){
		$destinataire = "guillaume.amselle@gmail.com";
		$sujet = "Message depuis le site CV";
		$message .= "Nom: ".$_POST['name']."\r\n";
		$message .= "Adresse courriel : ".$_POST['email']."\r\n";
		$message .= "Message : ".$_POST['message']."\r\n";
		$entete = 'From: '.$_POST['email']."\r\n".'Reply-To: '.$_POST['email']."\r\n".'X-Mailer: PHP/'.phpversion();
		
		if (mail($destinataire, $sujet, $message, $entete)) {
			echo "<script>alert('Message envoyé');</scipt>";
		}else{ echo "<script>alert('Une erreur est survenue lors de l'envoi du formulaire par courriel');</script>";}
	}
}

?>