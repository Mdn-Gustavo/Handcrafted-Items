<?php

require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController
{
    private Usuario $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new Usuario();
    }

    public function index(): array
    {
        return $this->usuarioModel->all();
    }

    public function show(int $id): ?array
    {
        return $this->usuarioModel->findById($id);
    }

    public function authenticate(array $dados): array
    {
        $email = trim($dados['email'] ?? '');
        $senha = $dados['senha'] ?? '';

        if ($email === '' || $senha === '') {
            return [false, 'Informe e-mail e senha.', null];
        }

        try {
            $usuario = $this->usuarioModel->verificarLogin($email, $senha);
        } catch (PDOException $erro) {
            return [false, 'Erro ao consultar o banco. Verifique se o Script.sql foi importado novamente.', null];
        }

        if (!$usuario) {
            return [false, 'E-mail ou senha inválidos.', null];
        }

        return [true, 'Login realizado com sucesso.', $usuario];
    }

    public function store(array $dados): array
    {
        [$valido, $mensagem, $usuario] = $this->validar($dados, true);

        if (!$valido) {
            return [false, $mensagem];
        }

        try {
            if ($this->usuarioModel->findByEmail($usuario['email'])) {
                return [false, 'Esse e-mail já está cadastrado. Use outro e-mail ou edite o usuário existente.'];
            }

            $ok = $this->usuarioModel->create($usuario);
        } catch (PDOException $erro) {
            return [false, 'Erro no banco ao cadastrar usuário. Confira se a tabela usuarios tem os campos id, nome, email, senha, tipo_usuario e criado_em.'];
        }

        return [$ok, $ok ? 'Usuário cadastrado com sucesso.' : 'Não foi possível cadastrar o usuário.'];
    }

    public function update(int $id, array $dados): array
    {
        [$valido, $mensagem, $usuario] = $this->validar($dados, false);

        if (!$valido) {
            return [false, $mensagem];
        }

        try {
            $usuarioExistente = $this->usuarioModel->findByEmail($usuario['email']);

            if ($usuarioExistente && (int) $usuarioExistente['id'] !== $id) {
                return [false, 'Esse e-mail já está sendo usado por outro usuário.'];
            }

            $ok = $this->usuarioModel->update($id, $usuario);
        } catch (PDOException $erro) {
            return [false, 'Erro no banco ao atualizar usuário. Confira se a tabela usuarios está atualizada.'];
        }

        return [$ok, $ok ? 'Usuário atualizado com sucesso.' : 'Não foi possível atualizar o usuário.'];
    }

    public function destroy(int $id, ?int $usuarioLogadoId): array
    {
        if ($usuarioLogadoId === $id) {
            return [false, 'Você não pode excluir o próprio usuário logado.'];
        }

        try {
            $ok = $this->usuarioModel->delete($id);
        } catch (PDOException $erro) {
            return [false, 'Erro no banco ao excluir usuário.'];
        }

        return [$ok, $ok ? 'Usuário excluído com sucesso.' : 'Não foi possível excluir o usuário.'];
    }

    private function validar(array $dados, bool $senhaObrigatoria): array
    {
        $nome = trim($dados['nome'] ?? '');
        $email = trim($dados['email'] ?? '');
        $senha = $dados['senha'] ?? '';
        $tipoUsuario = $dados['tipo_usuario'] ?? 'comum';
        $tiposPermitidos = ['admin', 'comum'];

        if ($nome === '' || $email === '') {
            return [false, 'Preencha nome e e-mail.', []];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [false, 'Informe um e-mail válido.', []];
        }

        if ($senhaObrigatoria && strlen($senha) < 6) {
            return [false, 'A senha precisa ter pelo menos 6 caracteres.', []];
        }

        if (!$senhaObrigatoria && $senha !== '' && strlen($senha) < 6) {
            return [false, 'A nova senha precisa ter pelo menos 6 caracteres.', []];
        }

        if (!in_array($tipoUsuario, $tiposPermitidos, true)) {
            $tipoUsuario = 'comum';
        }

        return [true, '', [
            'nome' => $nome,
            'email' => $email,
            'senha' => $senha,
            'tipo_usuario' => $tipoUsuario,
        ]];
    }
}
