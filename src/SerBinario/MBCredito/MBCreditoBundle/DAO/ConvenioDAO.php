<?php
namespace SerBinario\MBCredito\MBCreditoBundle\DAO;

use Doctrine\ORM\EntityManager;
use SerBinario\MBCredito\MBCreditoBundle\Entity\Convenio;

/**
 * Description of ConvenioDAO
 *
 * @author andrey
 */
class ConvenioDAO 
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
     * @param Convenio $entity
     * @return boolean
     */
    public function save(Convenio $entity) 
    {
        try {
            
            $this->manager->persist($entity);
            $this->manager->flush();
            
            return true;
            
        } catch (Exception $ex) {
            return false;
        }
    }
    
    /**
     * 
     * @param Convenio $entity
     * @return boolean
     */
    public function update(Convenio $entity) 
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
     * @return array Convenio | null
     */
    public function findAll()
    {
        try {
            $arrayObj = $this->manager->getRepository("SerBinario\MBCredito\MBCreditoBundle\Entity\Convenio")->findAll();
            
            return $arrayObj;
        } catch (Exception $ex) {
            return null;
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
            $obj = $this->manager->getRepository("SerBinario\MBCredito\MBCreditoBundle\Entity\Convenio")->find($id);
            
            return $obj;
        } catch (Exception $ex) {
            return null;
        }
    }
    
    /**
     * 
     * @param type $num
     * @return type
     */
    public function finByNumConvenio($num)
    {
        try {
            $obj = $this->manager->getRepository("SerBinario\MBCredito\MBCreditoBundle\Entity\Convenio")->findBy(array("mciEmpCliente" => $num));
            
            return $obj;
        } catch (Exception $ex) {
            return null;
        }
    } 
    
}
