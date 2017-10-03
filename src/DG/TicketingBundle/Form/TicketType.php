<?php

namespace DG\TicketingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder        
        // ->add('visitDay')
        ->add('nameTicket', TextType::class, array('label' => 'Nom','required' => true))
        ->add('firstnameTicket', TextType::class, array('label' => 'Prénom','required' => true))
        ->add('brithDate',  DateType::class, array(
                                'label' => 'Date de naissance',
                                'widget' => 'single_text',
                                'html5' => false,
                                'format' => "dd/MM/yyyy",
                                'model_timezone' => 'Europe/Paris',
                                'attr' => [
                                  'class' => 'js-datepicker',
                                  'data-provide' => 'datepicker',
                                  'data-date-language' => 'fr'
                                ],
                                'required' => true,

                                
                            ))
        // ->add('ticketType')
        // ->add('booking')
        ->add('reducedPrice', CheckboxType::class, array('label' => 'Tarif réduit (étudiant, employé du musée, d’un service du Ministère de la Culture, militaire…)','required' => false))
        ->add('Ajouter un autre ticket',      SubmitType::class)
        ->add('Valider',      SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DG\TicketingBundle\Entity\Ticket'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dg_ticketingbundle_ticket';
    }


}
