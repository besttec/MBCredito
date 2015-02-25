<?php
namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * LimiteCreditNovo
 *
 * @ORM\Table(name="limite_credito_novo")
 * @ORM\Entity
 */
class LimiteCreditoNovo 
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_limite_credito_novo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var string
     *
     * @Assert\NotBlank(message="Limite de crédito do cliente não informado")
     * @Assert\Length(max=50, maxMessage="Valor de limite ultrapassa a quantidade de caracteres permitidas")
     * 
     * @ORM\Column(name="limite_credito_novo", type="string", length=50, nullable=false)
     */
    private $limiteCreditoNovo;
    
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
    public function getLimiteCreditoNovo() 
    {
        return $this->limiteCreditoNovo;
    }

    /**
     * 
     * @param type $id
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\LimiteCreditoNovo
     */
    public function setId($id) 
    {
        $this->id = $id;
        return $this;
    }

    /**
     * 
     * @param type $limiteCreditoNovo
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\LimiteCreditoNovo
     */
    public function setLimiteCreditoNovo($limiteCreditoNovo) 
    {
        $this->limiteCreditoNovo = $limiteCreditoNovo;
        return $this;
    }


}
