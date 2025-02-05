<?php

declare(strict_types=1);

namespace Pyz\Zed\AntelopeGui\Communication\Form;

use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @method \Pyz\Zed\AntelopeGui\Communication\AntelopeGuiCommunicationFactory getFactory()
 */
class AntelopeCreateForm extends AbstractType
{
    public const string FIELD_NAME = 'name';
    public const string FIELD_LOCATION = 'location';

    public function getBlockPrefix(): string
    {
        return 'antelope';
    }

    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $this->addNameField($builder);
        $this->addLocationField($builder);
    }

    protected function addNameField(FormBuilderInterface $builder): static
    {
        $builder->add(static::FIELD_NAME, TextType::class, [
            'label' => 'Name',
            'constraints' => [
                $this->createNotBlankConstraint(),
            ],
        ]);

        return $this;
    }

    protected function addLocationField(FormBuilderInterface $builder): static
    {
        $builder->add(static::FIELD_LOCATION, ChoiceType::class, [
            'label' => 'Location',
            'placeholder' => 'Select location',
            'choices' => $this->getFactory()->createAntelopeLocationFormDataProvider()->getOptions()[static::FIELD_LOCATION],
            'choice_label' => 'locationName',
            'choice_value' => 'idLocation',
            'required' => true
        ]);

        return $this;
    }

    protected function createNotBlankConstraint(): NotBlank
    {
        return new NotBlank();
    }
}
