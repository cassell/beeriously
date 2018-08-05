<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\Language\Controller;

use Beeriously\Infrastructure\Controller\AbstractController;
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

        $translationFiles = glob(__DIR__.'/../../../../translations/messages.*.yml');

        foreach ($translationFiles as $translationFile) {
            $parsed = Yaml::parse(file_get_contents($translationFile));

            $languages[] = [
                'locale' => preg_split('/\./', basename($translationFile))[1],
                'english' => $parsed['beeriously.language.english'],
                'native' => $parsed['beeriously.language.native'],
                'flag' => $parsed['beeriously.language.flag'],
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
