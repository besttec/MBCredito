<?php
namespace SerBinario\MBCredito\MBCreditoBundle\Util;

use Doctrine\ORM\EntityManager;

/**
 * Description of gridClass
 *
 * @author psgvaz
 */
class GridClass
{
    /**
     *
     * @var type 
     */
    private $em;
    
    /**
     *
     * @var type 
     */
    private $parametros;
    
    /**
     *
     * @var type 
     */
     private $start;
     
     /**
      *
      * @var type 
      */
     private $length;
     
     /**
      *
      * @var type 
      */
     private $columns;
     
     /**
      *
      * @var type 
      */
     private $entity;
     
     /**
      *
      * @var type 
      */
     private $entityJOIN;
     
     /**
      *
      * @var type 
      */
     private $whereFull;
     
     /**
      *
      * @var type 
      */
     private $columnWhereMain;
     
     /**
      *
      * @var type 
      */
     private $whereValueMain;
     
     /**
      *
      * @var type 
      */
     private $filterBool = false;
     
    /**
     * 
     */
    public function __construct(EntityManager $em,
            $parametros, 
            $columns,
            $entity, 
            $entityJOIN,             
            $whereMain,
            $whereValueMain,
            $whereFull = "") 
    {
        $this->start               = $parametros['start'];
        $this->length              = $parametros['length'];
        $this->columns             = $columns;
        $this->entity              = $entity;
        $this->entityJOIN          = $entityJOIN; 
        $this->columnWhereMain     = $whereMain;
        $this->whereValueMain      = $whereValueMain;
        $this->parametros          = $parametros;
        $this->em                  = $em;
        $this->whereFull           = $whereFull;
    }
    
    /**
     * 
     * @param type $request
     * @return type
     */
    private function filter ( $request, $dqlColumns = null)
    {
        $columnValue  = array();
        $columns      = $request['columns'];
               
        if ( isset($request['search']) && $request['search']['value'] != '' ) {
                 $globalSearch = utf8_encode($request['search']['value']);
                 
                 return $globalSearch;
        }
        
        for ( $i=0; $i < count($columns); $i++ ) {
            
            if(!empty($columns[$i]['search']['value'])) {
                $columnValue[$dqlColumns[$i]] = $columns[$i]['search']['value']; 
            }          
	}

        return $columnValue;
    }
    
    /**
     * 
     * @param type $request
     * @return type
     */
    private function order ($request, $sqlColumn)
    {
        $column = $request['order']['0']['column'];
        $dir = $request['order']['0']['dir'];

        return $sqlColumn["{$column}"] . " " . $dir ." ";
    }
    
    /**
     * 
     * @return boolean
     */
    public static function isAjax()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            return true;
        }
        
        return false;
        
    }
    
    /**
     * 
     */
    public function builderQuery()
    {        
        try {
            
            $dqlWhere    = " "; 
            if(!empty($this->whereValueMain)){
                $dqlWhere .= " WHERE {$this->columnWhereMain} = {$this->whereValueMain}";
            }else{
                //$dqlWhere .= " WHERE ";
            }
            
            if(!empty($this->whereFull)) {
                 $dqlWhere .= " WHERE {$this->whereFull}";
            }
            
            $whereGlobal    = false;
            $wherePerson    = false;
            $filterValue    = array();
            $filterKey      = array();
            $dqlStart       = $this->start;
            $dqlLength      = $this->length;
            $dqlColumn      = $this->columns;
            $dqlFilter      = $this->filter($this->parametros, $dqlColumn);
           
            if(count($dqlFilter) > 0) {
                $this->filterBool = true;

            }
            
            $dqlOrder       = $this->order($this->parametros, $dqlColumn);
            $letras         = array('b', 'c', 'd', 'e');
            $entityJoin     = $this->entityJOIN;
            $sqlJoin        = "";
            //$entityJoinMain = $this->entityJOINWhereMain;

            for($i = 0; $i < count($entityJoin); $i++) {
                $verifyJoin = explode(".", $entityJoin[$i]);
                //var_dump(count($verifyJoin));exit;
                if(count($verifyJoin) == 2) {
                    $sqlJoin .= " JOIN {$entityJoin[$i]} {$letras[$i]} ";
                } else {
                    $sqlJoin .= " JOIN a.{$entityJoin[$i]} {$letras[$i]} ";
                }               
                
            }
           
            if(!empty($dqlFilter)) {
                
                if(!empty($this->whereValueMain)){
                    $dqlWhere .= " AND ("; 
                }else{
                    $dqlWhere .= " WHERE ("; 
                }
            
            
                             
                if(is_array($dqlFilter)) {
                    $wherePerson = true;
                    $filterKey   = array_keys($dqlFilter);
                    $filterValue = array_values($dqlFilter);
                    
                    for($i = 0; $i < count($filterKey); $i++) {
                        $index = $i + 1;
                        $dqlWhere .= " {$filterKey[$i]} LIKE ?{$index} AND ";
                    }                    
                } else {
                    $whereGlobal = true;
                    foreach($dqlColumn as $valor) {
                        $dqlWhere .= " {$valor} LIKE ?1 OR  ";
                    }                                         
                }
                
                $dqlWhere    = substr($dqlWhere, 0, -4) . ")";
            }            
            
            $query  = $this->em->createQuery("SELECT a FROM {$this->entity} a"
                        . " {$sqlJoin} "
                        . " {$dqlWhere} "
                        . "ORDER BY {$dqlOrder}")
                        ->setFirstResult($dqlStart)
                        ->setMaxResults($dqlLength);
            //print_r($dqlOrder); exit();            
            if($whereGlobal) {
                $query->setParameter(1,strtoupper("%{$dqlFilter}%"));
            } else if($wherePerson) {
                for($i = 0; $i < count($filterValue); $i++) {
                    $index = $i + 1;
                    $query->setParameter($index, strtoupper("%{$filterValue[$i]}%"));
                }
            } 
            $result = $query->getResult();
                  
            return $result;
        } catch (Exception $ex) {
            print_r($ex);
        }
    
    }
    
    /**
     * 
     * @return int
     */
    public function getCountByIdJoin($entityJOIN, 
        $columnWhereMain,
        $whereValueMain)
    {
        try {
            $qb = $this->em->createQueryBuilder();
            $qb->select("count(a)");
            $qb->from("{$this->entity}", "a");
            $qb->join("a.{$entityJOIN}", "b");
            $qb->where("b.{$columnWhereMain} = ?1");
            $qb->setParameter(1, $whereValueMain);
            
            $result = $qb->getQuery()->getSingleScalarResult();
            
            return $result;
        } catch (Exception $ex) {
            return 0;
        }
    }
    
    /**
     * 
     * @param type $entityJOIN
     * @param type $whereFull
     * @return int
     */
     public function getCountByWhereFull($entityJOIN = array(),
        $subEntityJOIN = array(),
        $whereFull)
    {
        try {
            $qb = $this->em->createQueryBuilder();
            $qb->select("count(a)");
            $qb->from("{$this->entity}", "a");
            
            foreach($entityJOIN as $chave => $entity) {
                $qb->join("a.{$entity}", "{$chave}");
            }

            foreach($subEntityJOIN as $chave => $entity) {
                $qb->join("{$entity}", "{$chave}");
            }
              
            $qb->where("{$whereFull}");
           // var_dump($qb->getQuery());exit();
            $result = $qb->getQuery()->getSingleScalarResult();
            
            return $result;
        } catch (Exception $ex) {
            return 0;
        }
    }
    
    /**
     * 
     * @return int
     */
    public function getCount()
    {
        try {
            $qb = $this->em->createQueryBuilder();
            $qb->select("count(a)");
            $qb->from("{$this->entity}", "a");
        
            $result = $qb->getQuery()->getSingleScalarResult();
            
            return $result;
        } catch (Exception $ex) {
            return 0;
        }
    }
    
    /**
     * 
     * @return type
     */
    public function isFilter()
    {
        return $this->filterBool;
    }


    
    public function getStart() 
    {
        return $this->start;
    }

    public function getLength() 
    {
        return $this->length;
    }

    public function getColumns() 
    {
        return $this->columns;
    }

    public function getEntity() 
    {
        return $this->entity;
    }

    public function getEntityJOIN() 
    {
        return $this->entityJOIN;
    }

    public function getWhereMain() 
    {
        return $this->whereMain;
    }

    public function getWhereValueMain() 
    {
        return $this->whereValueMain;
    }

    public function setStart(type $start) 
    {
        $this->start = $start;
    }

    public function setLength(type $length) 
    {
        $this->length = $length;
    }

    public function setColumns(type $columns) 
    {
        $this->columns = $columns;
    }

    public function setEntity(type $entity) 
    {
        $this->entity = $entity;
    }

    public function setEntityJOIN(type $entityJOIN) 
    {
        $this->entityJOIN = $entityJOIN;
    }

    public function setWhereMain(type $whereMain) 
    {
        $this->whereMain = $whereMain;
    }

    public function setWhereValueMain(type $whereValueMain) 
    {
        $this->whereValueMain = $whereValueMain;
    }


}
