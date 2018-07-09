<?php
/*
 * This file is part of the Harmony package.
 *
 * (c) Tim Goudriaan <tim@harmony-project.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Harmony\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Controller handling the user security actions
 *
 * @author Tim Goudriaan <tim@harmony-project.io>
 */
class SecurityController extends AbstractController
{
    /**
     * @var AuthenticationUtils
     */
    private $helper;

    /**
     * @var CsrfTokenManagerInterface
     */
    private $tokenManager;

    public function __construct(AuthenticationUtils $helper, CsrfTokenManagerInterface $tokenManager = null)
    {
        $this->helper = $helper;
        $this->tokenManager = $tokenManager;
    }

    /**
     * Action that renders the user authentication form
     */
    public function loginAction(): Response
    {
        $csrfToken = $this->tokenManager
            ? $this->tokenManager->getToken('authenticate')->getValue()
            : null;

        return $this->render('@HarmonyUser/security/login.html.twig', [
            'csrf_token' => $csrfToken,
            'error' => $this->helper->getLastAuthenticationError(),
            'last_username' => $this->helper->getLastUsername(),
        ]);
    }

    /**
     * Action that is directed to handle user log outs
     *
     * Logging out is captured by the Symfony SecurityBundle, therefore this
     * code should actually never be reached.
     */
    public function logoutAction(): void
    {
        throw new \Exception('This should never be reached!');
    }
}
