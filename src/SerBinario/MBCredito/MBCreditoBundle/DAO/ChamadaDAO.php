<?php
namespace SerBinario\MBCredito\MBCreditoBundle\DAO;

use SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente;
use Doctrine\ORM\EntityManager;
/**
 * Description of ChamadaDAO
 *
 * @author andrey
 */
class ChamadaDAO 
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
     * @param ChamadaCliente $entity
     * @return ChamadaCliente|boolean
     */
    public function update(ChamadaCliente $entity)
    {
        try {
            $this->manager->merge($entity);
            $this->manager->flush();
            
            return $entity;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function findById($id)
    {
        try {
            $obj = $this->manager->getRepository("SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente")->find($id);
            
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
            $arryObj = $this->manager->getRepository("SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente")->findAll();
            
            return $arryObj;
        } catch (Exception $ex) {
            return null;
        }
    }
}
