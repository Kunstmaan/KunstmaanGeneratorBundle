<?php

namespace {{ namespace }}\Form\PageParts;

use {{ namespace }}\Entity\PageParts\{{ pagepart }};
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * {{ pagepart }}AdminType
 */
class {{ pagepart }}AdminType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting form the
     * top most type. Type extensions can further modify the form.
     * @param FormBuilderInterface $builder The form builder
     * @param array $options The options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $names = {{ pagepart }}::$supportedHeaders;
        array_walk($names, function(&$item) { $item = 'Header ' . $item; });

        $builder->add('niv', ChoiceType::class, array(
            'label' => 'pagepart.header.type',
            'choices' => array_combine($names, {{ pagepart }}::$supportedHeaders),
            'required' => true,
        ));
        $builder->add('title', TextType::class, array(
            'label' => 'pagepart.header.title',
            'required' => true
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getBlockPrefix()
    {
        return '{{ pagepart|lower }}type';
    }

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolver $resolver The resolver for the options.
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => '\{{ namespace }}\Entity\PageParts\{{ pagepart }}'
        ));
    }
}
