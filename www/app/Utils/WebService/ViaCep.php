<?php

namespace App\Utils\WebService;

class ViaCep{


    /**
     * Método responsavel por consultar um cep no via cep
     * @param string
     * @return array
     */
    public static function consultViaCep(string $cep): ?array
    {

        //INICIA O CURL
        $curl = curl_init();

        //CONFIGURAÇÕES DO CURL
        curl_setopt_array($curl,[
            CURLOPT_URL => 'https://viacep.com.br/ws/'.$cep.'/json/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET'
        ]);

        //RESPONSE
        $response = curl_exec($curl);

        //FECHA A CONEXÃO ABERTA
        curl_close($curl);

        //CONVERTE O JSON PARA ARRAY
        $array = json_decode($response,true);

        //RETORNA O CONTEÚDO EM ARRAY
        return isset($array['cep']) ? $array : null;
    }
}