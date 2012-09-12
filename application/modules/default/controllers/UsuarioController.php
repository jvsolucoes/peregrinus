<?php
/**
 * Description of UsuarioController
 *
 * @author victor
 */
class UsuarioController extends Zend_Controller_Action {
    
    private $_modelUsuario;
    private $_modelAplicacao;
    private $_modelModulo;
    private $_modelAcao;
    private $_modelTrabalhador;
    
    public function init() {
        parent::init();
        
        $this->_modelUsuario = new Usuario();
        $this->_modelAplicacao = new Aplicacao();
        $this->_modelModulo = new Modulo();
        $this->_modelAcao = new Acao();
        $this->_modelTrabalhador = new Trabalhador();
        
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
            
            $this->_modelUsuario->fetchAll(null, 'login ASC');
            
            $this->view->mensagem = "Usuário adicionado com sucesso!";
                
            $this->_forward("listar");
        } else {
            $trabalhadores = $this->_modelTrabalhador->listar();
            $aplicacoes = Aplicacao::listar();
            
            $this->view->aplicacoes = $aplicacoes;
            $this->view->trabalhadores = $trabalhadores;
        }
    }
    
    public function editarAction() {
        $this->view->aplicacao = $this->_getAllParams();
        
        if ($this->_request->isPost()) {
            
            $dados = $this->_request->getPost();
            
            $this->_modelUsuario->editar($dados);
            
            $this->view->mensagem = "Módulo editado com sucesso!";
                
            $this->_forward("listar");
        } else {
            $id = (int) $this->_getParam('id');
            
            $usuario = $this->_modelUsuario->find($id)->current();
            $trabalhadores = $this->_modelTrabalhador->listar();
            $aplicacoes = Aplicacao::listar();
            
            $this->view->trabalhadores = $trabalhadores;
            $this->view->aplicacoes = $aplicacoes;
            $this->view->usuario = $usuario;
        }
        
    }
    
}