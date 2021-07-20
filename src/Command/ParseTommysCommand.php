<?php


namespace App\Command;

use App\Entity\Meal;
use App\Entity\MealOnMenu;
use App\Entity\Menu;
use App\Entity\Restaurant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;


#[AsCommand(
    name: 'app:parse-tommys',
    description: 'Add a short description for your command'
)]
class ParseTommysCommand extends Command
{

    private EntityManagerInterface $em;

    /**
     * ParseTommysCommand constructor.
     */

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $content = file_get_contents("http://www.tommysrestaurant.cz/menu/");
        $crawler = new Crawler($content);
        $crawler = $crawler->filter('tr');

        $restRepo = $this->em->getRepository(Restaurant::class);
        /** @var Restaurant $restaurant */
        $restaurant = $restRepo->find(1);

        $menu = null;
        $weekMeal = array();
        foreach ($crawler as $domElement) {
            $priceColumn = $domElement->childNodes->item(1)->textContent;
            $mealColumn = $domElement->childNodes->item(0)->textContent;
            //Pokud je druhý sloupec prázdný tak
            if ($priceColumn !== "") {

                //Pokud je menu prázdné tak je to týdenní
                if ($menu !== null) {
                    $this->createMeal((int)$priceColumn, $mealColumn, $restaurant, $io, $menu);
                } else {
                    $weekMeal[] = [
                        'meal' => $mealColumn,
                        'price' => $priceColumn
                    ];
                    $io->writeln("creating new week meal $mealColumn");
                }
            } else {
                try {
                    $date = $this->findDay($mealColumn);
                    $menu = $this->createMenu($date, $restaurant, $io);
                    foreach ($weekMeal as $value) {
                        $this->createMeal((int)$value['price'], $value['meal'], $restaurant, $io, $menu);

                    }
                } catch (\Exception) {
                    continue;
                }
            }
        }
        $this->em->flush();
        return Command::SUCCESS;
    }

    public function findDay(string $day): \DateTime
    {
        return match ($day) {
            "Pondělí" => new \DateTime("Monday this week"),
            "Úterý" => new \DateTime("Tuesday this week"),
            "Středa" => new \DateTime("Wednesday this week"),
            "Čtvrtek" => new \DateTime("Thursday this week"),
            "Pátek" => new \DateTime("Friday this week"),
            default => throw new \Exception("Unknown day $day")
        };
    }

    public function createMeal(string $priceColumn, string $mealColumn, Restaurant $restaurant, $io, $menu)
    {
        $price = (int)$priceColumn;
        $mealRep = $this->em->getRepository(Meal::class);
        $mealObj = $mealRep->findOneBy(array('name' => $mealColumn));
        if ($mealObj === null) {
            $mealObj = new Meal($restaurant, $mealColumn);
            $io->writeln("creating new meal $mealColumn");
        } else {
            $io->writeln("found meal in database $mealColumn");
        }
        $mealOnMenu = new MealOnMenu($menu, $mealObj, $price);
        $this->em->persist($mealOnMenu);
    }

    public function createMenu($date, $restaurant, $io): Menu
    {

        $menuRep = $this->em->getRepository(Menu::class);
        $oldMenu = $menuRep->findOneBy(['date' => $date, 'restaurant' => $restaurant]);
        if ($oldMenu !== null) {
            $this->em->remove($oldMenu);
            $this->em->flush();
            $io->writeln("removed old menu");
        }
        $io->writeln("Creating new menu");
        $menu = new Menu($restaurant, $date);
        $this->em->persist($menu);
        return $menu;

    }



}
