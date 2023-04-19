<?php

namespace sistema\Controlador;

use sistema\Nucleo\Controlador;
use sistema\Modelo\PostModelo;
use sistema\Nucleo\Helpers;
use sistema\Modelo\CategoriaModelo;

class SiteControlador extends Controlador
{

    public function __construct()
    {
        parent::__construct('templates/site/views');
    }

    /**
     * Home Page
     * @return void
     */
    public function index(): void
    {
        $posts = (new PostModelo())->busca("status = 1");

        echo $this->template->renderizar('index.html', [
            'posts' => $posts->resultado(true),
            'categorias' => $this->categorias(),
        ]);
    }

    /**
     * Busca posts 
     * @return void
     */
    public function buscar(): void
    {
        $busca = filter_input(INPUT_POST, 'busca', FILTER_DEFAULT);
        if (isset($busca)) {
            $posts = (new PostModelo())->busca("status = 1 AND titulo LIKE '%{$busca}%'")->resultado(true);
            if ($posts) {
                foreach ($posts as $post) {
                    echo "<li class='list-group-item fw-bold'><a href=" . Helpers::url('post/') . $post->id . ">$post->titulo</a></li>";
                }
            }
        }
    }

    /**
     * Busca post por ID
     * @param string $slug
     * @return void
     */
    public function post(string $slug): void
    {
        $post = (new PostModelo())->buscaPorSlug($slug);
        if (!$post) {
            Helpers::redirecionar('404');
        }

        $post->salvarVisitas();

        echo $this->template->renderizar('post.html', [
            'post' => $post,
            'categorias' => $this->categorias(),
        ]);
    }

    /**
     * Categorias
     * @return array
     */
    public function categorias(): array
    {
        return (new CategoriaModelo())->busca("status = 1")->resultado(true);
    }

    /**
     * Lista posts por categoria
     * @param string $slug
     * @return void
     */
    public function categoria(string $slug): void
    {
        $categoria = (new CategoriaModelo())->buscaPorSlug($slug);
        if (!$categoria) {
            Helpers::redirecionar('404');
        }

        $categoria->salvarVisitas();

        echo $this->template->renderizar('categoria.html', [
            'posts' => (new CategoriaModelo())->posts($categoria->id),
            'categorias' => $this->categorias(),
        ]);
    }

    /**
     * Sobre
     * @return void
     */
    public function sobre(): void
    {
        echo $this->template->renderizar('sobre.html', [
            'titulo' => 'Sobre nós',
            'categorias' => $this->categorias(),
        ]);
    }

    
    
    
    
     public function contatos(): void
    {
        echo $this->template->renderizar('contatos.html', [
            'titulo' => 'contato Izabel fabiano',
            'subtitulo' => 'teste CONTATO de subtitulo'
        ]);
    }

    public function servicos(): void
    {
        echo $this->template->renderizar('servicos.html', [
            'titulo' => 'SERVIÇOS  TItulo',
            'subtitulo' => 'SERVIÇOS  de subtitulo'
        ]);
    }
    /**
     * Fornecedor
     * @return array
     */
    public function fornecedor(): array
    {
        return (new FornecedorModelo())->busca();
    }

    public function fornecedores(int $id): void
    {
        $posts = (new FornecedorModelo())->posts($id);

        echo $this->template->renderizar('listar.html', [
            'fornecedor' => $posts,
            'categorias' => $this->fornecedor(),
        ]);
    }

    /**
     * MixProdutos
     * @return array
     */
    public function mixProdutos(): array
    {
        return (new MixProdutosModelo())->busca();
    }

    public function mixProduto(int $id): void
    {
        $posts = (new MixProdutosModelo())->posts($id);

        echo $this->template->renderizar('listar.html', [
            'mixProdutos' => $posts,
            'categorias' => $this->mixProdutos(),
        ]);
    }

    /**
     * ERRO 404
     * @return void
     */
    public function erro404(): void
    {
        echo $this->template->renderizar('404.html', [
            'titulo' => 'Página não encontrada'
        ]);
    }

}
