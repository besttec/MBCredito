<?php

namespace SerBinario\MBCredito\MBCreditoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use SerBinario\MBCredito\MBCreditoBundle\Util\GridClass;
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
        return array();
    }
    
    /**
     * @Route("/grid")
     * @Method({"POST"})
     * @Template("")
     */
    public function testeGridAction()
    {
        if(GridClass::isAjax()) {
            
            $columns = array("a.nomeCliente",
                "a.mciEmpCliente",
                "a.cpfCliente",
                "a.dddFoneResidCliente"
                );

            $entityJOIN = array("tipoEvento", "noivos"); 

            $eventosArray        = array();
            $parametros          = $this->getParamsPost();        
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

            $resultEvento  = $gridClass->builderQuery();    
            $countTotal    = $gridClass->getCountByIdJoin("noivos", "idnoivos", $idNoivos);
            $countEventos = count($resultEvento);



            for($i=0;$i < $countEventos; $i++)
            {
                $eventosArray[$i]['DT_RowId']   =  "row_".$resultEvento[$i]->getIdeventos();
                $eventosArray[$i]['info'] = utf8_encode($resultEvento[$i]->getInfo());
                $eventosArray[$i]['titulo'] =  utf8_encode($resultEvento[$i]->getTitulo());
                $eventosArray[$i]['endereco'] =  utf8_encode($resultEvento[$i]->getEndereco());
                $eventosArray[$i]['cidade'] =  utf8_encode($resultEvento[$i]->getCidade());
                $eventosArray[$i]['uf'] = $resultEvento[$i]->getUf();
                $eventosArray[$i]['data'] = $resultEvento[$i]->getData()->format("d-m-Y");
                $eventosArray[$i]['local'] = utf8_encode($resultEvento[$i]->getLocal());
                $eventosArray[$i]['tipoEvento'] = utf8_encode($resultEvento[$i]->getTipoEvento()->getTipoEvento());
            }

            //Se a variável $sqlFilter estiver vazio
            if(!$gridClass->isFilter()){
                $countEventos = $countTotal;
            }


            $columns = array(               
                'draw' => $parametros['draw'],
                'recordsTotal' => "{$countTotal}",
                'recordsFiltered' => "{$countEventos}",
                'data' => $eventosArray               
            );

             return new JsonResponse($columns);
        }else{
            $this->view("noivos/gridEventosNoivos", array('type' => $type, 'msg' => $msg));
        }
            
    }
    
    
}
