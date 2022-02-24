<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Command\Create;

use App\Admin\Domain\ValueObject\Email;
use App\Admin\Domain\ValueObject\PlainPassword;
use App\Common\Application\Command\CommandInterface;
use App\Common\Domain\ValueObject\Uuid;

class CreateCommand implements CommandInterface
{
    public readonly Uuid $uuid;
    public readonly Email $email;
    public readonly PlainPassword $password;

    public function __construct(
        string $uuid,
        string $email,
        string $password
    ) {
        $this->uuid = new Uuid($uuid);
        $this->email = new Email($email);
        $this->password = new PlainPassword($password);
    }
}
