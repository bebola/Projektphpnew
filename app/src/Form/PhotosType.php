<?php
/**
 * Photos type.
 */

namespace App\Form;

use App\Entity\Galleries;
use App\Entity\Photos;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

/**
 * Class PhotosType.
 */

class PhotosType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @see FormTypeExtensionInterface::buildForm()
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder The form builder
     * @param array                                        $options The options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'file',
            FileType::class,
            [
                'mapped' => false,
                'label' => 'label_upload_photo',
                'required' => true,
                'constraints' => new Image(
                    [
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/gif',
                        ],
                    ]
                ),
            ]
        );
        $builder->add(
            'title',
            TextType::class,
            [
                'label' => 'label_title',
                'required' => true,
                'attr' => ['max_length => 255'],
            ]
        );
        $builder->add(
            'text',
            TextareaType::class,
            [
                'label' => 'label_text',
                'required' => true,
                'attr' => ['max_length => 255'],
            ]
        );
        $builder->add(
            'galleries',
            EntityType::class,
            [
                'class' => Galleries::class,
                'choice_label' => function ($Galleries) {
                    return $Galleries->getTitle();
                },
                'label' => 'label_gallery',
                'placeholder' => 'label_none',
                'required' => true,
            ]
        );
    }
    /**
     * Configures the options for this type.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver The resolver for the options
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Photos::class]);
    }
    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'Photos';
    }

}