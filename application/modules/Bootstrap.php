<?php

class Default_Bootstrap extends Zend_Application_Module_Bootstrap {

    const MODULO = "default";
    /**
     * Initialize autoloader
     *
     * Use the setFallbackAutoloader() method to have the autoloader act
     * as a catch-all
     *
     * @return void
     */
    protected function _initAutoload() {
        $loader = Zend_Loader_Autoloader::getInstance();
        $loader->setFallbackAutoloader(true);
    }

}