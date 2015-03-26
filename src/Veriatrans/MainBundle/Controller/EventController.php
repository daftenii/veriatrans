<?php
/**
 * User: dorin
 * Date: 24.03.2015
 * Time: 16:15
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
//use Veriatrans\MainBundle\Form\ClientType;
/**
 * Class ClientController
 * @package Veriatrans\MainBundle\Controller
 * @Route("/admin")
 */
class EventController extends Controller
{
    private $arrayTableAndRow = array(
        'Driver' => array(
            array(
                'medicalIssueDate'=>'1 MONTH',
                'expiry'=>'2 YEAR',
                'description'=>'%s - data eliberării avizului medical',
                '%s'=>array(
                    'FirstName',
                    'LastName'
                )
            )
        ),
        'Truck' => array(
            array(
                'ITPDate'=>'1 MONTH',
                'description'=>'%s - ITP',
                '%s'=>array(
                    'RegistrationNumber',
                    'Model'
                )
            )
        )
    );

    /**
     * Create new event
     *
     * @Route("/list-events", name="list_events")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function listAction()
    {

        return array(
            'currentMenuItem' => ''
        );
    }

    /**
     *
     * @Route("/json-list-events", name="json_list_events")
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
        $Events = $em->getRepository( 'VeriatransMainBundle:Event' )->get($this->arrayTableAndRow,$iDisplayStart,$iDisplayLength,$mDataProp_0,$sSortDir_0);
        $AllEvents = $em->getRepository( 'VeriatransMainBundle:Event' )->findAll();

        $TempEvents = array();
        $i=0;
        foreach($Events AS $eachEvent){
            $modifiedAt = $eachEvent['ModifiedAt'];
            unset($eachEvent['ModifiedAt']);
            $eachEvent['order'] = $iDisplayStart + (++$i);
            $eachEvent['ExpireDays'] = $eachEvent['ExpireDays'].' '.'zile';
            if($eachEvent['IsViewed']){
                $modifiedAt = -$modifiedAt;
            }
            $TempEvents[$modifiedAt] = $eachEvent;
        }
        $Events = $TempEvents;
        krsort($Events);
        $Events = array_values($Events);

        $Events = array(
            'iTotalRecords' => count($AllEvents),
            'iTotalDisplayRecords' => count($AllEvents),
            'sEcho' => 0,
            'aaData' => $Events
        );
        print(json_encode($Events));
        exit;
    }

    /**
     * @Route("/{id}/json-event-viewed", name="json_event_viewed")
     * @Method("DELETE")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function jsonDeleteAction( Request $request,$id)
    {

        $translator = $this->get( 'translator' );
        $em             = $this->getDoctrine()->getManager();
        $Client          = $em->getRepository( 'VeriatransMainBundle:Event' )->find( $id );
        if ( !$Client ) {
            throw $this->createNotFoundException( $translator->trans( 'Event not found.', array(), 'MainBundle' ) );
        }
        $deleteResult = $em->getRepository( 'VeriatransMainBundle:Event' )->updateOneCell(array('isViewed'=>true),(integer)$id);

        print(json_encode(array('success'=>$deleteResult,'message'=>'')));
        exit;
    }
}
