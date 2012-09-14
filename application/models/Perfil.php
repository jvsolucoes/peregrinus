<?php
/**
 * Description of Usuario
 *
 * @author victor
 */
class Perfil extends Zend_Db_Table_Abstract {
    
    protected $_name = "perfil";
    protected $_primary = array("codPerfil");
    protected $_dependentTables = array('PerfilAplicacaoModuloAcao', 'Usuario');  
    
    protected $_modelPerfilAplicacaoModuloAcao;
    protected $_modelUsuario;
    
    private function inicializar() {
        $this->_modelPerfilAplicacaoModuloAcao = new PerfilAplicacaoModuloAcao();
        $this->_modelUsuario = new Usuario();
    }
    
    public function listar() {
        $sql = $this->getAdapter()->select()
                    ->from(array("perfil"), array("*"))
                    ->order("nomePerfil ASC");
        
        $result = $this->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $this->getAdapter()->fetchAll($sql);

        return $result;
    }

    public static function validarModulo($app, $model) {
        $usuario = Zend_Auth::getInstance()->getIdentity();
        
        $aplicacao = Aplicacao::buscarNome($app);
        $modulo = Modulo::buscarNome($model);
        
        $permissao = PerfilAplicacaoModuloAcao::buscarPermissoesModulo($usuario->codPerfil, $aplicacao->codAplicacao, $modulo->codModulo);
        
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
        $dados['codPerfil'] = $usuario;
        
        $this->_modelPerfilAplicacaoModuloAcao->inserir($dados);
        
        $this->getAdapter()->commit();
    }
    
    private function add($dados) {
        $data = array(
            'nomePerfil' => $dados['nomePerfil']
        );
        
        try {
            $this->insert($data);
            $idPerfil = $this->getAdapter()->lastInsertId();
        } catch (Zend_Exception $e) {
            $this->getAdapter()->rollBack();
            throw new Zend_Exception("N&atilde;o foi possível cadastrar o perfil" . $e->getMessage());
        }
        
        return $idPerfil;
    }
    
    public function editar($dados) {
        $this->inicializar();
        
        $this->getAdapter()->beginTransaction();
        
        $this->edit($dados);
        $this->_modelPerfilAplicacaoModuloAcao->inserir($dados);
        
        $this->getAdapter()->commit();
    }
    
    private function edit($dados) {
        
        $data = array(
            'nomePerfil' => $dados['nomePerfil']
        );
        
        try {
            $where = $this->getAdapter()->quoteInto("codPerfil = ?", $dados['codPerfil']);
            $this->update($data, $where);
        } catch (Zend_Exception $e) {
            $this->getAdapter()->rollBack();
            throw new Zend_Exception("N&atilde;o foi possível editar os dados do perfil" . $e->getMessage());
        }
    }
    
}