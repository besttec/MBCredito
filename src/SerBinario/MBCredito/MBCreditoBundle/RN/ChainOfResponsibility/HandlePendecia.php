<?php
namespace SerBinario\MBCredito\MBCreditoBundle\RN\ChainOfResponsibility;

use SerBinario\MBCredito\MBCreditoBundle\RN\ChainOfResponsibility\IHandle;
use SerBinario\MBCredito\MBCreditoBundle\RN\ChainOfResponsibility\HandleValidade;
use SerBinario\MBCredito\MBCreditoBundle\DAO\ClienteDAO;
use SerBinario\MBCredito\UserBundle\Entity\User;

/**
 * Description of HandlePendecia
 *
 * @author andrey
 */
class HandlePendecia implements IHandle
{    
    /**
     *
     * @var type 
     */
    private $handleSucessor;
    
    /**
     *
     * @var type 
     */
    private $clienteDAO;
    
    /**
     *
     * @var type 
     */
    private $user;
    
    /**
     *
     * @var type 
     */
    private $statusArray;
    
    /**
     * 
     * @param HandleValidade $handleSucessor
     */
    public function __construct(HandleValidade $handleSucessor, ClienteDAO $clienteDAO, User $user, $statusArray)
    {
        $this->handleSucessor = $handleSucessor;
        $this->clienteDAO     = $clienteDAO;
        $this->user           = $user;
        $this->statusArray    = $statusArray;
    }
    
    /**
     * 
     * @return type
     */
    public function handle() 
    {      
        #Resuperando ligação pendente
        $resultDados = $this->clienteDAO->findCallPen($this->user);
        
        #Verifica se existe chamamada pendente
        if(! $resultDados) {
            return $this->handleSucessor->handle();
        }
        
        #Recupera a consulta corrente;
        $consulta = $resultDados->getConsultaCliente();
        
        #Recuperando o cliente
        $cliente     = $consulta->getClientesCliente();
        
        //tipos dos créditos
        $valorTipoCredito = array();
        //valores para o tipo de crédito 13ª salário
        $valorArray13     = array();
        
        //pega o tipo de crédito pessoal
        $tipoCreditoP = $consulta->getTipoCreditoCliente();
        
        //pega tipo de crédito consignado
        $tipoCreditoC = $consulta->getTipoCreditoConsignado();
        
        //Condição para tratar os tipo de crédito consignado
        if($tipoCreditoC) {
            if($tipoCreditoC == "1") {
                $valorTipoCredito = array('number' => '1', 'rotulo' => 'Tipo Crédito Consignado', 'tipo' => 'Crédito Renovação');
            } else if($tipoCreditoC == "2") {
                $valorTipoCredito = array('number' => '2', 'rotulo' => 'Tipo Crédito Consignado', 'tipo' => 'Crédito Novo');
            }           
        }
        
        //Condição para tratar os tipo de crédito pessoal
        if($tipoCreditoP) {
            if($tipoCreditoP == "1") {
                $valorTipoCredito = array('number' => '1', 'rotulo' => 'Tipo Crédito Pessoal', 'tipo' => 'Crédito Renovação');
            } else if ($tipoCreditoP == "2") {
                $valorTipoCredito = array('number' => '2', 'rotulo' => 'Tipo Crédito Pessoal', 'tipo' => 'Crédito Novo');
            } else if ($tipoCreditoP == "3") {
                $valorTipoCredito = array('number' => '3', 'rotulo' => 'Tipo Crédito Pessoal', 'tipo' => 'Antecipação de 13ª Salário');
                //Pega os valor correspondente ao tipo de crédito 13ª salário
                $valores13 = $consulta->getAntecipacoes13();
                if($valores13) {
                   $valorArray13 = $valores13;
                } else {
                   $valorArray13 = null;
                }
            } else if($tipoCreditoP == "4") {
                $valorTipoCredito = array('number' => '4', 'rotulo' => 'Tipo Crédito Pessoal', 'tipo' => 'Crédito Automático');
            }
        }       
        
        #Recupera todas as chamadas do cliente = $cliente
        $calls       = $this->clienteDAO->findCallsCliente($consulta); 
        $chamadaAnt  = null;
        
        if(count($calls) > 1) {
            $chamadaAnt = $calls[count($calls) - 2];
        }
        
        #Retorno 
        return array(
                "cliente"         => $cliente,
                "status"          => $this->statusArray,
                "calls"           => $calls,
                "chamadaAtual"    => $resultDados,
                "consulta"        => $consulta,
                "chamadaAnterior" => $chamadaAnt,
                "error"           => null,
                "type"            => null,
                "tipoCredito"     => $valorTipoCredito,
                "valorArray13"    => $valorArray13
            );
    }
    
}
