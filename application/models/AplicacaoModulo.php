<?php
/**
 * Description of AplicacaoModulo
 *
 * @author victor
 */
class AplicacaoModulo extends Zend_Db_Table_Abstract {

    protected $_name = "aplicacao_modulo";
    protected $_primary = array("codAplicacao", "codModulo");
    
    protected $_referenceMap = array(
        'Aplicacao' => array(
            'refTableClass' => 'Aplicacao',
            'refColumns' => 'id',
            'columns' => 'codAplicacao',
            'onDelete' => self::CASCADE
        ),
        'Modulo' => array(
            'refTableClass' => 'Modulo',
            'refColumns' => 'id',
            'columns' => 'codModulo',
            'onDelete' => self::CASCADE
        )
    );
    
    
    public static function listarCategoria($aplicacao) {
        
        $am = new AplicacaoModulo();
        $sql = $am->getAdapter()->select()
                                ->from(array("am" => "aplicacao_modulo"), array('am.*'))
                                ->join(array("m" => "modulo"), "am.codModulo = m.codModulo", array("m.*"))
                                ->where("am.codAplicacao = ?", $aplicacao)
                                ->order("m.nomeModulo ASC");
        
        $result = $am->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $am->getAdapter()->fetchAll($sql);

        return $result;
                                
    }
    
    public static function buscar($aplicacao) {
        
        $am = new AplicacaoModulo();
        $sql = $am->getAdapter()->select()
                                ->from(array("am" => "aplicacao_modulo"), array('am.*'))
                                ->join(array("m" => "modulo"), "am.codModulo = m.codModulo", array("m.*"))
                                ->where("am.codAplicacao = ?", $aplicacao)
                                ->order("m.nomeModulo ASC");
        
        
        $result = $am->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $am->getAdapter()->fetchAll($sql);

        return $result;
    }
    
    public static function buscarLinha($aplicacao, $modulo) {
        $am = new AplicacaoModulo();
        
        $sql = $am->getAdapter()->select()
                                ->from(array("aplicacao_modulo"),
                                        array('*'))
                                ->where("codAplicacao = ? ", $aplicacao)
                                ->where("codModulo = ? ", $modulo);

        $result = $am->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $am->getAdapter()->fetchRow($sql);

        return $result;
        
    }
    
    public function inserir($dados, $acao = NULL) {
        
        if ($acao == "editar") {
            $where = $this->getAdapter()->quoteInto("codAplicacao = ?", $dados['codAplicacao']);
            $this->delete($where);
        }
        
        foreach ($dados['modulo'] as $key => $valor) {
            $idModulo = $valor;

            $data = array(
                'codAplicacao' => $dados['codAplicacao'],
                'codModulo' => $idModulo
            );

            try {
                $this->insert($data);                
            } catch (Exception $e) {
                $this->getAdapter()->rollBack();
                throw new Exception("N&atilde;o foi possível cadastrar o(s) módulo(s) para esta Aplicação" . $e->getMessage());
            }
        }
        
    }
}