<?php

namespace App\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class MessageListType
{

    public function buildList(FormBuilderInterface $builder) {
        $builder->add('emails', CollectionType::class, [
            // each entry in the array will be an "email" field
            'entry_type' => TextType::class,
            // these options are passed to each "email" type
            'entry_options' => [
                'attr' => ['class' => 'email-box'],
            ],
        ]);
    }
}