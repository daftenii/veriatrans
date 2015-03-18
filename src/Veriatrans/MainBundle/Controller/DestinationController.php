<?php
/**
 * User: dorin
 * Date: 3/17/15
 * Time: 4:38 PM
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
use Veriatrans\MainBundle\Entity\Destination;
//use Veriatrans\MainBundle\Form\DestinationType;
/**
 * Class DestinationController
 * @package Veriatrans\MainBundle\Controller
 * @Route("/admin")
 */
class DestinationController extends Controller
{
    /**
     * Create new destination
     *
     * @Route("/create-destination", name="create_destination")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function createAction()
    {
        return array();
    }

    /**
     * Retrieve all available destinations
     *
     * @Route("/list-destinations", name="list_destinations")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function listDestinationsAction(){
        //$destinationForm = $this->createForm( new DestinationType() );
        return array(
            'destinationForm' => '',
            'currentMenuItem' => 'destination'
        );
    }

    /**
     *
     * @Route("/json-list-destinations", name="json_list_destinations")
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
        $Destinations = $em->getRepository( 'VeriatransMainBundle:Destination' )->get($iDisplayStart,$iDisplayLength,$mDataProp_0,$sSortDir_0);
        $AllDestinations = $em->getRepository( 'VeriatransMainBundle:Destination' )->findAll();

        $Destinations = array(
            'iTotalRecords' => count($AllDestinations),
            'iTotalDisplayRecords' => count($AllDestinations),
            'sEcho' => 0,
            'aaData' => $Destinations
        );
        print(json_encode($Destinations));
        exit;
    }

    /**
     *
     * @Route("/json-retrieve-destination-columns-length", name="json_retrieve_destination_columns_length")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function jsonRetrieveColumnsLengthAction(){

        $em = $this->getDoctrine()->getManager();
        $databaseName = $this->container->getParameter( 'database_name' );
        $tableName = $em->getClassMetadata('VeriatransMainBundle:Destination')->getTableName();
        $DestinationColumns = $em->getRepository( 'VeriatransMainBundle:Destination' )->getColumnsLength($tableName,$databaseName);
        $TempDestinationColumn = array();
        foreach($DestinationColumns AS $EachColumn){
            $TempDestinationColumn[strtolower($EachColumn['Field'])] = preg_replace('/\D/', '', $EachColumn['Type']);
        }
        $DestinationColumns = $TempDestinationColumn;
        unset($TempDestinationColumn);

        print(json_encode($DestinationColumns));
        exit;
    }

    /**
     * @Route("/{id}/json-update-destination", name="json_update_destination")
     * @Method("PUT")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function jsonUpdateAction( Request $request,$id)
    {

        $translator = $this->get( 'translator' );
        $em             = $this->getDoctrine()->getManager();
        $Destination          = $em->getRepository( 'VeriatransMainBundle:Destination' )->find( $id );
        if ( !$Destination ) {
            throw $this->createNotFoundException( $translator->trans( 'Destination not found.', array(), 'MainBundle' ) );
        }

        $column = $request->request->get('column');
        $value = $request->request->get('value');
        $isDate = strtolower(substr($column,-4)) == 'date';

        if($isDate){
            $value = strtotime($value);
        }
        $updateResult = $em->getRepository( 'VeriatransMainBundle:Destination' )->updateOneCell(array($column=>$value),(integer)$id);

        print(json_encode(array('success'=>$updateResult,'message'=>'')));
        exit;
    }

    /**
     * @Route("/{id}/json-delete-destination", name="json_delete_destination")
     * @Method("DELETE")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function jsonDeleteAction( Request $request,$id)
    {

        $translator = $this->get( 'translator' );
        $em             = $this->getDoctrine()->getManager();
        $Destination          = $em->getRepository( 'VeriatransMainBundle:Destination' )->find( $id );
        if ( !$Destination ) {
            throw $this->createNotFoundException( $translator->trans( 'Destination not found.', array(), 'MainBundle' ) );
        }
        $deleteResult = $em->getRepository( 'VeriatransMainBundle:Destination' )->updateOneCell(array('isDeleted'=>true),(integer)$id);

        print(json_encode(array('success'=>$deleteResult,'message'=>'')));
        exit;
    }

    /**
     * @Route("/json-create-destination", name="json_create_destination")
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

        $createResult = $em->getRepository( 'VeriatransMainBundle:Destination' )->create($post);

        print(json_encode(array('success'=>(boolean)$createResult, 'id'=>$createResult, 'message'=>'')));
        exit;
    }

}
