<?php
	// Inicia a sessão
	session_start();
	// Chama a conexão com o banco de dados
	include_once("conexao.php");

	// Recebendo os dados do formulário
	$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

	//echo "Nome: $nome <br>";
	//echo "E-mail: $email <br>";	

	// Insere e executa os valores no banco de dados
	$result_usuarios = "INSERT INTO usuarios (nome, email, created) VALUES ('$nome', '$email', NOW())";
	$resultado_usuario = mysqli_query($conn, $result_usuarios);

	// Verificando se o usuário foi inserido ou não
	// CSS Style para exibir a frase verde ou vermelha
	if (mysqli_insert_id($conn)) {
		$_SESSION['msg'] = "<p style='color:green;'>Usuário cadastrado com sucesso!</p>";
		header("Location: index.php");
	}
	else{
		$_SESSION['msg'] = "<p style='color:red;'>Usuário NÃO cadastrado com sucesso!</p>";
		header("Location: index.php");
	}
?>