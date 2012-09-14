-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 12/09/2012 às 12h02min
-- Versão do Servidor: 5.5.24
-- Versão do PHP: 5.4.6-2~precise+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `peregrinus`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `acao`
--

CREATE TABLE IF NOT EXISTS `acao` (
  `codAcao` int(11) NOT NULL AUTO_INCREMENT,
  `nomeAcao` varchar(45) NOT NULL,
  `linkAcao` varchar(45) NOT NULL,
  PRIMARY KEY (`codAcao`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `acao`
--

INSERT INTO `acao` (`codAcao`, `nomeAcao`, `linkAcao`) VALUES
(1, 'Adicionar', 'adicionar'),
(2, 'Editar', 'editar'),
(3, 'Excluir', 'excluir'),
(4, 'Emitir', 'emitir'),
(6, 'Gerar Relatório', 'gerarrelatorio');

-- --------------------------------------------------------

--
-- Estrutura da tabela `antena`
--

CREATE TABLE IF NOT EXISTS `antena` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setor` char(2) DEFAULT NULL COMMENT 'Ex: A',
  `tipo` int(13) DEFAULT NULL COMMENT 'Ex: Painel',
  `ganho_dbi` int(14) DEFAULT NULL COMMENT 'Ex: 20',
  `rel_fc_db` varchar(45) DEFAULT NULL COMMENT 'Ex: 26,0',
  `meia_pot_graus` varchar(45) DEFAULT NULL COMMENT 'Ex: 90,0',
  `elevacao_graus` varchar(45) DEFAULT NULL COMMENT 'Ex: 90',
  `azimute_graus` varchar(45) DEFAULT NULL COMMENT 'Ex: 187',
  `polarizacao` varchar(45) DEFAULT NULL COMMENT 'Ex: V',
  `altura_m` varchar(45) DEFAULT NULL COMMENT 'Ex: 15',
  `raio_km` varchar(45) DEFAULT NULL COMMENT 'Ex: 4',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aplicacao`
--

CREATE TABLE IF NOT EXISTS `aplicacao` (
  `codAplicacao` int(11) NOT NULL AUTO_INCREMENT,
  `nomeAplicacao` varchar(45) NOT NULL,
  `linkAplicacao` varchar(45) NOT NULL,
  PRIMARY KEY (`codAplicacao`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `aplicacao`
--

INSERT INTO `aplicacao` (`codAplicacao`, `nomeAplicacao`, `linkAplicacao`) VALUES
(1, 'Default', 'default');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aplicacao_modulo`
--

CREATE TABLE IF NOT EXISTS `aplicacao_modulo` (
  `codAplicacao` int(11) NOT NULL,
  `codModulo` int(11) NOT NULL,
  PRIMARY KEY (`codAplicacao`,`codModulo`),
  KEY `fk_aplicacao_modulo_codModulo` (`codModulo`),
  KEY `fk_aplicacao_modulo_codAplicacao` (`codAplicacao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `aplicacao_modulo`
--

INSERT INTO `aplicacao_modulo` (`codAplicacao`, `codModulo`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8);

-- --------------------------------------------------------

--
-- Estrutura da tabela `boleto`
--

CREATE TABLE IF NOT EXISTS `boleto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(45) DEFAULT NULL,
  `data_emissao` varchar(255) NOT NULL,
  `valor_total` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `boleto_has_cliente_servico`
--

CREATE TABLE IF NOT EXISTS `boleto_has_cliente_servico` (
  `boleto_id` int(11) NOT NULL,
  `cliente_servico_id` int(11) NOT NULL,
  PRIMARY KEY (`boleto_id`,`cliente_servico_id`),
  KEY `fk_boleto_has_cliente_servico_cliente_servico1_idx` (`cliente_servico_id`),
  KEY `fk_boleto_has_cliente_servico_boleto1_idx` (`boleto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estacao_id` int(11) NOT NULL,
  `ativo` bit(1) NOT NULL COMMENT '1 - Ativo\n0 - Desativado',
  `data_cadastro` varchar(45) DEFAULT NULL,
  `nome_razao` varchar(255) NOT NULL,
  `cpf_cnpj` varchar(14) NOT NULL,
  `data_nascimento` varchar(45) DEFAULT NULL,
  `telefone_res` varchar(45) DEFAULT NULL,
  `telefone_cel_1` varchar(45) DEFAULT NULL,
  `telefone_cel_2` varchar(45) DEFAULT NULL,
  `email_1` varchar(45) DEFAULT NULL,
  `email_2` varchar(45) DEFAULT NULL,
  `site` varchar(45) DEFAULT NULL,
  `observacoes` text,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_estacao1_idx` (`estacao_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente_has_endereco`
--

CREATE TABLE IF NOT EXISTS `cliente_has_endereco` (
  `cliente_id` int(11) NOT NULL,
  `endereco_id` int(11) NOT NULL,
  PRIMARY KEY (`cliente_id`,`endereco_id`),
  KEY `fk_cliente_has_endereco_endereco1_idx` (`endereco_id`),
  KEY `fk_cliente_has_endereco_cliente1_idx` (`cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente_has_responsavel`
--

CREATE TABLE IF NOT EXISTS `cliente_has_responsavel` (
  `cliente_id` int(11) NOT NULL,
  `responsavel_id` int(11) NOT NULL,
  PRIMARY KEY (`cliente_id`,`responsavel_id`),
  KEY `fk_cliente_has_responsavel_cliente1_idx` (`cliente_id`),
  KEY `fk_cliente_has_responsavel_responsavel` (`responsavel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente_servico`
--

CREATE TABLE IF NOT EXISTS `cliente_servico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `servico_id` int(11) NOT NULL,
  `tarifa_instalacao` double(8,2) NOT NULL DEFAULT '0.00',
  `servico_desconto` varchar(45) DEFAULT NULL,
  `vencimento_dia` int(2) unsigned zerofill NOT NULL,
  `data_inicio` date NOT NULL,
  `data_licenca` date DEFAULT NULL,
  `operadora` varchar(45) NOT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_service_company1` (`cliente_id`),
  KEY `fk_company_service_service1` (`servico_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `conta_bancaria`
--

CREATE TABLE IF NOT EXISTS `conta_bancaria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_banco` varchar(45) DEFAULT NULL,
  `agencia` varchar(255) NOT NULL,
  `conta` varchar(14) NOT NULL,
  `operacao` varchar(40) DEFAULT NULL,
  `titular_nome` varchar(45) DEFAULT NULL,
  `titular_cpf_cnpj` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contrato`
--

CREATE TABLE IF NOT EXISTS `contrato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provedor_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `numero_contratacao` varchar(255) NOT NULL,
  `numero_registro_cartorio` varchar(14) NOT NULL,
  `cartorio_nome` varchar(40) DEFAULT NULL,
  `comarca_municipio` varchar(45) DEFAULT NULL,
  `comarca_data` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contrato_provedor1_idx` (`provedor_id`),
  KEY `fk_contrato_cliente1_idx` (`cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

CREATE TABLE IF NOT EXISTS `endereco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` char(1) DEFAULT NULL COMMENT 'C: cobrança / I: instalação / C: comercial',
  `logradouro` varchar(45) DEFAULT NULL,
  `bairro` varchar(45) DEFAULT NULL,
  `numero` varchar(45) DEFAULT NULL,
  `complemento` varchar(45) DEFAULT NULL,
  `cidade` varchar(45) DEFAULT NULL,
  `estado` varchar(45) NOT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `caixa_postal` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estacao`
--

CREATE TABLE IF NOT EXISTS `estacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) DEFAULT NULL,
  `latitude_graus` int(13) DEFAULT NULL,
  `latitude_minutos` int(14) DEFAULT NULL,
  `latitude_segundos` varchar(45) DEFAULT NULL,
  `longitude_graus` varchar(45) DEFAULT NULL,
  `longitude_minutos` varchar(45) DEFAULT NULL,
  `longitude_segundos` varchar(45) DEFAULT NULL,
  `altitude_metros` varchar(45) DEFAULT NULL,
  `estacao_base` varchar(45) DEFAULT NULL,
  `cap_instalada_mbps` varchar(45) DEFAULT NULL,
  `qtd_acessos_instalados` varchar(45) DEFAULT NULL,
  `qtd_acessos_previstos` varchar(45) DEFAULT NULL,
  `freq_transmissao_1_de` varchar(45) DEFAULT NULL,
  `freq_transmissao_1_ate` varchar(45) DEFAULT NULL,
  `freq_transmissao_2_de` varchar(45) DEFAULT NULL,
  `freq_transmissao_2_ate` varchar(45) DEFAULT NULL,
  `freq_transmissao_3_de` varchar(45) DEFAULT NULL,
  `freq_transmissao_3_ate` int(11) DEFAULT NULL,
  `freq_recepcao_1_de` varchar(45) DEFAULT NULL,
  `freq_recepcao_1_ate` varchar(45) DEFAULT NULL,
  `potencia_transmissor` varchar(45) DEFAULT NULL,
  `potencia_unidade` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estacao_has_antena`
--

CREATE TABLE IF NOT EXISTS `estacao_has_antena` (
  `estacao_id` int(11) NOT NULL,
  `antena_id` int(11) NOT NULL,
  PRIMARY KEY (`estacao_id`,`antena_id`),
  KEY `fk_estacao_has_antena_antena1_idx` (`antena_id`),
  KEY `fk_estacao_has_antena_estacao1_idx` (`estacao_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `modulo`
--

CREATE TABLE IF NOT EXISTS `modulo` (
  `codModulo` int(11) NOT NULL AUTO_INCREMENT,
  `codMenuPai` int(11) DEFAULT NULL,
  `nomeModulo` varchar(45) NOT NULL,
  `linkModulo` varchar(45) NOT NULL,
  `menu` int(4) NOT NULL,
  PRIMARY KEY (`codModulo`),
  KEY `fk_modulo_codMenuPai` (`codMenuPai`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `modulo`
--

INSERT INTO `modulo` (`codModulo`, `codMenuPai`, `nomeModulo`, `linkModulo`, `menu`) VALUES
(1, NULL, 'Cadastro', 'cadastro', 0),
(2, NULL, 'Relatório', 'relatorio', 0),
(3, NULL, 'Tipo de Trabalhador', 'tipotrabalhador', 0),
(4, NULL, 'Perfil', 'perfil', 0),
(5, NULL, 'Ação', 'acao', 0),
(6, NULL, 'Módulo', 'modulo', 0),
(7, NULL, 'Usuário', 'usuario', 0),
(8, NULL, 'Aplicação', 'aplicacao', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `modulo_acao`
--

CREATE TABLE IF NOT EXISTS `modulo_acao` (
  `codModulo` int(11) NOT NULL,
  `codAcao` int(11) NOT NULL,
  PRIMARY KEY (`codModulo`,`codAcao`),
  KEY `fk_modulo_acao_codAcao` (`codAcao`),
  KEY `fk_modulo_acao_codModulo` (`codModulo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `modulo_acao`
--

INSERT INTO `modulo_acao` (`codModulo`, `codAcao`) VALUES
(1, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(1, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(1, 3),
(3, 3),
(4, 3),
(5, 3),
(6, 3),
(7, 3),
(8, 3),
(2, 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `movimentacao`
--

CREATE TABLE IF NOT EXISTS `movimentacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` varchar(45) DEFAULT NULL,
  `tipo` varchar(255) NOT NULL,
  `de_para` varchar(14) NOT NULL,
  `cpf_cnpj` varchar(40) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `valor` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `nfts`
--

CREATE TABLE IF NOT EXISTS `nfts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `boleto_id` int(11) NOT NULL,
  `numero` varchar(45) DEFAULT NULL,
  `cnpj_emitente` varchar(255) NOT NULL,
  `data_emissao` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_nfts_boleto1_idx` (`boleto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil`
--

CREATE TABLE IF NOT EXISTS `perfil` (
  `codPerfil` int(11) NOT NULL AUTO_INCREMENT,
  `nomePerfil` varchar(45) NOT NULL,
  PRIMARY KEY (`codPerfil`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `perfil`
--

INSERT INTO `perfil` (`codPerfil`, `nomePerfil`) VALUES
(1, 'Administrador'),
(2, 'SCM');

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil_aplicacao`
--

CREATE TABLE IF NOT EXISTS `perfil_aplicacao` (
  `codPerfil` int(11) NOT NULL,
  `codAplicacao` int(11) NOT NULL,
  `codModulo` int(11) NOT NULL,
  `codAcao` int(11) NOT NULL,
  PRIMARY KEY (`codPerfil`,`codAplicacao`,`codModulo`,`codAcao`),
  KEY `fk_perfil_aplicacao_codAplicacao` (`codAplicacao`),
  KEY `fk_perfil_aplicacao_codPerfil` (`codPerfil`),
  KEY `fk_perfil_aplicacao_codModulo` (`codModulo`),
  KEY `fk_perfil_aplicacao_codAcao` (`codAcao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `perfil_aplicacao`
--

INSERT INTO `perfil_aplicacao` (`codPerfil`, `codAplicacao`, `codModulo`, `codAcao`) VALUES
(1, 1, 1, 1),
(1, 1, 1, 2),
(1, 1, 1, 3),
(1, 1, 2, 4),
(1, 1, 3, 1),
(1, 1, 3, 2),
(1, 1, 3, 3),
(1, 1, 4, 1),
(1, 1, 4, 2),
(1, 1, 4, 3),
(1, 1, 5, 1),
(1, 1, 5, 2),
(1, 1, 5, 3),
(1, 1, 6, 1),
(1, 1, 6, 2),
(1, 1, 6, 3),
(1, 1, 7, 1),
(1, 1, 7, 2),
(1, 1, 7, 3),
(1, 1, 8, 1),
(1, 1, 8, 2),
(1, 1, 8, 3);

-- --------------------------------------------------------

--
-- Estrutura da tabela `provedor_has_endereco`
--

CREATE TABLE IF NOT EXISTS `provedor_has_endereco` (
  `provedor_id` int(11) NOT NULL,
  `endereco_id` int(11) NOT NULL,
  PRIMARY KEY (`provedor_id`,`endereco_id`),
  KEY `fk_provedor_has_endereco_endereco1_idx` (`endereco_id`),
  KEY `fk_provedor_has_endereco_provedor1_idx` (`provedor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `provedor_has_responsavel`
--

CREATE TABLE IF NOT EXISTS `provedor_has_responsavel` (
  `provedor_id` int(11) NOT NULL,
  `responsavel_id` int(11) NOT NULL,
  PRIMARY KEY (`provedor_id`,`responsavel_id`),
  KEY `fk_provedor_has_responsavel_responsavel1_idx` (`responsavel_id`),
  KEY `fk_provedor_has_responsavel_provedor1_idx` (`provedor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `provedor_has_servico`
--

CREATE TABLE IF NOT EXISTS `provedor_has_servico` (
  `provedor_id` int(11) NOT NULL,
  `servico_id` int(11) NOT NULL,
  PRIMARY KEY (`provedor_id`,`servico_id`),
  KEY `fk_provedor_has_servico_servico1_idx` (`servico_id`),
  KEY `fk_provedor_has_servico_provedor1_idx` (`provedor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `provedor_scm`
--

CREATE TABLE IF NOT EXISTS `provedor_scm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conta_bancaria_id` int(11) NOT NULL,
  `movimentacao_id` int(11) NOT NULL,
  `ativo` bit(1) NOT NULL COMMENT '1 - Ativo\n0 - Desativado',
  `razao` varchar(255) NOT NULL,
  `cnpj` varchar(14) NOT NULL,
  `ie` varchar(40) DEFAULT NULL,
  `im` varchar(45) DEFAULT NULL,
  `nome_fantasia` varchar(255) NOT NULL,
  `atividade_principal` varchar(255) NOT NULL,
  `telefone_com_1` varchar(45) DEFAULT NULL,
  `telefone_com_2` varchar(45) DEFAULT NULL,
  `site` varchar(45) DEFAULT NULL,
  `logo` varchar(45) DEFAULT NULL,
  `observacoes` tinytext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_UNIQUE` (`site`),
  KEY `fk_provedor_conta_bancaria1_idx` (`conta_bancaria_id`),
  KEY `fk_provedor_movimentacao1_idx` (`movimentacao_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `provedor_sva`
--

CREATE TABLE IF NOT EXISTS `provedor_sva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conta_bancaria_id` int(11) NOT NULL,
  `movimentacao_id` int(11) NOT NULL,
  `ativo` bit(1) NOT NULL COMMENT '1 - Ativo\n0 - Desativado',
  `razao` varchar(255) NOT NULL,
  `cnpj` varchar(14) NOT NULL,
  `ie` varchar(40) DEFAULT NULL,
  `im` varchar(45) DEFAULT NULL,
  `nome_fantasia` varchar(255) NOT NULL,
  `atividade_principal` varchar(255) NOT NULL,
  `telefone_com_1` varchar(45) DEFAULT NULL,
  `telefone_com_2` varchar(45) DEFAULT NULL,
  `site` varchar(45) DEFAULT NULL,
  `logo` varchar(45) DEFAULT NULL,
  `circuito_mbps` varchar(45) DEFAULT NULL,
  `perc_utilizacao_link` varchar(45) DEFAULT NULL,
  `observacoes` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_UNIQUE` (`site`),
  KEY `fk_provedor_conta_bancaria1_idx` (`conta_bancaria_id`),
  KEY `fk_provedor_movimentacao1_idx` (`movimentacao_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `responsavel`
--

CREATE TABLE IF NOT EXISTS `responsavel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` char(2) NOT NULL,
  `setor` int(13) DEFAULT NULL,
  `telefone_com` varchar(45) NOT NULL,
  `telefone_cel` varchar(45) DEFAULT NULL,
  `telefone_res` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `imagem_assinatura` varchar(45) DEFAULT NULL,
  `data_validade_assinatura` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico`
--

CREATE TABLE IF NOT EXISTS `servico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_cobranca` char(1) DEFAULT NULL COMMENT 'M: mensal / U: única',
  `descricao` text,
  `valor` double(8,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_razao` varchar(150) NOT NULL COMMENT 'Descrição: Nome/Razão',
  `tipo_pessoa` char(2) NOT NULL COMMENT 'Descrição: Tipo Pessoa\nOpções: PF / PJ',
  `tipo_usuario` char(3) DEFAULT NULL COMMENT 'Descrição: Tipo UsuárioOpções: SCM / SVA / ATL / CLI',
  `cpf_cnpj` varchar(14) NOT NULL,
  `login` varchar(12) NOT NULL,
  `senha` varchar(64) NOT NULL,
  `ativo` bit(1) NOT NULL COMMENT '0 / 1',
  `codPerfil` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_usuario_codPerfil` (`codPerfil`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome_razao`, `tipo_pessoa`, `tipo_usuario`, `cpf_cnpj`, `login`, `senha`, `ativo`, `codPerfil`) VALUES
(12, 'Victor Ribeiro', 'PF', NULL, '06374571452', 'victor', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', b'1', 1);

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `aplicacao_modulo`
--
ALTER TABLE `aplicacao_modulo`
  ADD CONSTRAINT `fk_aplicacao_modulo_codAplicacao` FOREIGN KEY (`codAplicacao`) REFERENCES `aplicacao` (`codAplicacao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_aplicacao_modulo_codModulo` FOREIGN KEY (`codModulo`) REFERENCES `modulo` (`codModulo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `boleto_has_cliente_servico`
--
ALTER TABLE `boleto_has_cliente_servico`
  ADD CONSTRAINT `fk_boleto_has_cliente_servico_boleto1` FOREIGN KEY (`boleto_id`) REFERENCES `boleto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_boleto_has_cliente_servico_cliente_servico1` FOREIGN KEY (`cliente_servico_id`) REFERENCES `cliente_servico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_cliente_estacao1` FOREIGN KEY (`estacao_id`) REFERENCES `estacao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `cliente_has_endereco`
--
ALTER TABLE `cliente_has_endereco`
  ADD CONSTRAINT `fk_cliente_has_endereco_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_has_endereco_endereco1` FOREIGN KEY (`endereco_id`) REFERENCES `endereco` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `cliente_has_responsavel`
--
ALTER TABLE `cliente_has_responsavel`
  ADD CONSTRAINT `fk_cliente_has_responsavel_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_has_responsavel_responsavel` FOREIGN KEY (`responsavel_id`) REFERENCES `responsavel` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `cliente_servico`
--
ALTER TABLE `cliente_servico`
  ADD CONSTRAINT `fk_company_service_company1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_company_service_service1` FOREIGN KEY (`servico_id`) REFERENCES `servico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `contrato`
--
ALTER TABLE `contrato`
  ADD CONSTRAINT `fk_contrato_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_contrato_provedor1` FOREIGN KEY (`provedor_id`) REFERENCES `provedor_sva` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `estacao_has_antena`
--
ALTER TABLE `estacao_has_antena`
  ADD CONSTRAINT `fk_estacao_has_antena_antena1` FOREIGN KEY (`antena_id`) REFERENCES `antena` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_estacao_has_antena_estacao1` FOREIGN KEY (`estacao_id`) REFERENCES `estacao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `modulo`
--
ALTER TABLE `modulo`
  ADD CONSTRAINT `fk_modulo_codMenuPai` FOREIGN KEY (`codMenuPai`) REFERENCES `modulo` (`codModulo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `modulo_acao`
--
ALTER TABLE `modulo_acao`
  ADD CONSTRAINT `fk_modulo_acao_codAcao` FOREIGN KEY (`codAcao`) REFERENCES `acao` (`codAcao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_modulo_acao_codModulo` FOREIGN KEY (`codModulo`) REFERENCES `modulo` (`codModulo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `nfts`
--
ALTER TABLE `nfts`
  ADD CONSTRAINT `fk_nfts_boleto1` FOREIGN KEY (`boleto_id`) REFERENCES `boleto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `perfil_aplicacao`
--
ALTER TABLE `perfil_aplicacao`
  ADD CONSTRAINT `fk_perfil_aplicacao_codAcao` FOREIGN KEY (`codAcao`) REFERENCES `acao` (`codAcao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_perfil_aplicacao_codAplicacao` FOREIGN KEY (`codAplicacao`) REFERENCES `aplicacao` (`codAplicacao`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_perfil_aplicacao_codModulo` FOREIGN KEY (`codModulo`) REFERENCES `modulo` (`codModulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_perfil_aplicacao_codPerfil` FOREIGN KEY (`codPerfil`) REFERENCES `perfil` (`codPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `provedor_has_endereco`
--
ALTER TABLE `provedor_has_endereco`
  ADD CONSTRAINT `fk_provedor_has_endereco_endereco1` FOREIGN KEY (`endereco_id`) REFERENCES `endereco` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_provedor_has_endereco_provedor1` FOREIGN KEY (`provedor_id`) REFERENCES `provedor_sva` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `provedor_has_responsavel`
--
ALTER TABLE `provedor_has_responsavel`
  ADD CONSTRAINT `fk_provedor_has_responsavel_provedor1` FOREIGN KEY (`provedor_id`) REFERENCES `provedor_sva` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_provedor_has_responsavel_responsavel1` FOREIGN KEY (`responsavel_id`) REFERENCES `responsavel` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `provedor_has_servico`
--
ALTER TABLE `provedor_has_servico`
  ADD CONSTRAINT `fk_provedor_has_servico_provedor1` FOREIGN KEY (`provedor_id`) REFERENCES `provedor_sva` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_provedor_has_servico_servico1` FOREIGN KEY (`servico_id`) REFERENCES `servico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `provedor_scm`
--
ALTER TABLE `provedor_scm`
  ADD CONSTRAINT `fk_provedor_conta_bancaria10` FOREIGN KEY (`conta_bancaria_id`) REFERENCES `conta_bancaria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_provedor_movimentacao10` FOREIGN KEY (`movimentacao_id`) REFERENCES `movimentacao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `provedor_sva`
--
ALTER TABLE `provedor_sva`
  ADD CONSTRAINT `fk_provedor_conta_bancaria1` FOREIGN KEY (`conta_bancaria_id`) REFERENCES `conta_bancaria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_provedor_movimentacao1` FOREIGN KEY (`movimentacao_id`) REFERENCES `movimentacao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_codPerfil` FOREIGN KEY (`codPerfil`) REFERENCES `perfil` (`codPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
