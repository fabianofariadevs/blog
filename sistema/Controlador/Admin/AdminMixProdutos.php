<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\MixProdutosModelo;

class AdminMixProdutos extends AdminControlador
{
    public function listar(): void
    {
        echo $this->template->renderizar('mixProdutos/listar.html', [
            'mixProdutos'=> (new MixProdutosModelo())->busca()
        ]);
    }
    
    public function cadastrar(): void
    {
        echo $this->template->renderizar('mixProdutos/formulario.html', []);
    }

}
