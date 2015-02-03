<?php
namespace SerBinario\MBCredito\MBCreditoBundle\RN\ChainOfResponsibility;

use SerBinario\MBCredito\MBCreditoBundle\RN\ChainOfResponsibility\IHandle;
use SerBinario\MBCredito\MBCreditoBundle\RN\ChainOfResponsibility\HandleNormal;
use SerBinario\MBCredito\MBCreditoBundle\DAO\ChamadaDAO;
use SerBinario\MBCredito\MBCreditoBundle\DAO\ClienteDAO;
use SerBinario\MBCredito\UserBundle\Entity\User;
/**
 * Description of HandleValidade
 *
 * @author andrey
 */
class HandleValidade implements IHandle
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
     * @var type 
     */
    private $validador;
    
    /**
     *
     * @var type 
     */
    private $chamadaDAO;
    
    /**
     * 
     * @param HandleNormal $handleSucessor
     */
    public function __construct(HandleNormal $handleSucessor, ClienteDAO $clienteDAO, User $user, $statusArray, $validador, ChamadaDAO $chamadaDAO)
    {
        $this->handleSucessor = $handleSucessor;
        $this->clienteDAO     = $clienteDAO;
        $this->user           = $user;
        $this->statusArray    = $statusArray;
        $this->validador      = $validador;
        $this->chamadaDAO     = $chamadaDAO;
    }
    
    /**
     * 
     * @return type
     */
    public function handle() 
    {        
        #Recuperando chamada com validade
        $resultDados = $this->clienteDAO->findCallDate();
        
        #Verifica se existe chamamada com validade
        if(! $resultDados) {
            return $this->handleSucessor->handle();
        }
        
        #Recuperando o o cliente e alterando o status em chamada
        $cliente = $resultDados->getClientesCliente(); 
        $cliente->setStatusEmChamada(true);                              
        $this->clienteDAO->updateCliente($cliente);
        
        #Recuperando o id da chamada corrente
        $chamadaAnt = $resultDados->getIdChamadaCliente();

        #Cadastrando a nova chamada
        $chamada = new \SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente();
        $chamada->setStatusPendencia(true);
        $chamada->setStatusChamada(false);
        $chamada->setDataPendencia(new \DateTime("now", new \DateTimeZone("America/Recife")));
        $chamada->setUser($this->user);
        
        #Validando o objeto chamada
        $valResult = $this->validador->validate($chamada);
        $error     = null;
        
        #Verifica se houve algum erro de validação
        if(count($valResult) == 0) {
            $this->chamadaDAO->save($chamada);
        } else {
           $error = (string) $valResult;  
        }
        
        #Recupera todas as chamadas do cliente = $cliente
        $calls    = $this->clienteDAO->findCallsCliente($cliente);

        #Recupera a última consulta do cliente;
        $consulta = $resultDados->getConsultaCliente();
        
        #Retorno 
        return array(
                "cliente"         => $cliente,
                "status"          => $this->statusArray,
                "calls"           => $calls,
                "chamadaAtual"    => null,
                "consulta"        => $consulta,
                "chamadaAnterior" => $chamadaAnt,
                "error"           => $error,
                "type"            => "danger"
            );
    }

}
