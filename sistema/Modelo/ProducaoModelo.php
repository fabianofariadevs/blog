<?php

namespace sistema\Modelo;

use sistema\Nucleo\Conexao;
 /**
 * Classe PLANEJ__ProducaoModelo
 *
 * @author Fabiano Faria
 */
class ProducaoModelo
{
    public function busca(): array
    {
        //aqui escolhemos quais as colunas ou id selecionar
        //ex: SELECT * FROM table WHERE id = 1 AND id = 2;
        //COM LIMIT, OFFSET, OU OPERADORES
        $query = "SELECT * FROM tbl_cliente_fabrica ";
        $stmt = Conexao::getInstancia()->query($query);        
        $resultado = $stmt->fetchAll();
        //var_dump($resultado);
        return $resultado;

    }
    
    public function buscaporId(int$id): bool | object
    {
        //aqui buscar por ID
        $query = "SELECT * FROM 'tbl_cliente_fabrica' WHERE id_tbl_cliente_fabrica - 1 ORDER BY id DESC";
        $stmt = Conexao::getInstancia()->query($query);        
        $resultado = $stmt->fetch();
        return $resultado;
    }


}

