<?php
/**
 * Description of Modulo
 *
 * @author victor
 */
class Modulo extends Zend_Db_Table_Abstract {

    protected $_name = "modulo";
    protected $_primary = array("codModulo");
    protected $_dependentTables = array('AplicacaoModulo', 'ModuloAcao', 'PerfilAplicacaoModuloAcao');
    
    protected $_modelModuloAcao;
    
    private function inicializar() {
        $this->_modelModuloAcao = new ModuloAcao();
    }
    
    public static function listar($aplicacao) {
        $modulo = new Modulo();
        $sql = $modulo->getAdapter()->select()
                                ->from(array("m" => "modulo"),
                                        array('m.*'))
                                ->join(array('ap' => 'aplicacao_modulo'), 'm.codModulo = ap.codModulo',
                                        array('ap.*'))
                                ->where("ap.codAplicacao = " . $aplicacao)
                                ->order("m.nomeModulo ASC");

        $result = $modulo->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $modulo->getAdapter()->fetchAll($sql);
        
        return $result;
    }
    
    public function listarTodos() {
        
        $sql = $this->getAdapter()->select()
                                ->from(array("m" => "modulo"),
                                        array('m.*'))
                                ->order("m.nomeModulo ASC");

        $result = $this->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $this->getAdapter()->fetchAll($sql);
        
        return $result;
    }

    public static function buscarNome($nome) {
        $modulo = new Modulo();
        $sql = $modulo->getAdapter()->select()
                                ->from(array("modulo"),
                                        array('*'))
                                ->where("linkModulo = '" . $nome . "'");
        
        $result = $modulo->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $modulo->getAdapter()->fetchRow($sql);

        return $result;
    }

    public static function buscarId($id) {
        $modulo = new Modulo();
        $sql = $modulo->getAdapter()->select()
                                ->from(array("modulo"),
                                        array('*'))
                                ->where("id = " . $id)
                                ->order("nomeModulo ASC");

        $result = $modulo->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $modulo->getAdapter()->fetchRow($sql);

        return $result;
    }
    
    public function inserir($dados) {
        $this->inicializar();
        
        $this->getAdapter()->beginTransaction();
        
        $modulo = $this->add($dados);
        $dados['codModulo'] = $modulo;
        
        $this->_modelModuloAcao->inserir($dados);
        
        $this->getAdapter()->commit();
        
    }
    
    private function add($dados) {
        $data = array(
            'nomeModulo' => $dados['nomeModulo'],
            'linkModulo' => Functions::gerarLink($dados['nomeModulo'])
        );
        
        try {
            $this->insert($data);
            $idModulo = $this->getAdapter()->lastInsertId();
        } catch (Zend_Exception $e) {
            $this->getAdapter()->rollBack();
            throw new Zend_Exception("N&atilde;o foi possível cadastrar o módulo" . $e->getMessage());
        }
        
        return $idModulo;
    }
    
    public function editar($dados) {
        $this->inicializar();
        
        $this->getAdapter()->beginTransaction();
        
        $this->edit($dados);
        $acao = "editar";
        $this->_modelModuloAcao->inserir($dados, $acao);
        
        $this->getAdapter()->commit();
    }
    
    private function edit($dados) {
        $data = array(
            'nomeModulo' => $dados['nomeModulo'],
            'linkModulo' => Functions::gerarLink($dados['nomeModulo'])
        );
        
        try {
            $where = $this->getAdapter()->quoteInto("codModulo = ?", $dados['codModulo']);
            $this->update($data, $where);
        } catch (Zend_Exception $e) {
            $this->getAdapter()->rollBack();
            throw new Zend_Exception("N&atilde;o foi possível editar os dados do módulo" . $e->getMessage());
        }
    }
    
}