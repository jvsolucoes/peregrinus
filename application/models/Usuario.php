<?php
/**
 * Description of Usuario
 *
 * @author victor
 */
class Usuario extends Zend_Db_Table_Abstract {
    
    protected $_name = "usuario";
    protected $_primary = array("codUsuario");
    
    protected $_referenceMap = array(
        'Perfil' => array(
            'refTableClass' => 'Perfil',
            'refColumns' => 'id',
            'columns' => 'codPerfil',
            'onDelete' => self::CASCADE
        )
    );
    
    public static function isLogged() {
        return Zend_Auth::getInstance()->hasIdentity();
    }
    
    public function listar() {
        $sql = $this->getAdapter()->select()
                    ->from(array("usuario"), array("*"))
                    ->order("nome ASC");
        
        $result = $this->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $this->getAdapter()->fetchAll($sql);

        return $result;
    }

    public static function validarModulo($app, $model) {
        $usuario = Zend_Auth::getInstance()->getIdentity();
        
        $aplicacao = Aplicacao::buscarNome($app);
        $modulo = Modulo::buscarNome($model);
        
        $permissao = PerfilAplicacaoModuloAcao::buscarPermissoesModulo($usuario->id, $aplicacao->id, $modulo->id);
        
        if(!$permissao) {
            return false;
        }

        return true;
    }

    public static function validarAcao($app, $model, $action) {
        $usuario = Zend_Auth::getInstance()->getIdentity();

        $aplicacao = Aplicacao::buscarNome($app);
        $modulo = Modulo::buscarNome($model);
        $acao = Acao::buscarNome($action);

        $permissao = PerfilAplicacaoModuloAcao::buscarPermissoes($usuario->id, $aplicacao->id, $modulo->id, $acao->id);

        if($permissao) {
            return true;
        } else if ($usuario->id_pessoa == NULL) {
            return true;
        }

        return false;
    }
    
    public function inserir($dados) {
        $this->inicializar();
        
        $this->getAdapter()->beginTransaction();
        
        $usuario = $this->add($dados);
        $dados['id_usuario'] = $usuario;
        
//        $this->_modelPerfilAplicacaoModuloAcao->inserir($dados);
        
        $this->getAdapter()->commit();
    }
    
    private function add($dados) {
        $data = array(
            'email' => $dados['email'],
            'login' => $dados['login'],
            'senha' => sha1($dados['senha']),
            'id_trabalhador' => $dados['trabalhador']
        );
        
        try {
            $this->insert($data);
            $idUsuario = $this->getAdapter()->lastInsertId();
        } catch (Zend_Exception $e) {
            $this->getAdapter()->rollBack();
            throw new Zend_Exception("N&atilde;o foi possível cadastrar o usuário" . $e->getMessage());
        }
        
        return $idUsuario;
    }
    
    public function editar($dados) {
        $this->inicializar();
        
        $this->getAdapter()->beginTransaction();
        
        $this->edit($dados);
        $acao = "editar";
        $this->_modelUsuarioAplicacaoModuloAcao->inserir($dados, $acao);
        
        $this->getAdapter()->commit();
    }
    
    private function edit($dados) {
        
        $data = array(
            'email' => $dados['email'],
            'login' => $dados['login']
        );
        
        if (isset($dados['senha'])) {
            $data['senha'] = sha1($dados['senha']);
        }
        
        try {
            $where = $this->getAdapter()->quoteInto("id = ?", $dados['id_usuario']);
            $this->update($data, $where);
        } catch (Zend_Exception $e) {
            $this->getAdapter()->rollBack();
            throw new Zend_Exception("N&atilde;o foi possível editar os dados do usuário" . $e->getMessage());
        }
    }
    
}
