<?php
namespace SerBinario\MBCredito\MBCreditoBundle\DAO;

use Doctrine\ORM\EntityManager;
use SerBinario\MBCredito\MBCreditoBundle\Entity\SuperEstadual;
/**
 * Description of SuperEstadualDAO
 *
 * @author andrey
 */
class SuperEstadualDAO 
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
            $query = $this->manager->createQuery("SELECT c FROM SerBinario\MBCredito\MBCreditoBundle\Entity\SuperEstadual c WHERE c.codSuperEstadual = ?1")
                    ->setParameter(1, $cod);
            
            return $query->getResult();
        } catch (Exception $ex) {

        }
    }
    
    /**
     * 
     * @param SuperEstadual $entity
     * @return boolean
     */
    public function insertSuperRegional(SuperEstadual $entity) 
    {
        try {
            
            $this->manager->persist($entity);
            $this->manager->flush();
            
            return true;
            
        } catch (Exception $ex) {
            return false;
        }
    }
}
