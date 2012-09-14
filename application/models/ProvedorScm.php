<?php
/**
 * Description of ProvedorScm
 *
 * @author luciana
 */
class ProvedorScm extends Zend_Db_Table_Abstract {

    protected $_name = "provedor_scm";
    protected $_primary = array("id");
    
    protected $_referenceMap = array(
        'ContaBancaria' => array(
            'refTableClass' => 'ContaBancaria',
            'refColumns' => 'id',
            'columns' => 'conta_bancaria_id',
            'onDelete' => self::CASCADE
        ),
        'Endereco' => array(
            'refTableClass' => 'Endereco',
            'refColumns' => 'id',
            'columns' => 'id_endereco',
            'onDelete' => self::CASCADE
        )
    );
    
    protected $_modelContaBancaria;
    protected $_modelEndereco;
    protected $_modelUsuario;
    
    private function inicializar() {
        $this->_modelAplicacaoModulo = new AplicacaoModulo();
        $this->_modelContaBancaria = new ContaBancaria();
        $this->_modelEndereco = new Endereco();
        $this->_modelUsuario = new Usuario();
    }
    
    public function inserir($dados) {
        $this->inicializar();
        
        $this->getAdapter()->beginTransaction();
        
//        echo "<pre>";
//        var_dump($dados);
//        die();
        
        $dados['idUsuario'] = $this->_modelUsuario->inserir($dados);
        $dados['idContaBancaria'] = $this->_modelContaBancaria->inserir($dados);
        $dados['idEndereco'] = $this->_modelEndereco->inserir($dados);
                
        $provedorScm = $this->add($dados);
        
        $this->getAdapter()->commit();
        
    }
    
    private function add($dados) {
        $data = array(
            'usuario_id' => $dados['idUsuario'],
            'conta_bancaria_id' => $dados['idContaBancaria'],
            'id_endereco' => $dados['idEndereco'],
            'ativo' => 0,
            'razao' => $dados['razao'],
            'cnpj' => $dados['cnpj'],
            'ie' => $dados['ie'],
            'im' => $dados['im'],
            'nome_fantasia' => $dados['nome_fantasia'],
            'atividade_principal' => $dados['atividade_principal'],
            'telefone_com_1' => $dados['telefone_com_1'],
            'telefone_com_2' => $dados['telefone_com_2'],
            'site' => $dados['site'],
            'logo' => $dados['logo'],
            'observacoes' => $dados['observacoes']
        );
        
        try {
            $this->insert($data);
        } catch (Zend_Exception $e) {
            $this->getAdapter()->rollBack();
            throw new Zend_Exception("N&atilde;o foi possível cadastrar o provedor SCM" . $e->getMessage());
        }
    }
    
    public function editar($dados) {
        $this->inicializar();
        
        $this->getAdapter()->beginTransaction();
        
        $this->edit($dados);
        
        $this->_modelContaBancaria->editar($dados);
        $this->_modelEndreco->editar($dados);
        
        $this->getAdapter()->commit();
    }
    
    private function edit($dados) {
        $data = array(
            'conta_bancaria_id' => $dados['idContaBancaria'],
            'id_endereco' => $dados['idEndereco'],
            'ativo' => $dados['ativo'],
            'razao' => $dados['razao'],
            'cnpj' => $dados['cnpj'],
            'ie' => $dados['ie'],
            'im' => $dados['im'],
            'nome_fantasia' => $dados['nome_fantasia'],
            'atividade_principal' => $dados['principal'],
            'telefone_com_1' => $dados['telefone_com_1'],
            'telefone_com_2' => $dados['telefone_com_2'],
            'site' => $dados['site'],
            'logo' => $dados['logo'],
            'observacoes' => $dados['observacoes']
        );
        
        try {
            $where = $this->getAdapter()->quoteInto("id = ?", $dados['id_provedor_scm']);
            $this->update($data, $where);
        } catch (Zend_Exception $e) {
            $this->getAdapter()->rollBack();
            throw new Zend_Exception("N&atilde;o foi possível editar os dados da aplicação" . $e->getMessage());
        }
    }
    
}