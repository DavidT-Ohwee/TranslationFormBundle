<?php

/*
 * This file is part of A2lix projects.
 *
 * (c) David ALLIX
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace A2lix\TranslationFormBundle\Form\Type;

use A2lix\TranslationFormBundle\Form\EventListener\AutoFormListener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AutoFormType extends AbstractType
{
    /** @var autoFormListener */
    private $autoFormListener;

    /**
     * @param AutoFormListener $autoFormListener
     */
    public function __construct(AutoFormListener $autoFormListener)
    {
        $this->autoFormListener = $autoFormListener;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber($this->autoFormListener);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'fields' => [],
            'excluded_fields' => [],
        ]);

        $resolver->setNormalizer('data_class', function (Options $options, $value) {
            if (empty($value)) {
                throw new \RuntimeException(sprintf('Missing "data_class" option of "AutoFormType".'));
            }

            return $value;
        });
    }
}
