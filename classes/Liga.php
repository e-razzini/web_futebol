<?php

class Liga
{

    private $url;
    private $proxy;
    private $dom;
    private $html;
// public $resultadoJogos =[];

    public function __construct()
    {
        $this->proxy = '10.1.21.254:3128';
        $this->url = 'https://www.placardefutebol.com.br/liga-das-nacoes-uefa';
        $this->dom = new DOMDocument();
    }

    private function getContextoConexao()
    {
        $arrayPConfig = array(

            'http' => array(

                'proxy' => $this->proxy,
                'request_fulluri' => true,
            ),

            'https' => array(
                'proxy' => $this->proxy,
                'request_fulluri' => true,
            ),
        );

        $context = stream_context_create($arrayPConfig);

        return $context;
    }

/////
    private function carregarHtml()
    {
        $context = $this->getContextoConexao();
        $this->html = file_get_contents($this->url);
        //$this->html = file_get_contents($this->url, false, $context);

        libxml_use_internal_errors(true);

        $this->dom->loadHTML($this->html);
        libxml_clear_errors();
    }

/////
    private function scannerDivs()
    {

        $todasDiv = $this->dom->getElementsByTagName('div');
        return $todasDiv;
    }

    private function divEncontrarClasse($divPai, $nameClass, $typeAttribute = 'class')
    {

        $divInterna = null;

        foreach ($divPai as $dvsInternas) {

            $buscaClasse = $dvsInternas->getAttribute($typeAttribute);

            if ($buscaClasse == $nameClass) {

                $divInterna = $dvsInternas->getElementsByTagName('div');
                break;
            }
        }
        return $divInterna;
    }

    private function divEncontraTag($subDiv, $nomeClasse, $tagValue = 'a')
    {

        $tagRetornada = null;

        foreach ($subDiv as $dvsInternas) {

            $buscaClasse = $dvsInternas->getAttribute('class');

            if ($buscaClasse == $nomeClasse) {

                $tagRetornada = $dvsInternas->getElementsByTagName($tagValue);
                break;

            }
        }
        return $tagRetornada;
    }

    private function getDados($tagBuscada)
    {

        $arrayTags = [];

        foreach ($tagBuscada as $tagInfo) {

            $tag = str_replace("\n", " ", trim($tagInfo->nodeValue));
            $arrayTags[] = str_replace("    ", "", trim($tag));
        }

        return $arrayTags;
    }

    public function resultadoLiga()
    {

        $this->carregarHtml();
        $tagsDiv = $this->scannerDivs();

        $dp = $this->divEncontrarClasse($tagsDiv, 'container main-content');
        $df = $this->divEncontrarClasse($dp, 'livescore', 'id');

        $dn = $this->divEncontraTag($df, 'container content');

        $capturaTags = $this->getDados($dn);

        $captura = [];
        $captura = $capturaTags;

        return $captura;

    }

}
