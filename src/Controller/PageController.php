<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends AbstractController
{
    private $defaultLanguage = 'uk';

    private $languages = [
        'uk' => 'Український',
        'pl' => 'Polski',
        'en' => 'English',
        'de' => 'Deutsch',
        'ru' => 'Русский',
    ];

    /**
     * @Route("/{language}/{page}", name="page_show_language")
     * @Route("/{language}", name="home_language")
     * @Route("/{page}", name="page_show")
     * @Route("/", name="home")
     */
    public function show($language = null, $page = null): Response
    {
        $language = $language ?? $this->defaultLanguage;
        $page = $page ?? 'index';

        $pagesFilePath = __DIR__ . '/../../content/pages.json';
        $pages = $this->loadDataFromJson($pagesFilePath, $language);
        if (!isset($pages[$page])) {
            throw new NotFoundHttpException('Сторінка не знайдена!');
        }

        $pageFilePath = __DIR__ . '/../../content/pages/' . $page . '.json';
        $localizedData = $this->loadDataFromJson($pageFilePath, $language);

        return $this->render(
            $page . ".html.twig",
            [
                'language' => $this->languages[$language],
                'page_title' => $pages[$page],
                'pageData' => $localizedData,
                'menuData' => $pages,
            ]
        );
    }



    private function loadDataFromJson($filePath, $language) {
        if (!file_exists($filePath)) {
            throw new NotFoundHttpException('Файл не знайдено!');
        }

        $jsonData = json_decode(file_get_contents($filePath), true);

        $localizedData = [];
        foreach ($jsonData as $key => $values) {
            $localizedData[$key] = $values[$language] ?? 'Переклад не знайдено';
        }

        return $localizedData;
    }
}