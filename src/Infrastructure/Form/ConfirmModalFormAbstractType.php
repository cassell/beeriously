<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;

abstract class ConfirmModalFormAbstractType extends AbstractType implements DataMapperInterface
{
    abstract public function getMessage(): string;

    abstract protected function getMessageData($object): array;

    abstract public function getTitle(): string;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('message', ConfirmModalMessageFormType::class, [
            'confirm_message_title' => $this->getTitle(),
        ]);
        $builder->setDataMapper($this);
    }

    public function mapDataToForms($data, $forms)
    {
        $forms = iterator_to_array($forms);
        $forms['message']->setData([
            'message' => $this->getMessage(),
            'data' => $this->getMessageData($data),
            'submitButtonClass' => $this->getSubmitButtonClass(),
            'submitButtonText' => $this->getSubmitButtonText(),
            'cancelButtonText' => $this->getCancelButtonText(),
            'title' => $this->getTitle(),
        ]);
    }

    public function mapFormsToData($forms, &$data)
    {
        return $data;
    }

    public function getSubmitButtonClass(): string
    {
        return 'btn btn-danger';
    }

    public function getSubmitButtonText(): string
    {
        return 'beeriously.global.submit';
    }

    private function getCancelButtonText()
    {
        return 'beeriously.global.cancel';
    }
}
