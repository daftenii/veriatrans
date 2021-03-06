<?php
/**
 * User: dorin
 * Date: 3/17/15
 * Time: 7:50 PM
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
use Veriatrans\MainBundle\Entity\Trailer;
//use Veriatrans\MainBundle\Form\TrailerType;
/**
 * Class TrailerController
 * @package Veriatrans\MainBundle\Controller
 * @Route("/admin")
 */
class TrailerController extends Controller
{
    /**
     * Create new trailer
     *
     * @Route("/create-trailer", name="create_trailer")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function createAction()
    {
        return array();
    }

    /**
     * Retrieve all available trailers
     *
     * @Route("/list-trailers", name="list_trailers")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function listTrailersAction(){
        //$trailerForm = $this->createForm( new TrailerType() );
        return array(
            'currentMenuItem' => 'trailer',
        );
    }

    /**
     *
     * @Route("/json-list-trailers", name="json_list_trailers")
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
        $Trailers = $em->getRepository( 'VeriatransMainBundle:Trailer' )->get($iDisplayStart,$iDisplayLength,$mDataProp_0,$sSortDir_0);
        $AllTrailers = $em->getRepository( 'VeriatransMainBundle:Trailer' )->findAll();

        $Trailers = array(
            'iTotalRecords' => count($AllTrailers),
            'iTotalDisplayRecords' => count($AllTrailers),
            'sEcho' => 0,
            'aaData' => $Trailers
        );
        print(json_encode($Trailers));
        exit;
    }

    /**
     *
     * @Route("/json-retrieve-trailer-columns-length", name="json_retrieve_trailer_columns_length")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function jsonRetrieveColumnsLengthAction(){

        $em = $this->getDoctrine()->getManager();
        $databaseName = $this->container->getParameter( 'database_name' );
        $tableName = $em->getClassMetadata('VeriatransMainBundle:Trailer')->getTableName();
        $TrailerColumns = $em->getRepository( 'VeriatransMainBundle:Trailer' )->getColumnsLength($tableName,$databaseName);
        $TempTrailerColumn = array();
        foreach($TrailerColumns AS $EachColumn){
            $TempTrailerColumn[strtolower($EachColumn['Field'])] = preg_replace('/\D/', '', $EachColumn['Type']);
        }
        $TrailerColumns = $TempTrailerColumn;
        unset($TempTrailerColumn);

        print(json_encode($TrailerColumns));
        exit;
    }

    /**
     * @Route("/{id}/json-update-trailer", name="json_update_trailer")
     * @Method("PUT")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function jsonUpdateAction( Request $request,$id)
    {

        $translator = $this->get( 'translator' );
        $em             = $this->getDoctrine()->getManager();
        $Trailer          = $em->getRepository( 'VeriatransMainBundle:Trailer' )->find( $id );
        if ( !$Trailer ) {
            throw $this->createNotFoundException( $translator->trans( 'Trailer not found.', array(), 'MainBundle' ) );
        }

        $column = $request->request->get('column');
        $value = $request->request->get('value');
        $isDate = strtolower(substr($column,-4)) == 'date';

        if($isDate){
            $value = strtotime($value);
        }
        $updateResult = $em->getRepository( 'VeriatransMainBundle:Trailer' )->updateOneCell(array($column=>$value),(integer)$id);

        print(json_encode(array('success'=>$updateResult,'message'=>'')));
        exit;
    }

    /**
     * @Route("/{id}/json-delete-trailer", name="json_delete_trailer")
     * @Method("DELETE")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function jsonDeleteAction( Request $request,$id)
    {

        $translator = $this->get( 'translator' );
        $em             = $this->getDoctrine()->getManager();
        $Trailer          = $em->getRepository( 'VeriatransMainBundle:Trailer' )->find( $id );
        if ( !$Trailer ) {
            throw $this->createNotFoundException( $translator->trans( 'Trailer not found.', array(), 'MainBundle' ) );
        }
        $deleteResult = $em->getRepository( 'VeriatransMainBundle:Trailer' )->updateOneCell(array('isDeleted'=>true),(integer)$id);

        print(json_encode(array('success'=>$deleteResult,'message'=>'')));
        exit;
    }

    /**
     * @Route("/json-create-trailer", name="json_create_trailer")
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

        $createResult = $em->getRepository( 'VeriatransMainBundle:Trailer' )->create($post);

        print(json_encode(array('success'=>(boolean)$createResult, 'id'=>$createResult, 'message'=>'')));
        exit;
    }

}
