<?php

namespace DG\TicketingBundle\Form;

use DG\TicketingBundle\Repository\TicketRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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

        // SI il est plus de 14h, le jour en cour est désactivé
        if(date("H")>=14){
          $aujourdhui = date("d-m-Y");
          $disabledDate = $disabledDate.$aujourdhui;
        }


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
      ->add('durationBooking', ChoiceType::class, array(
          'label' => 'Votre visite va durée :',
          'required' => true,
          'choices'  => array(
              'Une Journée' => 1,
              'Une Demi-Journée' => 0.5
          ),
      ))

      /*
       * Rappel :
       ** - 1er argument : nom du champ, ici « tickets », car c'est le nom de l'attribut
       ** - 2e argument : type du champ, ici « CollectionType » qui est une liste de quelque chose
       ** - 3e argument : tableau d'options du champ
       */
      ->add('tickets', CollectionType::class, array(
        'entry_type'   => TicketType::class,
        'allow_add'    => true,
        'allow_delete' => true,
        'by_reference' => false
      ))
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
