<?php

namespace App\Form;
use App\Entity\Option;
use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('room')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('heat', ChoiceType::class, ['choices'=>$this->getChoices()])
            ->add('options', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class,[
                    'class'=>Option::class,
                    'choice_label'=>'name',
                    'multiple'=>true,
                    'required'=>false
                ])
               ->add('imageFile',Filetype::class,['required'=>false,'label'=>false])
            ->add('city')
            ->add('adresse')
            ->add('postal_code')
            ->add('sold')
            ->add('images',Filetype::class,['required'=>false,'label'=>false,'multiple'=>true,    
                  'mapped' => false
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain'=>'forms'
        ]);
    }
    public function getChoices()
    {
        $choices=Property::HEAT;
        $output=[];
        foreach($choices as $k=>$v){
            $output[$v]=$k;
        }
        return $output;
    }
}
