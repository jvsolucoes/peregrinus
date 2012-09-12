<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        parent::init();
        
        if (!Usuario::isLogged()) {
            $this->_forward("login");
        } else {
            $this->_usuario = Usuario::isLogged();
            $this->view->usuario = $this->_usuario;
        }
    }

    public function indexAction() {
        $this->view->aplicacao = $this->_getAllParams();
    }
    
    public function loginAction() {
        $this->view->aplicacao = $this->_getAllParams();
        
        // Verifica se foi submetido via POST
        if (!$this->_request->isPost())
            return false;

        // Obt�m os dados passados via POST
        $data = $this->_request->getPost();
        
        $db_adapter = Usuario::getDefaultAdapter();

        // Cria uma instancia de Zend_Auth
        $objAuth = Zend_Auth::getInstance();

        $auth_adapter = new Zend_Auth_Adapter_DbTable($db_adapter, 'usuario', 'login', 'senha', 'sha1(?)');
        
        // Configura as credencias informadas pelo usu�rio
        $auth_adapter->setIdentity($data['login']);
        $auth_adapter->setCredential($data['senha']);

        // Tenta autenticar o usu�rio
        $result = $objAuth->authenticate($auth_adapter);
        
        /**
         * Se o usu�rio for autenticado redireciona para a index e grava seu email,
         * caso contr�rio exibe uma mensagem de alerta na p�gina
         */
        if ($result->isValid()) {
            /**
             * Pega os dados do usu�rio, omitindo a senha
             * http://framework.zend.com/manual/en/zend.auth.adapter.dbtable.html
             */
            $authData = $auth_adapter->getResultRowObject(null, 'senha');
            
            // Armazena os dados do usu�rio
            $objAuth->getStorage()->write($authData);
            
            $this->_forward("index");
            
        } else {
            $this->view->mensagem = 'Os dados informados (login e/ou senha) n&atilde;o s&atilde;o v&aacute;lidos.';
        }
    }
    
    public function logoutAction() {
        $this->view->aplicacao = $this->_getAllParams();
        $objAuth = Zend_Auth::getInstance();

        // Limpa a autenticação
        $objAuth->clearIdentity();
        $this->_redirect("/");
    }

}