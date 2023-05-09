<?php

namespace App\Form;

use App\Entity\Hackathon;
use App\Entity\Inscription;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class InscriptionHackathonType extends AbstractType
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('texteLibre', TextareaType::class)
            ->add('hackathon', EntityType::class, [
            'class' => Hackathon::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('h')
                    ->where('NOT EXISTS(
                        SELECT i.id FROM App\Entity\Inscription i
                        WHERE i.hackathon = h AND i.utilisateur = :userId
                    )')
                    ->setParameter('userId', $this->security->getUser());
            },
            'choice_label' => 'theme',
            'required' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}