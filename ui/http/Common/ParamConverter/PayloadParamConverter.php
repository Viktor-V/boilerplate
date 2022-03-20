<?php

declare(strict_types=1);

namespace UI\Http\Common\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use UI\Http\Common\Payload\PayloadInterface;
use ReflectionClass;

class PayloadParamConverter implements ParamConverterInterface
{
    public const NAME = 'payload';

    public function apply(Request $request, ParamConverter $configuration)
    {
        $payloadClass = $configuration->getClass();
        /** @var PayloadInterface $payload */
        $payload = new $payloadClass();

        if ($request->isMethod(Request::METHOD_GET)) {
            $payload->fromArray($request->query->all());
        } else {
            $payload->fromArray(array_merge($request->request->all(), $request->files->all()));
        }

        $request->attributes->set(self::NAME, $payload);

        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        $payloadClass = $configuration->getClass();
        if (!$payloadClass) {
            return false;
        }

        $reflection = new ReflectionClass($payloadClass);

        return $configuration->getName() === self::NAME && $reflection->implementsInterface(PayloadInterface::class);
    }
}
