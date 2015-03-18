<?php
/**
 * User: dorin
 * Date: 3/18/15
 * Time: 10:34 AM
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
use Veriatrans\MainBundle\Entity\ContainerTerminal;
//use Veriatrans\MainBundle\Form\ContainerType;
/**
 * Class ContainerController
 * @package Veriatrans\MainBundle\Controller
 * @Route("/admin")
 */
class ContainerController extends Controller
{
    /**
     * Create new container
     *
     * @Route("/create-container", name="create_container")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function createAction()
    {
        return array();
    }

    /**
     * Retrieve all available containers
     *
     * @Route("/list-containers", name="list_containers")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function listContainersAction(){
        //$containerForm = $this->createForm( new ContainerType() );
        return array(
            'currentMenuItem' => 'container',
        );
    }

    /**
     *
     * @Route("/json-list-containers", name="json_list_containers")
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
        $Containers = $em->getRepository( 'VeriatransMainBundle:ContainerTerminal' )->get($iDisplayStart,$iDisplayLength,$mDataProp_0,$sSortDir_0);
        $AllContainers = $em->getRepository( 'VeriatransMainBundle:ContainerTerminal' )->findAll();

        $Containers = array(
            'iTotalRecords' => count($AllContainers),
            'iTotalDisplayRecords' => count($AllContainers),
            'sEcho' => 0,
            'aaData' => $Containers
        );
        print(json_encode($Containers));
        exit;
    }

    /**
     *
     * @Route("/json-retrieve-container-columns-length", name="json_retrieve_container_columns_length")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function jsonRetrieveColumnsLengthAction(){

        $em = $this->getDoctrine()->getManager();
        $databaseName = $this->container->getParameter( 'database_name' );
        $tableName = $em->getClassMetadata('VeriatransMainBundle:ContainerTerminal')->getTableName();
        $ContainerColumns = $em->getRepository( 'VeriatransMainBundle:ContainerTerminal' )->getColumnsLength($tableName,$databaseName);
        $TempContainerColumn = array();
        foreach($ContainerColumns AS $EachColumn){
            $TempContainerColumn[strtolower($EachColumn['Field'])] = preg_replace('/\D/', '', $EachColumn['Type']);
        }
        $ContainerColumns = $TempContainerColumn;
        unset($TempContainerColumn);

        print(json_encode($ContainerColumns));
        exit;
    }

    /**
     * @Route("/{id}/json-update-container", name="json_update_container")
     * @Method("PUT")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function jsonUpdateAction( Request $request,$id)
    {

        $translator = $this->get( 'translator' );
        $em             = $this->getDoctrine()->getManager();
        $Container          = $em->getRepository( 'VeriatransMainBundle:ContainerTerminal' )->find( $id );
        if ( !$Container ) {
            throw $this->createNotFoundException( $translator->trans( 'Container not found.', array(), 'MainBundle' ) );
        }

        $column = $request->request->get('column');
        $value = $request->request->get('value');
        $isDate = strtolower(substr($column,-4)) == 'date';

        if($isDate){
            $value = strtotime($value);
        }
        $updateResult = $em->getRepository( 'VeriatransMainBundle:ContainerTerminal' )->updateOneCell(array($column=>$value),(integer)$id);

        print(json_encode(array('success'=>$updateResult,'message'=>'')));
        exit;
    }

    /**
     * @Route("/{id}/json-delete-container", name="json_delete_container")
     * @Method("DELETE")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function jsonDeleteAction( Request $request,$id)
    {

        $translator = $this->get( 'translator' );
        $em             = $this->getDoctrine()->getManager();
        $Container          = $em->getRepository( 'VeriatransMainBundle:ContainerTerminal' )->find( $id );
        if ( !$Container ) {
            throw $this->createNotFoundException( $translator->trans( 'Container not found.', array(), 'MainBundle' ) );
        }
        $deleteResult = $em->getRepository( 'VeriatransMainBundle:ContainerTerminal' )->updateOneCell(array('isDeleted'=>true),(integer)$id);

        print(json_encode(array('success'=>$deleteResult,'message'=>'')));
        exit;
    }

    /**
     * @Route("/json-create-container", name="json_create_container")
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

        $createResult = $em->getRepository( 'VeriatransMainBundle:ContainerTerminal' )->create($post);

        print(json_encode(array('success'=>(boolean)$createResult, 'id'=>$createResult, 'message'=>'')));
        exit;
    }

}
