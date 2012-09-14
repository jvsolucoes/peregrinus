<?php
/**
 * Description of PerfilController
 *
 * @author victor
 */
class PerfilController extends Zend_Controller_Action {
    
    private $_modelPerfil;
    private $_modelAplicacao;
    private $_modelModulo;
    private $_modelAcao;
    
    public function init() {
        parent::init();
        
        $this->_modelPerfil = new Perfil();
        $this->_modelAplicacao = new Aplicacao();
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
        
        $perfis = $this->_modelPerfil->fetchAll();
        
        $this->view->perfis = $perfis;
    }
    
    public function cadastrarAction() {
        $this->view->aplicacao = $this->_getAllParams();
        
        if ($this->_request->isPost()) {
            
            $dados = $this->_request->getPost();
            
            $this->_modelPerfil->inserir($dados);
            
            $this->view->mensagem = "Usuário adicionado com sucesso!";
                
            $this->_forward("listar");
        } else {
            $aplicacoes = Aplicacao::listar();
            
            $this->view->aplicacoes = $aplicacoes;
        }
    }
    
    public function editarAction() {
        $this->view->aplicacao = $this->_getAllParams();
        
        if ($this->_request->isPost()) {
            
            $dados = $this->_request->getPost();
            
            $this->_modelPerfil->editar($dados);
            
            $this->view->mensagem = "Perfil editado com sucesso!";
                
            $this->_forward("listar");
        } else {
            $id = (int) $this->_getParam('id');
            
            $perfil = $this->_modelPerfil->find($id)->current();
            $aplicacoes = Aplicacao::listar();
            
            $this->view->aplicacoes = $aplicacoes;
            $this->view->perfil = $perfil;
        }
        
    }
}