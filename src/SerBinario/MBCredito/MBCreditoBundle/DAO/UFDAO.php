<?php
namespace SerBinario\MBCredito\MBCreditoBundle\DAO;

use SerBinario\MBCredito\MBCreditoBundle\Entity\UF;
use Doctrine\ORM\EntityManager;
/**
 * Description of UFDAO
 *
 * @author andrey
 */
class UFDAO 
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
     * @param UF $entity
     * @return boolean
     */
    public function save(UF $entity)
    {
        try {
            $this->manager->persist($entity);
            $this->manager->flush();
            
            return $uf;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    /**
     * 
     * @param type $uf
     */
    public function findUf($uf)
    {
        try {
            $obj = $this->manager->getRepository("SerBinario\MBCredito\MBCreditoBundle\Entity\UF")->findBy(array("uf" => $uf));
            
            return $obj;
        } catch (Exception $ex) {
            return null;
        }
    }
    
    /**
     * 
     * @return type
     */
    public function findAll()
    {
        try {
            $arrayObj = $this->manager->getRepository("SerBinario\MBCredito\MBCreditoBundle\Entity\UF")->findAll();
            
            return $arrayObj;
        } catch (Exception $ex) {
            return null;
        }
    }
    
     /**
     * 
     * @param type $id
     */
    public function findId($id)
    {
        try {
            $obj = $this->manager->getRepository("SerBinario\MBCredito\MBCreditoBundle\Entity\UF")->find($id);
            
            return $obj;
        } catch (Exception $ex) {
            return null;
        }
    }
}
