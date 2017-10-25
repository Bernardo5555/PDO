<!DOCTYPE html>
<?php
require_once 'config.php';
?>
<html lang="pt-BR">
<head>
    <title>Prática com PDO</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Aprendendo PDO na prática" />
    <meta name="author" content="Pir-Bernardo, Jão-João Paulo, Lucal-Lucas, Eu mesmo-Osvaldo" />
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <header>
        <h1>PDO na Prática</h1>
        <nav>
            <ul>
                <li><a href="index.php">Página inicial</a></li>
                <li><a href="">Inserir</a></li>
                <li><a href="">Ler</a></li>
                <li><a href="">Atualizar</a></li>
                <li><a href="">Excluir</a></li>
            </ul>
        </nav>
        <?php
        # CREATE
        if(isset($_POST['enviar'])){
            $nome  = $_POST['nome'];
            $email = $_POST['email'];
            $sql  = 'INSERT INTO usuario (nome, email) ';
            $sql .= 'VALUES (:nome, :email)';
            try {
                $create = $db->prepare($sql);
                $create->bindValue(':nome', $nome, PDO::PARAM_STR);
                $create->bindValue(':email', $email, PDO::PARAM_STR);
                if($create->execute()){
                    echo "<div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <strong>Inserido com sucesso!</strong>
                    </div>";
                }
            } catch (PDOException $e) {
                echo "<div class='alert alert-error'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Erro ao inserir dados!</strong>" . $e->getMessage() . "
                </div>";
            }
        }
        # UPDATE
        if(isset($_POST['atualizar'])){
        $id = (int)$_GET['id'];
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $sqlUpdate = 'UPDATE usuario SET nome = ?, email = ? WHERE id = ?';
            $dados = array($nome, $email, $id);
            try {
                $update = $db->prepare($sqlUpdate);
                if($update->execute($dados)){
                    echo "<div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <strong>Atualizado com sucesso!</strong>
                    </div>";
                }
            } catch (PDOException $e) {
                echo "<div class='alert alert-error'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <strong>Erro ao atualizar dados!</strong>" . $e->getMessage() . "
                    </div>";
            }
        }
        # DELETE
        if(isset($_GET['action']) && $_GET['action'] == 'delete'){
            $id = (int)$_GET['id'];
            $sqlDelete = 'DELETE FROM usuario WHERE id = :id';
            try {
                $delete = $db->prepare($sqlDelete);
                $delete->bindValue(':id', $id, PDO::PARAM_INT);
                if($delete->execute()){
                    echo "<div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <strong>Deletado com sucesso!</strong>
                    </div>";
                }
            } catch (PDOException $e) {
                echo "<div class='alert alert-error'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <strong>Erro ao deletar dados!</strong>" . $e->getMessage() . "
                    </div>";
            }
        }
        ?>
    </header>

<section>
    <header>
        <p>Cabeçalho do article</p>
    </header>
    <article>
        <?php
        if(isset($_GET['action']) && $_GET['action'] == 'update'){
            $id = (int)$_GET['id'];
            $sqlSelect = 'SELECT * FROM usuario WHERE id = :id';
            try {
                $select = $db->prepare($sqlSelect);
                $select->bindValue(':id', $id, PDO::PARAM_INT);
                $select->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            $result = $select->fetch(PDO::FETCH_OBJ);
        ?>
            <ul>
                <li><a href="index.php">Página inicial</a></li>
                <li>Atualizar</li>
            </ul>
            <form method="post" action="">
                <input type="text" name="nome" value="<?= $result->nome; ?>" placeholder="Nome:" />
                <input type="text" name="email" value="<?= $result->email; ?>" placeholder="E-mail:" />
                <br />
                <input type="submit" name="atualizar" value="Atualizar dados">					
            </form>
        <?php } else { ?>
            <form method="post" action="">
                <input type="text" name="nome" placeholder="Nome:" />
                <input type="text" name="email" placeholder="E-mail:" />
                <br />
                <input type="submit" name="enviar" value="Cadastrar dados">					
            </form>
        <?php } ?>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome:</th>
                    <th>E-mail:</th>
                    <th>Ações:</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sqlRead = 'SELECT * FROM usuario';
            try {
                $read = $db->prepare($sqlRead);
                $read->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            while( $rs = $read->fetch(PDO::FETCH_OBJ) ){
            ?>
                <tr>
                    <td><?= $rs->id; ?></td>
                    <td><?= $rs->nome; ?></td>
                    <td><?= $rs->email; ?></td>
                    <td>
                        <a href="index.php?action=update&id=<?= $rs->id; ?>" ><i class="icon-pencil"></i></a>
                        <a href="index.php?action=delete&id=<?= $rs->id; ?>"  onclick="return confirm('Deseja deletar?');"><i class="icon-remove"></i></a>
                    </td>
                </tr>
            <?php }	?>
            </tbody>
        </table>
    </article>
    <footer>
        <p>Esse é o rodapé do article</p>
    </footer>
</section>>
<footer>
    <p>Esse é o rodapé final</p>
</footer>
</body>
</html>