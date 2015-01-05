<?php
namespace SerBinario\MBCredito\MBCreditoBundle\DAO;

use SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes;
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
    
    /*
     * 
     */
    public function findNotUse()
    {
        try {
            $query = $this->manager->createQuery("SELECT c FROM SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes c WHERE c.statusChamada = ?1")
                    ->setParameter(1, false)
                    ->setMaxResults(1);
            
            return $query->getResult();
        } catch (Exception $ex) {

        }
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

