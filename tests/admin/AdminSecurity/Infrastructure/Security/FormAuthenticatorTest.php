<?php

declare(strict_types=1);

namespace App\Tests\Admin\AdminSecurity\Infrastructure\Security;

use App\Admin\AdminDashboard\Infrastructure\Controller\DashboardController;
use App\Admin\AdminSecurity\Infrastructure\Controller\SecurityController;
use App\Admin\AdminSecurity\Infrastructure\Security\FormAuthenticator;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Exception\LogicException;
use Symfony\Component\Security\Core\User\InMemoryUserProvider;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;
use Symfony\Component\Security\Http\Authenticator\Token\PostAuthenticationToken;
use PHPUnit\Framework\TestCase;
use Exception;

class FormAuthenticatorTest extends TestCase
{
    public function testSupports(): void
    {
        $attributes = $this->createMock(ParameterBag::class);
        $attributes
            ->method('get')
            ->with('_route')
            ->willReturn(SecurityController::AUTH_ROUTE_NAME);

        $request = $this->createMock(Request::class);
        $request
            ->method('isMethod')
            ->with('POST')
            ->willReturn(true);
        $request->attributes = $attributes;

        self::assertTrue(
            (new FormAuthenticator(
                $this->createMock(UserProviderInterface::class),
                $this->createMock(UserPasswordHasherInterface::class),
                $this->createMock(CsrfTokenManagerInterface::class),
                $this->createMock(UrlGeneratorInterface::class)
            ))->supports($request)
        );
    }

    public function testAuthenticate(): void
    {
        $username = 'admin';
        $password = 'password';

        $requestBag = new InputBag();
        $requestBag->set('csrf_token', 'token');
        $requestBag->set('username', $username);
        $requestBag->set('password', $password);

        $request = $this->createMock(Request::class);
        $request->request = $requestBag;

        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $csrfTokenManager
            ->method('isTokenValid')
            ->willReturn(true);

        /**
         * TODO: On symfony 6 change User to UserInterface
         * TODO: At the moment method getUserIdentifier is not available in UserInterface
         */
        $user = $this->createMock(UserInterface::class);

        /**
         * TODO: On symfony 6 change InMemoryUserProvider to UserProviderInterface
         * TODO: At the moment method loadUserByIdentifier is not available in UserProviderInterface
         */
        $userProvider = $this->createMock(InMemoryUserProvider::class);
        $userProvider
            ->method('loadUserByIdentifier')
            ->with($username)
            ->willReturn($user);

        $passwordHasher = $this->createMock(UserPasswordHasher::class);
        $passwordHasher
            ->method('isPasswordValid')
            ->with($user, $password)
            ->willReturn(true);

        /** @var Passport $passport */
        $passport = (new FormAuthenticator(
            $userProvider,
            $passwordHasher,
            $csrfTokenManager,
            $this->createMock(UrlGeneratorInterface::class)
        ))->authenticate($request);

        /** @var UserBadge $badge */
        $badge = $passport->getBadge(UserBadge::class);

        self::assertEquals($username, $badge->getUserIdentifier());
    }

    public function testWrongAuthenticateCsrfToken(): void
    {
        $request = $this->createMock(Request::class);
        $request->request = new InputBag();

        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $csrfTokenManager
            ->method('isTokenValid')
            ->willReturn(false);

        $this->expectException(InvalidCsrfTokenException::class);

        (new FormAuthenticator(
            $this->createMock(UserProviderInterface::class),
            $this->createMock(UserPasswordHasherInterface::class),
            $csrfTokenManager,
            $this->createMock(UrlGeneratorInterface::class)
        ))->authenticate($request);
    }

    public function testWrongAuthenticateUsername(): void
    {
        $username = 'admin';

        $requestBag = new InputBag();
        $requestBag->set('csrf_token', 'token');
        $requestBag->set('username', $username);

        $request = $this->createMock(Request::class);
        $request->request = $requestBag;

        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $csrfTokenManager
            ->method('isTokenValid')
            ->willReturn(true);

        /**
         * TODO: On symfony 6 change InMemoryUserProvider to UserProviderInterface
         * TODO: At the moment method loadUserByIdentifier is not available in UserProviderInterface
         */
        $userProvider = $this->createMock(InMemoryUserProvider::class);
        $userProvider
            ->method('loadUserByIdentifier')
            ->with($username)
            ->willThrowException(new Exception());

        $this->expectException(CustomUserMessageAuthenticationException::class);

        (new FormAuthenticator(
            $userProvider,
            $this->createMock(UserPasswordHasherInterface::class),
            $csrfTokenManager,
            $this->createMock(UrlGeneratorInterface::class)
        ))->authenticate($request);
    }

    public function testWrongAuthenticatePassword(): void
    {
        $username = 'admin';
        $password = 'passwordwrong';

        $requestBag = new InputBag();
        $requestBag->set('csrf_token', 'token');
        $requestBag->set('username', $username);
        $requestBag->set('password', $password);

        $request = $this->createMock(Request::class);
        $request->request = $requestBag;

        $csrfTokenManager = $this->createMock(CsrfTokenManagerInterface::class);
        $csrfTokenManager
            ->method('isTokenValid')
            ->willReturn(true);

        $user = $this->createMock(UserInterface::class);

        /**
         * TODO: On symfony 6 change InMemoryUserProvider to UserProviderInterface
         * TODO: At the moment method loadUserByIdentifier is not available in UserProviderInterface
         */
        $userProvider = $this->createMock(InMemoryUserProvider::class);
        $userProvider
            ->method('loadUserByIdentifier')
            ->with($username)
            ->willReturn($user);

        $passwordHasher = $this->createMock(UserPasswordHasher::class);
        $passwordHasher
            ->method('isPasswordValid')
            ->with($user, $password)
            ->willReturn(false);

        $this->expectException(CustomUserMessageAuthenticationException::class);

        (new FormAuthenticator(
            $userProvider,
            $passwordHasher,
            $csrfTokenManager,
            $this->createMock(UrlGeneratorInterface::class)
        ))->authenticate($request);
    }

    public function testOnAuthenticationSuccess(): void
    {
        $targetUrl = '/admin/';

        $urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $urlGenerator
            ->method('generate')
            ->with(DashboardController::DASHBOARD_ROUTE_NAME)
            ->willReturn($targetUrl);

        /** @var RedirectResponse $response */
        $response = (new FormAuthenticator(
            $this->createMock(UserProviderInterface::class),
            $this->createMock(UserPasswordHasherInterface::class),
            $this->createMock(CsrfTokenManagerInterface::class),
            $urlGenerator
        ))->onAuthenticationSuccess(
            $this->createMock(Request::class),
            $this->createMock(TokenInterface::class),
            'admin'
        );

        self::assertEquals($targetUrl, $response->getTargetUrl());
    }

    public function testOnAuthenticationFailure(): void
    {
        $targetUrl = '/admin/auth';

        $urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $urlGenerator
            ->method('generate')
            ->with(SecurityController::AUTH_ROUTE_NAME)
            ->willReturn($targetUrl);

        /** @var RedirectResponse $response */
        $response = (new FormAuthenticator(
            $this->createMock(UserProviderInterface::class),
            $this->createMock(UserPasswordHasherInterface::class),
            $this->createMock(CsrfTokenManagerInterface::class),
            $urlGenerator
        ))->onAuthenticationFailure(
            $this->createMock(Request::class),
            $this->createMock(AuthenticationException::class)
        );

        self::assertEquals($targetUrl, $response->getTargetUrl());
    }

    public function testStart(): void
    {
        $targetUrl = '/admin/auth';

        $urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $urlGenerator
            ->method('generate')
            ->with(SecurityController::AUTH_ROUTE_NAME)
            ->willReturn($targetUrl);

        /** @var RedirectResponse $response */
        $response = (new FormAuthenticator(
            $this->createMock(UserProviderInterface::class),
            $this->createMock(UserPasswordHasherInterface::class),
            $this->createMock(CsrfTokenManagerInterface::class),
            $urlGenerator
        ))->start(
            $this->createMock(Request::class)
        );

        self::assertEquals($targetUrl, $response->getTargetUrl());
    }

    public function testCreateAuthenticatedToken(): void
    {
        $userIdentifier = 'admin';
        $userRoles = ['ROLE_ADMIN'];

        /**
         * TODO: On symfony 6 change User to UserInterface
         * TODO: At the moment method getUserIdentifier is not available in UserInterface
         */
        $user = $this->createMock(User::class);
        $user
            ->method('getUserIdentifier')
            ->willReturn($userIdentifier);
        $user
            ->method('getRoles')
            ->willReturn($userRoles);

        $passport = $this->createMock(UserPassportInterface::class);
        $passport
            ->method('getUser')
            ->willReturn($user);

        /** @var PostAuthenticationToken $token */
        $token = (new FormAuthenticator(
            $this->createMock(UserProviderInterface::class),
            $this->createMock(UserPasswordHasherInterface::class),
            $this->createMock(CsrfTokenManagerInterface::class),
            $this->createMock(UrlGeneratorInterface::class)
        ))->createAuthenticatedToken($passport, 'admin');

        self::assertEquals($userIdentifier, $token->getUserIdentifier());
        self::assertEquals($userRoles, $token->getRoleNames());
    }

    public function testWrongPassport(): void
    {
        $passport = $this->createMock(PassportInterface::class);

        $this->expectException(LogicException::class);

        (new FormAuthenticator(
            $this->createMock(UserProviderInterface::class),
            $this->createMock(UserPasswordHasherInterface::class),
            $this->createMock(CsrfTokenManagerInterface::class),
            $this->createMock(UrlGeneratorInterface::class)
        ))->createAuthenticatedToken($passport, 'admin');
    }
}
