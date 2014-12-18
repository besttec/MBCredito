<?php
namespace SerBinario\MBCredito\MBCreditoBundle\Util;

use SerBinario\MBCredito\MBCreditoBundle\Util\ServerUtil;
use SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes;
/**
 * Description of MBCreditoUtil
 *
 *  $url = 'http://www8.dataprev.gov.br/SipaINSS/pages/hiscre/hiscreInicio.xhtml';
 * 
 * @author andrey
 */
class MBCreditoUtil 
{   
    /**
     *
     * @var type 
     */
    private $returnServer;
    
    /**
     *
     * @var type 
     */
    private $url;
    
    /**
     *
     * @var type 
     */
    private $server;
    
    /**
     * 
     * @param type $url
     */
    public function __construct($url)
    {
        $this->server       = new ServerUtil();
        $this->url          = $url;
        $this->returnServer = $this->server->open($url);
    }
    
    /**
     * 
     * @param type $string
     * @param type $start
     * @param type $end
     * @return string
     */
    private function between($string, $start, $end)
    {
        $out = explode($start, $string);

        if(isset($out[1]))
        {
            $string = explode($end, $out[1]);
            echo $string[0];
            return $string[0];
        }

        return '';
    } 
    
    /**
     * 
     * @return type
     */
    public function get_captcha()
    {        
        $dom = new \DOMDocument;        
	libxml_use_internal_errors(true);        
	$dom->loadHTML($this->returnServer);

	$nodes = $dom->getElementsByTagName('img');

	foreach($nodes as $node) {
            if($node->getAttribute('id') === "captcha") {                         
                return $node->getAttribute('src'); 
            }
        }    
    }
    
    /**
     * 
     * @return type
     */
    private function get_token()
    {
        $dom = new \DOMDocument;        
	libxml_use_internal_errors(true);        
	$dom->loadHTML($this->returnServer);

	$nodes = $dom->getElementsByTagName('input');

	foreach($nodes as $node) {
            if($node->getAttribute('name') === "DTPINFRA_TOKEN") {                         
                return $node->getAttribute('value'); 
            }
        }    
    }
    
    /**
     * 
     * @return type
     */
    private function get_view_state()
    {   
        $dom = new \DOMDocument;        
	libxml_use_internal_errors(true);        
	$dom->loadHTML($this->returnServer);

	$nodes = $dom->getElementsByTagName('input');
        
	foreach($nodes as $node) {
            if($node->getAttribute('name') === "javax.faces.ViewState") {                              
                return $node->getAttribute('value'); 
            }
        }      
    }
    
    private function getJ_idt()
    {
        $dom = new \DOMDocument;        
	libxml_use_internal_errors(true);        
	$dom->loadHTML($this->returnServer);

	$nodes = $dom->getElementsByTagName('input');
        
	foreach($nodes as $node) {
            var_dump($node->getAttribute('name'));
            if(strripos($node->getAttribute('name'), "j_idt")) {                              
                return "{$node->getAttribute('name')}={$node->getAttribute('value')}"; 
            }
        } 
        
        exit;
    }
    
    /**
     * 
     * @param Clientes $cliente
     */
    public function submitForm(Clientes $cliente, $captcha, $cookie = "")
    {   
        $nomeCliente     = $cliente->getNomeCliente();
        $cpfCliente      = $cliente->getCpfCliente();
        $numBeneficio    = $cliente->getNumBeneficioCliente();
        $dataNascimento  = $cliente->getDataNascCliente();
        $ano             = $dataNascimento->format("Y");
        $mes             = $dataNascimento->format("m");
        $dia             = $dataNascimento->format("d");
        
        $token           = $this->get_token();
        $viewState       = $this->get_view_state();
        $botaoConfirmar	 = "Visualizar";
        //$j_idt26	 = $this->getJ_idt();
        
        $postdata = "nome={$nomeCliente}&DTPINFRA_TOKEN={$token}&cpfCliente={$cpfCliente}&"
        . "nb={$numBeneficio}&ano={$ano}&mes={$mes}&dia={$dia}&"
        . "javax.faces.ViewState={$viewState}&botaoConfirmar={$botaoConfirmar}&j_idt26=j_idt26&captchaId={$captcha}";   
 
        $result   = $this->server->submit($this->url, $postdata);               

        return $result; 
    }

}