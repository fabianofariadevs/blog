<?php

use Pecee\SimpleRouter\SimpleRouter;
use sistema\Nucleo\Helpers;

try {
    //ROTAS SITE
    SimpleRouter::setDefaultNamespace('sistema\Controlador');

    SimpleRouter::get(URL_SITE, 'SiteControlador@index');
    SimpleRouter::get(URL_SITE . 'index.php', 'SiteControlador@index');
    SimpleRouter::get(URL_SITE . 'sobre-nos', 'SiteControlador@sobre');
    SimpleRouter::get(URL_SITE . 'contatos', 'SiteControlador@contatos');
    SimpleRouter::get(URL_SITE . 'servicos', 'SiteControlador@servicos');

    SimpleRouter::get(URL_SITE . 'post/{slug}', 'SiteControlador@post');
    SimpleRouter::get(URL_SITE . 'categoria/{slug}', 'SiteControlador@categoria');
    SimpleRouter::post(URL_SITE . 'buscar', 'SiteControlador@buscar');
    SimpleRouter::get(URL_SITE . '404', 'SiteControlador@erro404');

    //ROTAS ADMIN
    SimpleRouter::group(['namespace' => 'Admin'], function () {

        //ADMIN LOGIN
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'login', 'AdminLogin@login');

        //DASHBOAD
        SimpleRouter::get(URL_ADMIN . 'dashboard', 'AdminDashboard@dashboard');
        SimpleRouter::get(URL_ADMIN . 'sair', 'AdminDashboard@sair');

        //ADMIN USUARIOS
        SimpleRouter::get(URL_ADMIN . 'usuarios/listar', 'AdminUsuarios@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'usuarios/cadastrar', 'AdminUsuarios@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'usuarios/editar/{id}', 'AdminUsuarios@editar');
        SimpleRouter::get(URL_ADMIN . 'usuarios/deletar/{id}', 'AdminUsuarios@deletar');

        //ADMIN POSTS
        SimpleRouter::get(URL_ADMIN . 'posts/listar', 'AdminPosts@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'posts/cadastrar', 'AdminPosts@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'posts/editar/{id}', 'AdminPosts@editar');
        SimpleRouter::get(URL_ADMIN . 'posts/deletar/{id}', 'AdminPosts@deletar');

        //ADMIN CATEGORIAS
        SimpleRouter::get(URL_ADMIN . 'categorias/listar', 'AdminCategorias@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'categorias/cadastrar', 'AdminCategorias@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'categorias/editar/{id}', 'AdminCategorias@editar');
        SimpleRouter::get(URL_ADMIN . 'categorias/deletar/{id}', 'AdminCategorias@deletar');

        //ADMIN CLIENTES
        SimpleRouter::get(URL_ADMIN . 'clientes/listar', 'AdminClientes@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'clientes/cadastrar', 'AdminClientes@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'clientes/editar/{id}', 'AdminClientes@editar');
        SimpleRouter::get(URL_ADMIN . 'clientes/deletar/{id}', 'AdminClientes@deletar');

//ADMIN RECEITAS
        SimpleRouter::get(URL_ADMIN . 'receitas/listar', 'AdminReceitas@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'receitas/cadastrar', 'AdminReceitas@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'receitas/editar/{id}', 'AdminReceitas@editar');
        SimpleRouter::get(URL_ADMIN . 'receitas/deletar/{id}', 'AdminReceitas@deletar');

//ADMIN PLANEJAMENTO DE PRODUÇÃO
        SimpleRouter::get(URL_ADMIN . 'producao/listar', 'AdminProducao@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'producao/cadastrar', 'AdminProducao@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'producao/editar/{id}', 'AdminProducao@editar');
        SimpleRouter::get(URL_ADMIN . 'producao/deletar/{id}', 'AdminProducao@deletar');

//ADMIN FORNECEDORES
        SimpleRouter::get(URL_ADMIN . 'fornecedor/listar', 'AdminFornecedor@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'fornecedor/cadastrar', 'AdminFornecedor@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'fornecedor/editar/{id}', 'AdminFornecedor@editar');
        SimpleRouter::get(URL_ADMIN . 'fornecedor/deletar/{id}', 'AdminFornecedor@deletar');


//ADMIN MIX PRODUTOS
        SimpleRouter::get(URL_ADMIN . 'mixProdutos/listar', 'AdminmixProdutos@listar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'mixProdutos/cadastrar', 'AdminmixProdutos@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'mixProdutos/editar/{id}', 'AdminmixProdutos@editar');
        SimpleRouter::get(URL_ADMIN . 'mixProdutos/deletar/{id}', 'AdminmixProdutos@deletar');

//ADMIN ESTOQUE M.PRIMA
        SimpleRouter::get(URL_ADMIN . 'estoqueMp/listar', 'AdminestoqueMp@listar');
        SimpleRouter::get(URL_ADMIN . 'estoqueMp/inventario', 'AdminestoqueMp@inventario');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'estoqueMp/cadastrar', 'AdminestoqueMp@cadastrar');
        SimpleRouter::match(['get', 'post'], URL_ADMIN . 'estoqueMp/editar/{id}', 'AdminestoqueMp@editar');
        SimpleRouter::get(URL_ADMIN . 'estoqueMp/deletar/{id}', 'AdminestoqueMp@deletar');
            
        
    });

    SimpleRouter::start();
} catch (Pecee\SimpleRouter\Exceptions\NotFoundHttpException $ex) {
    if (Helpers::localhost()) {
        echo $ex->getMessage();
    } else {
        Helpers::redirecionar('404');
    }
}
