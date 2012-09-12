<?php
/**
 * Description of Acao
 *
 * @author victor
 */
class Acao extends Zend_Db_Table_Abstract {

    protected $_name = "acao";
    protected $_primary = array("codAcao");
    protected $_dependentTables = array('ModuloAcao', 'PerfilAplicacaoModuloAcao');
    
    public function listar() {
        $sql = $this->getAdapter()->select()
                    ->from(array("acao"), array("*"))
                    ->order("nomeAcao ASC");
        
        $result = $this->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $this->getAdapter()->fetchAll($sql);

        return $result;
    }
    
    public static function buscarPorModulo($modulo) {
        $acao = new Acao();
        $sql = $acao->getAdapter()->select()
                                ->from(array("a" => "acao"),
                                        array('a.*'))
                                ->join(array('ma' => 'modulo_acao'), 'a.codAcao = ma.codAcao',
                                        array('ma.*'))
                                ->where("ma.codModulo = " . $modulo)
                                ->order("a.nomeAcao ASC");

        $result = $acao->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $acao->getAdapter()->fetchAll($sql);
        
        return $result;
    }
    
    public function inserir($dados) {
        
        $this->getAdapter()->beginTransaction();
        
        $data = array(
            'nomeAcao' => $dados['nomeAcao'],
            'linkAcao' => Functions::gerarLink($dados['nomeAcao'])
        );
        
        try {
            $this->insert($data);
        } catch (Zend_Exception $e) {
            $this->getAdapter()->rollBack();
            throw new Zend_Exception("N&atilde;o foi possível cadastrar a ação" . $e->getMessage());
        }
        
        $this->getAdapter()->commit();
        
    }
    
    public function editar($dados) {
        $this->getAdapter()->beginTransaction();
        
        $data = array(
            'nomeAcao' => $dados['nomeAcao'],
            'linkAcao' => Functions::gerarLink($dados['nomeAcao'])
        );
        
        try {
            $where = $this->getAdapter()->quoteInto("codAcao = ?", $dados['codAcao']);
            $this->update($data, $where);
        } catch (Zend_Exception $e) {
            $this->getAdapter()->rollBack();
            throw new Zend_Exception("N&atilde;o foi possível editar os dados da ação" . $e->getMessage());
        }
        
        $this->getAdapter()->commit();
    }
    
}