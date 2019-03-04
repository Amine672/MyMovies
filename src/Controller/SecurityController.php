<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;

use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils){
        
        $error = $authenticationUtils->getLastAuthenticationError();
        // $user = new User();
        $lastUsername = $authenticationUtils->getLastUsername();
        $formLogin = $this->get('form.factory')
                    ->createNamedBuilder(null)
                    ->add('_username', TextType::class, ['label' => 'Username'])
                    ->add('_password', PasswordType::class, ['label' => 'Pasword'])
                    ->add('submit', SubmitType::class, ['label' => 'Submit', 'attr' => ['class' => 'btn-primary btn-block']])
                    ->getForm();
        // $formLogin = $this->createForm(LoginType::class, $user);

        return $this->render('security/login.html.twig', [
            'formLogin' =>$formLogin->createView(),
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout(){}
}
