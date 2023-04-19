<?php

namespace sistema\Controlador\Admin;

use sistema\Nucleo\Helpers;
use sistema\Modelo\UsuarioModelo;

/**
 * Classe AdminUsuarios
 *
 * @author Ronaldo Aires
 */
class AdminUsuarios extends AdminControlador
{

    /**
     * Lista usuários
     * @return void
     */
    public function listar(): void
    {
        $usuario = new UsuarioModelo();

        echo $this->template->renderizar('usuarios/listar.html', [
            'usuarios' => $usuario->busca()->ordem('level DESC, status ASC')->resultado(true),
            'total' => [
                'usuarios' => $usuario->busca('level != 3')->total(),
                'usuariosAtivo' => $usuario->busca('status = 1 AND level != 3')->total(),
                'usuariosInativo' => $usuario->busca('status = 0 AND level != 3')->total(),
                'admin' => $usuario->busca('level = 3')->total(),
                'adminAtivo' => $usuario->busca('status = 1 AND level = 3')->total(),
                'adminInativo' => $usuario->busca('status = 0 AND level = 3')->total()
            ]
        ]);
    }

    /**
     * Cadastra usuário
     * @return void
     */
    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            //checa os dados 
            if ($this->validarDados($dados)) {

                if (empty($dados['senha'])) {
                    $this->mensagem->alerta('Informe uma senha para o usuário')->flash();
                } else {
                    $usuario = new UsuarioModelo();

                    $usuario->nome = $dados['nome'];
                    $usuario->email = $dados['email'];
                    $usuario->senha = Helpers::gerarSenha($dados['senha']);
                    $usuario->level = $dados['level'];
                    $usuario->status = $dados['status'];

                    if ($usuario->salvar()) {
                        $this->mensagem->sucesso('Usuário cadastrado com sucesso')->flash();
                        Helpers::redirecionar('admin/usuarios/listar');
                    } else {
                        $usuario->mensagem()->flash();
                    }
                }
            }
        }

        echo $this->template->renderizar('usuarios/formulario.html', [
            'usuario' => $dados
        ]);
    }

    /**
     * Edita os dados do usuário por ID
     * @param int $id
     * @return void
     */
    public function editar(int $id): void
    {
        $usuario = (new UsuarioModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            if ($this->validarDados($dados)) {
                $usuario = (new UsuarioModelo())->buscaPorId($id);

                $usuario->nome = $dados['nome'];
                $usuario->email = $dados['email'];
                $usuario->senha = (!empty($dados['senha']) ? Helpers::gerarSenha($dados['senha']) : $usuario->senha);
                $usuario->level = $dados['level'];
                $usuario->status = $dados['status'];
                $usuario->atualizado_em = date('Y-m-d H:i:s');

                if ($usuario->salvar()) {
                    $this->mensagem->sucesso('Usuário atualizado com sucesso')->flash();
                    Helpers::redirecionar('admin/usuarios/listar');
                } else {
                    $usuario->mensagem()->flash();
                }
            }
        }

        echo $this->template->renderizar('usuarios/formulario.html', [
            'usuario' => $usuario
        ]);
    }

    /**
     * Checa os dados do formulário
     * @param array $dados
     * @return bool
     */
    public function validarDados(array $dados): bool
    {
        if (empty($dados['nome'])) {
            $this->mensagem->alerta('Informe o nome do usuário')->flash();
            return false;
        }
        if (empty($dados['email'])) {
            $this->mensagem->alerta('Informe o e-mail do usuário')->flash();
            return false;
        }
        if (!Helpers::validarEmail($dados['email'])) {
            $this->mensagem->alerta('Informe um e-mail válido!')->flash();
            return false;
        }
        
        if(!empty($dados['senha'])){
            if(!Helpers::validarSenha($dados['senha'])){
                $this->mensagem->alerta('A senha deve ter entre 6 e 50 caracteres!')->flash();
                return false;
            }
        }

        return true;
    }

    /**
     * Deletar um usuário por ID
     * @param int $id
     * @return void
     */
    public function deletar(int $id): void
    {
        if (is_int($id)) {
            $usuario = (new UsuarioModelo())->buscaPorId($id);
            if (!$usuario) {
                $this->mensagem->alerta('O usuário que você está tentando deletar não existe!')->flash();
                Helpers::redirecionar('admin/usuarios/listar');
            } else {
                if ($usuario->deletar()) {
                    $this->mensagem->sucesso('Usuário deletado com sucesso!')->flash();
                    Helpers::redirecionar('admin/usuarios/listar');
                } else {
                    $this->mensagem->erro($usuario->erro())->flash();
                    Helpers::redirecionar('admin/usuarios/listar');
                }
            }
        }
    }

}
