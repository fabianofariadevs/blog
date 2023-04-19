<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\ReceitaModelo;
use sistema\Nucleo\helpers;

class AdminReceitas extends AdminControlador
{
    public function listar(): void
    {
        echo $this->template->renderizar('receitas/listar.html', [
            'receitas'=> (new ReceitaModelo())->busca()
        ]);
    }
    
    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        //var_dump($dados);
        if (isset($dados)) {
            (new ReceitaModelo())->armazenar($dados);     
            helpers::redirecionar('admin/receitas/listar');
        }
        
        echo $this->template->renderizar('receitas/formulario.html', []);
    }

}
