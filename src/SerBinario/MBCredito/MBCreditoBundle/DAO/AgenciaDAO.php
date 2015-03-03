<?php
namespace SerBinario\MBCredito\MBCreditoBundle\DAO;

use SerBinario\MBCredito\MBCreditoBundle\Entity\Ag;
use Doctrine\ORM\EntityManager;
/**
 * Description of AgenciaDAO
 *
 * @author andrey
 */
class AgenciaDAO 
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
        try {
            $arrayObj = $this->manager->getRepository("SerBinario\MBCredito\MBCreditoBundle\Entity\Ag")->findAll();
            
            return $arrayObj;
        } catch (Exception $ex) {
            return null;
        }
    }
    
    /**
     * 
     * @return type
     */
    public function findId($id)
    {
        try {
            $obj = $this->manager->getRepository("SerBinario\MBCredito\MBCreditoBundle\Entity\Ag")->find($id);
            
            return $obj;
        } catch (Exception $ex) {
            return null;
        }
    }
    
     /**
     * 
     * @return type
     */
    public function findByPrefixo($prefixo)
    {
        try {
            $obj = $this->manager->getRepository("SerBinario\MBCredito\MBCreditoBundle\Entity\Ag")
                    ->findBy(array(
                        "prefixoAg" => $prefixo
                    ));
            
            return $obj;
        } catch (Exception $ex) {
            return null;
        }
    }
    
    /**
     * 
     * @param \SerBinario\MBCredito\MBCreditoBundle\Entity\Ag $entity
     * @return boolean
     */
    public function update(Ag $entity)
    {
        try {
            $this->manager->merge($entity);
            $this->manager->flush();
            
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}