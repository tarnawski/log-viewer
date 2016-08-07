<?php

namespace LogViewerBundle\Form\Type;

use LogViewerBundle\Model\LogCriteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LogCriteriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod('GET');
        $builder->add('limit', ChoiceType::class, [
            'choices'  => [
                '5' => '5',
                '10' => '10',
                '25' => '25',
                '50' => '50',
                '100' => '100',
                '250' => '250',
                '500' => '500'
            ],
            'required' => false,
            'placeholder' => 'LIMIT LOGS',
        ]);
        $builder->add('level', ChoiceType::class, [
            'choices'  => [
                'EMERGENCY' => 'EMERGENCY',
                'ALERT' => 'ALERT',
                'CRITICAL' => 'CRITICAL',
                'ERROR' => 'ERROR',
                'WARNING' => 'WARNING',
                'NOTICE' => 'NOTICE',
                'INFO' => 'INFO',
                'DEBUG' => 'DEBUG'
            ],
            'required' => false,
            'placeholder' => 'ALL LEVEL',
        ]);
        $builder->add('date', ChoiceType::class, [
            'choices'  => [
                'LAST 1 HOURS' => '-1 hour',
                'LAST 3 HOURS' => '-3 hour',
                'LAST 6 HOURS' => '-6 hour',
                'LAST 12 HOURS' => '-12 hour',
                'LAST 1 DAYS' => '-1 day',
                'LAST 3 DAYS' => '-3 day',
                'LAST 7 DAYS' => '-7 day',
                'LAST 30 DAYS' => '-30 day',
                'LAST 60 DAYS' => '-60 day',
                'LAST 90 DAYS' => '-90 day',
            ],
            'required' => false,
            'placeholder' => 'ALL DATE',
        ]);
        $builder->get('date')->addModelTransformer(new CallbackTransformer(
            function () {
                return null;
            },
            function ($dateAsString) {
                if(!$dateAsString) return null;
                $date = new \DateTime();
                $date->modify($dateAsString);

                return $date;
            }
        ));

        $builder->add('message', TextType::class, [
            'attr' => [
                'placeholder' => 'SEARCH IN MESSAGES',
            ],
            'required' => false,
        ]);
        $builder->add('save', SubmitType::class, array('label' => 'FILTER'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LogCriteria::class
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}