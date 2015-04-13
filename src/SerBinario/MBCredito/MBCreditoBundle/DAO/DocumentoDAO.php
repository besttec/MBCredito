<?php
namespace SerBinario\MBCredito\MBCreditoBundle\DAO;

use SerBinario\MBCredito\MBCreditoBundle\Entity\Documento;
use Doctrine\ORM\EntityManager;

/**
 * Description of DocumentoDAO
 *
 * @author andrey
 */
class DocumentoDAO 
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
     * @param Documento $documento
     * @return Documento
     */
    public function save(Documento $documento)
    {
        try {
            $this->manager->persist($documento);
            $this->manager->flush();

            return $documento;
        } catch (Exception $ex) {
            return false;
        }
        
    }
    
    /**
     * 
     * @param type $name
     * @return type
     */
    public function findByName($name)
    {
        try {
            $result = $this->manager->getRepository("SerBinario\MBCredito\MBCreditoBundle\Entity\Documento")
                    ->findBy(array("name"=> $name));
            
            return $result;
        } catch (Exception $ex) {
            return null;
        }
    }
}
