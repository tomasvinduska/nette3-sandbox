<?php declare(strict_types = 1);

use Nette\Application\UI\Form;
use Nette\ComponentModel\IContainer;
use Nette\Forms\Controls\Button;
use Nette\Forms\Controls\Checkbox;
use Nette\Forms\Controls\CheckboxList;
use Nette\Forms\Controls\MultiSelectBox;
use Nette\Forms\Controls\RadioList;
use Nette\Forms\Controls\SelectBox;
use Nette\Forms\Controls\TextBase;
use Nette\Forms\Controls\UploadControl;
use Nette\Forms\IControl;
use Nette\Forms\IFormRenderer;
use Nette\Localization\ITranslator;

class AbstractForm extends Form
{

    /** @var callable[] */
    public $onSave = [];

    /** @var callable[] */
    public $onCancel = [];

    /**
     * @var bool
     */
    protected $ajax = false;

    /**
     * @var bool
     */
    protected $addButtonClasses = true;

    /**
     * @var bool
     */
    protected $addControlClasses = true;

    /** @var bool */
    private $usedPrimary = false;

    /** @var bool */
    private $inline = false;

    public function __construct(ITranslator $translator, ?IContainer $parent = null, ?string $name = null)
    {
        parent::__construct($parent, $name);
        $this->addProtection("Your session has expired. Please return to the home page and try again.");
        if (!empty($translator)) {
            $this->setTranslator($translator);
        }
        $this->onSuccess[] = function (Form $form, $values): void {
            if ($form->isSubmitted()) {
                if ($form->isSubmitted()->name === "save") {
                    $this->onSave($form, $values);
                }
                if ($form->isSubmitted()->name === "cancel") {
                    $this->onCancel($form, $values);
                }
            }
        };
    }

    public function getRenderer(): IFormRenderer
    {
        /** @var \Nette\Forms\IFormRenderer|\Nette\Forms\Rendering\DefaultFormRenderer $renderer */
        $renderer = parent::getRenderer();
        // setup form rendering
        $renderer->wrappers['controls']['container'] = null;
        $renderer->wrappers['pair']['container'] = 'div class="form-group row"';
        $renderer->wrappers['pair']['.error'] = 'has-danger';
        $renderer->wrappers['control']['container'] = 'div class=col-sm-9';
        $renderer->wrappers['label']['container'] = 'div class="col-sm-3 col-form-label"';
        $renderer->wrappers['control']['description'] = 'span class=form-text';
        $renderer->wrappers['control']['errorcontainer'] = 'span class=form-control-feedback';

        foreach ($this->getControls() as $control) {
            $this->setControlClass($control);
        }
        return $renderer;
    }

    //    public function getControls(): \Iterator
    //    {
    //
    //        $controls = parent::getControls();
    //        foreach ($controls as $control) {
    ////            $this->setControlClass($control);
    //        }
    //        return $controls;
    //    }

    private function setControlClass($control): void
    {
        /** @var \Nette\Forms\IControl $control */
        if (!($control instanceof IControl)) {
            return;
        }
        if ($this->addButtonClasses && $control instanceof Button) {
            $class = 'btn btn-secondary';
            if (!$this->usedPrimary) {
                $class = 'btn btn-primary';
            }
            $control->getControlPrototype()->addClass($class);
            $this->usedPrimary = true;
        } elseif ($this->addControlClasses && ($control instanceof TextBase || $control instanceof SelectBox || $control instanceof MultiSelectBox)) {
            $control->getControlPrototype()->addClass('form-control');
        } elseif ($this->addControlClasses && ($control instanceof Checkbox || $control instanceof CheckboxList || $control instanceof RadioList)) {
            $control->getLabelPrototype()->addClass('form-check-label');
            $control->getControlPrototype()->addClass('form-check-input');
            $control->getSeparatorPrototype()->setName('div')->addClass('form-check');
        } elseif ($this->addControlClasses && ($control instanceof UploadControl)) {
            $control->getControlPrototype()->addClass('form-control-file');
        }
    }

    public function getElementPrototype(): \Nette\Utils\Html
    {
        $prototype = parent::getElementPrototype();
        if ($this->isInline()) {
            $prototype->class('form-inline');
        }
        if ($this->isAjax()) {
            $prototype->addClass('ajax');
        }
        return $prototype;
    }

    public function isInline(): bool
    {
        return $this->inline;
    }

    public function setInline(bool $inline = true): void
    {
        $this->inline = $inline;
    }

    public function isAjax(): bool
    {
        return $this->ajax;
    }

    public function setAjax(bool $ajax = true): void
    {
        $this->ajax = $ajax;
    }

//    public function getComponent($name, $need = true)
//    {
//        $control = parent::getComponent($name, $need);
//        $this->setControlClass($control);
//        return $control;
//    }

    /**
     * @param bool $addButtonClasses
     * @return \App\Forms\AbstractForm
     */
    public function setAddButtonClasses(bool $addButtonClasses): Form
    {
        $this->addButtonClasses = $addButtonClasses;
        return $this;
    }

    /**
     * @param bool $addControlClasses
     * @return \App\Forms\AbstractForm
     */
    public function setAddControlClasses(bool $addControlClasses): Form
    {
        $this->addControlClasses = $addControlClasses;
        return $this;
    }

}
