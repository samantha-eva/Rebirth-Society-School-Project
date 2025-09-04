<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class UsersAuthenticator extends AbstractAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function supports(Request $request): ?bool
    {
        return $request->attributes->get('_route') === self::LOGIN_ROUTE
            && $request->isMethod('POST');
    }

    public function authenticate(Request $request): Passport
    {
      
        $email = $request->request->get('_username', '');
        $password = $request->request->get('_password', '');

        if (!$email || !$password) {
            throw new CustomUserMessageAuthenticationException('Email ou mot de passe manquant.');
        }

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($password),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
                new RememberMeBadge(),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $user = $token->getUser();

        // Si l’utilisateur essayait d’accéder à une page protégée avant login
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // Redirection selon rôle
        if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
            return new RedirectResponse($this->urlGenerator->generate('admin'));
        }
        
        return new RedirectResponse($this->urlGenerator->generate('app_home'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData()),
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}
