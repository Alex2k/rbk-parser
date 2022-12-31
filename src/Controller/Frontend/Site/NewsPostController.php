<?php

namespace App\Controller\Frontend\Site;

use App\Repository\NewsPostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsPostController extends BaseController
{
    private NewsPostRepository $newsPostRepository;

    public function __construct(
        NewsPostRepository $newsPostRepository
    ) {
        $this->newsPostRepository = $newsPostRepository;
    }

    /**
     * @Route("/news/{id}", name="site-news-post")
     *
     * @throws \Throwable
     */
    public function __invoke(Request $request, int $id): Response
    {
        $newsPost = $this->newsPostRepository->find($id);

        return $this->render(
            'site/news_post.html.twig',
            [
                'newsPost' => $newsPost,
            ]
        );
    }
}
