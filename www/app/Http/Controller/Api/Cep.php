<?php

namespace App\Http\Controller\Api;

use \App\Db\Pagination;
use \App\Http\Request;
use App\Model\Entity\Cep as EntityCep;
use App\Utils\WebService\ViaCep;
use \Exception;

class Cep extends Api {

    /**
     * Método responsável por obter e renderização o resultado do cep
     * @param string $cidade
     * @return string[]
     */
    public static function getCepVero(string $cidade): array
    {

        //CONSULTA NOROESTE CIDADES
        $resultsCidades = EntityCep::getCepVeroCidades($cidade);

        //MENSAGEM DE RETORNO
        if (!empty($resultsCidades)){
            $msg = 'OK DENTRO KMZ';
            $color = 'success';
        }else{
            $msg = 'NÃO ENCONTRADO KMZ';
            $color = 'danger';
        }

        //RETORNA OS ITENS
        return [
            //RETORNA A MENSAGEM
            'operadora' => 'VERO',
            'result' => $msg,
            'color' => $color,
        ];

    }

    /**
     * Método responsável por obter e renderização o resultado do cep
     * @param string $cidade
     * @return string[]
     */
    public static function getCepWebby(string $cidade): array
    {

        //CONSULTA NOROESTE CIDADES
        $resultsCidades = EntityCep::getCepWebbyCidades($cidade);


        //MENSAGEM DE RETORNO
        if (!empty($resultsCidades)){
            $msg = 'OK DENTRO KMZ';
            $color = 'success';
        }else{
            $msg = 'NÃO ENCONTRADO KMZ';
            $color = 'danger';
        }

        //RETORNA OS ITENS
        return [
            //RETORNA A MENSAGEM
            'operadora' => 'WEBBY',
            'result' => $msg,
            'color' => $color,
        ];

    }

    /**
     * Método responsável por obter e renderização o resultado do cep
     * @param string $cidade
     * @return string[]
     */
    public static function getCepNeorede(string $cidade): array
    {

        //CONSULTA NOROESTE CIDADES
        $resultsCidades = EntityCep::getCepNeoredeCidades($cidade);


        //MENSAGEM DE RETORNO
        if (!empty($resultsCidades)){
            $msg = 'OK DENTRO KMZ';
            $color = 'success';
        }else{
            $msg = 'NÃO ENCONTRADO KMZ';
            $color = 'danger';
        }

        //RETORNA OS ITENS
        return [
            'operadora' => 'NEOREDE',
            'result' => $msg,
            'color' => $color,
        ];

    }

    /**
     * Método responsável por obter e renderização o resultado do cep
     * @param string $cep
     * @param string $cidade
     * @return string[]
     */
    public static function getCepAlgar(string $cep, string $cidade): array
    {

        //CONSULTA ALGAR
        $resultsCep = EntityCep::getCepAlgar($cep);

        //CONSULTA ALGAR CIDADES
        $resultsCidades = EntityCep::getCepAlgarCidades($cidade);


        //MENSAGEM DE RETORNO
        if (!empty($resultsCep) OR !empty($resultsCidades)){
            $msg = 'OK DENTRO KMZ';
            $color = 'success';
        }else{
            $msg = 'NÃO ENCONTRADO KMZ';
            $color = 'danger';
        }

        //RETORNA OS ITENS
        return [
            'operadora' => 'ALGAR',
            'result' => $msg,
            'color' => $color,
        ];

    }

    /**
     * Método responsável por obter e renderização o resultado do cep
     * @param string $cep
     * @return string[]
     */
    public static function getCepOI(string $cep): array
    {

        //CONSULTA OI
        $resultsOI = EntityCep::getCepOI($cep);

        //CONSULTA OI SP
        $resultsOISP = EntityCep::getCepOISP($cep);

        //CONSULTA OI SUL
        $resultsOISul = EntityCep::getCepOISul($cep);

        //MENSAGEM DE RETORNO
        if (!empty($resultsOI) OR !empty($resultsOISP) OR !empty($resultsOISul)){
            $msg = 'OK DENTRO KMZ';
            $color = 'success';
        }else{
            $msg = 'NÃO ENCONTRADO KMZ';
            $color = 'danger';
        }

        //RETORNA OS ITENS
        return [
            //RETORNA A MENSAGEM
            'operadora' => 'OI',
            'result' => $msg,
            'color' => $color
        ];

    }

    /**
     * Método responsável por obter e renderização o resultado do cep
     * @param string $cep
     * @return string[]
     */
    public static function getCepVip(string $cep): array
    {

        //CONSULTA VIP
        $results = EntityCep::getCepVip($cep);

        //MENSAGEM DE RETORNO
        if (!empty($results)){
            $msg = 'OK DENTRO KMZ';
            $color = 'success';
        }else{
            $msg = 'NÃO ENCONTRADO KMZ';
            $color = 'danger';
        }

        //RETORNA OS ITENS
        return [
            //RETORNA A MENSAGEM
            'operadora' => 'VIP',
            'result' => $msg,
            'color' => $color
        ];

    }


    /**
     * Método responsável por obter e renderização o resultado do cep
     * @param string $cep
     * @return string[]
     */
    public static function getCepDesktop(string $cep): array
    {

        //CONSULTA DESKTOP
        $results = EntityCep::getCepDesktop($cep);

        //MENSAGEM DE RETORNO
        if (!empty($results)){
            $msg = 'OK DENTRO KMZ';
            $color = 'success';
        }else{
            $msg = 'NÃO ENCONTRADO KMZ';
            $color = 'danger';
        }

        //RETORNA OS ITENS
        return [
            //RETORNA A MENSAGEM
            'operadora' => 'DESKTOP',
            'result' => $msg,
            'color' => $color
        ];

    }

    /**
     * Método responsável por obter e renderização o resultado do cep
     * @param string $cep
     * @return string[]
     */
    public static function getCepVivo(string $cep): array
    {

        //CONSULTA VIVO SP
        $resultsVivoSP = EntityCep::getCepVivoSP($cep);

        //CONSULTA VIVO NACIONAL
        $resultsVivoNacional = EntityCep::getCepVivoNacional($cep);

        //MENSAGEM DE RETORNO
        if (!empty($resultsVivoSP OR !empty($resultsVivoNacional))){
            $msg = 'OK DENTRO KMZ';
            $color = 'success';
        }else{
            $msg = 'NÃO ENCONTRADO KMZ';
            $color = 'danger';
        }

        //RETORNA OS ITENS
        return [
            //RETORNA A MENSAGEM
            'operadora' => 'VIVO',
            'result' => $msg,
            'color' => $color
        ];

    }

    /**
     * Método responsável por obter e renderização o resultado do cep
     * @param string $cep
     * @return string[]
     */
    public static function getCepTim(string $cep): array
    {

        //RESULTADOS CEP TIM
        $results = EntityCep::getCepTim($cep);

        //MENSAGEM DE RETORNO
        if (!empty($results)){
            $msg = 'OK DENTRO KMZ';
            $color = 'success';
        }else{
            $msg = 'NÃO ENCONTRADO KMZ';
            $color = 'danger';
        }

        //RETORNA OS ITENS
        return [
            //RETORNA A MENSAGEM
            'operadora' => 'TIM',
            'result' => $msg,
            'color' => $color
        ];

    }

    /**
     * Método responsável por obter e renderização o resultado do cep
     * @param string $cep
     * @return string[]
     */
    public static function getCepNet(string $cep): array
    {

        //RESULTADOS CEP NET NACIONAL
        $resultsNacional = EntityCep::getCepNetNacional($cep);

        //RESULTADOS CEP NET SP
        $resultsSP = EntityCep::getCepNetSP($cep);

        //REMOVE OS 3 ULTIMOS NÚMEROS
        //$cepSubstr = substr($cep, 0, -3);

        //RESULTADOS CEP NET CIDADE 011
        //$resultsCidades11 = EntityCep::getCepNetCidades11($cepSubstr);

        //MENSAGEM DE RETORNO
        if (!empty($resultsNacional) OR !empty($resultsSP)){
            $msg = 'OK DENTRO KMZ';
            $color = 'success';
        }else{
            $msg = 'NÃO ENCONTRADO KMZ';
            $color = 'danger';
        }

        //RENDERIZA O ITEM
        //RETORNA OS ITENS
        return [
            //RETORNA A MENSAGEM
            'operadora' => 'NET',
            'result' => $msg,
            'color' => $color
        ];

    }

    /**
     * Método responsável por retornar consulta de cep operadora
     * @param string $cep
     * @return array
     */
    public static function getCep(string $cep): array
    {

        //VERIFICA SE O CEP NÃO É VAZIO
        if (empty($cep)){
            return ['Sem CEP'];
        }

        //GET CEP E REMOVE STRINGS
        $cep = preg_replace('/[A-Z a-z\@\.\;\-\" "]+/', '', $cep);

        //CONSULTA SE O CEP EXITE NO VIA CEP
        $address = ViaCep::consultViaCep($cep);

        //VALIDA A INSTANCIA
        if(empty($address)){
            return ['CEP Inválido'];
        }

        //REMOVE CEP QUE COMEÇA COM 0 A ESQUERDA
        $cep = ltrim($cep, "0");

        //RETORNA O RESULTADO EM ARRAY
        return [
            'cep'           => $cep,
            'net_list'      => self::getCepNet($cep),
            'vivo_list'     => self::getCepVivo($cep),
            'tim_list'      => self::getCepTim($cep),
            'algar_list'    => self::getCepAlgar($cep, $address['localidade']),
            'desktop_list'  => self::getCepDesktop($cep),
            'oi_list'       => self::getCepOI($cep),
            'vip_list'      => self::getCepVIP($cep),
            'neorede_list'  => self::getCepNeorede($address['localidade']),
            'webby_list'    => self::getCepWebby($address['localidade']),
            'vero_list'     => self::getCepVero($address['localidade']),
        ];

    }

}