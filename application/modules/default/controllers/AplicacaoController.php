<?php
/**
 * Description of AplicacaoController
 *
 * @author victor
 */
class AplicacaoController extends Zend_Controller_Action {
    
    private $_modelModulo;
    private $_modelAplicacao;
    
    public function init() {
        parent::init();
        
        $this->_modelModulo = new Modulo();
        $this->_modelAplicacao = new Aplicacao();
        
        if (!Usuario::isLogged()) {
            $this->_forward("login", "index");
        } else {
            $this->_usuario = Usuario::isLogged();
            $this->view->usuario = $this->_usuario;
        }
        
    }
    
    public function listarAction() {
        $this->view->aplicacao = $this->_getAllParams();
        
        $aplicacoes = Aplicacao::listar();
        
        $this->view->aplicacoes = $aplicacoes;
    }
    
    public function cadastrarAction() {
        $this->view->aplicacao = $this->_getAllParams();
        
        if ($this->_request->isPost()) {
            
            $dados = $this->_request->getPost();
            
            $this->_modelAplicacao->inserir($dados);
            
            $this->view->mensagem = "Aplicação adicionada com sucesso!";
                
            $this->_forward("listar");
        } else {
            $modulos = $this->_modelModulo->listarTodos();
            $this->view->modulos = $modulos;
        }
    }
    
    public function editarAction() {
        $this->view->aplicacao = $this->_getAllParams();
        
        if ($this->_request->isPost()) {
            
            $dados = $this->_request->getPost();
            
            $this->_modelAplicacao->editar($dados);
            
            $this->view->mensagem = "Aplicação editada com sucesso!";
                
            $this->_forward("listar");
        } else {
            $id = (int) $this->_getParam('id');
            
            $aplicacao = $this->_modelAplicacao->find($id)->current();
            $modulos = $this->_modelModulo->listarTodos();
            
            $this->view->app = $aplicacao;
            $this->view->modulos = $modulos;
        }
        
    }
    
}