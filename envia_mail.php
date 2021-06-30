<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require (__DIR__).'\PHPMailer\src\PHPMailer.php';
require (__DIR__).'\PHPMailer\src\Exception.php';
require (__DIR__).'\PHPMailer\src\SMTP.php';

class Email{
	
	public function enviarEmail(Prontuario $prontuario,$trocadata){
	$Mailer = new PHPMailer();
	$Mailer->IsSMTP();
	$Mailer->SMTPDebug=0;
	$Mailer->Host ='smtp.gmail.com';
	$Mailer->charset="UTF-8";
	$Mailer->isHTML(true);
	$Mailer->CharSet = 'UTF-8';
	$Mailer->SMTPAuth = true;
	$Mailer->SMTPSecure = 'tls';
	$Mailer->Port = 587;
	$Mailer->Username = 'mailsenderadm1n@gmail.com';
	$Mailer->Password = 'lasalle123';
	$Mailer->From = 'mailsenderadm1n@gmail.com';
	$Mailer->FromName = 'Admin';
	$Mailer->Subject = 'Confirme a entrega do prontuário';
	$cd_prontuario=$prontuario->getCd_prontuario();
	$Mailer->Body = 
			  "<p>Confirme a entrega do prontuário número $cd_prontuario ".
              "<br>Para confirmar a entrega  ".
              "<a href='http://localhost/tcc/confirma.php?cd_prontuario=$cd_prontuario&trocadata=$trocadata'>clique aqui</a></p><br><br><br>".
			  "Está uma mensagem automática e não deve ser respondida.";
	$Mailer->AltBody = 'Para conseguir essa e-mail corretamente, use um visualizador de e-mail com suporte a HTML';
	$Mailer->AddAddress('daniel.correia@soulasalle.com.br');
	
	if($Mailer->Send()){
		echo "<script>
            window.alert('Um email foi enviado para confirmar a entrega do prontuário!');
            window.location.href = 'http://localhost/tcc/home.php';
            </script>";
	}else{
		echo "<script>
		window.alert('Erro no envio do e-mail:$Mailer->ErrorInfo');
		window.location.href = 'http://localhost/tcc/home.php';
		</script>";
	}
}
	public function trocarMovimentoEmail($cd_prontuario , $emailorigem, $emaildestino){
	$Mailer = new PHPMailer();
	$Mailer->IsSMTP();
	$Mailer->SMTPDebug=0;
	$Mailer->Host ='smtp.gmail.com';
	$Mailer->charset="UTF-8";
	$Mailer->isHTML(true);
	$Mailer->CharSet = 'UTF-8';
	$Mailer->SMTPAuth = true;
	$Mailer->SMTPSecure = 'tls';
	$Mailer->Port = 587;
	$Mailer->Username = 'mailsenderadm1n@gmail.com';
	$Mailer->Password = 'lasalle123';
	$Mailer->From = 'mailsenderadm1n@gmail.com';
	$Mailer->FromName = 'Admin';
	$Mailer->Subject = "Disponibilidade de prontuário";

	$Mailer->Body =  "O usuário ".$emaildestino." necessita do prontuário ".$cd_prontuario.".<br> Este prontuário já está disponível?<br>".
					 "<a href='http://localhost/tcc/troca.php?troca=1&cd_prontuario=$cd_prontuario&emailorigem=$emailorigem&emaildestino=$emaildestino'>Sim</a><br>".
					 "<a href='http://localhost/tcc/troca.php?troca=0&cd_prontuario=$cd_prontuario&emailorigem=$emailorigem&emaildestino=$emaildestino'>Não</a>";

	$Mailer->AltBody = 'Para conseguir essa e-mail corretamente, use um visualizador de e-mail com suporte a HTML';
	$Mailer->AddAddress($emailorigem);
		
	if($Mailer->Send()){
		echo"<script>
            window.alert('Este prontuário está em uso pelo usuário $emailorigem . Um email foi enviado para esse usuário para verificar se há disponibilidade de troca de titularidade.');
            window.location.href = 'http://localhost/tcc/home.php';
            </script>";
	}else{
		echo "<script>
            window.alert('Erro no envio do e-mail:$Mailer->ErrorInfo');
            window.location.href = 'http://localhost/tcc/home.php';
            </script>";
		}
}
	public function recusaEmail(string $emailorigem, string $emaildestino){
	$Mailer = new PHPMailer();
	$Mailer->IsSMTP();
	$Mailer->SMTPDebug=0;
	$Mailer->Host ='smtp.gmail.com';
	$Mailer->charset="UTF-8";
	$Mailer->isHTML(true);
	$Mailer->CharSet = 'UTF-8';
	$Mailer->SMTPAuth = true;
	$Mailer->SMTPSecure = 'tls';
	$Mailer->Port = 587;
	$Mailer->Username = 'mailsenderadm1n@gmail.com';
	$Mailer->Password = 'lasalle123';
	$Mailer->From = 'mailsenderadm1n@gmail.com';
	$Mailer->FromName = 'Admin';
	$Mailer->Subject = "Disponibilidade de prontuário";
	$Mailer->Body =  "O usuário ".$emailorigem." recusou a troca.";
	$Mailer->AltBody = 'Para conseguir essa e-mail corretamente, use um visualizador de e-mail com suporte a HTML';
	$Mailer->AddAddress($emaildestino);
	$Mailer->Send();
	}

	public function trocaConfirmada(string $emailorigem, string $emaildestino){
	$Mailer = new PHPMailer();
	$Mailer->IsSMTP();
	$Mailer->SMTPDebug=0;
	$Mailer->Host ='smtp.gmail.com';
	$Mailer->charset="UTF-8";
	$Mailer->isHTML(true);
	$Mailer->CharSet = 'UTF-8';
	$Mailer->SMTPAuth = true;
	$Mailer->SMTPSecure = 'tls';
	$Mailer->Port = 587;
	$Mailer->Username = 'mailsenderadm1n@gmail.com';
	$Mailer->Password = 'lasalle123';
	$Mailer->From = 'mailsenderadm1n@gmail.com';
	$Mailer->FromName = 'Admin';
	$Mailer->Subject = "Disponibilidade de prontuário";
	$Mailer->Body =  "O usuário ".$emailorigem." aceitou a troca.<br>Você pode entrar em contato com o usuário via email e combinar o local da entrega.";
	$Mailer->AltBody = 'Para conseguir essa e-mail corretamente, use um visualizador de e-mail com suporte a HTML';
	$Mailer->AddAddress($emaildestino);
	$Mailer->Send();
	}

	public function esqueceuSenha(string $login){
	$emaildestino = "daniel.correia@soulasalle.com.br";
	$Mailer = new PHPMailer();
	$Mailer->IsSMTP();
	$Mailer->SMTPDebug=0;
	$Mailer->Host ='smtp.gmail.com';
	$Mailer->charset="UTF-8";
	$Mailer->isHTML(true);
	$Mailer->CharSet = 'UTF-8';
	$Mailer->SMTPAuth = true;
	$Mailer->SMTPSecure = 'tls';
	$Mailer->Port = 587;
	$Mailer->Username = 'mailsenderadm1n@gmail.com';
	$Mailer->Password = 'lasalle123';
	$Mailer->From = 'mailsenderadm1n@gmail.com';
	$Mailer->FromName = 'Admin';
	$Mailer->Subject = "Senha esquecida";
	$Mailer->Body =  "O usuário ".$login." esqueceu a senha, por favor entre em contato!";
	$Mailer->AltBody = 'Para conseguir essa e-mail corretamente, use um visualizador de e-mail com suporte a HTML';
	$Mailer->AddAddress($emaildestino);
	if($Mailer->Send()){
		echo "<script>
            window.alert('Um email foi enviado para o suporte e em breve algum administrador entrará em contato com você!');
            window.location.href = 'http://localhost/tcc/login.php';
            </script>";
	}else{
		echo "<script>
            window.alert('Erro ao enviar o email');
            window.location.href = 'http://localhost/tcc/login.php';
            </script>";
	}
	}
	public function transfereEmail(string $emailorigem,string $emaildestino, int $cd_prontuario){
	$Mailer = new PHPMailer();
	$Mailer->IsSMTP();
	$Mailer->SMTPDebug=0;
	$Mailer->Host ='smtp.gmail.com';
	$Mailer->charset="UTF-8";
	$Mailer->isHTML(true);
	$Mailer->CharSet = 'UTF-8';
	$Mailer->SMTPAuth = true;
	$Mailer->SMTPSecure = 'tls';
	$Mailer->Port = 587;
	$Mailer->Username = 'mailsenderadm1n@gmail.com';
	$Mailer->Password = 'lasalle123';
	$Mailer->From = 'mailsenderadm1n@gmail.com';
	$Mailer->FromName = 'Admin';
	$Mailer->Subject = "Troca de titularidade";
	$Mailer->Body =  "O usuário ".$emailorigem.", que tinha posse sobre o prontuário ".$cd_prontuario.", manifestou interesse em devolvê-lo. 
					  Você é o primeiro da fila para este prontuário e a posse foi transferida para você. Entre em contato com esse usuário para mais detalhes.
					  Caso não tenha mais interesse nesse prontuário você deverá dar baixa no sistema.";
	$Mailer->AltBody = 'Para conseguir essa e-mail corretamente, use um visualizador de e-mail com suporte a HTML';
	$Mailer->AddAddress($emaildestino);
	$Mailer->Send();
	}
}

?>