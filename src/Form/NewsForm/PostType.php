<?php
namespace App\Form\NewsForm;

use App\Entity\NewsEntity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * undocumented class
 */
class PostType extends AbstractType
{
     public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder->add('title');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults([
            'data_class'    => Post::class,
        ]);
    }
    
}


