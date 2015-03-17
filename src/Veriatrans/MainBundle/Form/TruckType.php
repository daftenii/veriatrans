<?php
//doesn't used
namespace Veriatrans\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityRepository;

class TruckType extends AbstractType
{
    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder
            ->add( 'registrationNumber', 'text', array(
                'label'    => 'RegistrationNumber',
                'required' => true/*,
                'attr'     => array( 'class' => "form-control" )*/
            ) )
            ->add( 'model', 'text', array(
                'label'    => 'Model',
                'required' => true/*,
                'attr'     => array( 'class' => "form-control" )*/
            ) )
            ->add( 'vin', 'text', array(
                'label'    => 'VIN',
                'required' => true/*,
                'attr'     => array( 'class' => "form-control" )*/
            ) )
            ->add( 'createdDate', 'text', array(
                'label'    => 'CreatedDate',
                'required' => true/*,
                'attr'     => array( 'class' => "form-control" )*/
            ) )
            ->add( 'ITPDate', 'text', array(
                'label'    => 'ITPDate',
                'required' => true/*,
                'attr'     => array( 'class' => "form-control" )*/
            ) )
            ->add( 'licenceDate', 'text', array(
                'label'    => 'LicenceDate',
                'required' => true/*,
                'attr'     => array( 'class' => "form-control" )*/
            ) )
            ->add( 'rcaDate', 'text', array(
                'label'    => 'RCADate',
                'required' => true/*,
                'attr'     => array( 'class' => "form-control" )*/
            ) )
            ->add( 'cmrDate', 'text', array(
                'label'    => 'CMRDate',
                'required' => true/*,
                'attr'     => array( 'class' => "form-control" )*/
            ) )
            ->add( 'createdOn', 'text', array(
                'label'    => 'createdOn',
                'required' => true/*,
                'attr'     => array( 'class' => "form-control" )*/
            ) );

        //$builder->addEventSubscriber( new TruckTypeSubscriber( $options ) );
    }

    public function setDefaultOptions( OptionsResolverInterface $resolver )
    {
        $resolver->setDefaults( array(
            'data_class'         => 'Veriatrans\MainBundle\Entity\Truck',
            'isReserve'          => false,
            'translation_domain' => 'TruckBundleForms'
        ) );
    }

    public function getName()
    {
        return 'veriatrans_mainbundle_truck';
    }
}
