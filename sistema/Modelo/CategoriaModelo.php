<?php

namespace sistema\Modelo;

use sistema\Nucleo\Modelo;

/**
 * Classe CategoriaModelo
 *
 * @author Fabiano Faria
 */
class CategoriaModelo extends Modelo
{

    public function __construct()
    {
        parent::__construct('categorias');
    }

    public function posts(int $id): ?array
    {
        $busca = (new PostModelo())->busca("categoria_id = {$id} AND status = 1");
        return $busca->resultado(true);
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
