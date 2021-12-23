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
    public function sendEmail(\Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message())
            ->setSubject('Asunto')
            ->setFrom(['gas3006@hotmail.com' => 'Tu Usuario'])
            ->setTo(['carrascoalexis_30@outlook.com' => 'Jaime Niñoles'])
            ->setBody(
                'Esto es texto en HTML.',
                'text/html'
             )
             ->addPart(
                'Esto es texto pelado.',
                'text/plain'
         );
         $mailer->send($message);

        return $this->render('mailer/index.html.twig', [
            'controller_name' => 'MailerController',     
        ]); 
    }
}
