<?php
/**
 * Description of ModuloController
 *
 * @author victor
 */
class ModuloController extends Zend_Controller_Action {
    
    private $_modelModulo;
    private $_modelAcao;
    
    public function init() {
        parent::init();
        
        $this->_modelModulo = new Modulo();
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
        
        $modulos = $this->_modelModulo->listarTodos();
        
        $this->view->modulos = $modulos;
    }
    
    public function cadastrarAction() {
        $this->view->aplicacao = $this->_getAllParams();
        
        if ($this->_request->isPost()) {
            
            $dados = $this->_request->getPost();
            
            $this->_modelModulo->inserir($dados);
            
            $this->view->mensagem = "Módulo adicionado com sucesso!";
                
            $this->_forward("listar");
        } else {
            $acoes = $this->_modelAcao->listar();
            $this->view->acoes = $acoes;
        }
    }
    
    public function editarAction() {
        $this->view->aplicacao = $this->_getAllParams();
        
        if ($this->_request->isPost()) {
            
            $dados = $this->_request->getPost();
            
            $this->_modelModulo->editar($dados);
            
            $this->view->mensagem = "Módulo editado com sucesso!";
                
            $this->_forward("listar");
        } else {
            $id = (int) $this->_getParam('id');
            
            $modulo = $this->_modelModulo->find($id)->current();
            $acoesModulo = $modulo->findDependentRowSet('ModuloAcao');
            
            $acoes = $this->_modelAcao->listar();
            
            $this->view->acoesModulo = $acoesModulo;
            $this->view->acoes = $acoes;
            $this->view->modulo = $modulo;
        }
        
    }
    
}