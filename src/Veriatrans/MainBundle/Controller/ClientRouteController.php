<?php
/**
 * User: dorin
 * Date: 23.03.2015
 * Time: 18:07
 * @author Aftenii Dorin
 */
namespace Veriatrans\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Validator\Constraints\Date;
use Veriatrans\MainBundle\Entity\DriverRoute;
//use Veriatrans\MainBundle\Form\DriverRouteType;
/**
 * Class DriverRouteController
 * @package Veriatrans\MainBundle\Controller
 * @Route("/admin")
 */
class ClientRouteController extends Controller
{
    /**
     * Create new clientRoute
     *
     * @Route("/create-client-route", name="create_client_route")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function createAction()
    {
        return array();
    }

    /**
     * Retrieve all available clientRoutes
     *
     * @Route("/list-client-routes", name="list_client_routes")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function listClientRoutesAction(){
        // $clientRouteForm = $this->createForm( new ClientRouteType() );
        return array(
            //  'clientRouteForm' => $clientRouteForm->createView(),
            'currentMenuItem'      => 'clientRoute'
        );
    }

    /**
     *
     * @Route("/json-list-client-routes", name="json_list_client_routes")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function jsonRetrieveAction(Request $request){

        /*        // $_GET parameters
                $request->query->get('name');
                // $_POST parameters
                $request->request->get('name');*/

        $iDisplayLength = $request->query->get('iDisplayLength');
        $iDisplayStart = $request->query->get('iDisplayStart');
        $iSortCol_0 = $request->query->get('iSortCol_0');
        $sSortDir_0 = $request->query->get('sSortDir_0');
        $mDataProp_0 = $request->query->get("mDataProp_{$iSortCol_0}");

        $em = $this->getDoctrine()->getManager();
        $ClientRoutes = $em->getRepository( 'VeriatransMainBundle:ClientRoute' )->get($iDisplayStart,$iDisplayLength,$mDataProp_0,$sSortDir_0);
        $AllClientRoutes = $em->getRepository( 'VeriatransMainBundle:ClientRoute' )->findAll();

        $ClientRoutes = array(
            'iTotalRecords' => count($AllClientRoutes),
            'iTotalDisplayRecords' => count($AllClientRoutes),
            'sEcho' => 0,
            'aaData' => $ClientRoutes
        );
        print(json_encode($ClientRoutes));
        exit;
    }

    /**
     *
     * @Route("/{column}/json-retrieve-join-data", name="json_retrieve_join_data")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
/*    public function jsonRetrieveJoinDataAction(Request $request,$column){
        $translator = $this->get( 'translator' );
        $em             = $this->getDoctrine()->getManager();
        $databaseName = $this->container->getParameter( 'database_name' );
        $table = substr($column,0,strlen($column)-2);
        $columns = $request->query->get('columns');
        $results = $em->getRepository( "VeriatransMainBundle:ClientRoute" )->retrieveJoinData($databaseName,$table,$columns);
        if(!$results){
            throw $this->createNotFoundException( $translator->trans( 'Table not found.', array(), 'MainBundle' ) );
        }
        print(json_encode($results));
        exit;
    }*/

    /**
     *
     * @Route("/json-retrieve-client-route-columns-length", name="json_retrieve_client_route_columns_length")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function jsonRetrieveColumnsLengthAction(){

        $em = $this->getDoctrine()->getManager();
        $databaseName = $this->container->getParameter( 'database_name' );
        $tableName = $em->getClassMetadata('VeriatransMainBundle:ClientRoute')->getTableName();
        $ClientRouteColumns = $em->getRepository( 'VeriatransMainBundle:ClientRoute' )->getColumnsLength($tableName,$databaseName);
        $TempClientRouteColumn = array();
        foreach($ClientRouteColumns AS $EachColumn){
            $TempClientRouteColumn[strtolower($EachColumn['Field'])] = preg_replace('/\D/', '', $EachColumn['Type']);
        }
        $ClientRouteColumns = $TempClientRouteColumn;
        unset($TempClientRouteColumn);

        print(json_encode($ClientRouteColumns));
        exit;
    }

    /**
     * @Route("/{id}/json-update-client-route", name="json_update_client_route")
     * @Method("PUT")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function jsonUpdateAction( Request $request,$id)
    {
        $translator = $this->get( 'translator' );
        $em             = $this->getDoctrine()->getManager();
        $ClientRoute          = $em->getRepository( 'VeriatransMainBundle:ClientRoute' )->find( $id );
        if ( !$ClientRoute ) {
            throw $this->createNotFoundException( $translator->trans( 'ClientRoute not found.', array(), 'MainBundle' ) );
        }

        $column = $request->request->get('column');
        $value = $request->request->get('value');
        $isDate = strtolower(substr($column,-4)) == 'date';

        if($isDate){
            $value = strtotime($value);
        }
        $updateResult = $em->getRepository( 'VeriatransMainBundle:ClientRoute' )->updateOneCell(array($column=>$value),(integer)$id);

        print(json_encode(array('success'=>$updateResult,'message'=>'')));
        exit;
    }

    /**
     * @Route("/{id}/json-delete-client-route", name="json_delete_client_route")
     * @Method("DELETE")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function jsonDeleteAction( Request $request,$id)
    {

        $translator = $this->get( 'translator' );
        $em             = $this->getDoctrine()->getManager();
        $ClientRoute          = $em->getRepository( 'VeriatransMainBundle:ClientRoute' )->find( $id );
        if ( !$ClientRoute ) {
            throw $this->createNotFoundException( $translator->trans( 'ClientRoute not found.', array(), 'MainBundle' ) );
        }
        $deleteResult = $em->getRepository( 'VeriatransMainBundle:ClientRoute' )->updateOneCell(array('isDeleted'=>true),(integer)$id);

        print(json_encode(array('success'=>$deleteResult,'message'=>'')));
        exit;
    }

    /**
     * @Route("/json-create-client-route", name="json_create_client_route")
     * @Method("POST")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function jsonCreateAction( Request $request)
    {
        $em             = $this->getDoctrine()->getManager();
        $post = $request->request->get('params');

        foreach($post AS $column=>&$value){
            $isDate = strtolower(substr($column,-4)) == 'date';

            if($isDate){
                $value = strtotime($value);
            }
        }

        $createResult = $em->getRepository( 'VeriatransMainBundle:ClientRoute' )->create($post);

        print(json_encode(array('success'=>(boolean)$createResult, 'id'=>$createResult, 'message'=>'')));
        exit;
    }

}
