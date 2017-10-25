<?php
#Definição de constantes
define('HOST','localhost'); //endereço do host
define('DB_NAME','os'); //nome da base de dados
define('USER','root'); //nome do usuario da base de dados
define('PASS',''); //a senha do usuario da base de dados
try { //tentando a conexão com a base de dados usando try/catch
    $db = new PDO('mysql:host='.HOST.';dbname='.DB_NAME,USER, PASS); 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    if($e->getCode() == 1049) {
        echo "Base de dados errada...";
    } else {
        echo $e->getMessage(); //exibe a mensagem do erro (string)
    }
}