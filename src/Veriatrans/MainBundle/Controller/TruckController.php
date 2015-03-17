<?php

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
use Veriatrans\MainBundle\Entity\Truck;
use Veriatrans\MainBundle\Form\TruckType;
/**
 * Class TruckController
 * @package Veriatrans\MainBundle\Controller
 * @Route("/admin")
 */
class TruckController extends Controller
{
    /**
     * Create new truck
     *
     * @Route("/create-truck", name="create_truck")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function createAction()
    {
        return array();
    }

    /**
     * Retrieve all available trucks
     *
     * @Route("/list-trucks", name="list_trucks")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function listTrucksAction(){
        $truckForm = $this->createForm( new TruckType() );
        return array(
            'truckForm' => $truckForm->createView(),
            'currentMenuItem'      => 'truck'
        );
    }

    /**
     *
     * @Route("/json-list-trucks", name="json_list_trucks")
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
        $Trucks = $em->getRepository( 'VeriatransMainBundle:Truck' )->get($iDisplayStart,$iDisplayLength,$mDataProp_0,$sSortDir_0);
        $AllTrucks = $em->getRepository( 'VeriatransMainBundle:Truck' )->findAll();

        $Trucks = array(
            'iTotalRecords' => count($AllTrucks),
            'iTotalDisplayRecords' => count($AllTrucks),
            'sEcho' => 0,
            'aaData' => $Trucks
        );
        print(json_encode($Trucks));
        exit;
    }

    /**
     *
     * @Route("/json-retrieve-truck-columns-length", name="json_retrieve_truck_columns_length")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function jsonRetrieveColumnsLengthAction(){

        $em = $this->getDoctrine()->getManager();
        $databaseName = $this->container->getParameter( 'database_name' );
        $tableName = $em->getClassMetadata('VeriatransMainBundle:Truck')->getTableName();
        $TruckColumns = $em->getRepository( 'VeriatransMainBundle:Truck' )->getColumnsLength($tableName,$databaseName);
        $TempTruckColumn = array();
        foreach($TruckColumns AS $EachColumn){
            $TempTruckColumn[strtolower($EachColumn['Field'])] = preg_replace('/\D/', '', $EachColumn['Type']);
        }
        $TruckColumns = $TempTruckColumn;
        unset($TempTruckColumn);

        print(json_encode($TruckColumns));
        exit;
    }

    /**
     * @Route("/{id}/json-update-truck", name="json_update_truck")
     * @Method("PUT")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function jsonUpdateAction( Request $request,$id)
    {

        $translator = $this->get( 'translator' );
        $em             = $this->getDoctrine()->getManager();
        $Truck          = $em->getRepository( 'VeriatransMainBundle:Truck' )->find( $id );
        if ( !$Truck ) {
            throw $this->createNotFoundException( $translator->trans( 'Truck not found.', array(), 'MainBundle' ) );
        }

        $column = $request->request->get('column');
        $value = $request->request->get('value');
        $isDate = strtolower(substr($column,-4)) == 'date';

        if($isDate){
            $value = strtotime($value);
        }
        $updateResult = $em->getRepository( 'VeriatransMainBundle:Truck' )->updateOneCell(array($column=>$value),(integer)$id);

        print(json_encode(array('success'=>$updateResult,'message'=>'')));
        exit;
    }

    /**
     * @Route("/{id}/json-delete-truck", name="json_delete_truck")
     * @Method("DELETE")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function jsonDeleteAction( Request $request,$id)
    {

        $translator = $this->get( 'translator' );
        $em             = $this->getDoctrine()->getManager();
        $Truck          = $em->getRepository( 'VeriatransMainBundle:Truck' )->find( $id );
        if ( !$Truck ) {
            throw $this->createNotFoundException( $translator->trans( 'Truck not found.', array(), 'MainBundle' ) );
        }
        $deleteResult = $em->getRepository( 'VeriatransMainBundle:Truck' )->updateOneCell(array('isDeleted'=>true),(integer)$id);

        print(json_encode(array('success'=>$deleteResult,'message'=>'')));
        exit;
    }

    /**
     * @Route("/json-create-truck", name="json_create_truck")
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

        $createResult = $em->getRepository( 'VeriatransMainBundle:Truck' )->create($post);

        print(json_encode(array('success'=>(boolean)$createResult, 'id'=>$createResult, 'message'=>'')));
        exit;
    }

}
