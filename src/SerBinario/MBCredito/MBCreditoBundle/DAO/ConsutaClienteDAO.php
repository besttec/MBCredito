<?php
namespace SerBinario\MBCredito\MBCreditoBundle\DAO;

use SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente;
use Doctrine\ORM\EntityManager;

/**
 * 
 */
class ConsultaClienteDAO
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
     * @param ConsultaCliente $entity
     * @return boolean
     */
    public function insert(ConsultaCliente $entity) 
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
     * @param ConsultaCliente $entity
     * @return boolean
     */
    public function update(ConsultaCliente $entity) 
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

