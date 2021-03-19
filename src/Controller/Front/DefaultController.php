<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuestionRepository;
use App\Repository\ResponseRepository;

class DefaultController extends AbstractController
{
    /**
     * @Route("/chatBot", name="chatBot_index")
     */
    public function chatBot(QuestionRepository $questionRepository, ResponseRepository $responseRepository): Response
    {
        $questions = $questionRepository->findAll();
        $originalQuestion = null;
        foreach ($questions as $question) {
            
            if($question->getPreviousResponse() == null){
                $originalQuestion = $question->getId();
            }
            if($originalQuestion != null){
            break;
            }
        }

        $responses = $responseRepository->findAll();
        
        return $this->render('front/default/chatBot.html.twig', [
            'questions' => $questions,
            'responses' => $responses,
            'originalQuestion' => $originalQuestion,
        ]);
    }
}
