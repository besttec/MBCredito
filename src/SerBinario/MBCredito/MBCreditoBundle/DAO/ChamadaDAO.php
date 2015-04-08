<?php
namespace SerBinario\MBCredito\MBCreditoBundle\DAO;

use SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente;
use \SerBinario\MBCredito\UserBundle\Entity\User;
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
    public function save(ChamadaCliente $entity)
    {
        try {
            $this->manager->persist($entity);
            $this->manager->flush();
            
            return $entity;
        } catch (Exception $ex) {
            return false;
        }
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
    
    /**
     * 
     * @param type $id
     * @return boolean
     */
    public function updateChamadasAnteriores($idChamada, $idConsulta)
    {
        try {
            $q = $this->manager->createQueryBuilder()
                    ->update("SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente", "c")                    
                    ->set("c.statusChamada", true)
                    ->where("c.idChamadaCliente != ?1")
                    ->andWhere("c.consultaCliente = ?2")
                    ->setParameter(1, $idChamada)
                    ->setParameter(2, $idConsulta)
                    ->getQuery();
            
            $result = $q->execute();
            
            return $result;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    /**
     * 
     * @param User $usuario
     * @param type $usuarioBusca
     */
    public function findByUsers($dataInicial, $dataFinal, User $usuario = null, $usuarioBusca = "")
    {
        $qb = $this->manager->createQueryBuilder();
        $qb->select("u.id, u.username, s.status, count(c) as quantidade");
        $qb->from("SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente", "c");
        $qb->join("c.consultaCliente", "b");
        $qb->join("b.user", "u");
        $qb->join("c.statusStatus", "s");
        $qb->join("c.subrotinasSubrotina", "sub");
        $qb->where("c.dataPendencia BETWEEN :inicial AND :final");
        $qb->setParameter("inicial", $dataInicial);
        $qb->setParameter("final", $dataFinal);
        
        if($usuarioBusca) {
            $qb->andWhere("u.username like '%:user%'");
            $qb->setParameter("user", $usuarioBusca);
        }
        
        if($usuario) {
            $qb->andWhere("u.id = :user");
            $qb->setParameter("user", $usuario->getId());
        }
        
        $qb->groupBy("s.status");
        
        return $qb->getQuery()->getArrayResult();
    }
    
    /**
     * 
     * @param type $idUser
     * @param type $dataInicial
     * @param type $dataFinal
     * @return type
     */
    public function findByContratada($idUser, $dataInicial, $dataFinal)
    {
        $qb = $this->manager->createQueryBuilder();
        $qb->select("count(c) as quantidade");
        $qb->from("SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente", "c");
        $qb->join("c.consultaCliente", "b");
        $qb->join("b.user", "u");
        $qb->join("c.subrotinasSubrotina", "sub");
        $qb->where("c.dataPendencia BETWEEN :inicial AND :final");
        $qb->setParameter("inicial", $dataInicial);
        $qb->setParameter("final", $dataFinal);
        $qb->andWhere("u.id = :id AND sub.codigoSubrotina = 1");
        $qb->setParameter("id", $idUser);
 
        $result = $qb->getQuery()->getSingleResult();
        
        if($result) {
            $result = $result['quantidade'];
        }       
        
        return $result;
        
    }    
    
    /**
     * 
     * @param type $idUser
     * @param type $finalizada
     * @param type $dataInicial
     * @param type $dataFinal
     * @return type
     */
    public function findByFinalizada($idUser, $finalizada, $dataInicial, $dataFinal)
    {
        $qb = $this->manager->createQueryBuilder();
        $qb->select("count(c) as quantidade");
        $qb->from("SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente", "c");
        $qb->join("c.consultaCliente", "b");
        $qb->join("b.user", "u");
        $qb->join("c.statusStatus", "s");
        $qb->where("c.dataPendencia BETWEEN :inicial AND :final");
        $qb->setParameter("inicial", $dataInicial);
        $qb->setParameter("final", $dataFinal);
        $qb->andWhere("u.id = :id AND s.idStatus = {$finalizada}");
        $qb->setParameter("id", $idUser);
 
        $result = $qb->getQuery()->getSingleResult();
        
        if($result) {
            $result = $result['quantidade'];
        }       
        
        return $result;        
    }
    
    /**
     * 
     * @return type
     */
    public function getManager() 
    {
        return $this->manager;
    }


}
