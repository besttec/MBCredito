<?php
namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SerBinario\MBCredito\UserBundle\Entity\User;
use SerBinario\MBCredito\MBCreditoBundle\Entity\Convenio;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * LoginPA
 *
 * @ORM\Table(name="convenio_pa")
 * @ORM\Entity
 */
class ConvenioPA 
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    
    /**
     * @var \DateTime
     * 
     * @Assert\DateTime(message="Valor informado para data é inválido")
     *
     * @ORM\Column(name="data", type="datetime", nullable=false)
     */
    private $data;
    
    /**
     * @var Convenio
     *
     * @Assert\Type(type="object", message="Valor informado para Convenio não é um objeto")
     * 
     * @ORM\ManyToOne(targetEntity="SerBinario\MBCredito\MBCreditoBundle\Entity\Convenio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="convenio_id", referencedColumnName="id")
     * })
     */
    private $convenio;
    
    /**
     * @var string
     *
     * @Assert\Length(max=2, maxMessage="Valor iformado para esta ultrapassa 
     * a quantidade máxima de caracteres permitidas")
     * 
     * @ORM\Column(name="estado", type="string",length = 2, nullable=true)
     */
    private $estado;
    
     /**
     * @var User
     *
     * @Assert\Type(type="object", message="Valor informado para User não é um objeto")
     * 
     * @ORM\ManyToOne(targetEntity="SerBinario\MBCredito\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id_user", referencedColumnName="id")
     * })
     */
    private $user;
    
    /**
     * 
     * @return type
     */
    public function getId() 
    {
        return $this->id;
    }
    
    /**
     * 
     * @return type
     */
    public function getNumeroPA() 
    {
        return $this->numeroPA;
    }
    
    /**
     * 
     * @return type
     */
    public function getData() 
    {
        return $this->data;
    }
    
    /**
     * 
     * @return type
     */
    public function getUser() 
    {
        return $this->user;
    }
    
    /**
     * 
     * @param type $id
     */
    public function setId($id) 
    {
        $this->id = $id;
    }
    
    /**
     * 
     * @param type $numeroPA
     */
    public function setNumeroPA($numeroPA) 
    {
        $this->numeroPA = $numeroPA;
    }
    
    /**
     * 
     * @param type $data
     */
    public function setData($data) 
    {
        $this->data = $data;
    }
    
    /**
     * 
     * @param User $user
     */
    public function setUser(User $user) 
    {
        $this->user = $user;
    }
    
    /**
     * 
     * @return type
     */
    public function getConvenio() 
    {
        return $this->convenio;
    }

    /**
     * 
     * @param Convenio $convenio
     */
    public function setConvenio(Convenio $convenio) 
    {
        $this->convenio = $convenio;
    }
    
    /**
     * 
     * @return type
     */
    public function getEstado() 
    {
        return $this->estado;
    }

    /**
     * 
     * @param type $estado
     */
    public function setEstado($estado) 
    {
        $this->estado = $estado;
    }



}