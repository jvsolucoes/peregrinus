<?php

/**
 * Description of Functions
 *
 * @author victor
 */
class Functions {

    function formataData($data) {
        $temp = explode('/', $data);
        if (count($temp) == 3)
            return $temp[2] . "-" . $temp[1] . "-" . $temp[0];
        $temp = explode('-', $data);
        return (count($temp) == 3) ? $temp[2] . "/" . $temp[1] . "/" . $temp[0] : false;
    }

    public static function formatarData($data) {
        $temp = explode('/', $data);
        if (count($temp) == 3)
            return $temp[2] . "-" . $temp[1] . "-" . $temp[0];
        $temp = explode('-', $data);
        return (count($temp) == 3) ? $temp[2] . "/" . $temp[1] . "/" . $temp[0] : false;
    }

    function getAcaoAtual() {
        if (empty($_GET['url']))
            return 'index';
        return (count($temp = explode('/', $_GET['url'])) > 1) ? $temp[1] : 'index';
    }

    public static function gravandoValorNoBanco($valor) {

        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", ".", $valor);

        return $valor;
    }

    /**
     * Recebe o numero do mes de 1-12 e retorna o nome do mês
     * <br>Recebe 4, retorna Abril
     * @param int $mes 7
     * @return String
     */
    function meses($mes) {
        $mes = (int) $mes;
        $array_mes = array(
            1 => "Janeiro",
            2 => "Fevereiro",
            3 => "Mar&ccedil;o",
            4 => "Abril",
            5 => "Maio",
            6 => "Junho",
            7 => "Julho",
            8 => "Agosto",
            9 => "Setembro",
            10 => "Outubro",
            11 => "Novembro",
            12 => "Dezembro"
        );
        $meses = $array_mes[$mes];
        return $meses;
    }

    public static function fullUpper($string) {
        $from = "������������������";
        $to = "������������������";
        return strtr(strtoupper($string), $from, $to);
    }

    public static function replace($string) {
        $caracteres = array("(", ")", "/", "-", ".", " ");

        return str_replace($caracteres, "", $string);
    }

    public static function retira_acentos($texto) {
        $array1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
            , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
        $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
            , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C");
        
        return str_replace($array1, $array2, $texto);
    }
    
    public static function gerarLink($texto) {
        $funcao = new Functions();
        
        $semAcento = $funcao->retira_acentos($texto);
        $lower = strtolower($semAcento);
        $link = str_replace(" ", "", $lower);
        
        return $link;
    }

}

?>
