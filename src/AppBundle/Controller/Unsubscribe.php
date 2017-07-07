<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use AppBundle\Entity\Club;

class Unsubscribe extends Controller
{

    /**
     * @Route("/unsubscribe-breakfast")
     * @param Request $request
     */

    public function sendAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $request->request->get('user_name');
        $userR = $em->getRepository('AppBundle:Club')->findOneBy(array('username' => $user));

        if ($userR) {
            if ($userR->getStatuss() == 1) {
                $leave = 0;
                $userR->setStatuss($leave);
                $em->persist($userR);
                $em->flush();
                define('SLACK_WEBHOOK', 'https://hooks.slack.com/services/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');
                $message = array('payload' => json_encode(array('text' => 'Username: ' . $user . '    Status: inactive')));
                $c = curl_init(SLACK_WEBHOOK);
                curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($c, CURLOPT_POST, true);
                curl_setopt($c, CURLOPT_POSTFIELDS, $message);
                curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
                curl_exec($c);
                curl_close($c);
                echo 'Your subscription between ' . $userR->getSdates() . '-' . $userR->getFdates() . ' is inactive now.';
            } else {
                echo 'You have already unsubscribed from Breakfast Club.';
            }
        } else {
            echo 'You are not yet subscribed at Breakfast Club. Run /join-breakfastclub to subscribe. ';
        }

        return $this->render('default/breakfast.html.twig');
    }
}