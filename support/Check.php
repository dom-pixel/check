<?php

namespace App\Support;

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
    public static function Email($Email)
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
    public static function Name($Name)
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
    public static function ClearSpecialCharacters($Name)
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
    public static function CPF($Cpf)
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
    public static function Nascimento($Data)
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
     * <b>Tranforma Data:</b> Transforma uma data no formato DD/MM/YYYY em uma data no formato YYYY-MM-DD!
     * @param STRING $Name = Data em (d/m/Y)
     * @return STRING = $Data = Data no formato YYYY-MM-DD!
     */
    public static function DataDB($Data)
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
     * <b>Tranforma TimeStamp:</b> Transforma uma data no formato DD/MM/YY em uma data no formato TIMESTAMP!
     * @param STRING $Name = Data em (d/m/Y) ou (d/m/Y H:i:s)
     * @return STRING = $Data = Data no formato timestamp!
     */
    public static function Data($Data)
    {
        self::$Format = explode(' ', $Data);
        self::$Data = explode('/', self::$Format[0]);

        if (!checkdate(self::$Data[1], self::$Data[0], self::$Data[2])) :
            return false;
        else :
            if (empty(self::$Format[1])) :
                self::$Format[1] = date('H:i:s');
            endif;

            self::$Data = self::$Data[2] . '-' . self::$Data[1] . '-' . self::$Data[0] . ' ' . self::$Format[1];
            return self::$Data;
        endif;
    }

    /**
     * <b>Tranforma Data e Hora:</b> Transforma uma data no formato YYYY-MM-DD em uma data no formato (d/m/Y) ou (d/m/Y H:i:s)!
     * @param STRING $Name = Data em (Y-m-d) ou (Y-m-d H:i:s)
     * @return STRING = $Data = Data no formato Português Brasil!
     */
    public static function DataTimePtbr($Data)
    {
        if (empty($Data)) :
            return false;
        endif;
        self::$Format = explode(' ', $Data);
        self::$Data = explode('-', self::$Format[0]);

        if (!checkdate(self::$Data[1], self::$Data[2], self::$Data[0])) :
            return false;
        else :
            if (empty(self::$Format[1])) :
                self::$Format[1] = date('H:i:s');
            endif;

            self::$Data = self::$Data[2] . '/' . self::$Data[1] . '/' . self::$Data[0] . ' ' . self::$Format[1];
            return self::$Data;
        endif;
    }

    /**
     * <b>Tranforma Data e Hora:</b> Transforma uma data no formato YYYY-MM-DD em uma data no formato (d/m/Y)!
     * @param STRING $Name = Data em (Y-m-d)
     * @return STRING = $Data = Data no formato Português Brasil!
     */
    public static function DataPtbr($Data)
    {
        self::$Format = explode(' ', $Data);
        self::$Data = explode('-', self::$Format[0]);

        if (!checkdate(self::$Data[1], self::$Data[2], self::$Data[0])) :
            return false;
        else :
            if (empty(self::$Format[1])) :
                self::$Format[1] = date('H:i:s');
            endif;

            self::$Data = self::$Data[2] . '/' . self::$Data[1] . '/' . self::$Data[0];
            return self::$Data;
        endif;
    }

    /**
     * <b>Soma dias a uma data:</b> Soma uma quantidades de dias a uma data Y-m-d!
     * @param DATE $Date = Uma data no formaro Y-m-d
     * @return DATE = $Date = Uma data no Y-m-d
     */
    public static function DataMaisDias($Date, $dias)
    {
        self::$Data = $Date;
        self::$Format = $dias;

        $data_termino = new DateTime(self::$Data);
        $data_termino->add(new DateInterval('P' . self::$Format . 'D'));
        return $data_termino->format('Y-m-d');
    }

    /**
     * <b>Soma meses a uma data:</b> Soma uma quantidades de meses a uma data Y-m-d!
     * @param DATE $Date = Uma data no formaro Y-m-d
     * @return DATE = $Date = Uma data no Y-m-d
     */
    public static function DataMaisMeses($Date, $meses)
    {
        self::$Data = $Date;
        self::$Format = $meses;

        $data_termino = new DateTime(self::$Data);
        $data_termino->add(new DateInterval('P' . self::$Format . 'M'));
        return $data_termino->format('Y-m-d');
    }

    /**
     * <b>Diferença entre duas datas:</b> Recebe duas datas Y-m-d e subtrai a maior pela menor e retorna dias
     * @param DATE $data_ini = Data início
     * @param DATE $data_fim = Data final
     * @param String $retorno = 'd' dias, 'm' meses e 'y' anos
     * @return Int = $dias = Quantidade de dias de $time_final - $time_inicial
     */
    public static function DiffData($data_ini, $data_fim, $retorno = '%a')
    {

        $datetime1 = new DateTime($data_ini);
        $datetime2 = new DateTime($data_fim);
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

    public static function MesAbreviado($mes)
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

    public static function MesAtual($mes)
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

    public static function DiaSemana($diasemana)
    {
        $semana = array(1 => "Segunda", 2 => "Terça", 3 => "Quarta", 4 => "Quinta", 5 => "Sexta", 6 => "Sábado", 0 => "Domingo");

        return $semana[$diasemana];
    }

    public static function DataporExtenso($Data)
    {
        $semana = self::DiaSemana(strftime('%w', strtotime($Data)));
        $dia = strftime('%d', strtotime($Data));
        $mes = self::MesAtual(strftime('%m', strtotime($Data)));
        $ano = strftime('%Y', strtotime($Data));

        return "{$semana}, {$dia} de {$mes} de {$ano}";
    }

    /**
     * <b>Transforma uma string sem ponto e virgula em um float</b> Considera que o float terá 2 casas decimais, para conversão de arquivos textos
     * @param STRING $String = Uma string qualquer
     * @return Flat = $Result = Um número float recebido pelo $String
     */
    public static function StringToFloat($String)
    {
        self::$Data = strip_tags(trim($String));

        $tamanho = strlen(self::$Data);
        $Result = substr(self::$Data, 0, $tamanho - 2) . "." . substr(self::$Data, $tamanho - 2, 2);

        return (float)$Result;
    }

    /**
     * <b>Transforma uma string em Data</b> String no formato DDMMAA em aaaa-mm-aa
     * @param STRING $String = Uma string qualquer
     * @return Flat = $Result = Um número float recebido pelo $String
     */
    public static function StringDDMMAAToDateDB($String)
    {
        self::$Data = strip_tags(trim($String));
        $Result = substr(date('Y'), 0, 2) . substr(self::$Data, 4, 2) . "-" . substr(self::$Data, 2, 2) . "-" . substr(self::$Data, 0, 2);
        return $Result;
    }

    /**
     * <b>Transforma uma Data em String</b> Data no formato AAAA-MM-DD em DDMMAA
     * @param DATE $Date = Date AAAA-MM-DD
     * @return String = $Result = String no formato DDMMAA
     */
    public static function DateDB_AAAAMMDD_To_DDMMAA($Date)
    {
        self::$Data = strip_tags(trim($Date));
        $Result = substr(self::$Data, 8, 2) . substr(self::$Data, 5, 2) . substr(self::$Data, 2, 2);
        return $Result;
    }

    /**
     * <b>Transforma uma Data Y-m-d em String</b> String no formato AAAAMMDD
     * @param DATE $Date = Data Y-m-d
     * @return Flat = $Result = AAAAMMDD
     */
    public static function DateDBLimpaChars($Date)
    {
        self::$Data = strip_tags(trim($Date));
        $Result = substr(self::$Data, 0, 4) . substr(self::$Data, 5, 2) . substr(self::$Data, 8, 2);
        return $Result;
    }

    /**
     * <b>Limita os Palavras:</b> Limita a quantidade de palavras a serem exibidas em uma string!
     * @param STRING $String = Uma string qualquer
     * @return INT = $Limite = String limitada pelo $Limite
     */
    public static function Words($String, $Limite, $Pointer = null)
    {
        self::$Data = strip_tags(trim($String));
        self::$Format = (int)$Limite;

        $ArrWords = explode(' ', self::$Data);
        $NumWords = count($ArrWords);
        $NewWords = implode(' ', array_slice($ArrWords, 0, self::$Format));

        $Pointer = (empty($Pointer) ? '...' : ' ' . $Pointer);
        $Result = (self::$Format < $NumWords ? $NewWords . $Pointer : self::$Data);
        return $Result;
    }

    public static function Chars($String, $Limite)
    {
        self::$Data = strip_tags($String);
        self::$Format = $Limite;
        if (strlen(self::$Data) <= self::$Format) {
            return self::$Data;
        } else {
            $subStr = strrpos(substr(self::$Data, 0, self::$Format), ' ');
            return substr(self::$Data, 0, $subStr) . '...';
        }
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
     * <b>Obter categoria:</b> Informe o name (url) de uma categoria para obter o ID da mesma.
     * @param STRING $category_name = URL da categoria
     * @return INT $category_id = id da categoria informada
     */
    public static function CatByName($CategoryName)
    {
        $read = new Read;
        $read->ExeRead('ws_categories', "WHERE category_name = :name", "name={$CategoryName}");
        if ($read->getRowCount()) :
            return $read->getResult()[0]['category_id'];
        else :
            echo "A categoria {$CategoryName} não foi encontrada!";
            die;
        endif;
    }

    /**
     * <b>Usuários Online:</b> Ao executar este HELPER, ele automaticamente deleta os usuários expirados. Logo depois
     * executa um READ para obter quantos usuários estão realmente online no momento!
     * @return INT = Qtd de usuários online
     */
    public static function UserOnline()
    {
        $now = date('Y-m-d H:i:s');
        $deleteUserOnline = new Delete;
        $deleteUserOnline->ExeDelete('ws_siteviews_online', "WHERE online_endview < :now", "now={$now}");

        $readUserOnline = new Read;
        $readUserOnline->ExeRead('ws_siteviews_online');
        return $readUserOnline->getRowCount();
    }

    /**
     * <b>Imagem Upload:</b> Ao executar este HELPER, ele automaticamente verifica a existencia da imagem na pasta
     * uploads. Se existir retorna a imagem redimensionada!
     * @return HTML = imagem redimencionada!
     */
    public static function Image($ImageUrl, $ImageDesc, $ImageW = null, $ImageH = null)
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
     * Pesquisa imagem do aluno, se existir retorna, se não. Retorna o noavatar da pasta tpl/img
     * @return STRING = URL do avatar
     */
    public static function Avatar($AlunoId)
    {
        $Read = new Read;
        $Read->ExeRead(CF_ALUNOS, "WHERE alunoId = :alId", "alId={$AlunoId}");

        if (!$Read->getResult()) :
            return false;
        else :
            self::$Data = $Read->getResult()[0];
            self::$Format = 'uploads/' . self::$Data['alunoAvatar'];

            if ((file_exists(self::$Format) && !is_dir(self::$Format)) || (file_exists('../' . self::$Format) && !is_dir('../' . self::$Format))) :
                return BASE . '/' . self::$Format;

            elseif (self::$Data['alunoSexo'] == 'f') :
                self::$Format = BASE . '/tpl/_img/f_noavatar.jpg';
                return self::$Format;

            elseif (self::$Data['alunoSexo'] == 'm') :
                self::$Format = BASE . '/tpl/_img/m_noavatar.jpg';
                return self::$Format;
            endif;
        endif;
    }

    /**
     * PEGA NOME DO AGENT DE
     * @return STRING Agent Name
     */
    public static function Agent()
    {
        self::$Data = $_SESSION['useronline']['online_agent'];
        if (empty(self::$Data)) :
            return null;
        else :
            if (strpos(self::$Data, 'Chrome')) :
                return 'Chrome';
            elseif (strpos(self::$Data, 'Firefox')) :
                return 'Firefox';
            elseif (strpos(self::$Data, 'MSIE') || strpos(self::$Data, 'Trident/')) :
                return 'IE';
            else :
                return 'Outros';
            endif;
        endif;
    }

    public static function NewPass($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
    {
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';
        $retorno = '';
        $caracteres = '';

        $caracteres .= $lmin;
        if ($maiusculas) :
            $caracteres .= $lmai;
        endif;
        if ($numeros) :
            $caracteres .= $num;
        endif;
        if ($simbolos) :
            $caracteres .= $simb;
        endif;

        $len = strlen($caracteres);
        for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand - 1];
        }
        return $retorno;
    }

    /**
     * <b>Formata Decimal:</b> Ao executar este HELPER, é formatado o decimal para grava no mysql troca , por .
     * @return decimal válido!
     */
    public static function decimalDB($valor)
    {
        self::$Data = str_replace(".", "", $valor);
        self::$Data = str_replace(",", ".", self::$Data);
        return self::$Data;
    }

    /**
     * <b>Formata Decimal:</b> Ao executar este HELPER, é formatado o decimal para exibir ao usuário PT_BR no mysql troca . por ,
     * @return decimal formatado!
     */
    public static function decimalPtbr($valor)
    {
        return self::$Data = str_replace(".", ",", $valor);
    }

    /**
     * <b>Calcula valor da parcela:</b> Ao executar este HELPER, ele calcula o valor das parcelas e se houver dízima ele coloca o valor maior dos centavos na primeira parcela,
     * @param DECIMAL $v_valor = Valor a ser parcelado
     * @param INT $n_parcelas = quantidade de parcelas
     * @return ARRAY = $parcelas = Valor das parcelas!
     */
    public static function roundPlots($v_valor, $n_parcelas)
    {
        // Valor do mantante (float)
        $montante = $v_valor;

        // Número de parcelas (int)
        $num_parcelas = $n_parcelas;

        // -- não altere daqui para baixo --
        // Valor total
        // (calculado para verificar correção do valor total calculado com montante
        $total = 0;

        // Parcelas, onde cada parcela tem 'numero', 'vencimento' (data) e 'valor'
        $parcelas = array();

        foreach (range(1, $num_parcelas) as $num_parcela) {
            $dias = $num_parcela * 30;

            $parcelas[] = array(
                'numero' => $num_parcela,
                'vencimento' => strtotime("Today +{$dias} days"),
                'valor' => round($montante / $num_parcelas, 2)
            );

            $total += $parcelas[$num_parcela - 1]['valor'];
        }

        /* Corrigir distorção causada divisão e arredondamento de dizima periódica,
          que deixa sobrando/faltando algumas pequenas partes do valor, removendo/adicionando essas
          partes na 1ª parcela
         */
        $parcelas[0]['valor'] = $total > $montante ?
            $parcelas[0]['valor'] - ($total - $montante) :
            $parcelas[0]['valor'] + ($montante - $total);


        return $parcelas;
    }


    /**
     * <b>Calcula valor da parcela:</b> Ao executar este HELPER, ele calcula o valor das parcelas e se houver dízima ele coloca o valor maior dos centavos na primeira parcela,
     * @param DECIMAL $v_valor = Valor a ser parcelado
     * @param INT $n_parcelas = quantidade de parcelas
     * @return ARRAY = $parcelas = Valor das parcelas!
     */
    public static function roundPlotsDecimais($v_valor, $n_parcelas, $n_decimais)
    {
        // Valor do mantante (float)
        $montante = $v_valor;

        // Número de parcelas (int)
        $num_parcelas = $n_parcelas;

        // -- não altere daqui para baixo --
        // Valor total
        // (calculado para verificar correção do valor total calculado com montante
        $total = 0;

        // Parcelas, onde cada parcela tem 'numero', 'vencimento' (data) e 'valor'
        $parcelas = array();

        foreach (range(1, $num_parcelas) as $num_parcela) {
            $dias = $num_parcela * 30;

            $parcelas[] = array(
                'numero' => $num_parcela,
                'vencimento' => strtotime("Today +{$dias} days"),
                'valor' => round($montante / $num_parcelas, $n_decimais)
            );

            $total += $parcelas[$num_parcela - 1]['valor'];
        }

        /* Corrigir distorção causada divisão e arredondamento de dizima periódica,
          que deixa sobrando/faltando algumas pequenas partes do valor, removendo/adicionando essas
          partes na 1ª parcela
         */
        $parcelas[0]['valor'] = $total > $montante ?
            $parcelas[0]['valor'] - ($total - $montante) :
            $parcelas[0]['valor'] + ($montante - $total);


        return $parcelas;
    }

    public static function ProximoDiaX($day, $y, $m, $d)
    {
        $date = date_create();
        date_date_set($date, $y, $m, $d);

        if (date_format($date, 'd') >= $day) :
            if (date_format($date, 'm') + 1 == 2) :
                $days_month = cal_days_in_month(CAL_GREGORIAN, date_format($date, 'm') + 1, date_format($date, 'Y'));
                $date->setDate(date_format($date, 'Y'), date_format($date, 'm') + 1, $days_month);
                return $date->format('Y-m-d');
            else :
                $date->setDate(date_format($date, 'Y'), date_format($date, 'm') + 1, $day);
                return $date->format('Y-m-d');
            endif;
        else :
            if (date_format($date, 'm') == 2 && $day == 30) :
                $days_month = cal_days_in_month(CAL_GREGORIAN, date_format($date, 'm'), date_format($date, 'Y'));
                $date->setDate(date_format($date, 'Y'), date_format($date, 'm'), $days_month);
                return $date->format('Y-m-d');
            else :
                $date->setDate(date_format($date, 'Y'), date_format($date, 'm'), $day);
                return $date->format('Y-m-d');
            endif;
        endif;
    }

    public static function ParcelasCarne($data, $numero)
    {
        $parc = array();
        $parc[] = $data;
        list($ano, $mes, $dia) = explode("-", $data);
        for ($i = 1; $i < $numero; $i++) {
            $mes++;
            if ((int)$mes == 13) {
                $ano++;
                $mes = 1;
            }
            $tira = $dia;
            while (!checkdate($mes, $tira, $ano)) {
                $tira--;
            }
            $parc[] = sprintf("%02d/%02d/%s", $ano, $mes, $tira);
        }
        return $parc;
    }

    /**
     * Adiciona ou suntrai dias da data atual para subtrair colocar valor negativo
     * @param DateTime $dias
     * @return DateTime Adiciona ou Subtrai dias sendo que ai subtrair deve passar negativo
     */
    public static function DataHojeMaisMenosDias($dias)
    {
        return date('Y-m-d', strtotime("{$dias} days"));
    }

    /**
     * Adiciona ou suntrai dias a uma data (Y-m-d) para subtrair colocar valor negativo
     * @param DateTime $dias
     * @return DateTime Adiciona ou Subtrai dias sendo que ai subtrair deve passar negativo
     */
    public static function DataMaisMenosDias($data, $dias)
    {
        return date('Y-m-d', strtotime("{$dias} days", strtotime($data)));
    }

    /*
     * proDiaUtil()
     * Retorna o próximo dia útil em relação a data.
     *
     * @data   -> Variável que recebe a data.
     * 			Formato: DD/MM/AAAA
     */

    public static function proDiaUtil($data)
    {
        // Separa a data
        $dt = explode('-', $data);
        $dia = $dt[2];
        $mes = $dt[1];
        $ano = $dt[0];
        /*
          (1) Pega uma data de referência (variável), compara com o datas definidas pelo sistema (feriados e finais de semana)
          e retorna a próxima data um dia útil
          (2) As datas do sistema são: [1] sábados; [2] domingos; [3] feriados fixos; [4] feriados veriáveis; [5] dias opcionais (ex: quarta de cinza)
          (3) Retorno o próximo/imediato dia útil.
         */

        // 1 - verifica se a data referente é um final de semana (sábado ou domingo);
        // se sábado acrescenta mais 1 dia e faz nova verificação
        // se domingo acrescenta mais 1 dia e faz nova verificação
        $fsem = date('D', mktime(0, 0, 0, $mes, $dia, $ano));
        $i = 1;
        switch ($fsem) {
            case 'Sat':
                return self::proDiaUtil(date(FR_DATA, mktime(0, 0, 0, $mes, $dia + $i, $ano)));
                break;

            case 'Sun':
                return self::proDiaUtil(date(FR_DATA, mktime(0, 0, 0, $mes, $dia + $i, $ano)));
                break;

            default:
                // 2 - verifica se a data referente é um feriado
                if (in_array($data, self::Feriados($ano)) == true) {
                    return self::proDiaUtil(date(FR_DATA, mktime(0, 0, 0, $mes, $dia + $i, $ano)));
                } else {
                    // Retorna o dia útil
                    return $data;
                }
                break;
        }
    }

    /*
     * Feriados()
     * Gera um array com as datas dos feriados com referência no ano da data pesquisada.
     *
     * @ano   -> Variável que recebe o ano base para o cálculo;
     */

    public static function Feriados($ano)
    {
        $feriados = array(
            // Armazena feriados fíxos
            date(FR_DATA, mktime(0, 0, 0, '01', '01', $ano)), // 01/01 Ano novo
            date(FR_DATA, mktime(0, 0, 0, '04', '21', $ano)), // 21/04 Tiradentes
            date(FR_DATA, mktime(0, 0, 0, '05', '01', $ano)), // 01/05 Dia do trabalho
            date(FR_DATA, mktime(0, 0, 0, '09', '07', $ano)), // 07/09 Independencia
            date(FR_DATA, mktime(0, 0, 0, '10', '12', $ano)), // 12/10 Aparecida
            date(FR_DATA, mktime(0, 0, 0, '11', '02', $ano)), // 02/11 Finados
            date(FR_DATA, mktime(0, 0, 0, '11', '15', $ano)), // 15/11 Proclamação
            //date(FR_DATA, mktime(0,0,0,'12','24',$ano)), // 24/12 Véspera de Natal
            date(FR_DATA, mktime(0, 0, 0, '12', '25', $ano)), // 25/12 Natal
            //date(FR_DATA, mktime(0,0,0,'12','31',$ano)), // 31/12 Véspera de Ano novo
            // Armazena feriados variáveis
            //self::flxFeriado($ano, 'pascoa', $r = 1), // Páscoa - Sempre domingo
            self::flxFeriado($ano, 'carn_sab', $r = 1), // Carnaval - Sempre sábado
            self::flxFeriado($ano, 'carn_dom', $r = 1), // Carnaval - Sempre domingo
            self::flxFeriado($ano, 'carn_seg', $r = 1), // Carnaval - Segunda
            self::flxFeriado($ano, 'carn_ter', $r = 1), // Carnaval - Terça
            //strtoupper(self::flxFeriado($ano, 'carn_qua', $r = 1)), // Carnaval - Quarta de cinza
            self::flxFeriado($ano, 'sant_sex', $r = 1), // Sexta Santa
            self::flxFeriado($ano, 'corp_chr', $r = 1)  // Corpus Christi
        );
        return $feriados;
    }

    /*
     * flxFeriado()
     * Calcula os dias de feriados variáveis. Com base na páscoa.
     *
     * @ano   -> Variável que recebe o ano base para o cálculo;
     * @tipo  -> Tipo de dados
     * 			[carn_sab]: Sábado de carnaval;
     * 			[carn_dom]: Domingo de carnaval;
     * 			[carn_seg]: Segunda-feira de carnaval;
     * 			[carn_ter]: Terça-feira de carnaval;
     * 			[carn_qua]: Quarta-feira de carnaval;
     * 			[sant_sex]: Sexta-feira santa;
     * 			[corp_chr]: Corpus Christi;
     */

    public static function flxFeriado($ano, $tipo = NULL)
    {
        $a = explode("/", self::calPascoa($ano));
        switch ($tipo) {
            case 'carn_sab':
                $d = $a[0] - 50;
                break;
            case 'carn_dom':
                $d = $a[0] - 49;
                break;
            case 'carn_seg':
                $d = $a[0] - 48;
                break;
            case 'carn_ter':
                $d = $a[0] - 47;
                break;
            case 'carn_qua':
                $d = $a[0] - 46;
                break;
            case 'sant_sex':
                $d = $a[0] - 2;
                break;
            case 'corp_chr':
                $d = $a[0] + 60;
                break;
            case NULL:
            case 'pascoa':
                $d = $a[0];
                break;
        }
        return date(FR_DATA, mktime(0, 0, 0, $a[1], $d, $a[2]));
    }

    /*
     * calPascoa()
     * Calcula o domingo da pascoa. Base para todos os feriádos móveis.
     *
     * @ano   -> Variável que recebe o ano base para o cálculo ;
     */

    public static function calPascoa($ano)
    {
        $A = ($ano % 19);
        $B = (int)($ano / 100);
        $C = ($ano % 100);
        $D = (int)($B / 4);
        $E = ($B % 4);
        $F = (int)(($B + 8) / 25);
        $G = (int)(($B - $F + 1) / 3);
        $H = ((19 * $A + $B - $D - $G + 15) % 30);
        $I = (int)($C / 4);
        $K = ($C % 4);
        $L = ((32 + 2 * $E + 2 * $I - $H - $K) % 7);
        $M = (int)(($A + 11 * $H + 22 * $L) / 451);
        $P = (int)(($H + $L - 7 * $M + 114) / 31);
        $Q = (($H + $L - 7 * $M + 114) % 31) + 1;
        return date('d/m/Y', mktime(0, 0, 0, $P, $Q, $ano));
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
