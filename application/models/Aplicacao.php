<?php
/**
 * Description of Aplicacao
 *
 * @author victor
 */
class Aplicacao extends Zend_Db_Table_Abstract {

    protected $_name = "aplicacao";
    protected $_primary = array("codAplicacao");
    protected $_dependentTables = array('AplicacaoModulo', 'PerfilAplicacaoModuloAcao');
    
    protected $_modelAplicacaoModulo;
    
    private function inicializar() {
        $this->_modelAplicacaoModulo = new AplicacaoModulo();
    }
    
    public static function listar() {

        $aplicacao = new Aplicacao();

        $sql = $aplicacao->getAdapter()->select()
                                ->from(array("aplicacao"),
                                        array("*"))
                                ->order("nomeAplicacao ASC");

        $result = $aplicacao->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $aplicacao->getAdapter()->fetchAll($sql);

        return $result;
    }

    public static function buscarNome($nome) {
        $aplicacao = new Aplicacao();
        
        $sql = $aplicacao->getAdapter()->select()
                                ->from(array("aplicacao"),
                                        array("*"))
                                ->where("linkAplicacao = '" . $nome . "'");

        
        $result = $aplicacao->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $aplicacao->getAdapter()->fetchRow($sql);

        return $result;
    }

    public static function buscarId($id) {
        $aplicacao = new Aplicacao();

        $sql = $aplicacao->getAdapter()->select()
                                ->from(array("aplicacao"),
                                        array("*"))
                                ->where("codAplicacao = " . $id);
        
        $result = $aplicacao->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $aplicacao->getAdapter()->fetchRow($sql);

        return $result;
    }
    
    public function inserir($dados) {
        $this->inicializar();
        
        $this->getAdapter()->beginTransaction();
        
        $aplicacao = $this->add($dados);
        $dados['codAplicacao'] = $aplicacao;
        
        $this->_modelAplicacaoModulo->inserir($dados);
        
        $this->getAdapter()->commit();
        
    }
    
    private function add($dados) {
        $data = array(
            'nomeAplicacao' => $dados['nomeAplicacao'],
            'linkAplicacao' => Functions::gerarLink($dados['nomeAplicacao'])
        );
        
        try {
            $this->insert($data);
            $idAplicacao = $this->getAdapter()->lastInsertId();
        } catch (Zend_Exception $e) {
            $this->getAdapter()->rollBack();
            throw new Zend_Exception("N&atilde;o foi possível cadastrar a aplicação" . $e->getMessage());
        }
        
        return $idAplicacao;
    }
    
    public function editar($dados) {
        $this->inicializar();
        
        $this->getAdapter()->beginTransaction();
        
        $this->edit($dados);
        $acao = "editar";
        $this->_modelAplicacaoModulo->inserir($dados, $acao);
        
        $this->getAdapter()->commit();
    }
    
    private function edit($dados) {
        $data = array(
            'nomeAplicacao' => $dados['nomeAplicacao'],
            'linkAplicacao' => Functions::gerarLink($dados['nomeAplicacao'])
        );
        
        try {
            $where = $this->getAdapter()->quoteInto("codAplicacao = ?", $dados['codAplicacao']);
            $this->update($data, $where);
        } catch (Zend_Exception $e) {
            $this->getAdapter()->rollBack();
            throw new Zend_Exception("N&atilde;o foi possível editar os dados da aplicação" . $e->getMessage());
        }
    }
    
}