<?php

namespace App\Command;

use App\Service\UrlService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearUrlCommand extends Command
{
    protected static $defaultName = 'app:clear-url';

    protected $urlService;

    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->urlService->removeUrlByExpirationDate();
        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
