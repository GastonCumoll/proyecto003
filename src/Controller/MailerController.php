<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerController extends AbstractController
{
    /**
     * @Route("/email")
     */
    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('gas3006@hotmail.com')
            ->to('carrascoalexis_30@outlook.com')
            ->subject('Welcome to the Space Bar!')
            ->text("holaqtal! ❤️")
            ->html("<h1>Nice to meet you ! ❤️</h1>");

        $mailer->send($email);
    return $this->render('mailer/index.html.twig', [
        'controller_name' => 'MailerController',
    ]);
    }
}
