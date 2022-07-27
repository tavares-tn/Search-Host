<?php

/**
 * Description of Banco
 *
 * @author tavares
 */
class Banco {

    private $ip = '127.0.0.1';
    private $base = 'rede';
    private $usuario = 'root';
    private $senha = 'tavares';

    function conectaBanco() {

        try {
            $dsn = "mysql:host={$this->ip};dbname={$this->base}";
            $this->conexao = new PDO($dsn, $this->usuario, $this->senha);
//            echo conectou;
        } catch (Exception $erroConectarBanco) {
            echo 'Erro ! ' . $erroConectarBanco->getMessage();
        }
    }

    function fecharConexaoBancoDados() {
        $this->conexao = null;
    }

    function insertRede($rede, $hora) {

//        echo $hora.'<br>'.$rede;
        try {
//
            $this->conexao->exec("insert into REDE (rede,hora) values('{$rede}','{$hora}')");
        } catch (Exception $erroInserirDadosBanco) {
            echo 'Erro ! ' . $erroInserirDadosBanco->getMessage();
        }
    }

    function insertDispositivo($endIP, $mac, $fab, $nome, $idRede) {

        try {
            $this->conexao->exec("insert into DISPOSITIVO (enderecoIP, enderecoMAC,fabricante,hostName,idRede) values('{$endIP}','{$mac}','{$fab}','{$nome}','{$idRede}')");
        } catch (Exception $erroInserirDadosBanco) {
            echo 'Erro ! ' . $erroInserirDadosBanco->getMessage();
        }
    }

    function ultimaRede() {

        try {
            $mostra = $this->conexao->query("select idRede from REDE");

            foreach ($mostra as $value) {
                $t = $value['idRede'];
            }
            return $t;
        } catch (Exception $erroMostraDadosBanco) {
            echo 'Erro ! ' . $erroMostraDadosBanco->getMessage();
        }
    }

    function historicoRedes() {

        try {
            $mostra = $this->conexao->query("select enderecoIP,enderecoMAC,hostName,rede,hora from DISPOSITIVO,REDE where REDE.idRede = DISPOSITIVO.idRede");

            foreach ($mostra as $value) {
                echo'<tr>';
                echo "<td>" . $value['enderecoIP'] . "</td>";
                echo "<td>" . $value['enderecoMAC'] . "</td>";
                echo "<td>" . $value['hostName'] . "</td>";
                echo "<td>" . $value['rede'] . "</td>";
                echo "<td>" . $value['hora'] . "</td>";
                 echo '</tr>';
            }
        } catch (Exception $erroMostraDadosBanco) {
            echo 'Erro ! ' . $erroMostraDadosBanco->getMessage();
        }
    }

}
