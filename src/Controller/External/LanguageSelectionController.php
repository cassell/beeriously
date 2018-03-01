<?php

declare(strict_types=1);

namespace Beeriously\Controller\External;

use Beeriously\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;

class LanguageSelectionController extends AbstractController
{
    /**
     * @Route("/choose-language", name="beeriously_choose_language", methods={"GET"})
     */
    public function chooseLanguage()
    {
        $languages = [];

        $translationFiles = glob(__DIR__.'/../../../translations/*.yml');

        foreach ($translationFiles as $translationFile) {
            $parsed = Yaml::parse(file_get_contents($translationFile))['beeriously']['language'];

            $languages[] = [
                'locale' => preg_split('/\./', basename($translationFile))[1],
                'english' => $parsed['english'],
                'native' => $parsed['native'],
                'flag' => $parsed['flag'],
            ];
        }

        usort($languages, function ($a, $b) {
            return strcmp($a['english'], $b['english']);
        });

        return $this->render('user/external/language.html.twig', [
            'languages' => $languages,
        ]);
    }
}
