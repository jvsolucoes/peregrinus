<?php
/**
 * Description of ModuloAcao
 *
 * @author victor
 */
class ModuloAcao extends Zend_Db_Table_Abstract {

    protected $_name = "modulo_acao";
    protected $_primary = array("codModulo", "codAcao");
    
    protected $_referenceMap = array(
        'Modulo' => array(
            'refTableClass' => 'Modulo',
            'refColumns' => 'id',
            'columns' => 'codModulo',
            'onDelete' => self::CASCADE
        ),
        'Acao' => array(
            'refTableClass' => 'Acao',
            'refColumns' => 'id',
            'columns' => 'codAcao',
            'onDelete' => self::CASCADE
        )
    );
    
    public static function buscar($modulo, $acao) {
        $ma = new ModuloAcao();
        
        $sql = $ma->getAdapter()->select()
                                ->from(array("modulo_acao"),
                                        array('*'))
                                ->where("codModulo = ? ", $modulo)
                                ->where("codAcao = ? ", $acao);

        $result = $ma->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $ma->getAdapter()->fetchRow($sql);

        return $result;
        
    }
    
    public function inserir($dados, $acao = NULL) {
        
        if ($acao == "editar") {
            $where = $this->getAdapter()->quoteInto("codModulo = ?", $dados['codModulo']);
            $this->delete($where);
        }
        
        foreach ($dados['acao'] as $key => $valor) {
            $idAcao = $valor;

            $data = array(
                'codModulo' => $dados['codModulo'],
                'codAcao' => $idAcao
            );

            try {
                $this->insert($data);                
            } catch (Exception $e) {
                $this->getAdapter()->rollBack();
                throw new Exception("N&atilde;o foi possível cadastrar a(s) ação(ões) para este Módulo" . $e->getMessage());
            }
        }
        
    }
    
}