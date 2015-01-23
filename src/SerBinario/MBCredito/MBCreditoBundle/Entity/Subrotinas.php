<?php
namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Subrotinas
 *
 * @ORM\Table(name="subrotinas", indexes={@ORM\Index(name="fk_subrotinas_status1_idx", columns={"status_id_status"})})
 * @ORM\Entity
 */
class Subrotinas
{
    /**
     * @var integer
     *
     * @Assert\Type(type="integer", message="Valor informado para id de subrotina é inválido")
     * 
     * @ORM\Column(name="id_subrotina", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSubrotina;
    
    /**
     * @var integer
     * 
     * @Assert\NotBlank(message="Valor de código de subrotinas não informado")
     * @Assert\Type(type="integer", message="Valor informado para código de subrotina é inválido")
     *
     * @ORM\Column(name="codigo_subrotina", type="integer", nullable=false)
     */
    private $codigoSubrotina;

    /**
     * @var string
     * 
     * @Assert\Length(max=45, maxMessage="Valor informado para subrotina 
     *  ultrapassa a quantidade máxima de caracteres permitidas")
     * @Assert\NotBlank(message="Valor de subrotina não informado")
     * 
     * @ORM\Column(name="subrotina", type="string", length=45, nullable=false)
     */
    private $subrotina;

    /**
     * @var \Status
     * 
     * @Assert\Type(type="object", message="Valor informado para Status não pe um objeto")
     *
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status_id_status", referencedColumnName="id_status")
     * })
     */
    private $statusStatus;



    /**
     * Get idSubrotina
     *
     * @return integer 
     */
    public function getIdSubrotina()
    {
        return $this->idSubrotina;
    }

    /**
     * Set subrotina
     *
     * @param string $subrotina
     * @return Subrotinas
     */
    public function setSubrotina($subrotina)
    {
        $this->subrotina = $subrotina;

        return $this;
    }

    /**
     * Get subrotina
     *
     * @return string 
     */
    public function getSubrotina()
    {
        return $this->subrotina;
    }

    /**
     * Set statusStatus
     *
     * @param \SerBinario\MBCredito\MBCreditoBundle\Entity\Status $statusStatus
     * @return Subrotinas
     */
    public function setStatusStatus(\SerBinario\MBCredito\MBCreditoBundle\Entity\Status $statusStatus = null)
    {
        $this->statusStatus = $statusStatus;

        return $this;
    }

    /**
     * Get statusStatus
     *
     * @return \SerBinario\MBCredito\MBCreditoBundle\Entity\Status 
     */
    public function getStatusStatus()
    {
        return $this->statusStatus;
    }
    
    /**
     * 
     * @return type
     */
    public function getCodigoSubrotina() 
    {
        return $this->codigoSubrotina;
    }
    
    /**
     * 
     * @param type $codigoSubrotina
     */
    public function setCodigoSubrotina($codigoSubrotina)
    {
        $this->codigoSubrotina = $codigoSubrotina;
    }


}
