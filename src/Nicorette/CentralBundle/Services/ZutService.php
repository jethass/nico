<?php

namespace Nicorette\CentralBundle\Services;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Nicorette\CentralBundle\Entity\Answer;
use Nicorette\CentralBundle\Entity\QuizAnswer;

/**
 * service pour la gestion des bouttons zut
 * @author  Saiid Abdeljabbar<said.abdeljabar@proxym-it.com>
 */
class ZutService
{

    private $em;
    private $container;
    private $answerEntity;

    public function __construct($container)
    {
        $this->em = $container->get('doctrine')->getManager();
        $this->container = $container;
    }

    public function saveUserAnswers($answers, $user, $quiz)
    {
        $quizAnswer = new QuizAnswer();
        $quizAnswer->setData($quiz, $user);
        $this->em->persist($quizAnswer);
        $this->em->flush();
        if ($answers) {
            foreach ($answers as $choice) {
                if (isset($choice['ChoiceId'])) {
                    $choiceEntity = $this->em->getRepository('NicoretteCentralBundle:Choice')->find($choice['ChoiceId']);
                    if ($choiceEntity) {
                        $answer = new Answer();
                        $answer->setQuizAnswer($quizAnswer);
                        $answer->setChoice($choiceEntity);
                        $this->em->persist($answer);
                    }
                }
            }
        }
        try {
            $this->em->flush();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

?>