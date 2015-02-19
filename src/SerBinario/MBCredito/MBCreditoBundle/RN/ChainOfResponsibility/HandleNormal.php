<?php
namespace SerBinario\MBCredito\MBCreditoBundle\RN\ChainOfResponsibility;

use SerBinario\MBCredito\MBCreditoBundle\RN\ChainOfResponsibility\IHandle;
use SerBinario\MBCredito\MBCreditoBundle\Entity\ConvenioPA;
use SerBinario\MBCredito\MBCreditoBundle\DAO\ChamadaDAO;
use SerBinario\MBCredito\MBCreditoBundle\DAO\ClienteDAO;
use SerBinario\MBCredito\UserBundle\Entity\User;
/**
 * Description of HandleNormal
 *
 * @author andrey
 */
class HandleNormal implements IHandle
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
     * @var type 
     */
    private $convenioPA;
    
    /**
     * 
     * @param HandleNormal $handleSucessor
     */
    public function __construct(ClienteDAO $clienteDAO, User $user, $statusArray, $validador, ChamadaDAO $chamadaDAO, ConvenioPA $convenioPA = null)
    {
        $this->handleSucessor = null;
        $this->clienteDAO     = $clienteDAO;
        $this->user           = $user;
        $this->statusArray    = $statusArray;
        $this->validador      = $validador;
        $this->chamadaDAO     = $chamadaDAO;
        $this->convenioPA     = $convenioPA;
    }
    
    /**
     * 
     * @return type
     */
    public function handle() 
    {   
        #Verifica se existe convênio vinculado.
        if( !$this->convenioPA) {
            return array(
                "error" => "Não existe convênio vinculado, contate o administrador!",
                "type"  => "danger"
                );
        } 
        
        #Parametros da consulta de clientes
        $idConvenioPA     = $this->convenioPA->getConvenio()->getId();
        $estadoConvenioPA = $this->convenioPA->getEstado();
        
        #Recupera uma consulta que já foi consultado e não está sendo atendido por nenhum callcenter
        $consulta = $this->clienteDAO->findNotUse($idConvenioPA, $estadoConvenioPA);       
        
        #Verifica se existe cliente.
        if( !$consulta) {
            return array(
                "error" => "Não existe cliente disponível",
                "type"  => "danger"
                );
        } 
                
        #Recuperando o cliente da consulta
        $cliente  = $consulta->getClientesCliente();
        
        #Alterando o status em chamada do cliente
        $cliente->setStatusEmChamada(true);                              
        $this->clienteDAO->updateCliente($cliente);                

        #Cadastrando a nova chamada
        $chamada = new \SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente();
        $chamada->setStatusPendencia(true);
        $chamada->setStatusChamada(false);
        $chamada->setDataPendencia(new \DateTime("now", new \DateTimeZone("America/Recife")));
        $chamada->setConsultaCliente($consulta);
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
        $calls    = $this->clienteDAO->findCallsCliente($consulta);
        
        #Retorno 
        return array(
                "cliente"         => $cliente,
                "status"          => $this->statusArray,
                "calls"           => $calls,
                "chamadaAtual"    => $chamada,
                "consulta"        => $consulta,
                "chamadaAnterior" => null,
                "error"           => $error,
                "type"            => "danger",
                "tipoCredito"     => $valorTipoCredito,
                "valorArray13"    => $valorArray13
            );
    }

}