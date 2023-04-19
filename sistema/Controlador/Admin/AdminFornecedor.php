<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\FornecedorModelo;
/* Classe AdminFornecedor
 *
 * @author Fabiano Faria
 */
class AdminFornecedor extends AdminControlador
{
    public function listar(): void
    {
        echo $this->template->renderizar('fornecedor/listar.html', [
            'fornecedor'=> (new FornecedorModelo())->busca()
        ]);
        
    }
    

}
