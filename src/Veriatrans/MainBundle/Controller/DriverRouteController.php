<?php
/**
 * User: dorin
 * Date: 19.03.2015
 * Time: 09:21
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
class DriverRouteController extends Controller
{
    /**
     * Create new driverRoute
     *
     * @Route("/create-driverRoute", name="create_driverRoute")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function createAction()
    {
        return array();
    }

    /**
     * Retrieve all available driverRoutes
     *
     * @Route("/list-driver-routes", name="list_driver_routes")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function listDriverRoutesAction(){
        // $driverRouteForm = $this->createForm( new DriverRouteType() );
        return array(
            //  'driverRouteForm' => $driverRouteForm->createView(),
            'currentMenuItem'      => 'driverRoute'
        );
    }

    /**
     *
     * @Route("/json-list-driver-routes", name="json_list_driver_routes")
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
        $DriverRoutes = $em->getRepository( 'VeriatransMainBundle:DriverRoute' )->get($iDisplayStart,$iDisplayLength,$mDataProp_0,$sSortDir_0);
        $AllDriverRoutes = $em->getRepository( 'VeriatransMainBundle:DriverRoute' )->findAll();

        $DriverRoutes = array(
            'iTotalRecords' => count($AllDriverRoutes),
            'iTotalDisplayRecords' => count($AllDriverRoutes),
            'sEcho' => 0,
            'aaData' => $DriverRoutes
        );
        print(json_encode($DriverRoutes));
        exit;
    }

    /**
     *
     * @Route("/{column}/json-retrieve-join-data", name="json_retrieve_join_data")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function jsonRetrieveJoinDataAction(Request $request,$column){
        $translator = $this->get( 'translator' );
        $em             = $this->getDoctrine()->getManager();
        $databaseName = $this->container->getParameter( 'database_name' );
        $table = substr($column,0,strlen($column)-2);
        $columns = $request->query->get('columns');
        $results = $em->getRepository( "VeriatransMainBundle:DriverRoute" )->retrieveJoinData($databaseName,$table,$columns);
        if(!$results){
            throw $this->createNotFoundException( $translator->trans( 'Table not found.', array(), 'MainBundle' ) );
        }
        print(json_encode($results));
        exit;
    }

    /**
     *
     * @Route("/json-retrieve-driver-route-columns-length", name="json_retrieve_driver_route_columns_length")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function jsonRetrieveColumnsLengthAction(){

        $em = $this->getDoctrine()->getManager();
        $databaseName = $this->container->getParameter( 'database_name' );
        $tableName = $em->getClassMetadata('VeriatransMainBundle:DriverRoute')->getTableName();
        $DriverRouteColumns = $em->getRepository( 'VeriatransMainBundle:DriverRoute' )->getColumnsLength($tableName,$databaseName);
        $TempDriverRouteColumn = array();
        foreach($DriverRouteColumns AS $EachColumn){
            $TempDriverRouteColumn[strtolower($EachColumn['Field'])] = preg_replace('/\D/', '', $EachColumn['Type']);
        }
        $DriverRouteColumns = $TempDriverRouteColumn;
        unset($TempDriverRouteColumn);

        print(json_encode($DriverRouteColumns));
        exit;
    }

    /**
     * @Route("/{id}/json-update-driver-route", name="json_update_driver_route")
     * @Method("PUT")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function jsonUpdateAction( Request $request,$id)
    {
        $translator = $this->get( 'translator' );
        $em             = $this->getDoctrine()->getManager();
        $DriverRoute          = $em->getRepository( 'VeriatransMainBundle:DriverRoute' )->find( $id );
        if ( !$DriverRoute ) {
            throw $this->createNotFoundException( $translator->trans( 'DriverRoute not found.', array(), 'MainBundle' ) );
        }

        $column = $request->request->get('column');
        $value = $request->request->get('value');
        $isDate = strtolower(substr($column,-4)) == 'date';

        if($isDate){
            $value = strtotime($value);
        }
        $updateResult = $em->getRepository( 'VeriatransMainBundle:DriverRoute' )->updateOneCell(array($column=>$value),(integer)$id);

        print(json_encode(array('success'=>$updateResult,'message'=>'')));
        exit;
    }

    /**
     * @Route("/{id}/json-delete-driver-route", name="json_delete_driver_route")
     * @Method("DELETE")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function jsonDeleteAction( Request $request,$id)
    {

        $translator = $this->get( 'translator' );
        $em             = $this->getDoctrine()->getManager();
        $DriverRoute          = $em->getRepository( 'VeriatransMainBundle:DriverRoute' )->find( $id );
        if ( !$DriverRoute ) {
            throw $this->createNotFoundException( $translator->trans( 'DriverRoute not found.', array(), 'MainBundle' ) );
        }
        $deleteResult = $em->getRepository( 'VeriatransMainBundle:DriverRoute' )->updateOneCell(array('isDeleted'=>true),(integer)$id);

        print(json_encode(array('success'=>$deleteResult,'message'=>'')));
        exit;
    }

    /**
     * @Route("/json-create-driver-route", name="json_create_driver_route")
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

        $createResult = $em->getRepository( 'VeriatransMainBundle:DriverRoute' )->create($post);

        print(json_encode(array('success'=>(boolean)$createResult, 'id'=>$createResult, 'message'=>'')));
        exit;
    }

}
