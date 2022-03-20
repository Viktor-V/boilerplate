<?php

declare(strict_types=1);

namespace UI\Http\Common\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use UI\Http\Common\Payload\FormPayloadInterface;
use InvalidArgumentException;
use ReflectionClass;

class FormParamConverter implements ParamConverterInterface
{
    public const NAME = 'form';

    public function __construct(
        private FormFactoryInterface $formFactory
    ) {
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        /** @var FormPayloadInterface $payload */
        $payload = $request->attributes->get(PayloadParamConverter::NAME);
        if (!$payload instanceof FormPayloadInterface) {
            throw new InvalidArgumentException();
        }

        $form = $this->formFactory->create($payload::PAYLOAD_FORM, $payload);
        $request->attributes->set(self::NAME, $form);

        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        $payloadClass = $configuration->getClass();
        if (!$payloadClass) {
            return false;
        }

        $reflection = new ReflectionClass($payloadClass);

        return $configuration->getName() === self::NAME && $reflection->implementsInterface(FormInterface::class);
    }
}
