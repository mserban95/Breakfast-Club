<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ParameterBag;
use AppBundle\Entity\Club;

class Breakfast extends Controller
{

    /**
     * @Route("/join-breakfast")
     * @param Request $request
     */

    public function sendAction(Request $request)
    {
        $today = getdate();
        $club = new Club();
        $em = $this->getDoctrine()->getEntityManager();

        if ($today['weekday'] == 'Monday') {
            $cdate = $today['mday'] . '.' . $today['mon'] . '.' . $today['year'];
            $deleted = $em->getRepository('AppBundle:Club')->findOneBy(array('sdate' => $cdate));
            while ($deleted) {
                $em->remove($deleted);
                $em->flush();
                $deleted = $em->getRepository('AppBundle:Club')->findOneBy(array('sdate' => $cdate));
            }
        }

        $user = $request->request->get('user_name');
        $userR = $em->getRepository('AppBundle:Club')->findOneBy(array('username' => $user));

        if ($today['weekday'] == 'Monday' || $today['weekday'] == 'Tuesday' || $today['weekday'] == 'Wednesday' ||
            $today['weekday'] == 'Thursday' || ($today['weekday'] == 'Friday' && $today['hours'] < 16)
        ) {
            if ($today['weekday'] == 'Monday') {
                $today['mday'] = $today['mday'] + 7;
            }
            if ($today['weekday'] == 'Tuesday') {
                $today['mday'] = $today['mday'] + 6;
            }
            if ($today['weekday'] == 'Wednesday') {
                $today['mday'] = $today['mday'] + 5;
            }
            if ($today['weekday'] == 'Thursday') {
                $today['mday'] = $today['mday'] + 4;
            }
            if ($today['weekday'] == 'Friday') {
                $today['mday'] = $today['mday'] + 3;
            }
            if ($today['mday'] > 30 && ($today['mon'] = 4 || $today['mon'] = 6 || $today['mon'] = 9 ||
                            $today['mon'] = 11)
            ) {
                $today['mday'] = $today['mday'] - 30;
                $today['mon'] = $today['mon'] + 1;
            }
            if ($today['mday'] > 31 && ($today['mon'] = 1 || $today['mon'] = 3 || $today['mon'] = 5 ||
                            $today['mon'] = 7 || $today['mon'] = 8 || $today['mon'] = 10 || $today['mon'] = 12)
            ) {
                $today['mday'] = $today['mday'] - 31;
                $today['mon'] = $today['mon'] + 1;
            }
            if ($today['mday'] > 28 && $today['mon'] = 2) {
                $today['mday'] = $today['mday'] - 28;
                $today['mon'] = $today['mon'] + 1;
            }

            $fday = $today['mday'] + 4;
            $sdate = $today['mday'] . '.' . $today['mon'] . '.' . $today['year'];
            $fdate = $fday . '.' . $today['mon'] . '.' . $today['year'];

            if ($userR) {
                if ($userR->getStatuss() == 0) {
                    $userR->setStatuss(1);
                    $em->persist($userR);
                    $em->flush();

                    define('SLACK_WEBHOOK', 'https://hooks.slack.com/services/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');
                    $message = array('payload' => json_encode(array('text' => 'Username: ' . $user . '    Status: active')));
                    $c = curl_init(SLACK_WEBHOOK);
                    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($c, CURLOPT_POST, true);
                    curl_setopt($c, CURLOPT_POSTFIELDS, $message);
                    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
                    curl_exec($c);
                    curl_close($c);

                    echo 'Your subscription is active again between ' . $userR->getSdates() . ' - ' . $userR->getFdates() . '.';
                } else {
                    echo 'You have already subscribed between ' . $userR->getSdates() . ' - ' . $userR->getFdates() .
                        '. You are welcome to join again from next week.';
                }
            } else {

                $club->setUsernames($user);
                $club->setSdates($sdate);
                $club->setFdates($fdate);
                $club->setStatuss(1);
                $em->persist($club);
                $em->flush();

                define('SLACK_WEBHOOK', 'https://hooks.slack.com/services/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');
                $message = array('payload' => json_encode(array('text' => 'Username: ' . $user . '    Status: active')));
                $c = curl_init(SLACK_WEBHOOK);
                curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($c, CURLOPT_POST, true);
                curl_setopt($c, CURLOPT_POSTFIELDS, $message);
                curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
                curl_exec($c);
                curl_close($c);

                $payload = 'You have successfully joined the Breakfast Club between ' . $sdate . ' - ' . $fdate .
                    '. Please go to Carlos’ desk to pay the corresponding 5€!';
                echo $payload;
            }
        } else {
            if ($today['weekday'] == 'Friday') {
                $today['mday'] = $today['mday'] + 10;
            }
            if ($today['weekday'] == 'Saturday') {
                $today['mday'] = $today['mday'] + 9;
            }
            if ($today['weekday'] == 'Sunday') {
                $today['mday'] = $today['mday'] + 8;
            }
            if ($today['mday'] > 30 && ($today['mon'] = 4 || $today['mon'] = 6 || $today['mon'] = 9 ||
                            $today['mon'] = 11)
            ) {
                $today['mday'] = $today['mday'] - 30;
                $today['mon'] = $today['mon'] + 1;
            }
            if ($today['mday'] > 31 && ($today['mon'] = 1 || $today['mon'] = 3 || $today['mon'] = 5 ||
                            $today['mon'] = 7 || $today['mon'] = 8 || $today['mon'] = 10 || $today['mon'] = 12)
            ) {
                $today['mday'] = $today['mday'] - 31;
                $today['mon'] = $today['mon'] + 1;
            }
            if ($today['mday'] > 28 && $today['mon'] = 2) {
                $today['mday'] = $today['mday'] - 28;
                $today['mon'] = $today['mon'] + 1;
            }

            $fday = $today['mday'] + 4;
            $sdate = $today['mday'] . '.' . $today['mon'] . '.' . $today['year'];
            $fdate = $fday . '.' . $today['mon'] . '.' . $today['year'];

            if ($userR) {
                if ($userR->getStatuss() == 0) {
                    $userR->setStatuss(1);
                    $em->persist($userR);
                    $em->flush();

                    define('SLACK_WEBHOOK', 'https://hooks.slack.com/services/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');
                    $message = array('payload' => json_encode(array('text' => 'Username: ' . $user . '    Status: active')));
                    $c = curl_init(SLACK_WEBHOOK);
                    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($c, CURLOPT_POST, true);
                    curl_setopt($c, CURLOPT_POSTFIELDS, $message);
                    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
                    curl_exec($c);
                    curl_close($c);

                    echo 'Your subscription is active again between ' . $userR->getSdates() . ' - ' . $userR->getFdates() . '.';
                } else {
                    echo 'You have already subscribed between ' . $userR->getSdates() . ' - ' . $userR->getFdates() .
                        '. You are welcome to join again from next week.';
                }

            } else {

                $club->setUsernames($user);
                $club->setSdates($sdate);
                $club->setFdates($fdate);
                $club->setStatuss(1);
                $em->persist($club);
                $em->flush();

                define('SLACK_WEBHOOK', 'https://hooks.slack.com/services/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');
                $message = array('payload' => json_encode(array('text' => 'Username: ' . $user . '    Status: active')));
                $c = curl_init(SLACK_WEBHOOK);
                curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($c, CURLOPT_POST, true);
                curl_setopt($c, CURLOPT_POSTFIELDS, $message);
                curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
                curl_exec($c);
                curl_close($c);

                $payload = 'You have successfully joined the Breakfast Club between ' . $today['mday'] . '.' . $today['mon'] . '.'
                    . $today['year'] . ' - ' . $fday . '.' . $today['mon'] . '.' . $today['year'] .
                    '. Please go to Carlos’ desk to pay the corresponding 5€!';
                echo $payload;
            }
        }

        return $this->render('default/breakfast.html.twig');
    }
}
