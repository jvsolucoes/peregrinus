<?php
/**
 * Description of AcaoController
 *
 * @author victor
 */
class AcaoController extends Zend_Controller_Action {
    
    private $_modelAcao;
    
    public function init() {
        parent::init();
        
        $this->_modelAcao = new Acao();
        
        if (!Usuario::isLogged()) {
            $this->_forward("login", "index");
        } else {
            $this->_usuario = Usuario::isLogged();
            $this->view->usuario = $this->_usuario;
        }
        
    }
    
    public function listarAction() {
        $this->view->aplicacao = $this->_getAllParams();
        
        $acoes = $this->_modelAcao->fetchAll(null, 'nomeAcao ASC');
        
        $this->view->acoes = $acoes;
    }
    
    public function cadastrarAction() {
        $this->view->aplicacao = $this->_getAllParams();
        
        if ($this->_request->isPost()) {
            
            $dados = $this->_request->getPost();
            
            $this->_modelAcao->inserir($dados);
            
            $this->view->mensagem = "Ação adicionado com sucesso!";
                
            $this->_forward("listar");
        }
    }
    
    public function editarAction() {
        $this->view->aplicacao = $this->_getAllParams();
        
        if ($this->_request->isPost()) {
            
            $dados = $this->_request->getPost();
            
            $this->_modelAcao->editar($dados);
            
            $this->view->mensagem = "Ação editado com sucesso!";
                
            $this->_forward("listar");
        } else {
            $id = (int) $this->_getParam('id');
            
            $acao = $this->_modelAcao->find($id)->current();
            
            $this->view->acao = $acao;
        }
        
    }
    
}