<?php
namespace SerBinario\MBCredito\MBCreditoBundle\DAO;

use SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes;
use SerBinario\MBCredito\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;

/**
 * 
 */
class ClienteDAO
{   
    /**
     *
     * @var type 
     */
    private $manager;
    
    /**
     * 
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager) 
    {        
        $this->manager = $manager;        
    }
    
    /**
     * 
     * @return boolean
     */
    public function selectAllCliente() 
    {
        try {            
            $query = $this->manager->createQuery("SELECT c FROM SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes c");
            
            return $query->getResult();            
        } catch (Exception $ex) {
            return false;
        }
    }
    
    /**
     * 
     * @param type $numBeneficio
     * @return type
     */
    public function findNumBeneficio($numBeneficio)
    {
        try {
            $query = $this->manager->createQuery("SELECT c FROM SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes c WHERE c.numBeneficioComp = ?1")
                    ->setParameter(1, $numBeneficio);
            
            return $query->getResult();
        } catch (Exception $ex) {

        }
    }
    
    /**
     * 
     * @param User $usuario
     * @return type
     */
    public function findCallPen(User $usuario)
    {
       #Seleciona os Registros com Pendências.
        $queryPendencia = $this->manager->createQuery("SELECT a FROM SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente a JOIN a.user c  WHERE a.statusPendencia =?1 AND c.id =?2")
                            ->setParameter(1, true)
                            ->setParameter(2, $usuario->getId())
                            ->setMaxResults(1);

        $resultPenden   = $queryPendencia->getResult();        
        $chamada        = null;
        
        #Verifica se ha registros com Pendência, se houver retorna o registro encontrado.
        if(count($resultPenden) > 0) {
            $chamada =  $resultPenden[0];
        }
        
       return $chamada;;
    }
    
    /**
     * 
     * @param type $idConvenio
     * @return type
     */
    public function findNotUse($idConvenio, $estado)
    {
        try {         
            
            #Seleciona os registro que não foram finalizados.
            $query  = $this->manager->createQuery("SELECT a FROM SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes a "
                    . "JOIN a.superEstadualSuperEstadual c JOIN a.convenio b "
                    . "WHERE a.statusEmChamada =?1 AND a.statusConsulta = ?2  AND a.statusErro = ?3 AND a.statusLigacao = ?4 AND "
                    . " b.id = ?5 AND c.uf = ?6")
                        ->setParameter(1, false)
                        ->setParameter(2, true)
                        ->setParameter(3, false)
                        ->setParameter(4, true)
                        ->setParameter(5, $idConvenio)
                        ->setParameter(6, $estado)
                        ->setMaxResults(1);
            
            $result  =  $query->getResult();
            $cliente = null; 
            
            if(count($result) > 0) {
                $cliente =  $result[0];
            }
            
            return $cliente;            
        } catch (Exception $ex) {
            return null;
        }
    }
    
    /**
     * 
     * @param Clientes $cliente
     * @return type
     */
    public function findCallsCliente(Clientes $cliente)
    {
        $query  = $this->manager->createQuery("SELECT a FROM SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente a JOIN a.clientesCliente c WHERE a.statusChamada =?1 AND c.idCliente = ?2")
                        ->setParameter(1, true)
                        ->setParameter(2, $cliente->getIdCliente());
        
        return $query->getResult();
    }
    
    /**
     * 
     * @param Clientes $entity
     * @return boolean
     */
    public function insertCliente(Clientes $entity) 
    {
        try {
            
            $this->manager->persist($entity);
            $this->manager->flush();
            
            return true;
            
        } catch (Exception $ex) {
            return false;
        }
    }
    
    /**
     * 
     * @param Clientes $entity
     * @return boolean
     */
    public function updateCliente(Clientes $entity) 
    {
        try {
            
            $this->manager->merge($entity);
            $this->manager->flush();
            
            return true;
            
        } catch (Exception $ex) {
            return false;
        }
    }
}

