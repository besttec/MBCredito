<?php

namespace SerBinario\MBCredito\MBCreditoBundle\DAO;

use Doctrine\ORM\EntityManager;
use SerBinario\MBCredito\MBCreditoBundle\Entity\Emprestimos;

class EmprestimoDAO
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
     * @param Emprestimos $entity
     * @return boolean
     */
    public function update(Emprestimos $entity) 
    {
        try {
            
            $this->manager->merge($entity);
            $this->manager->flush();
            
            return true;
            
        } catch (Exception $ex) {
            return false;
        }
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function findEmprestimo($id)
    {
        try {
            $query = $this->manager->createQuery("SELECT c FROM SerBinario\MBCredito\MBCreditoBundle\Entity\Emprestimos c WHERE c.idEmprestimo = ?1")
                    ->setParameter(1, $id);
            
            return $query->getResult();
        } catch (Exception $ex) {
            return false;
        }
    }
}

