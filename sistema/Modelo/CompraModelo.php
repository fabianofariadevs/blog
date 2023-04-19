<?php

namespace sistema\Modelo;

use sistema\Nucleo\Modelo;
 /**
 * Classe CompraModelo
 *
 * @author Fabiano Faria
 */
class CompraModelo extends Modelo
{
 public function __construct()
    {
        parent::__construct('tbl_pedido_compra');
    }

    /**
     * Busca a compra pelo ID
     * @return CompraModelo|null
     */
    public function compra(): ?CompraModelo
    {
        if ($this->categoria_id) {
            return (new CategoriaModelo())->buscaPorId($this->categoria_id);
        }
        return null;
    }

    /**
     * Busca o usuário pelo ID
     * @return UsuarioModelo|null
     */
    public function usuario(): ?UsuarioModelo
    {
        if ($this->usuario_id) {
            return (new UsuarioModelo())->buscaPorId($this->usuario_id);
        }
        return null;
    }
    
    /**
     * Salva o post com slug
     * @return bool
     */
    public function salvar(): bool
    {
        $this->slug();
        return parent::salvar();
    }

}


