<?php

namespace Support;

/**
 * Check.class [ HELPER ]
 * Classe responável por manipular e validade dados do sistema!
 */
class Check
{

    private static $Data;
    private static $Format;

    /**
     * <b>Verifica E-mail:</b> Executa validação de formato de e-mail. Se for um email válido retorna true, ou retorna false.
     * @param STRING $Email = Uma conta de e-mail
     * @return BOOL = True para um email válido, ou false
     */
    public static function email($Email)
    {
        self::$Data = (string)$Email;
        self::$Format = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';

        if (preg_match(self::$Format, self::$Data)) :
            return true;
        else :
            return false;
        endif;
    }

    /**
     * <b>Tranforma URL:</b> Tranforma uma string no formato de URL amigável e retorna o a string convertida!
     * @param STRING $Name = Uma string qualquer
     * @return STRING = $Data = Uma URL amigável válida
     */
    public static function name($Name)
    {
        self::$Format = array();
        self::$Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
        self::$Format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

        self::$Data = strtr(utf8_decode($Name), utf8_decode(self::$Format['a']), self::$Format['b']);
        self::$Data = strip_tags(trim(self::$Data));
        self::$Data = str_replace(' ', '-', self::$Data);
        self::$Data = str_replace(array('-----', '----', '---', '--'), '-', self::$Data);

        return strtolower(utf8_encode(self::$Data));
    }

    /**
     * <b>Limpa Caracteres Especiais:</b> Limpa Caracteres Especiais em uma string com expressões regulares
     * @param STRING $str = Uma string qualquer
     * @return STRING = $str = Sem caracteres especiais
     */
    public static function clearSpecialCharacters($Name)
    {
        self::$Format = array();
        self::$Format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
        self::$Format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

        self::$Data = strtr(utf8_decode($Name), utf8_decode(self::$Format['a']), self::$Format['b']);
        self::$Data = strip_tags(trim(self::$Data));
        //self::$Data = str_replace(' ', '-', self::$Data);
        self::$Data = str_replace(array('     ', '    ', '   ', '  '), ' ', self::$Data);

        return strtolower(utf8_encode(self::$Data));
    }

    /**
     * <b>Checa CPF:</b> Informe um CPF para checar sua validade via algoritimo!
     * @param STRING $CPF = CPF com ou sem pontuação
     * @return BOLEAM = True se for um CPF válido
     */
    public static function cpf($Cpf)
    {
        self::$Data = preg_replace('/[^0-9]/is', '', $Cpf);
        // Verifica se foi informado todos os digitos corretamente
        if (strlen(self::$Data) != 11) {
            return false;
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', self::$Data)) {
            return false;
        }

        $digitoA = 0;
        $digitoB = 0;

        for ($i = 0, $x = 10; $i <= 8; $i++, $x--) {
            $digitoA += self::$Data[$i] * $x;
        }

        for ($i = 0, $x = 11; $i <= 9; $i++, $x--) {
            if (str_repeat($i, 11) == $Cpf) {
                return false;
            }
            $digitoB += self::$Data[$i] * $x;
        }

        $somaA = (($digitoA % 11) < 2) ? 0 : 11 - ($digitoA % 11);
        $somaB = (($digitoB % 11) < 2) ? 0 : 11 - ($digitoB % 11);

        if ($somaA != self::$Data[9] || $somaB != self::$Data[10]) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * <b>Tranforma Data:</b> Transforma uma data no formato DD/MM/YY em uma data no formato YYYY-MM-DD!
     * @param STRING $Name = Data em (d/m/Y)
     * @return STRING = $Data = Data no formato YYYY-MM-DD!
     */
    public static function nascimento($Data)
    {
        self::$Format = explode(' ', $Data);
        self::$Data = explode('/', self::$Format[0]);

        if (checkdate(self::$Data[1], self::$Data[0], self::$Data[2])) :
            self::$Data = self::$Data[2] . '-' . self::$Data[1] . '-' . self::$Data[0];
            return self::$Data;
        else :
            return false;
        endif;
    }

    /**
     * <b>Diferença entre duas datas:</b> Recebe duas datas Y-m-d e subtrai a maior pela menor e retorna dias
     * @param DATE $data_ini = Data início
     * @param DATE $data_fim = Data final
     * @param String $retorno = 'd' dias, 'm' meses e 'y' anos
     * @return Int = $dias = Quantidade de dias de $time_final - $time_inicial
     */
    public static function diffData($data_ini, $data_fim, $retorno = '%a')
    {

        $datetime1 = new \DateTime($data_ini);
        $datetime2 = new \DateTime($data_fim);
        $interval = $datetime1->diff($datetime2);
        return $interval->format($retorno);
        //
        //        $data1 = new DateTime($data_ini);
        //        $data2 = new DateTime($data_fim);
        //
        //        $intervalo = $data1->diff($data2);
        //echo "Intervalo é de {$intervalo->y} anos, {$intervalo->m} meses e {$intervalo->d} dias";
        //return $intervalo->d;
    }

    public static function mesAbreviado($mes)
    {
        $meses = array(
            '01' => 'Jan',
            '02' => 'Fev',
            '03' => 'Mar',
            '04' => 'Abr',
            '05' => 'Mai',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Ago',
            '09' => 'Set',
            '10' => 'Out',
            '11' => 'Nov',
            '12' => 'Dez'
        );

        return $meses[$mes];
    }

    public static function mesAtual($mes)
    {
        $meses = array(
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        );

        return $meses[$mes];
    }

    public static function diaSemana($diasemana)
    {
        $semana = array(1 => "Segunda", 2 => "Terça", 3 => "Quarta", 4 => "Quinta", 5 => "Sexta", 6 => "Sábado", 0 => "Domingo");

        return $semana[$diasemana];
    }

    public static function dataporExtenso($Data)
    {
        $semana = self::DiaSemana(strftime('%w', strtotime($Data)));
        $dia = strftime('%d', strtotime($Data));
        $mes = self::MesAtual(strftime('%m', strtotime($Data)));
        $ano = strftime('%Y', strtotime($Data));

        return "{$semana}, {$dia} de {$mes} de {$ano}";
    }

    public static function limpaStringCharSpecial($string)
    {

        // matriz de entrada
        $what = array('\\', '"', '/', '-', '_', '.', ',');

        // matriz de saída
        $by = array('', '', '', '', '', '', '');

        // devolver a string
        return str_replace($what, $by, trim($string));
    }

    public static function limpaStringCharSpecialAndSpace($string)
    {

        // matriz de entrada
        $what = array('(', ')', '\\', '"', '/', '-', '_', '.', ',', ' ');

        // matriz de saída
        $by = array('', '', '', '', '', '', '', '', '', '');

        // devolver a string
        return str_replace($what, $by, trim($string));
    }

    /**
     * <b>Imagem Upload:</b> Ao executar este HELPER, ele automaticamente verifica a existencia da imagem na pasta
     * uploads. Se existir retorna a imagem redimensionada!
     * @return HTML = imagem redimencionada!
     */
    public static function image($ImageUrl, $ImageDesc, $ImageW = null, $ImageH = null)
    {

        self::$Data = $ImageUrl;

        if (file_exists(self::$Data) && !is_dir(self::$Data)) :
            $patch = BASE;
            $imagem = self::$Data;
            return "<img src=\"{$patch}/tim.php?src={$patch}/{$imagem}&w={$ImageW}&h={$ImageH}\" alt=\"{$ImageDesc}\" title=\"{$ImageDesc}\"/>";
        else :
            return false;
        endif;
    }

    /**
     * <b>IP do Cliente</b> Disponibiliza o número IP do Device do cliente!
     * @return String = $ip = IP do Cliente
     */
    public static function getIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * @param array $src
     * @param array $in
     * @param int|string $pos
     * @return array
     */
    public static function array_push_before($src, $in, $pos)
    {
        if (is_int($pos))
            $R = array_merge(array_slice($src, 0, $pos), $in, array_slice($src, $pos));
        else {
            foreach ($src as $k => $v) {
                if ($k == $pos)
                    $R = array_merge($R, $in);
                $R[$k] = $v;
            }
        }
        return $R;
    }
}
