<?php

namespace SerBinario\MBCredito\MBCreditoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use SerBinario\MBCredito\MBCreditoBundle\Util\GridClass;
use SerBinario\MBCredito\MBCreditoBundle\Util\MBCreditoUtil;
use SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * @Route("/importarArquivo")
     * @Template()
     */
    public function viewImportarArquivoAction()
    {
        return array();
    }
    
    /**
     * @Route("/saveArquivo", name="saveArquivo")
     */
    public function saveArquivoAction(Request $request)
    {
        $uploadfile = $request->files->get("arquivo");
        
        if($uploadfile->isValid()) {
            
        }
    }
    
    /**
     * @Route("/inserirDados")
     * @Template()
     */
    public function viewInserirDadosAction()
    {
        $mbCredito = new MBCreditoUtil("http://www8.dataprev.gov.br/SipaINSS/pages/hiscre/hiscreInicio.xhtml");
        
        
        return array("img" => $mbCredito->get_captcha());
    }
    
    /**
     * @Route("/grid")
     * @Method({"POST"})
     * @Template("MBCreditoBundle:Default:viewInserirDados.html.twig")
     */
    public function testeGridAction(Request $request)
    {
        
        if(GridClass::isAjax()) {
            
            $columns = array("a.nomeCliente",
                "a.mciEmpCliente",
                "a.cpfCliente",
                "a.dddFoneResidCliente",
                "a.foneResidCliente",
                "a.dddFoneComerCliente",
                "a.foneComerCliente",
                "a.dddFoneCelCliente",
                "a.foneCelCliente",
                "a.foneCelCliente",
                "a.numBeneficioCliente",
                "a.sexosSexo",
                "a.dataNascCliente"
                );

            $entityJOIN = array(); 

            $eventosArray        = array();
            $parametros          = $request->request->all();        
            $entity              = "SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes"; 
            $columnWhereMain     = "";
            $whereValueMain      = "";
            
            $gridClass = new GridClass($this->getDoctrine()->getManager(), 
                    $parametros,
                    $columns,
                    $entity,
                    $entityJOIN,           
                    $columnWhereMain,
                    $whereValueMain);

            $resultCliente  = $gridClass->builderQuery();    
            $countTotal     = $gridClass->getCount();
            $countEventos   = count($resultCliente);

            for($i=0;$i < $countEventos; $i++)
            {
                $eventosArray[$i]['DT_RowId']   =  "row_".$resultCliente[$i]->getIdCliente();
                $eventosArray[$i]['nome']       =  $resultCliente[$i]->getNomeCliente();
                $eventosArray[$i]['mci']        =  $resultCliente[$i]->getMciEmpCliente();
                $eventosArray[$i]['cpf']        =  $resultCliente[$i]->getCpfCliente();
                $eventosArray[$i]['dddFoneRes']       =  $resultCliente[$i]->getDddFoneResidCliente();
                $eventosArray[$i]['FoneRes']       =  $resultCliente[$i]->getFoneResidCliente();
                $eventosArray[$i]['dddFoneCom']       =  $resultCliente[$i]->getDddFoneComerCliente();
                $eventosArray[$i]['FoneCom']       =  $resultCliente[$i]->getFoneComerCliente();
                $eventosArray[$i]['dddFoneCel']       =  $resultCliente[$i]->getDddFoneCelCliente();
                $eventosArray[$i]['FoneCel']       =  $resultCliente[$i]->getFoneCelCliente();
                $eventosArray[$i]['numBeneficio']       =  $resultCliente[$i]->getNumBeneficioCliente();
                $eventosArray[$i]['Sexo']       =  $resultCliente[$i]->getSexosSexo()->getNomeExtensoSexo();
                $eventosArray[$i]['dtNascimento']       =  $resultCliente[$i]->getDataNascCliente();
            }

            //Se a variável $sqlFilter estiver vazio
            if(!$gridClass->isFilter()){
                $countEventos = $countTotal;
            }

            $columns = array(               
                'draw'              => $parametros['draw'],
                'recordsTotal'      => "{$countTotal}",
                'recordsFiltered'   => "{$countEventos}",
                'data'              => $eventosArray               
            );

             return new JsonResponse($columns);
        }else{
            
            return array();
            
        }
            
    }
    
}
