<?php

declare(strict_types=1);

namespace App\AdminSecurity\Infrastructure\Security;

use App\AdminDashboard\AdminDashboardRouteName;
use App\AdminSecurity\AdminSecurityRouteName;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Exception\LogicException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Authenticator\InteractiveAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;
use Symfony\Component\Security\Http\Authenticator\Token\PostAuthenticationToken;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Throwable;

class FormAuthenticator implements AuthenticationEntryPointInterface, InteractiveAuthenticatorInterface
{
    public function __construct(
        private UserProviderInterface $userProvider,
        private UserPasswordHasherInterface $passwordHasher,
        private CsrfTokenManagerInterface $csrfTokenManager,
        private UrlGeneratorInterface $urlGenerator
    ) {
    }

    public function supports(Request $request): ?bool
    {
        return AdminSecurityRouteName::AUTH === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function authenticate(Request $request): PassportInterface
    {
        $token = new CsrfToken('authenticate', (string) $request->request->get('csrf_token'));
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        $username = (string) $request->request->get('username');

        try {
            /** @var PasswordAuthenticatedUserInterface $user */
            $user = $this->userProvider->loadUserByIdentifier($username);
        } catch (Throwable) {
            throw new CustomUserMessageAuthenticationException(_('Invalid credentials.'));
        }

        $isPasswordValid = $this->passwordHasher->isPasswordValid($user, (string) $request->request->get('password'));
        if (!$isPasswordValid) {
            throw new CustomUserMessageAuthenticationException(_('Invalid credentials.'));
        }

        return new SelfValidatingPassport(new UserBadge((string) $request->request->get('username')));
    }

    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        string $firewallName
    ): ?Response {
        return new RedirectResponse($this->urlGenerator->generate(AdminDashboardRouteName::DASHBOARD));
    }

    public function onAuthenticationFailure(
        Request $request,
        AuthenticationException $exception
    ): ?Response {
        if ($request->hasSession()) {
            $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        }

        return new RedirectResponse($this->urlGenerator->generate(AdminSecurityRouteName::AUTH));
    }

    /**
     * Override to control what happens when the user hits a secure page
     * but isn't logged in yet.
     */
    public function start(
        Request $request,
        AuthenticationException $authException = null
    ) {
        return new RedirectResponse($this->urlGenerator->generate(AdminSecurityRouteName::AUTH));
    }

    public function isInteractive(): bool
    {
        return true;
    }

    public function createAuthenticatedToken(
        PassportInterface $passport,
        string $firewallName
    ): TokenInterface {
        if (!$passport instanceof UserPassportInterface) {
            throw new LogicException(sprintf(
                'Passport does not contain a user, overwrite "createAuthenticatedToken()" in "%s"'
                . 'to create a custom authenticated token.',
                static::class
            ));
        }

        return new PostAuthenticationToken($passport->getUser(), $firewallName, $passport->getUser()->getRoles());
    }
}
