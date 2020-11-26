<?php

class PlacarFutebol
{

    private $url;
    private $proxy;
    private $dom;
    private $html;
// public $resultadoJogos =[];

    public function __construct()
    {
        $this->proxy = '10.1.21.254:3128';
        $this->url = 'https://www.placardefutebol.com.br/';
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

//transforma o html em objeto
        $this->dom->loadHTML($this->html);
        libxml_clear_errors();
    }

/////
    private function capturaTodasDivs()
    {

        $todasDiv = $this->dom->getElementsByTagName('div');
        return $todasDiv;
    }

/////
    private function divEncontrar($todasDiv)
    {

        $divInterna = null;

        foreach ($todasDiv as $dvsInternas) {

            $buscaClasse = $dvsInternas->getAttribute('class');

            if ($buscaClasse == 'container content trending-box') {

                $divInterna = $dvsInternas->getElementsByTagName('a');           
                break;
            }
        }
        return $divInterna;
    }
// teste de funcão com paramentros a seu gosto
    private function divEncontrarBuscaTag($todasDiv, $valueAttribute = 'container content', $typeAttribute = 'class', $tagValue = 'a')
    {

        $divInterna = null;

        foreach ($todasDiv as $dvsInternas) {

            $buscaClasse = $dvsInternas->getAttribute($typeAttribute);

            if ($buscaClasse == $valueAttribute) {

                $divInterna = $dvsInternas->getElementsByTagName($tagValue);
                break;
            }
        }
        return $divInterna;
    }

/////
    private function getDados($tagBuscada)
    {

        $arrayTags = null;

        foreach ($tagBuscada as $tagInfo) {

            $tag = str_replace("\n", "", trim($tagInfo->nodeValue));

            if ($tag != "Ver tabela e classificação") {

                $arrayTags[] = str_replace("   ", "", trim($tag));
            }

        }

        return $arrayTags;
    }

    public function resultadoPlacar()
    {

        $this->carregarHtml();
        $tagsDiv = $this->capturaTodasDivs();

        $encontraDiv = $this->divEncontrar($tagsDiv);
        $capturaOutTags = $this->divEncontrarBuscaTag($tagsDiv);

        $capturaTags = $this->getDados($capturaOutTags);
        $capturaTag = $this->getDados($encontraDiv);

        $captura = [];

        $captura = $capturaTags;
        $captura = $capturaTag;

        return $capturaTag;

    }

}
