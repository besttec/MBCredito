<?php
namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sexos
 *
 * @ORM\Table(name="sexos")
 * @ORM\Entity
 */
class Sexos
{
    /**
     * @var integer
     *
     * @Assert\Type(type="integer", message="Valor informado para id do sexo é inválido")
     * 
     * @ORM\Column(name="id_sexo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSexo;

    /**
     * @var string
     * 
     * @Assert\Length(max=2, maxMessage="Valor informado para nome abreviatura do sexo 
     *  ultrapassa a quantidade máxima de caracteres permitidas")
     *
     * @ORM\Column(name="nome_abreviatura_sexo", type="string", length=2, nullable=true)
     */
    private $nomeAbreviaturaSexo;

    /**
     * @var string
     * 
     * @Assert\Length(max=9, maxMessage="Valor informado para nome por extenso do sexo 
     *  ultrapassa a quantidade máxima de caracteres permitidas")
     *
     * @ORM\Column(name="nome_extenso_sexo", type="string", length=9, nullable=false)
     */
    private $nomeExtensoSexo;



    /**
     * Get idSexo
     *
     * @return integer 
     */
    public function getIdSexo()
    {
        return $this->idSexo;
    }

    /**
     * Set nomeAbreviaturaSexo
     *
     * @param string $nomeAbreviaturaSexo
     * @return Sexos
     */
    public function setNomeAbreviaturaSexo($nomeAbreviaturaSexo)
    {
        $this->nomeAbreviaturaSexo = $nomeAbreviaturaSexo;

        return $this;
    }

    /**
     * Get nomeAbreviaturaSexo
     *
     * @return string 
     */
    public function getNomeAbreviaturaSexo()
    {
        return $this->nomeAbreviaturaSexo;
    }

    /**
     * Set nomeExtensoSexo
     *
     * @param string $nomeExtensoSexo
     * @return Sexos
     */
    public function setNomeExtensoSexo($nomeExtensoSexo)
    {
        $this->nomeExtensoSexo = $nomeExtensoSexo;

        return $this;
    }

    /**
     * Get nomeExtensoSexo
     *
     * @return string 
     */
    public function getNomeExtensoSexo()
    {
        return $this->nomeExtensoSexo;
    }
}
