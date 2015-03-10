<?php
namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * UF
 *
 * @ORM\Table(name="uf")
 * @ORM\Entity
 */
class UF 
{
    /**
     * @var integer
     *
     * @Assert\Type(type="integer", message="Valor informado para id de UF é inválido")
     * 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var string
     *
     * @Assert\Length(max=2, maxMessage="Valor informado para uf  
     *  ultrapassa a quantidade máxima de caracteres permitidas")
     * 
     * @ORM\Column(name="uf", type="string", length=2, nullable=true)
     */
    private $uf;
    
    /**
     * 
     * @param type $id
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\UF
     */
    public function setId($id) 
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * 
     * @param type $uf
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\UF
     */
    public function setUf($uf) 
    {
        $this->uf = $uf;
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getUf() 
    {
        return $this->uf;
    }
    
    /**
     * 
     * @return type
     */
    function getId() {
        return $this->id;
    }


}