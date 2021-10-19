<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\CurlHttpClient;
use App\Entity\PrintScreen;
use App\Service\FileUploader;

class PrintScreenCommand extends Command
{
    protected static $defaultName = 'PrintScreen';
    protected static $defaultDescription = 'Printscreen Page.';
    private $httpClient;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->httpClient = new CurlHttpClient;
        $this->em = $em;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('url', InputArgument::REQUIRED, 'Url')
            ->addOption('file_type', 'PNG', InputOption::VALUE_OPTIONAL, 'File Type for the file, The Options include: "JPG", "PNG", "WebP", and "PDF". DEFAULT is PNG')
            ->addOption('fail_on_error', false, InputOption::VALUE_OPTIONAL, 'If fail on error is set to true then the API will return an error if the render encounters a 4xx or 5xx status code. DEFAULT is false')
            ->addOption('scroll_to_element', '', InputOption::VALUE_OPTIONAL, 'Target a specific element for the browser to scroll to before the render. This is useful if a given element is only loaded in the viewport. Default is ""')
            ->addOption('selector', '', InputOption::VALUE_OPTIONAL, 'Specify the target for the render based on a element with a matching selector. If the element is not found, a render of the results is still returned. Example: div > .main-navigation > .logo. Default is ""')
            ->addOption('full_page', false, InputOption::VALUE_OPTIONAL, 'Capture the full page of a website vs. the scrollable area that is visible in the viewport upon render. Default is false')
            ->addOption('lazy_load', false, InputOption::VALUE_OPTIONAL, 'If lazy load is set to true, the browser will cross down the entire page to ensure all content is loaded in the render. Default is false')
            ->addOption('width', 1680, InputOption::VALUE_OPTIONAL, 'Viewport width in pixels of the browser render. Default is 1680')
            ->addOption('height', 867, InputOption::VALUE_OPTIONAL, 'Viewport height in pixels of the browser render. Default is 867')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $errors = [];

        $io = new SymfonyStyle($input, $output);
        $url = $input->getArgument('url');
        $file_type = $input->getOption('file_type');
        $fail_on_error = $input->getOption('fail_on_error');
        $scroll_to_element = $input->getOption('scroll_to_element');
        $selector = $input->getOption('selector');
        $full_page = $input->getOption('full_page');
        $lazy_load = $input->getOption('lazy_load');
        $width = $input->getOption('width');
        $height = $input->getOption('height');
        
        //Valid URL
        if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
            $errors += ['url'=> $url];
        }

        
        //Save DB;
        $printScreen = new PrintScreen();
        $printScreen->setUrl($url);
        $printScreen->setFileType($file_type? $file_type : 'PNG');
        $printScreen->setFailOnError($fail_on_error? filter_var($fail_on_error, FILTER_VALIDATE_BOOLEAN) : false);
        $printScreen->setScrollToElement($scroll_to_element? $scroll_to_element : '');
        $printScreen->setSelector($selector? $selector : '');
        $printScreen->setFullPage($full_page? filter_var($full_page, FILTER_VALIDATE_BOOLEAN) : 'false');
        $printScreen->setLazyLoad($lazy_load? filter_var($lazy_load, FILTER_VALIDATE_BOOLEAN) : 'false');
        $printScreen->setWidth($width? $width : '1680');
        $printScreen->setHeight($height? $height : '867');
        $printScreen->setUrlImage('');
        $printScreen->setCreateDate(new \DateTime());

        if(count($errors) > 0){
            foreach($errors as $key => $error){
                $io->warning(sprintf('Error '. $key .' : %s', $error));
            }

            $printScreen->setStatus(false);
            $this->em->persist($printScreen);
            $this->em->flush();
            return Command::FAILURE;
        }

        $response = $this->httpClient->request('GET', 'https://shot.screenshotapi.net/screenshot', [
            'query' => [
                'token' => getenv('TOKEN_SCREENSHOTAPI'),
                'url' => $url,
                'file_type' => strtolower($file_type? $file_type : 'PNG'),
                'fail_on_error' => $fail_on_error? filter_var($fail_on_error, FILTER_VALIDATE_BOOLEAN) : 'false',
                'scroll_to_element' => $scroll_to_element? $scroll_to_element : '',
                'selector' => $selector? $selector : '',
                'full_page' => $full_page? filter_var($full_page, FILTER_VALIDATE_BOOLEAN) : 'false',
                'lazy_load' => $lazy_load? filter_var($lazy_load, FILTER_VALIDATE_BOOLEAN) : 'false',
                'width' => $width? $width : '1680',
                'height' => $height? $height : '867'
            ],
        ]);
    

        if($response->getStatusCode() != '200'){
            $io->error(sprintf('API returned error: %s', $response->getStatusCode()));
            $printScreen->setStatus(false);
            $this->em->persist($printScreen);
            $this->em->flush();
            return Command::FAILURE;
        }

        //Upload image.
        $path = json_decode($response->getContent())->screenshot;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $file = './public/printscreens/' . uniqid() . '.'.$type;
        $success = file_put_contents($file, $data);

        $printScreen->setUrlImage(str_replace('./public/', '/',$file));

        $io->success(sprintf('URL Screenshot: %s', json_decode($response->getContent())->screenshot));
        $io->success(sprintf('Width: %s', json_decode($response->getContent())->width));
        $io->success(sprintf('Height: %s', json_decode($response->getContent())->height));

        $printScreen->setStatus(true);
        $this->em->persist($printScreen);
        $this->em->flush();

        return Command::SUCCESS;
    }
}
