<?php
namespace SerBinario\MBCredito\MBCreditoBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Convenio
 * 
 * @ORM\Entity
 * @ORM\Table(name="convenio")
 */
class Convenio 
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
     * @var string
     * 
     * @Assert\Length(max=10, maxMessage="Valor informado para mciEmpCliente 
     * ultrapassa a quantidade máxima de caracteres permitidas")
     *
     * @ORM\Column(name="mci_emp_cliente", type="string", length=10, nullable=true)
     */
    private $mciEmpCliente;
    
    /**
     * @var string
     * 
     * @Assert\Length(max=20, maxMessage="Valor informado para nome do Convenio 
     * ultrapassa a quantidade máxima de caracteres permitidas")
     *
     * @ORM\Column(name="nome_convenio", type="string", length=20, nullable=true)
     */
    private $nomeConvenio;
    
    /**
     * 
     * @return type
     */
    public function getId() 
    {
        return $this->id;
    }
    
   /**
     * Set mciEmpCliente
     *
     * @param string $mciEmpCliente
     * @return Clientes
     */
    public function setMciEmpCliente($mciEmpCliente)
    {
        $this->mciEmpCliente = $mciEmpCliente;

        return $this;
    }

    /**
     * Get mciEmpCliente
     *
     * @return string 
     */
    public function getMciEmpCliente()
    {
        return $this->mciEmpCliente;
    }
    
    /**
     * 
     * @return type
     */
    public function getNomeConvenio() 
    {
        return $this->nomeConvenio;
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
     * @param type $nomeConvenio
     */
    public function setNomeConvenio($nomeConvenio) 
    {
        $this->nomeConvenio = $nomeConvenio;
    }


}
