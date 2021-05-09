<?php

declare(strict_types=1);

namespace App\Tests\Contact\Infrastructure\Form;

use App\Contact\Infrastructure\Form\ContactForm;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\FormExtensionInterface;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class ContactFormTest extends TypeTestCase
{
    public function testSubmitData(): void
    {
        $form = $this->factory->create(ContactForm::class);

        foreach (array_keys($form->createView()->children) as $key) {
            self::assertContains($key, ['name', 'email', 'subject', 'message', 'recaptcha']);
        }
    }

    /**
     * @return array<FormExtensionInterface>
     */
    protected function getExtensions(): array
    {
        return [
            new ValidatorExtension(Validation::createValidator())
        ];
    }
}
