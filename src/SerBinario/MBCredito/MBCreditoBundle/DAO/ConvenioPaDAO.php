<?php
namespace SerBinario\MBCredito\MBCreditoBundle\DAO;

use SerBinario\MBCredito\MBCreditoBundle\Entity\ConvenioPA;
use Doctrine\ORM\EntityManager;
use SerBinario\MBCredito\UserBundle\Entity\User;

/**
 * Description of LoginPaDAO
 *
 * @author andrey
 */
class ConvenioPaDAO 
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
     * @param ConvenioPA $entity
     * @return ConvenioPA
     */
    public function save(ConvenioPA $entity) 
    {
        try {            
            $this->manager->persist($entity);
            $this->manager->flush();
            
            return $entity;
            
        } catch (Exception $ex) {
            return false;
        }
    }
    
    /**
     * 
     * @param User $user
     * @return type ConvenioPA
     */
    public function findByUserLast(User $user)
    {
        $obj = $this->manager->getRepository("SerBinario\MBCredito\MBCreditoBundle\Entity\ConvenioPA")->findOneBy(array("user" => $user),array("id"=>"DESC"));
        
        return $obj;
    }
    
    /**
     * 
     * @param type $user
     * @return type ConvenioPA
     */
    public function findByUser(User $user)
    {
        $obj = $this->manager->getRepository("SerBinario\MBCredito\MBCreditoBundle\Entity\ConvenioPA")->findOneBy(array("user" => $user));
        
        return $obj;
    }
}
