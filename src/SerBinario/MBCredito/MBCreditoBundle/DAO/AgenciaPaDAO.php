<?php
namespace SerBinario\MBCredito\MBCreditoBundle\DAO;

use SerBinario\MBCredito\MBCreditoBundle\Entity\AgenciaPA;
use Doctrine\ORM\EntityManager;
use SerBinario\MBCredito\UserBundle\Entity\User;

/**
 * Description of LoginPaDAO
 *
 * @author andrey
 */
class AgenciaPaDAO 
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
     * @param AgenciaPA $entity
     * @return boolean|AgenciaPA
     */
    public function save(AgenciaPA $entity) 
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
     * @return type
     */
    public function findByUserLast(User $user)
    {
        $obj = $this->manager->getRepository("SerBinario\MBCredito\MBCreditoBundle\Entity\AgenciaPA")
                ->findOneBy(array("user" => $user),array("id"=>"DESC"));
        
        return $obj;
    }
    
    /**
     * 
     * @param User $user
     * @return type
     */
    public function findByUser(User $user)
    {
        $obj = $this->manager->getRepository("SerBinario\MBCredito\MBCreditoBundle\Entity\AgenciaPA")
                ->findOneBy(array("user" => $user));
        
        return $obj;
    }
}
