<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\ClienteModelo;
use sistema\Nucleo\helpers;
/* Classe AdminClientes
 *
 * @author Fabiano Faria
 */
class AdminClientes extends AdminControlador
{
    public function listar(): void
    {
        $post = new ClienteModelo();
        echo $this->template->renderizar('clientes/listar.html', [
            'clientes' => $post->busca()->ordem('status ASC, id_tbl_cliente_fabrica DESC')->resultado(true),
            'total' => [
                'clientes' => $post->total(),
                'clientesAtivo' => $post->busca('status = 1')->total(),
                'clientesInativo' => $post->busca('status = 0')->total()
            ]]);
    }
    
    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            $post = new ClienteModelo();

            $post->nome_cliente = $dados['nome_cliente'];
            $post->endereco_cliente = $dados['endereco_cliente'];
            $post->bairro_cli = $dados['bairro_cli'];
            $post->cidade_cli = $dados['cidade_cli'];
            $post->estado_cli = $dados['estado_cli'];
            $post->telefone_cli = $dados['telefone_cli'];
            $post->email_cli = $dados['email_cli'];
            $post->responsavel_empresa = $dados['responsavel_empresa'];
            $post->whatsapp = $dados['whatsapp'];
            $post->cnpj_fabrica = $dados['cnpj_fabrica'];
            $post->status = $dados['status'];

            if ($post->salvar()) {
                $this->mensagem->sucesso('Cliente cadastrado com sucesso')->flash();
                Helpers::redirecionar('admin/clientes/listar');
            }
        }

        echo $this->template->renderizar('clientes/formulario.html', [
  ///***ver qual classe cliente????          
            'tbl_cliente_fabrica' => $dados]);
    }

    public function editar(int $id): void
    {
        $post = (new ClienteModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            $post = (new ClienteModelo())->buscaPorId($id);

            $post->nome_cliente = $dados['nome_cliente'];
            $post->endereco_cliente = $dados['endereco_cliente'];
            $post->bairro_cli = $dados['bairro_cli'];
            $post->cidade_cli = $dados['cidade_cli'];
            $post->estado_cli = $dados['estado_cli'];
            $post->telefone_cli = $dados['telefone_cli'];
            $post->email_cli = $dados['email_cli'];
            $post->responsavel_empresa = $dados['responsavel_empresa'];
            $post->whatsapp = $dados['whatsapp'];
            $post->cnpj_fabrica = $dados['cnpj_fabrica'];
            $post->status = $dados['status'];

            if ($post->salvar()) {
                $this->mensagem->sucesso('Cliente atualizado com sucesso')->flash();
                Helpers::redirecionar('admin/clientes/listar');
            }
        }

        echo $this->template->renderizar('clientes/formulario.html', [
 ////**VER AQUI TAMBEM           
            'post' => $post,
            'categorias' => (new CategoriaModelo())->busca()
        ]);
    }

    public function deletar(int $id): void
    {
//        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (is_int($id)) {
            $post = (new ClienteModelo())->buscaPorId($id);
            if (!$post) {
                $this->mensagem->alerta('O Cliente que você está tentando deletar não existe!')->flash();
                Helpers::redirecionar('admin/clientes/listar');
            } else {
                if($post->deletar()){
                    $this->mensagem->sucesso('Cliente deletado com sucesso!')->flash();
                Helpers::redirecionar('admin/clientes/listar');
                }else {
                    $this->mensagem->erro($post->erro())->flash();
                Helpers::redirecionar('admin/clientes/listar');
                }
                
                
            }
        }
    }

}
