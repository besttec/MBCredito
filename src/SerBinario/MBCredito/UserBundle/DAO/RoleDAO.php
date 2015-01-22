<?php
namespace SerBinario\MBCredito\UserBundle\DAO;

use Doctrine\ORM\EntityManager;
/**
 * Description of RoleDAO
 *
 * @author andrey
 */
class RoleDAO 
{
    /**
     *
     * @var type 
     */
    private $manager;
    
    /**
     * Funçao Construtora
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
    public function getRoles()
    {
        $arrayObj = $this->manager->getRepository("SerBinario\MBCredito\UserBundle\Entity\Role")->findAll();
        
        return $arrayObj;
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function getRole($id)
    {
        $obj = $this->manager->getRepository("SerBinario\MBCredito\UserBundle\Entity\Role")->find($id);
        
        return $obj;
    }
}
