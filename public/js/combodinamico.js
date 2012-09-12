/**
 *
 * @copyright Cubo7 - Framework
 *
 * Descrição para funcoes
 *
 * @author Walmir Neto <wfsneto@gmail.com>
 * @link http://cubo7.ismywebsite.com
 * @version alpha
 *
 * Criado em: 30/09/2010, 14:10:53
 */

/**
 *
 */
function confirmacao(msg) {
    var resposta = confirm (msg)
    if (!resposta) {
        history.back(-1);
        return false;
    }
    return true;
}

/**
 * 
 */
function combo(id,target, action){
    $.ajax({
        type: "POST",
        url: action + "/" + id,
        data: "id=" + id,
        beforeSend: function() {
            // enquanto a função esta sendo processada, você
            // pode exibir na tela uma ...
            $(target).html('Processando...'); // ...mensagem de espera
        },
        success: function(txt) {
            // executa quando o servidor responde
            // Pego a div co id = combo2 que está dentro de um select
            // e substituo seu conteudo com o texto enviado pelo php
            $(target).html(txt);
        },
        error: function(txt) {
            //executa quando não responde ou envia um erro
            // em caso de erro você pode dar um alert('msg erro');
            alert('Desculpe, houve um erro interno.');
        }
    });
}

