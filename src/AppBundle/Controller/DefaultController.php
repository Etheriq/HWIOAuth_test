<?php

namespace AppBundle\Controller;

use AppBundle\Form\LoginType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/secure", name="secured_zone")
     * @Template()
     */
    public function securedResourceAction()
    {
        $user = $this->getUser();
        return [
            'user' => $user
        ];
    }

    /**
     * Login
     *
     * @Route("/signin", name="signin")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function signInAction(Request $request)
    {
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContextInterface::AUTHENTICATION_ERROR
            );
        } elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        $form = $this->createForm(new LoginType(), null, ['action' => $this->generateUrl('formLogin_check'), 'attr' => ['novalidate' => 'novalidate']]);

        return array(
            'form' => $form->createView(),
            'error' => $error,
        );
    }

    /**
     * Register
     *
     *
     * @param Request $request
     */
    public function signUpAction(Request $request)
    {

    }
}
