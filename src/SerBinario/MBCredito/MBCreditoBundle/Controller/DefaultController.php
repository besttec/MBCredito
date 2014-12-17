<?php
namespace SerBinario\MBCredito\MBCreditoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use SerBinario\MBCredito\MBCreditoBundle\Entity\Documento;
use SerBinario\MBCredito\MBCreditoBundle\Util\GridClass;
use SerBinario\MBCredito\MBCreditoBundle\Entity\Clientes;
use SerBinario\MBCredito\MBCreditoBundle\DAO\DocumentoDAO;
use SerBinario\MBCredito\MBCreditoBundle\DAO\ClienteDAO;

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
     * @Route("/importarArquivo", name="importarArquivo")
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
        $nameFile   = sha1(uniqid(mt_rand(), true));
        $validator  = $this->get('validator');
        
        $documento = new Documento();
        $documento->setName($nameFile);
        $documento->setFile($uploadfile);
        $documento->setData(new \DateTime("now", new \DateTimeZone("America/Recife")));
        
        $erros = $validator->validate($documento);
        
        if(! count($erros)) {
            $documentoDAO = new DocumentoDAO($this->getDoctrine()->getManager());            
            $documento->upload();
            
            $result = $documentoDAO->save($documento);    
            
            if($result) {
                $fileString = file($documento->getWebPath());
     
                for($i = 0; $i < count($fileString); $i++) {
                    $columns = explode(";", $fileString[$i]);
                    
                    $cliente = new Clientes();
                    
                    $sexo = new \SerBinario\MBCredito\MBCreditoBundle\Entity\Sexos();
                    $sexo->setNomeExtensoSexo($columns[0]);
                    
                    $cliente->setSexosSexo($sexo);
                    $cliente->setMciEmpCliente($columns[1]);
                    $cliente->setLimteCredito($columns[2]);
                    
                    $superEstadual = new \SerBinario\MBCredito\MBCreditoBundle\Entity\SuperEstadual();
                    $superEstadual->setUf($columns[3]);
                    $superEstadual->setCodSuperEstadual($columns[3]);
                    $superEstadual->setNomeSuperEstadual($columns[4]);
                    
                    $cliente->setSuperEstadualSuperEstadual($superEstadual);
                    
                    $superRegional = new \SerBinario\MBCredito\MBCreditoBundle\Entity\SuperRegional();
                    $superRegional->setCodSuperRegional($columns[4]);
                    $superRegional->setNomeSuperRegional($columns[5]);
                    
                    $cliente->setSuperRegionalSuperRegional($superRegional);
                    
                    $ag = new \SerBinario\MBCredito\MBCreditoBundle\Entity\Ag();
                    $ag->setPrefixoAg($columns[5]);
                    $ag->setNomeAg($columns[6]);
                    $ag->setCcAg($columns[7]);
                    
                    $cliente->setAgAg($ag);
                    $cliente->setNomeCliente($columns[8]);
                    $cliente->setCpfCliente($columns[9]);
                    $cliente->setDddFoneResidCliente($columns[10]);
                    $cliente->setFoneResidCliente($columns[11]);
                    $cliente->setDddFoneComerCliente($columns[12]);
                    $cliente->setFoneComerCliente($columns[13]);
                    $cliente->setDddFoneCelCliente($columns[14]);
                    $cliente->setFoneCelCliente($columns[15]);
                    $cliente->setDddFonePrefCliente($columns[16]);
                    $cliente->setFonePrefCliente($columns[17]);
                    $cliente->setCodCliente($columns[18]);
                    $cliente->setDataNascCliente(new \DateTime("now",  new \DateTimeZone("America/Recife")));
                    $cliente->setNumBeneficioCliente($columns[20]);
                    $cliente->setDvCliente($columns[21]);
                    
                    $clienteDAO = new ClienteDAO($this->getDoctrine()->getManager());
                    $clienteDAO->insertCliente($cliente);
                }
               
               $this->get("session")->getFlashBag()->add('success', "Arquivo importado com sucesso!");              
            } else {
                $this->get("session")->getFlashBag()->add('error', "Error ao importar o arquivo!"); 
            }
        }
        
        $this->get("session")->getFlashBag()->add('error', (string) $erros);
        
        return $this->redirect($this->generateUrl("importarArquivo"));
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
        } else {
            $this->view("noivos/gridEventosNoivos", array('type' => $type, 'msg' => $msg));
        }
            
    }
    
    
}
