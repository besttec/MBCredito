<?php
namespace SerBinario\MBCredito\UserBundle\DAO;

use Doctrine\ORM\EntityManager;
use SerBinario\MBCredito\UserBundle\Entity\User; 

/**
 * Description of UserDAO
 *
 * @author andrey
 */
class UserDAO 
{
    /**
     *
     * @var type 
     */
    private $manager;
    
    /**
     * Funçao Construtora
     * 
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager) 
    {
        $this->manager = $manager;
    }
    
    /**
     * 
     * @param User $user
     * @return User
     */
    public function save(User $user)
    {
        try {
            $this->manager->persist($user);
            $this->manager->flush();
            
            return $user;
        } catch (Exception $ex) {
            return null;
        }
    }
    
    /**
     * 
     * @param User $user
     * @return User
     */
    public function update(User $user)
    {
        try {
            $this->manager->merge($user);
            $this->manager->flush();
            
            return $user;
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
            $obj =  $this->manager->getRepository("SerBinario\MBCredito\UserBundle\Entity\User")->find($id);
            
            return $obj;
        } catch (Exception $ex) {
            return null;
        }
    }
    
    /**
     * 
     * @param type $param
     * @return type
     */
    public function findByEmailOrUsename($param)
    {
        try {
            $q = $this->manager
            ->createQueryBuilder()
            ->select('u')
            ->from("SerBinario\MBCredito\UserBundle\Entity\User", "u")
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $param)
            ->setParameter('email', $param)
            ->getQuery();
            
            return $q->getResult();
        } catch (Exception $ex) {
            return null;
        }
    }
}