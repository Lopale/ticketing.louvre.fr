<?php

namespace DG\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BookingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */


    private function getDisabledDateForDaysOff()
    {

        $disabledDateCurrentYear = '';
        $disabledDateNextYear = '';
        $currentYear = date('Y');
        $nextYear = date('Y')+1;
        $daysOff = ['01-01-', '17-04-', '01-05-', '08-05-', '25-05-', '05-06-', '14-07-', '15-08-', '01-11-', '11-11-'];
        foreach ($daysOff as $dayOff){
            $disabledDateCurrentYear = $disabledDateCurrentYear.$dayOff.$currentYear.', ';
            $disabledDateNextYear = $disabledDateNextYear.$dayOff.$nextYear.', ';
        }
        $disabledDate = $disabledDateCurrentYear.'25-12-'.$currentYear.', '.$disabledDateNextYear.'25-12-'.$nextYear;
        
        //$disabledDate ='25-12-2017,25-12-2018';

        return $disabledDate;
    }



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('visiteDay',   DateType::class, array(
                                'label' => 'Date de la visite',
                                'widget' => 'single_text',
                                'html5' => false,
                                'format' => "dd/MM/yyyy",
                                'model_timezone' => 'Europe/Paris',
                                'attr' => [
                                  'class' => 'js-datepicker',
                                  'data-date-start-date' => "0d",
                                  'data-date-end-date' => '+364d',
                                  'data-provide' => 'datepicker',
                                  'data-date-language' => 'fr',
                                  'data-date-start-date' => "0d",
                                  'data-date-end-date' => '+364d',
                                  'data-date-dates-disabled' => $this->getDisabledDateForDaysOff()
                                ],
                                'required' => true,

                                
                            ))
      ->add('email',     EmailType::class, array('label' => 'Adresse email à laquelle seront envoyé les billets','required' => true))
      ->add('Valider',      SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DG\TicketingBundle\Entity\Booking'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dg_ticketingbundle_booking';
    }


}
