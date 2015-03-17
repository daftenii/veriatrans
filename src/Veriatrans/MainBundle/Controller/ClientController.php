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
use Veriatrans\MainBundle\Entity\Client;
//use Veriatrans\MainBundle\Form\ClientType;
/**
 * Class ClientController
 * @package Veriatrans\MainBundle\Controller
 * @Route("/admin")
 */
class ClientController extends Controller
{
    /**
     * Create new client
     *
     * @Route("/create-client", name="create_client")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function createAction()
    {
        return array();
    }

    /**
     * Retrieve all available clients
     *
     * @Route("/list-clients", name="list_clients")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function listClientsAction(){
       // $clientForm = $this->createForm( new ClientType() );
        return array(
          //  'clientForm' => $clientForm->createView(),
            'currentMenuItem'      => 'client'
        );
    }

    /**
     *
     * @Route("/json-list-clients", name="json_list_clients")
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
        $Clients = $em->getRepository( 'VeriatransMainBundle:Client' )->get($iDisplayStart,$iDisplayLength,$mDataProp_0,$sSortDir_0);
        $AllClients = $em->getRepository( 'VeriatransMainBundle:Client' )->findAll();

        $Clients = array(
            'iTotalRecords' => count($AllClients),
            'iTotalDisplayRecords' => count($AllClients),
            'sEcho' => 0,
            'aaData' => $Clients
        );
        print(json_encode($Clients));
        exit;
    }

    /**
     *
     * @Route("/json-retrieve-client-columns-length", name="json_retrieve_client_columns_length")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function jsonRetrieveColumnsLengthAction(){

        $em = $this->getDoctrine()->getManager();
        $databaseName = $this->container->getParameter( 'database_name' );
        $tableName = $em->getClassMetadata('VeriatransMainBundle:Client')->getTableName();
        $ClientColumns = $em->getRepository( 'VeriatransMainBundle:Client' )->getColumnsLength($tableName,$databaseName);
        $TempClientColumn = array();
        foreach($ClientColumns AS $EachColumn){
            $TempClientColumn[strtolower($EachColumn['Field'])] = preg_replace('/\D/', '', $EachColumn['Type']);
        }
        $ClientColumns = $TempClientColumn;
        unset($TempClientColumn);

        print(json_encode($ClientColumns));
        exit;
    }

    /**
     * @Route("/{id}/json-update-client", name="json_update_client")
     * @Method("PUT")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function jsonUpdateAction( Request $request,$id)
    {

        $translator = $this->get( 'translator' );
        $em             = $this->getDoctrine()->getManager();
        $Client          = $em->getRepository( 'VeriatransMainBundle:Client' )->find( $id );
        if ( !$Client ) {
            throw $this->createNotFoundException( $translator->trans( 'Client not found.', array(), 'MainBundle' ) );
        }

        $column = $request->request->get('column');
        $value = $request->request->get('value');
        $isDate = strtolower(substr($column,-4)) == 'date';

        if($isDate){
            $value = strtotime($value);
        }
        $updateResult = $em->getRepository( 'VeriatransMainBundle:Client' )->updateOneCell(array($column=>$value),(integer)$id);

        print(json_encode(array('success'=>$updateResult,'message'=>'')));
        exit;
    }

    /**
     * @Route("/{id}/json-delete-client", name="json_delete_client")
     * @Method("DELETE")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function jsonDeleteAction( Request $request,$id)
    {

        $translator = $this->get( 'translator' );
        $em             = $this->getDoctrine()->getManager();
        $Client          = $em->getRepository( 'VeriatransMainBundle:Client' )->find( $id );
        if ( !$Client ) {
            throw $this->createNotFoundException( $translator->trans( 'Client not found.', array(), 'MainBundle' ) );
        }
        $deleteResult = $em->getRepository( 'VeriatransMainBundle:Client' )->updateOneCell(array('isDeleted'=>true),(integer)$id);

        print(json_encode(array('success'=>$deleteResult,'message'=>'')));
        exit;
    }

    /**
     * @Route("/json-create-client", name="json_create_client")
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

        $createResult = $em->getRepository( 'VeriatransMainBundle:Client' )->create($post);

        print(json_encode(array('success'=>(boolean)$createResult, 'id'=>$createResult, 'message'=>'')));
        exit;
    }

}
