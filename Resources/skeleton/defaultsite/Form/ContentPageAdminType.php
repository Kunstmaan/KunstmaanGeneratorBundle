<?php

namespace {{ namespace }}\Form;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * The admin type for content pages
 */
class ContentPageAdminType extends AbstractContentPageAdminType
{

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolverInterface $resolver The resolver for the options.
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => '{{ namespace }}\Entity\ContentPage'
        ));
    }

}