<?php
namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;


/**
 * Ag
 *
 * @ORM\Table(name="ag")
 * @ORM\Entity
 */
class Ag
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_ag", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAg;

    /**
     * @var string
     *
     * @Assert\Type(type="string", message="Valor inválido para prefixo ag")
     * @Assert\NotBlank(message="Perfixo ag não informado")
     * 
     * @ORM\Column(name="prefixo_ag", type="string", length=10, nullable=false)
     */
    private $prefixoAg;

    /**
     * @var string
     *
     * @Assert\Type(type="string", message="Valor inválido para Nome ag")
     * 
     * @ORM\Column(name="nome_ag", type="string", length=50, nullable=true)
     */
    private $nomeAg;
    
    /**
     * @var \UF
     * 
     * @Assert\NotNull(message="UF não informado")
     * @Assert\Type(type="object", message="Valor informado para UF não é um objeto")
     *
     * @ORM\ManyToOne(targetEntity="UF", cascade = {"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_uf", referencedColumnName="id")
     * })
     */
    private $uf;



    /**
     * Get idAg
     *
     * @return integer 
     */
    public function getIdAg()
    {
        return $this->idAg;
    }

    /**
     * Set prefixoAg
     *
     * @param string $prefixoAg
     * @return Ag
     */
    public function setPrefixoAg($prefixoAg)
    {
        $this->prefixoAg = $prefixoAg;

        return $this;
    }

    /**
     * Get prefixoAg
     *
     * @return string 
     */
    public function getPrefixoAg()
    {
        return $this->prefixoAg;
    }

    /**
     * Set nomeAg
     *
     * @param string $nomeAg
     * @return Ag
     */
    public function setNomeAg($nomeAg)
    {
        $this->nomeAg = $nomeAg;

        return $this;
    }

    /**
     * Get nomeAg
     *
     * @return string 
     */
    public function getNomeAg()
    {
        return $this->nomeAg;
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
     * @param type $uf
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\Ag
     */
    public function setUf($uf) 
    {
        $this->uf = $uf;
        return $this;
    }


}
