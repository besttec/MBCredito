<?php
namespace SerBinario\MBCredito\MBCreditoBundle\DAO;

use Doctrine\ORM\EntityManager;

/**
 * Description of LimiteCreditoNovo
 *
 * @author andrey
 */
class LimiteCreditoNovoDAO 
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
     * @param type $id
     * @return type
     */
    public function findById($id)
    {
        try {
            $this->manager->getRepository("SerBinario\MBCredito\MBCreditoBundle\Entity\LimiteCreditoNovo")->find($id);
        } catch (Exception $ex) {
            return null;
        }
    } 
}
