<?php

class CadastroController extends Zend_Controller_Action {

    private $_modelProvedorScm;
    private $_modelProvedorSva;

    public function init() {
        parent::init();

        $this->_modelProvedorScm = new ProvedorScm();


        if (!Usuario::isLogged()) {
            $this->_forward("login");
        } else {
            $this->_usuario = Usuario::isLogged();
            $this->view->usuario = $this->_usuario;
        }
    }

    public function listarAction() {
        $this->view->aplicacao = $this->_getAllParams();

        $usuario = Zend_Auth::getInstance()->getIdentity();
        $this->view->perfil = $usuario->codPerfil;
    }

    public function indexAction() {
        $this->view->aplicacao = $this->_getAllParams();
    }

    public function provedorscmAction() {
        $this->view->aplicacao = $this->_getAllParams();

        if ($this->_request->isPost()) {
            $dados = $this->_request->getPost();
            $acao = $this->_getParam('acao');

            if ($acao == "editar") {
                $idFicha = $this->_modelProvedorScm->editar($dados);
            } else {

                $dados['logo'] = "";
                $adapter = new Zend_File_Transfer_Adapter_Http();
                $adapter->setDestination('img/assinaturas/');

                if (!$adapter->receive()) {
                    $messages = $adapter->getMessages();
                    echo implode("\n", $messages);
                } else {
                    $dados['logo'] = substr($adapter->getFileName(), -11);
                }

                $this->_modelProvedorScm->inserir($dados);
            }

            $this->view->aba = $aba;
            $this->_redirect('/cadastro/listar/');
        }
    }

    public function listarprovedorscmAction() {
        $this->view->aplicacao = $this->_getAllParams();
        
        $provedoreScm = new ProvedorScm();
        $provedores = $provedoreScm->fetchAll();
        
        $this->view->provedores = $provedores;
    }

    public function provedorsvaAction() {
        $this->view->aplicacao = $this->_getAllParams();
    }

    public function clienteAction() {
        $this->view->aplicacao = $this->_getAllParams();
    }

    public function anatelAction() {
        $this->view->aplicacao = $this->_getAllParams();
    }

}