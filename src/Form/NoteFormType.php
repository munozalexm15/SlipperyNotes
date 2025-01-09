<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Notes;
use App\Entity\Photos;
use App\Entity\Users;

use Doctrine\DBAL\Types\BooleanType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('content', CKEditorType::class, [
                'config' => [
                    'config_name' => 'sn_editor_config',
                ]]
            )
            ->add('reminderDate', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('color', ColorType::class, [
                'attr' => ['class' => ' color-picker'],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Notes::class,
        ]);
    }
}
