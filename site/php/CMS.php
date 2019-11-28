<?php
    class CMS {
        var $host = "192.168.1.103", $user = "monty", $pass = "123", $db = "SFA";

        public function conectar(){
            $conexao = mysqli_connect($this->host, $this->user, $this->pass, $this->db);

            if(!$conexao){
                echo "Erro na conexão com o banco de dados " . mysql_error();
            }
            
            return $conexao;
        }
    }
?>