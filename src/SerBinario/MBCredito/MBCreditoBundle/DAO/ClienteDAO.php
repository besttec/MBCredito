<?php
namespace SerBinario\MBCredito\MBCreditoBundle\DAO;

use SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes;
use SerBinario\MBCredito\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;




/**
 * 
 */
class ClienteDAO
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
     * @return boolean
     */
    public function selectAllCliente() 
    {
        try {            
            $query = $this->manager->createQuery("SELECT c FROM SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes c");
            
            return $query->getResult();            
        } catch (Exception $ex) {
            return false;
        }
    }
    
    /**
     * 
     * @param type $numBeneficio
     * @return type
     */
    public function findNumBeneficio($numBeneficio)
    {
        try {
            $query = $this->manager->createQuery("SELECT c FROM SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes c WHERE c.numBeneficioComp = ?1")
                    ->setParameter(1, $numBeneficio);
            
            return $query->getResult();
        } catch (Exception $ex) {

        }
    }
    
    /**
     * 
     * @return type
     */
    public function findCallDate($user)
    {
        $conf = $this->manager->getConfiguration();
        $conf->addCustomDatetimeFunction("TimestampDiff", "DoctrineExtensions\Query\Mysql\TimestampDiff");
        
        $qb  = $this->manager->createQueryBuilder();
        $qb->select("a");       
        $qb->from("SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente", "a");
        $qb->join("a.user", "u");
        $qb->where("TimestampDiff(DAY, a.dataChamada, CURRENT_TIMESTAMP()) >= 0 AND TimestampDiff(SECOND, a.dataChamada, CURRENT_TIMESTAMP()) >= 0 AND a.statusChamada = ?1"); 
        $qb->andWhere("u.id = ?2");
        $qb->setParameter(1, false);
        $qb->setParameter(2, $user->getId());
        $qb->setMaxResults(1);
        
        $result  = $qb->getQuery()->getResult();
        
        $cliente = null;
        
        if(count($result) > 0) {
            $cliente =  $result[0];
        }
            
        return $cliente;
    }
    
    /**
     * 
     * @param User $usuario
     * @return type
     */
    public function findCallPen(User $usuario)
    {
       #Seleciona os Registros com Pendências.
        $queryPendencia = $this->manager->createQuery("SELECT a FROM SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente a "
                . "JOIN a.user c  WHERE a.statusPendencia =?1 AND c.id =?2")
                            ->setParameter(1, true)
                            ->setParameter(2, $usuario->getId())
                            ->setMaxResults(1);

        $resultPenden   = $queryPendencia->getResult();        
        $chamada        = null;
        
        #Verifica se ha registros com Pendência, se houver retorna o registro encontrado.
        if(count($resultPenden) > 0) {
            $chamada =  $resultPenden[0];
        }
        
       return $chamada;;
    }
    
    /**
     * 
     * @param type $idAgencia
     * @param type $estado
     * @return type
     */
    public function findNotUse($idAgencia, $estado)
    {
        try {
            
            $qb = $this->manager->createQueryBuilder();
            $qb->select("a");
            $qb->from("SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente", "a");
            $qb->join("a.clientesCliente", "cliente");
            $qb->join("cliente.agAg", "b");
            $qb->join("cliente.uf", "u");                       
            $qb->where("cliente.statusEmChamada =?1 AND a.statusConsulta = ?2 "
                    . " AND a.statusErro = ?3 AND a.statusLigacao = ?4 "
                    . " AND a.statusPendencia = ?5");
            $qb->setMaxResults(1);
            $qb->setParameters(
                    array(
                        1 => false,
                        2 => true,
                        3 => false,
                        4 => true,                        
                        5 => false
                    )
                );
            
            #Verifica se ha filtro por agência
            if($idAgencia != "") {
               $qb->andWhere("b.idAg = ?6");
               $qb->setParameter(6, $idAgencia);
            }
            
            #Verifica se ha filtro por estado
            if($estado != "") {
                $qb->andWhere("u.uf = ?7");
                $qb->setParameter(7, $estado);
            }
            
            $result = $qb->getQuery()->getResult(); 
            
            $consulta = null; 
            
            if(count($result) > 0) {
                $consulta =  $result[0];
            }
            
            return $consulta;         
        } catch (Exception $ex) {
            return null;
        }
    }
    
    /**
     * 
     * @return type
     */
    public function findLastConsulta()
    {
        try {
            $qb = $this->manager->createQueryBuilder();
            $qb->select("a");
            $qb->from("SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente","a");
            $qb->orderBy("a.id", "DESC");
            $qb->setMaxResults(1);
            
            $query  = $qb->getQuery();
            $result = $query->getOneOrNullResult();
            
            return $result;
        } catch (Exception $ex) {
            return null;
        }
    }
    
    /**
     * 
     * @param Clientes $cliente
     * @return type
     */
    public function findCallsCliente(\SerBinario\MBCredito\MBCreditoBundle\Entity\ConsultaCliente $consulta)
    {
        $query  = $this->manager->createQuery("SELECT a FROM SerBinario\MBCredito\MBCreditoBundle\Entity\ChamadaCliente a "
                . " JOIN a.consultaCliente consulta "
                . " WHERE a.statusPendencia =?1 AND consulta.id = ?2")
                        ->setParameter(1, false)
                        ->setParameter(2, $consulta->getId());
        
        return $query->getResult();
    }
    
    /**
     * 
     * @param Clientes $entity
     * @return boolean
     */
    public function insertCliente(Clientes $entity) 
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
     * @param Clientes $entity
     * @return boolean
     */
    public function updateCliente(Clientes $entity) 
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
    public function findClienteEstados($id)
    {
        try {
            
            $query  = $this->manager->createQuery("SELECT c FROM SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes c "
                . " JOIN c.agAg a "
                . " JOIN a.uf u "
                . " WHERE c.agAg = a.idAg AND a.uf = u.id AND u.id = ?1")
                        ->setParameter(1, $id);  
            return $query->getResult();
            
        } catch (Exception $ex) {
            return false;
        }
               
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function findClienteAgencia($id)
    {
        try {
            
            $query  = $this->manager->createQuery("SELECT c FROM SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes c "
                . " JOIN c.agAg a "
                . " WHERE c.agAg = a.idAg AND a.idAg = ?1")
                        ->setParameter(1, $id);  
            return $query->getResult();
            
        } catch (Exception $ex) {
            return false;
        }
               
    }
}

