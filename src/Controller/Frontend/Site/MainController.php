<?php

namespace App\Controller\Frontend\Site;

use App\Entity\NewsPost;
use App\Repository\NewsPostRepository;
use App\Service\NewsParser\Gateway\Rbk\Terminal;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function array_merge;

class MainController extends BaseController
{
    private NewsPostRepository $newsPostRepository;

    public function __construct(
        NewsPostRepository $newsPostRepository
    ) {
        $this->newsPostRepository = $newsPostRepository;
    }

    /**
     * @Route("/", name="site-main")
     *
     * @throws \Throwable
     */
    public function __invoke(Request $request): Response
    {
        $newsList = $this->newsPostRepository->findAll();

        return $this->render(
            'site/main.html.twig',
            [
                'newsList' => $newsList,
            ]
        );
    }
}
