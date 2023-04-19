<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\CompraModelo;
use sistema\Nucleo\Helpers;

/**
 * Classe AdminCompras
 *
 * @author Fabiano Faria
 */
class AdminCompras extends AdminControlador
{
    /**
     * Lista compras
     * @return void
     */
    public function listar(): void
    {
        $compras = new CompraModelo();

        echo $this->template->renderizar('compras/listar.html', [
            'compras' => $compras->busca(),
            'total' => [
                'compras' => $compras->total(),
                'comprasAtiva' => $compras->total('status = 1'),
                'comprasInativa' => $compras->total('status = 0')
            ]
        ]);
    }
    /**
     * Cadastra uma compra
     * @return void
     */
    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            if ($this->validarDados($dados)) {
            $categoria = new CompraModelo();

                $categoria->usuario_id = $this->usuario->id;
                $categoria->slug = Helpers::slug($dados['titulo']);
                $categoria->titulo = $dados['titulo'];
                $categoria->texto = $dados['texto'];
                $categoria->status = $dados['status'];

                if ($categoria->salvar()) {
                    $this->mensagem->sucesso('pedido de compra cadastrado com sucesso')->flash();
                    Helpers::redirecionar('admin/compras/listar');
                } else {
                    $this->mensagem->erro($compras->erro())->flash();
                    Helpers::redirecionar('admin/compras/listar');
                }
            }
        }

        echo $this->template->renderizar('compras/formulario.html', [
            'compras' => $dados]);
    }

    public function editar(int $id): void
    {
        $compras = (new CompraModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            if ($this->validarDados($dados)) {
                $compras = (new CategoriaModelo())->buscaPorId($compras->id);

                $compras->usuario_id = $this->usuario->id;
                $compras->slug = Helpers::slug($dados['titulo']);
                $compras->titulo = $dados['titulo'];
                $compras->texto = $dados['texto'];
                $compras->status = $dados['status'];
                $compras->atualizado_em = date('Y-m-d H:i:s');

                if ($compras->salvar()) {
                    $this->mensagem->sucesso('Compras atualizada com sucesso')->flash();
                    Helpers::redirecionar('admin/compras/listar');
                } else {
                    $this->mensagem->erro($compras->erro())->flash();
                    Helpers::redirecionar('admin/compras/listar');
                }
            }
        }
        echo $this->template->renderizar('compras/formulario.html', [
            'compras' => $compras
        ]);
    }
    /**
     * Valida os dados do formulário
     * @param array $dados
     * @return bool
     */
    private function validarDados(array $dados): bool
    {
        if (empty($dados['titulo'])) {
            $this->mensagem->alerta('Escreva um título para a Categoria!')->flash();
            return false;
        }
        return true;
    }

    /**
     * Deleta uma categoria pelo ID
     * @param int $id
     * @return void
     */
    public function deletar(int $id): void
    {
        if (is_int($id)) {
            $categoria = (new CategoriaModelo())->buscaPorId($id);

            if (!$categoria) {
                $this->mensagem->alerta('O categoria que você está tentando deletar não existe!')->flash();
                Helpers::redirecionar('admin/categorias/listar');
            } elseif ($categoria->posts($categoria->id)) {
                $this->mensagem->alerta("A categoria {$categoria->titulo} tem posts cadastrados, delete ou altere os posts antes de deletar!")->flash();
                Helpers::redirecionar('admin/categorias/listar');
            } else {
                if ($categoria->deletar()) {
                    $this->mensagem->sucesso('Categoria deletada com sucesso!')->flash();
                    Helpers::redirecionar('admin/categorias/listar');
                } else {
                    $this->mensagem->erro($categoria->erro())->flash();
                    Helpers::redirecionar('admin/categorias/listar');
                }
            }
        }
    }

}
