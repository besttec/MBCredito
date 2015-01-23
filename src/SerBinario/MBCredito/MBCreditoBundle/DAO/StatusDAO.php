<?php
namespace SerBinario\MBCredito\MBCreditoBundle\DAO;
use Doctrine\ORM\EntityManager;
use SerBinario\MBCredito\MBCreditoBundle\Entity\Status;

/**
 * Description of StatusDAO
 *
 * @author andrey
 */
class StatusDAO 
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
     * @return type
     */
    public function findAll()
    {
        $query = $this->manager->createQuery("SELECT s FROM SerBinario\MBCredito\MBCreditoBundle\Entity\Status s");
        
        return $query->getResult();
    }
     
    /**
     * 
     * @param type $id
     * @return type
     */
    public function findById($id)
    {
        try {
            $obj = $this->manager->getRepository("SerBinario\MBCredito\MBCreditoBundle\Entity\Status")->find($id);
            
            return $obj;
        } catch (Exception $ex) {
            return null;
        }
    }
   
} 
