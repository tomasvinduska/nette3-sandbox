<?php declare(strict_types = 1);

namespace App\Components;

use Nette\Application\UI\Control;

class AbstractControl extends Control
{

    public function getTemplateMainPath(?string $file, ?string $theme = null): string
    {
        if ($theme === null) {
            /** @var \App\Presenters\BasePresenter $presenter */
            $presenter = $this->getPresenter();
            $theme = $presenter->getTheme();
        }
        $path = [];
        $path[] = 'Themes';
        $path[] = $theme;
        $path[] = 'Templates';
        $path[] = 'Components';
        if (empty($file)) {
            $file = $this->getName() . '.latte';
        }
        $path = implode('/', $path);
        return APP_DIR . "/$path/$file";
    }

}
