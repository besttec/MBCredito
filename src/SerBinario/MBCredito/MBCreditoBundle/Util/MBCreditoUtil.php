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
    public $returnServer;
    
    /**
     *
     * @var type 
     */
    public $url;
    
    /**
     * 
     * @param type $url
     */
    public function __construct($url)
    {
        $this->url          = $url;
        $this->returnServer = ServerUtil::open($url);
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
            if($node->getAttribute('name') === "captcha") {                         
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
    
    /**
     * 
     * @param Clientes $cliente
     */
    public function submitForm(Clientes $cliente, $url, $cookie = "")
    {   
        $nomeCliente = $cliente->getNomeCliente();
        $cpfCliente  = $cliente->getCpfCliente();
        $token       = $this->get_token();
        $viewState   = $this->get_view_state();
        
        $postdata = "nome={$nomeCliente}&DTPINFRA_TOKEN={$token}";        
        $result   = ServerUtil::submit($url, $postdata, $cookie);               

        return $result; 
    }

}
