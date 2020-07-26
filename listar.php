<?php
	session_start();
	include_once("conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>CRUD - Listar</title>
	</head>
	<body>
		<a href="index.php">Cadastrar</a><br>
		<a href="listar.php">Listar</a><br>
		<h1>Listar Usuário</h1>
		<?php
			if (isset($_SESSION['msg'])) {
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}
			// Receber o número da página
			$pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);
			$pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

			// Setar a quantidade de itens por página
			$qtde_result_pagina = 1;

			// Calcular o início da visualização
			$inicio = ($qtde_result_pagina * $pagina) - $qtde_result_pagina;

			$result_usuarios = "SELECT * FROM usuarios LIMIT $inicio, $qtde_result_pagina";
			
			$resultado_usuarios = mysqli_query($conn, $result_usuarios);
			while ($row_usuario = mysqli_fetch_assoc($resultado_usuarios)) {
				echo "ID: " . $row_usuario['id'] . "<br>";
				echo "Nome: " .$row_usuario['nome'] . "<br>";
				echo "E-mail: " .$row_usuario['email']. "<br><hr>";
			}

			// Paginação - Somar a quantidade de usuários
			$result_pagina = "SELECT COUNT(id) AS num_result FROM usuarios";
			$resultado_pagina = mysqli_query($conn, $result_pagina);
			$row_pagina = mysqli_fetch_assoc($resultado_pagina);
			//echo $row_pagina['num_result'];

			// Quantidade de páginas
			$qtde_pagina = ceil($row_pagina['num_result'] / $qtde_result_pagina);

			// Limitar os links antes
			$max_links = 2; 
			echo "<a href='listar.php?pagina=1'>Primeira </a>";
			for ($pagina_ant = $pagina - $max_links; 
				$pagina_ant <= $pagina - 1;
				$pagina_ant ++) {
				if ($pagina_ant >= 1) {
					echo "<a href='listar.php?pagina=$pagina_ant'>$pagina_ant</a>";
				}
			}
			// Mostrar a página que o usuário está
			echo "$pagina";
			// Limitar os links depois
			for ($pagina_dep = $pagina + 1;
				$pagina_dep <= $pagina + $max_links;
				$pagina_dep++) {
					if ($pagina_dep <= $qtde_pagina) {
						echo "<a href='listar.php?pagina=$pagina_dep'>$pagina_dep</a>";	
					}
			}
			echo "<a href='listar.php?pagina=$qtde_pagina'> Ultima</a>";

		?>
	</body>
</html>

