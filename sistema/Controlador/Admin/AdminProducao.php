<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\ProducaoModelo;

/**
 * Classe AdminProdução
 *
 * @author Fabiano Faria
 */

class AdminProducao extends AdminControlador
{
    public function listar(): void
    {
        echo $this->template->renderizar('Producao/listar.html', [
            'Producao'=> (new ProducaoModelo())->busca()
        ]);
        
    }
    

}
