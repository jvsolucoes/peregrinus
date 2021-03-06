<?php
/**
 * Description of UsuarioController
 *
 * @author victor
 */
class UsuarioController extends Zend_Controller_Action {
    
    private $_modelUsuario;
    private $_modelPerfil;   
    
    public function init() {
        parent::init();
        
        $this->_modelUsuario = new Usuario();
        $this->_modelPerfil = new Perfil();
        
        if (!Usuario::isLogged()) {
            $this->_forward("login", "index");
        } else {
            $this->_usuario = Usuario::isLogged();
            $this->view->usuario = $this->_usuario;
        }
        
    }
    
    public function listarAction() {
        $this->view->aplicacao = $this->_getAllParams();
        
        $usuarios = $this->_modelUsuario->fetchAll();
        
        $this->view->usuarios = $usuarios;
    }
    
    public function cadastrarAction() {
        $this->view->aplicacao = $this->_getAllParams();
        
        if ($this->_request->isPost()) {
            
            $dados = $this->_request->getPost();
            
            $this->_modelUsuario->inserir($dados);
            
            $this->view->mensagem = "Usuário adicionado com sucesso!";
                
            $this->_forward("listar");
        } else {
            $perfis = $this->_modelPerfil->fetchAll(null, 'nomePerfil ASC');
            $this->view->perfis = $perfis;
        }
    }
    
    public function editarAction() {
        $this->view->aplicacao = $this->_getAllParams();
        
        if ($this->_request->isPost()) {
            
            $dados = $this->_request->getPost();
            
            $this->_modelUsuario->editar($dados);
            
            $this->view->mensagem = "Usuário editado com sucesso!";
                
            $this->_forward("listar");
        } else {
            $id = (int) $this->_getParam('id');
            
            $usuario = $this->_modelUsuario->find($id)->current();
            $perfis = $this->_modelPerfil->fetchAll(null, 'nomePerfil ASC');
            
            $this->view->perfis = $perfis;
            $this->view->usuario = $usuario;
        }
        
    }
    
}