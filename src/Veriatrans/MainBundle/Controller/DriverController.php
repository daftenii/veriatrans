<?php
/**
 * User: dorin
 * Date: 3/17/15
 * Time: 8:15 PM
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
use Veriatrans\MainBundle\Entity\Driver;
//use Veriatrans\MainBundle\Form\DriverType;
/**
 * Class DriverController
 * @package Veriatrans\MainBundle\Controller
 * @Route("/admin")
 */
class DriverController extends Controller
{
    /**
     * Create new driver
     *
     * @Route("/create-driver", name="create_driver")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function createAction()
    {
        return array();
    }

    /**
     * Retrieve all available drivers
     *
     * @Route("/list-drivers", name="list_drivers")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function listDriversAction(){
        //$driverForm = $this->createForm( new DriverType() );
        return array(
            'currentMenuItem' => 'driver',
        );
    }

    /**
     *
     * @Route("/json-list-drivers", name="json_list_drivers")
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
        $Drivers = $em->getRepository( 'VeriatransMainBundle:Driver' )->get($iDisplayStart,$iDisplayLength,$mDataProp_0,$sSortDir_0);
        $AllDrivers = $em->getRepository( 'VeriatransMainBundle:Driver' )->findAll();

        $Drivers = array(
            'iTotalRecords' => count($AllDrivers),
            'iTotalDisplayRecords' => count($AllDrivers),
            'sEcho' => 0,
            'aaData' => $Drivers
        );
        print(json_encode($Drivers));
        exit;
    }

    /**
     *
     * @Route("/json-retrieve-driver-columns-length", name="json_retrieve_driver_columns_length")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function jsonRetrieveColumnsLengthAction(){

        $em = $this->getDoctrine()->getManager();
        $databaseName = $this->container->getParameter( 'database_name' );
        $tableName = $em->getClassMetadata('VeriatransMainBundle:Driver')->getTableName();
        $DriverColumns = $em->getRepository( 'VeriatransMainBundle:Driver' )->getColumnsLength($tableName,$databaseName);
        $TempDriverColumn = array();
        foreach($DriverColumns AS $EachColumn){
            $TempDriverColumn[strtolower($EachColumn['Field'])] = preg_replace('/\D/', '', $EachColumn['Type']);
        }
        $DriverColumns = $TempDriverColumn;
        unset($TempDriverColumn);

        print(json_encode($DriverColumns));
        exit;
    }

    /**
     * @Route("/{id}/json-update-driver", name="json_update_driver")
     * @Method("PUT")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function jsonUpdateAction( Request $request,$id)
    {

        $translator = $this->get( 'translator' );
        $em             = $this->getDoctrine()->getManager();
        $Driver          = $em->getRepository( 'VeriatransMainBundle:Driver' )->find( $id );
        if ( !$Driver ) {
            throw $this->createNotFoundException( $translator->trans( 'Driver not found.', array(), 'MainBundle' ) );
        }

        $column = $request->request->get('column');
        $value = $request->request->get('value');
        $isDate = strtolower(substr($column,-4)) == 'date';

        if($isDate){
            $value = strtotime($value);
        }
        $updateResult = $em->getRepository( 'VeriatransMainBundle:Driver' )->updateOneCell(array($column=>$value),(integer)$id);

        print(json_encode(array('success'=>$updateResult,'message'=>'')));
        exit;
    }

    /**
     * @Route("/{id}/json-delete-driver", name="json_delete_driver")
     * @Method("DELETE")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function jsonDeleteAction( Request $request,$id)
    {

        $translator = $this->get( 'translator' );
        $em             = $this->getDoctrine()->getManager();
        $Driver          = $em->getRepository( 'VeriatransMainBundle:Driver' )->find( $id );
        if ( !$Driver ) {
            throw $this->createNotFoundException( $translator->trans( 'Driver not found.', array(), 'MainBundle' ) );
        }
        $deleteResult = $em->getRepository( 'VeriatransMainBundle:Driver' )->updateOneCell(array('isDeleted'=>true),(integer)$id);

        print(json_encode(array('success'=>$deleteResult,'message'=>'')));
        exit;
    }

    /**
     * @Route("/json-create-driver", name="json_create_driver")
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

        $createResult = $em->getRepository( 'VeriatransMainBundle:Driver' )->create($post);

        print(json_encode(array('success'=>(boolean)$createResult, 'id'=>$createResult, 'message'=>'')));
        exit;
    }

}
