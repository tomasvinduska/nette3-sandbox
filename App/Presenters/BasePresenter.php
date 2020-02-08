<?php declare(strict_types = 1);

namespace App\Presenters;

use Nette\DI\Container;

/**
 * Base presenter for all application presenters.
 *
 * @property-read \Nette\Bridges\ApplicationLatte\Template $template
 */
abstract class BasePresenter extends \Nette\Application\UI\Presenter
{

    /** @var string $theme */
    private $theme = 'Default';

    public function __construct(Container $container)
    {
        parent::__construct();
        $param = $container->getParameters();
        if (isset($param['THEME']) && $param['THEME'] !== false) {
            $this->theme = $param['THEME'];
        }
    }

    public function startup(): void
    {
        parent::startup();
        $this->template->theme = $this->getTheme();
    }

    public function getTheme(): string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): void
    {
        $this->theme = $theme;
    }

    /**
     * Determines best method for changing location - fix for $.nette.ajax history not working properly with redirect
     *
     * @param mixed $destination
     * @param mixed[] $args
     * @throws \Nette\Application\AbortException
     */
    public function moveTo($destination, array $args = []): void
    {
        if ($this->isAjax()) {
            $this->forward($destination, $args);
        } else {
            $this->redirect($destination, $args);
        }
    }

    /**
     * @param mixed $element
     * @throws \Nette\Application\ForbiddenRequestException
     */
    public function checkRequirements($element): void
    {
        parent::checkRequirements($element);
        $this->getUser()->getStorage()->setNamespace('frontend');
    }

    /**
     * Formats layout template file names.
     *
     * @return string[]
     */
    public function formatLayoutTemplateFiles(): array
    {
        $name = $this->getName();
        $module = preg_replace('#:?[a-zA-Z_0-9]+$#', '', $name);
        $presenter = substr($name, strrpos(':' . $name, ':'));
        $layout = $this->layout ?: 'layout';
        $theme = $this->getTheme();

        $return = [];
        if ($module) {
            $return[] = APP_DIR . "/Themes/$theme/Templates/" . $module . "Module/$presenter/@layout.latte";
            $return[] = APP_DIR . "/Themes/$theme/Templates/" . $module . "Module/@$layout.latte";
        }
        $return[] = APP_DIR . "/Themes/$theme/Templates/$presenter/@layout.latte";
        $return[] = APP_DIR . "/Themes/$theme/Templates/@$layout.latte";
        return $return;
    }

    /**
     * Formats view template file names.
     *
     * @return string[]
     */
    public function formatTemplateFiles(): array
    {
        $name = $this->getName();
        $module = preg_replace('#:?[a-zA-Z_0-9]+$#', '', $name);
        $presenter = substr($name, strrpos(':' . $name, ':'));
        $return = [];
        $return[] = APP_DIR . "/Themes/{$this->getTheme()}/Templates/" . (!empty($module) ? $module . 'Module/' : '') . "$presenter/$this->view.latte";
        return $return;
    }

}
