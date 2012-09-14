<?php
/**
 * Description of UsuarioAplicacaoModuloAcao
 *
 * @author victor
 */
class PerfilAplicacaoModuloAcao extends Zend_Db_Table_Abstract {

    protected $_name = "perfil_aplicacao";
    protected $_primary = array("codPerfil", "codAplicacao", "codModulo", "codAcao");
    
    protected $_referenceMap = array(
        'Perfil' => array(
            'refTableClass' => 'Perfil',
            'refColumns' => 'id',
            'columns' => 'codPerfil',
            'onDelete' => self::CASCADE
        ),
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
        ),
        'Acao' => array(
            'refTableClass' => 'Acao',
            'refColumns' => 'id',
            'columns' => 'codAcao',
            'onDelete' => self::CASCADE
        )
    );
    
    public static function buscarIdPerfil($id) {
        $pa = new PerfilAplicacaoModuloAcao();
        $sql = $pa->getAdapter()->select()
                                ->from(array("perfil_aplicacao"),
                                        array("*"))
                                ->where("codPerfil = ?", $id);

        $result = $pa->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $pa->getAdapter()->fetchAll($sql);

        return $result;
    }

    public static function buscarUsuario($id) {
        $amc = new AplicacaoModuloAcao();

        $sql = $amc->getAdapter()->select()
                                ->from(array("tb_usuario_aplicacao_modulo_acao"),
                                        array("*"))
                                ->where("id_usuario = ?", $id)
                                ->group("id_modulo");
        
        $result = $amc->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $amc->getAdapter()->fetchAll($sql);

        return $result;
    }

    public static function buscarUsuarioAcao($id) {
        $amc = new AplicacaoModuloAcao();

        $sql = $amc->getAdapter()->select()
                                ->from(array("tb_usuario_aplicacao_modulo_acao"),
                                        array("*"))
                                ->where("id_usuario = ?", $id);

        $result = $amc->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $amc->getAdapter()->fetchAll($sql);

        return $result;
    }

    public static function buscarPermissoes($idUsuario, $idAplicacao, $idModulo, $idAcao) {

        $app = new UsuarioAplicacaoModuloAcao();

        $sql = $app->getAdapter()->select()
                                ->from(array("tb_usuario_aplicacao_modulo_acao"),
                                        array("*"))
                                ->where("id_usuario = ?", $idUsuario)
                                ->where("id_aplicacao = ?", $idAplicacao)
                                ->where("id_modulo = ?", $idModulo)
                                ->where("id_acao = ?", $idAcao);

        $result = $app->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $app->getAdapter()->fetchAll($sql);

        return $result;
    }

    public static function buscarPermissoesModulo($idPerfil, $idAplicacao, $idModulo) {

        $app = new PerfilAplicacaoModuloAcao();

        $sql = $app->getAdapter()->select()
                                ->from(array("perfil_aplicacao"),
                                        array("*"))
                                ->where("codPerfil = ?", $idPerfil)
                                ->where("codAplicacao = ?", $idAplicacao)
                                ->where("codModulo = ?", $idModulo)
                                ->group("codModulo");

        $result = $app->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $result = $app->getAdapter()->fetchAll($sql);

        return $result;
    }
    
    public function inserir($dados) {
        
        $existe = $this->fetchAll("codPerfil = " . $dados['codPerfil']);
        
        if ($existe->count() > 0) {
            $where = $this->getAdapter()->quoteInto("codPerfil = ?", $dados['codPerfil']);
            $this->delete($where);
        }
        
        foreach ($dados['permissao'] as $key => $aplicacoes) {
            $aplicacao = $key;
            
            foreach ($aplicacoes as $indice => $modulos) {
                $modulo = $indice;

                foreach ($modulos as $acao => $valor) {

                    $data = array(
                        'codPerfil' => $dados['codPerfil'],
                        'codAplicacao' => $aplicacao,
                        'codModulo' => $modulo,
                        'codAcao' => $acao
                    );
                    
                    try {
                        $this->insert($data);                
                    } catch (Exception $e) {
                        $this->getAdapter()->rollBack();
                        throw new Exception("N&atilde;o foi possível cadastrar a(s) permissão(ões) para este perfil" . $e->getMessage());
                    }
                }
                
            }
            
        }
        
    }
    
}