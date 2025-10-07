<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Niveau;
use App\Entity\Player;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom')
            ->add('Prenom')
            ->add('BirthDate')
            ->add('MaCategorie', EntityType::class, [
                'class' => Category::class,
                'choice_label' => function (?Category $cat) {
                    return $cat ? $cat->getNom() : '';
                },
                'choice_value' => function (?Category $cat) {
                    return $cat ? $cat->getNom() : '';
                },
            ])
            ->add('UnNiveau', EntityType::class, [
                'class' => Niveau::class,
                'choice_label' => function (?Niveau $niv) {
                    return $niv ? $niv->getNom() : '';
                },
                'choice_value' => function (?Niveau $niv) {
                    return $niv ? $niv->getNom() : '';
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
