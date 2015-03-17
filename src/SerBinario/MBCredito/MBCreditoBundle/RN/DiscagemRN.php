<?php
namespace SerBinario\MBCredito\MBCreditoBundle\RN;

use Doctrine\ORM\EntityManager;
use SerBinario\MBCredito\UserBundle\Entity\User;
use SerBinario\MBCredito\MBCreditoBundle\RN\ChainOfResponsibility\HandlePendecia;
use SerBinario\MBCredito\MBCreditoBundle\RN\ChainOfResponsibility\HandleValidade;
use SerBinario\MBCredito\MBCreditoBundle\RN\ChainOfResponsibility\HandleNormal;
use SerBinario\MBCredito\MBCreditoBundle\DAO\AgenciaPaDAO;
use SerBinario\MBCredito\MBCreditoBundle\DAO\ClienteDAO;
use SerBinario\MBCredito\MBCreditoBundle\DAO\StatusDAO;
use SerBinario\MBCredito\MBCreditoBundle\DAO\ChamadaDAO;
use SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente;
use SerBinario\MBCredito\MBCreditoBundle\DAO\SubRotinasDAO;

/**
 * Description of DiscagemRN
 *
 * @author andrey
 */
class DiscagemRN 
{    
    /**
     *
     * @var type 
     */
    private $manager;
    
    /**
     *
     * @var type 
     */
    private $user;
    
    /**
     *
     * @var type 
     */
    private $validator;
    
    /**
     * Método construtor
     * 
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager, User $user, $validator) 
    {
        $this->manager   = $manager;
        $this->user      = $user;
        $this->validator = $validator;
    }
    
    /**
     * 
     * @param User $user
     */
    public function discagem()
    {
        #Parametros dos handles da cadeia
        $agenciaPaDAO  = new AgenciaPaDAO($this->manager);
        $objAgenciaPA  = $agenciaPaDAO->findByUserLast($this->user);
        $chamadaDAO    = new ChamadaDAO($this->manager);
        $clienteDAO    = new ClienteDAO($this->manager);
        $statusDAO     = new StatusDAO($this->manager);
        $status        = $statusDAO->findAll();       
        
        #Criação da cadeia de responsabilidade.
        $handleNormal    = new HandleNormal($clienteDAO, $this->user, $status, $this->validator, $chamadaDAO, $objAgenciaPA);
        $handleValidade  = new HandleValidade($handleNormal, $clienteDAO, $this->user, $status, $this->validator, $chamadaDAO);
        $handlePendencia = new HandlePendecia($handleValidade, $clienteDAO, $this->user, $status);
                
        #Dispara o tratamento na cadeia de responsabilidade
        $result = $handlePendencia->handle();
        
        #array de retorno
        return $result;
    }
    
    /**
     * 
     * @param type $chamadaAtual
     * @param ChamadaCliente $chamadaDados
     * @param type $statusId
     * @param type $subrotinaId
     * @param type $dtProxLig
     * @param type $chamadaAnt
     */
    public function saveDiscagem($chamadaAtual, ChamadaCliente $chamadaDados, $statusId, $subrotinaId, $dtProxLig, $chamadaAnt)
    {        
        #Verificação da existência de campos obrigatórios
        if($statusId != "" && $subrotinaId != "") {        
            #Parametros de retorno
            $error = null;
            $type  = null;

            #Recuperando a chamada atual no banco de dados
            $chamadaDAO   = new ChamadaDAO($this->manager);
            $objChamada   = $chamadaDAO->findById($chamadaAtual);
            //$objChamada->setStatusChamada(true);

            #Recuperando o status no banco de dados
            $statusDAO    = new StatusDAO($this->manager);
            $status       = $statusDAO->findById($statusId);

            #Recuperando a subrotina no banco de dados
            $subrotinaDAO = new  SubRotinasDAO($this->manager);
            $subrotina    = $subrotinaDAO->findById($subrotinaId);
            
            #Recuperando a consulta da chamada
            $consulta = $objChamada->getConsultaCliente();

            #Verifica se existe data e seta a data da pŕoxima chamada
            if($dtProxLig) {
                $date = \DateTime::createFromFormat("Y/m/d H:i", $dtProxLig);
                $objChamada->setDataChamada($date);
                $consulta->setStatusPendencia(true);    
            } else {
                $consulta->setStatusPendencia(false);
            }

            #Atualizando o objChamada com os novos dados
            $objChamada->setNovoDDD($chamadaDados->getNovoDDD());
            $objChamada->setNovoFone($chamadaDados->getNovoFone());
            $objChamada->setObservacao($chamadaDados->getObservacao());
            $objChamada->setStatusStatus($status);
            $objChamada->setSubrotinasSubrotina($subrotina);
            $objChamada->setStatusPendencia(false);

            #Validando o objChamada
            $valResult = $this->validator->validate($objChamada);

            #Verifica se houve algum erro
            if( !count($valResult) > 0) {

                #Se for remarcação
                /**if($chamadaAnt) {
                    $objChamadaAnt = $chamadaDAO->findById($chamadaAnt);
                    $objChamadaAnt->setStatusChamada(true);
                    $chamadaDAO->update($objChamadaAnt);
                }  */                
                
                $chamadaDAO->updateChamadasAnteriores($objChamada->getIdChamadaCliente(), $consulta->getId());
                
                #Recuoerando o cliente dessa consulta
                $cliente  = $consulta->getClientesCliente();

                #Verifica se o status é finalizado e encerra as chamadas para essa consulta
                if(($status->getIdStatus() == 1 && $subrotina->getCodigoSubrotina() == 1) 
                        ||  empty($dtProxLig)) {
                   $consulta->setStatusLigacao(false); 
                   $consulta->setStatusPendencia(false);
                   $objChamada->setStatusChamada(true);
                }

                #Recuperando o DAO de clientes
                $clienteDAO = new ClienteDAO($this->manager); 

                #Alterando o status em chamada do cliente para disponível
                $cliente->setStatusEmChamada(false);                              
                $clienteDAO->updateCliente($cliente);

                #Atualizando o objChamada
                $result = $chamadaDAO->update($objChamada);             

                #Verificação do resultado da atualização e criação das mensagens
                if($result) {
                    $error = "Dados Salvos com sucesso!";
                    $type  = "success";                
                } else {
                    $error = "Error ao salvar os dados!";
                    $type  = "danger";                     
                }
            } else {
                $error = (string) $valResult;
                $type  = "danger";
            }
        
        }else {
            $error = "Status (e)ou Subrotinas não informados!";
            $type  = "danger"; 
        }
        
        #Retorno
        return array(
            "error" => $error,
            "type"  => $type
        );    
    }
}