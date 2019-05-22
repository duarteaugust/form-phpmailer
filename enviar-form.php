<?php
/**
 * arquivo de confirguração da Biblioteca PHPMailer para envio de formulário de contato
 * 
 * Gabriel A. Duarte 22/05/2019
 * 
 */


 //namespace  e Biblioteca em escopo global
use PHPMailer\PHPMailer\PHPMailer; 
require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';

//verificando campos no servidor
if ( ($_POST["nome"]=='') || ($_POST["email"]=='') || $_POST["mensagem"]==''  ) {
    die ("Preencha o formulário");
}

//recebendo os dados do formulário via $_POST
$nome       = $_POST["nome"];
$email      = $_POST["email"];
$mensagem   = $_POST["mensagem"];
$objMailer = new PHPMailer();   //instanciando o objeto Mailer


try {
    //configurando o objeto Mailer
    $objMailer->CharSet = "utf-8";      //Charset do idioma escolhido
    $objMailer->IsSMTP();               //Define que será usado SMTP
    $objMailer->SMTPAuth = true;        //Caso o servidor SMTP precise de autenticação
    $objMailer->SMTPSecure = "tls";     //Tipo de criptografia utilizada para envios de e-mail
    $objMailer->Port = 587;             //Porta de saída do host
    $objMailer->IsHTML(true);           // Enviar como HTML
    $objMailer->Host        = "smtp.gmail.com";             //serviço SMTP do host de hospedagem 
    $objMailer->Username    = "turmasenai1204@gmail.com";   //meu email 
    $objMailer->Password    = "senha";           //senha do email
    //$mail->SMTPDebug = 2;                                         // Enable verbose debug output
    $objMailer->From        = $email;                       //Email de quem envia a mensagem.
    $objMailer->FromName    = $nome;
    $objMailer->AddAddress("turmasenai1204@gmail.com");     //para onde enviamos os dados do formulário
    //configurações ao se conectar via SMTP.
    $objMailer->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    
    $objMailer->Subject = "Formulário de Contato do Site"; //assunto do email.
    $mensagem = nl2br($mensagem);               //Insere quebras de linha HTML antes de todas quebras linhas de uma string
    //Texto do email com formato HTML
    $objMailer->Body = "
        <html> 
            <body> 
                <h1>E-mail enviado pelo formulário de contato do site</h1>
                <p>Nome: {$nome}</p>
                <p>Email: {$email}</p>
                <p>Mensagem: {$mensagem}</p>
            </body> 
        </html>";    
    //PlainText, para caso quem receber o email não aceite o corpo HTML
    $objMailer->AltBody = "{$mensagem} \n\n "; 

    $objMailer->send(); //envia o formulário para o email
    echo "Mensagem enviada com sucesso.";

} catch (Exception $e) {
    var_dump($e);
    echo "Mensagem não pode ser enviada: {$objMailer->ErrorInfo}";
}

?>
