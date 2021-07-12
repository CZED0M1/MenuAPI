<?php

namespace App\Command;

use DOMXPath;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;

#[AsCommand(
    name: 'app:parse-menu',
    description: 'Add a short description for your command',
)]
class ParseMenuCommand extends Command
{


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

$content = file_get_contents("http://www.tommysrestaurant.cz/menu/");
        $crawler = new Crawler($content);
        $crawler = $crawler->filter('tr');
        foreach ($crawler as $domElement) {

            if ($domElement->childNodes->item(1)->textContent!=null) {
            $io->write($domElement->childNodes->item(0)->textContent);
            $io->write("---");
            $io->writeln($domElement->childNodes->item(1)->textContent);
        }else {
                $io->writeln($domElement->textContent);
            }}
        return Command::SUCCESS;
    }
}
