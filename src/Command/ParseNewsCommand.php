<?php

namespace App\Command;

use App\Entity\NewsPost;
use App\Repository\NewsPostRepository;
use App\Service\NewsParser\Gateway\Rbk\Terminal;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ParseNewsCommand extends Command
{
    protected static $defaultName = 'app:parse-news';
    protected static $defaultDescription = '';

    private Terminal $parserTerminal;
    private NewsPostRepository $newsPostRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        Terminal $parserTerminal,
        NewsPostRepository $newsPostRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->parserTerminal = $parserTerminal;
        $this->newsPostRepository = $newsPostRepository;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
        ;
    }

    /**
     * @throws \Throwable
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $latestNewsList = $this->parserTerminal->getLatestNews();

        foreach ($latestNewsList as $latestNewsData) {
            sleep(1);

            $latestNewsContentData = $this->parserTerminal->getNewsPostContent(
                $latestNewsData['remote_url']
            );

            $existingNewsPost = $this->newsPostRepository->findBy([
                'remoteId' => $latestNewsData['remote_id'],
                'gatewayName' => $this->parserTerminal->getTerminalName(),
            ]);

            if ($existingNewsPost) {
                continue;
            }

            $newsPost = new NewsPost(
                $latestNewsContentData['title'],
                null,
                $latestNewsContentData['text'],
                $latestNewsContentData['image'],
                new \DateTimeImmutable($latestNewsContentData['date']),
                $latestNewsData['remote_id'],
                $latestNewsData['remote_url'],
                $this->parserTerminal->getTerminalName()
            );
            $this->entityManager->persist($newsPost);
        }

        $this->entityManager->flush();


        $io = new SymfonyStyle($input, $output);
        $io->success('DONE!');

        return Command::SUCCESS;
    }
}
