<?php
namespace SerBinario\MBCredito\MBCreditoBundle\DAO;

use Doctrine\ORM\EntityManager;
use SerBinario\MBCredito\MBCreditoBundle\Entity\SuperRegional;
/**
 * Description of SuperRegionalDAO
 *
 * @author andrey
 */
class SuperRegionalDAO 
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
     * @param type $cod
     * @return type
     */
    public function findCod($cod)
    {
        try {
            $query = $this->manager->createQuery("SELECT c FROM SerBinario\MBCredito\MBCreditoBundle\Entity\SuperRegional c WHERE c.codSuperRegional = ?1")
                    ->setParameter(1, $cod);
            
            return $query->getResult();
        } catch (Exception $ex) {

        }
    }
    
    /**
     * 
     * @param SuperRegional $entity
     * @return boolean
     */
    public function insertSuperRegional(SuperRegional $entity) 
    {
        try {
            
            $this->manager->persist($entity);
            $this->manager->flush();
            
            return $entity;
            
        } catch (Exception $ex) {
            return false;
        }
    }
}
