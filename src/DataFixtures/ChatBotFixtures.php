<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Entity\Response;
use Doctrine\Persistence\ObjectManager;

class ChatBotFixtures extends BaseFixtures
{
    public function loadData(ObjectManager $manager)
    {
        $question = new Question();
        $question->setMessage("Que souhaitez vous faire?");
        
        $question1 = new Question();
        $question1->setMessage("Sélectionnez parmi ces choix dans quel but souhaitez-vous vous former ?");

        $question2 = new Question();
        $question2->setMessage("Sélectionnez parmi ces choix votre souhaite d'évolution");

        $response = new Response();
        $response->setMessage("Me former");
        $response->setPreviousQuestion($question);
        $response->setNextQuestion($question1);
        $manager->persist($response);

        $response1 = new Response();
        $response1->setMessage("Faire évoluer ma situation professionnelle actuelle");
        $response1->setPreviousQuestion($question);
        $response1->setNextQuestion($question2);
        $manager->persist($response1);

        $question1->setPreviousResponse($response);
        $question2->setPreviousResponse($response1);

        $response2 = new Response();
        $response2->setMessage("Pour acquérir des compétences en lien avec mon poste de travail actuel");
        $response2->setPreviousQuestion($question1);
        $response2->setLink("https://www.google.com");
        $manager->persist($response2);

        $response3 = new Response();
        $response3->setMessage("Pour me réorienter professionnellement");
        $response3->setPreviousQuestion($question1);
        $response3->setLink("https://www.google.com");
        $manager->persist($response3);

        $response4 = new Response();
        $response4->setMessage("Changer de métier");
        $response4->setPreviousQuestion($question2);
        $response4->setLink("https://www.google.com");
        $manager->persist($response4);

        $response5 = new Response();
        $response5->setMessage("Changer de grade ou de corps");
        $response5->setPreviousQuestion($question2);
        $response5->setLink("https://www.google.com");
        $manager->persist($response5);

        $manager->persist($question);
        $manager->persist($question1);
        $manager->persist($question2);
        
        $manager->flush();
    }
}