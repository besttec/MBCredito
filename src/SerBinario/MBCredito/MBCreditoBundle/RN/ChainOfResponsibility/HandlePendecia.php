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
        
        #Recupera a última consulta do cliente;
        $consulta = $resultDados->getConsultaCliente();
        
        #Recuperando o cliente
        $cliente     = $consulta->getClientesCliente();
            
        #Recupera todas as chamadas do cliente = $cliente
        $calls    = $this->clienteDAO->findCallsCliente($consulta);        
        
        #Retorno 
        return array(
                "cliente"         => $cliente,
                "status"          => $this->statusArray,
                "calls"           => $calls,
                "chamadaAtual"    => $resultDados,
                "consulta"        => $consulta,
                "chamadaAnterior" => null,
                "error"           => null,
                "type"            => null
            );
    }
    
}
