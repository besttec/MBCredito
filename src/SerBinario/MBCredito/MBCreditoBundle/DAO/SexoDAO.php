<?php
namespace SerBinario\MBCredito\MBCreditoBundle\DAO;

use Doctrine\ORM\EntityManager;
use SerBinario\MBCredito\MBCreditoBundle\Entity\Sexos;

/**
 * Description of SexoDAO
 *
 * @author andrey
 */
class SexoDAO 
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
     * @param type $nomeExtenso
     * @return type
     */
    public function findNomeExtenso($nomeExtenso)
    {
        try {
            $query = $this->manager->createQuery("SELECT s FROM SerBinario\MBCredito\MBCreditoBundle\Entity\Sexos s WHERE s.nomeExtensoSexo = ?1")
                    ->setParameter(1, $nomeExtenso);
            
            return $query->getResult();
        } catch (Exception $ex) {

        }
    }
}
