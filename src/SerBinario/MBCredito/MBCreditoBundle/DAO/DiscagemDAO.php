<?php
namespace SerBinario\MBCredito\MBCreditoBundle\DAO;

use SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente;
use Doctrine\ORM\EntityManager;

/**
 * Description of DIscagemDAO
 *
 * @author andrey
 */
class DiscagemDAO 
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
     * @param ChamadaCliente $discagem
     * @return ChamadaCliente|boolean
     */
    public function save(ChamadaCliente $discagem)
    {
        try {
            $this->manager->persist($discagem);
            $this->manager->flush();
            
            return $discagem;
        } catch (Exception $ex) {
            return false;
        }
    }
}
