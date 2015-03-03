<?php
namespace SerBinario\MBCredito\MBCreditoBundle\DAO;

use Doctrine\ORM\EntityManager;
use SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente;

/**
 * Description of ConsultaClienteDAO
 *
 * @author andrey
 */
class ConsultaClienteDAO 
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
     * @param ConsultaCliente $entity
     * @return boolean
     */
    public function insert(ConsultaCliente $entity) 
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
     * @param ConsultaCliente $entity
     * @return boolean
     */
    public function update(ConsultaCliente $entity) 
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
     * @param type $antecipacoes
     * @return boolean
     */
    public function removeAllAntecipacoes($antecipacoes = array())
    {
        try {
            foreach ($antecipacoes as $antecipacao) {
                $this->manager->remove($antecipacao);
                $this->manager->flush();
            }
            
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
    public function findConsultaCliente($id)
    {
        try {
            $query = $this->manager->createQuery("SELECT c FROM SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente c WHERE c.id = ?1")
                    ->setParameter(1, $id);
            
            return $query->getResult();
        } catch (Exception $ex) {

        }
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function ConsultaClienteChamadas($id)
    {
        try {
            $query = $this->manager->createQuery("SELECT c FROM SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente c "
                    . "JOIN c.consultaCliente d "
                    . "JOIN c.statusStatus s "
                    . "WHERE c.consultaCliente = d.id and d.id = ?1 and c.statusStatus = s.idStatus "
                    . "and (s.idStatus = 2 or s.idStatus = 1) and (c.statusPendencia = 0 or c.statusPendencia = 1) ")
                    ->setParameter(1, $id);
            
            return $query->getResult();
        } catch (Exception $ex) {

        }
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function ConsultaClienteChamadasGrid($id)
    {
        try {
            $query = $this->manager->createQuery("SELECT c FROM SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente c "
                    . "JOIN c.consultaCliente d "
                    . "JOIN c.statusStatus s "
                    . "WHERE c.consultaCliente = d.id and d.id = ?1 and c.statusStatus = s.idStatus "
                    . "and (s.idStatus = 2 or s.idStatus = 1 or c.statusStatus = null) ")
                    ->setParameter(1, $id);
            
            return $query->getResult();
        } catch (Exception $ex) {

        }
    }
}
