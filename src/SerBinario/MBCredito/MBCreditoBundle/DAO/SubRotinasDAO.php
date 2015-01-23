<?php
namespace SerBinario\MBCredito\MBCreditoBundle\DAO;

use Doctrine\ORM\EntityManager;
use SerBinario\MBCredito\MBCreditoBundle\Entity\Status;
use SerBinario\MBCredito\MBCreditoBundle\Entity\Subrotinas;

/**
 * Description of SubRotinasDAO
 *
 * @author andrey
 */
class SubRotinasDAO 
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
     * @param type $idStatus
     * @return type
     */
    public function findByIdStatus($idStatus)
    {
        $query  = $this->manager->createQuery("SELECT a FROM SerBinario\MBCredito\MBCreditoBundle\Entity\Subrotinas a"
                . " JOIN a.statusStatus b WHERE b.idStatus = ?1")
                    ->setParameter(1, $idStatus);
        
        $result = $query->getArrayResult();
        
        return $result;
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function findById($id)
    {
        try {
            $obj = $this->manager->getRepository("SerBinario\MBCredito\MBCreditoBundle\Entity\Subrotinas")->find($id);
            
            return $obj;
        } catch (Exception $ex) {
            return null;
        }
    }
}
