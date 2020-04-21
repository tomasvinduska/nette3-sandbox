<?php declare(strict_types = 1);

namespace App\Presenters;

use App\Components\SignForm;
use Doctrine\ORM\EntityManager;
use Nette\Application\UI\Form;
use Nette\DI\Container;

class SignPresenter extends BasePresenter
{

    /** @var \App\Components\SignForm @inject */
    public $annotationInject;

    /**
     * @var \App\Components\SignForm
     */
    private $injectUsingMethod;

    /**
     * @var \App\Components\SignForm
     */
    private $signForm;

    /** @var \Doctrine\ORM\EntityManagerInterface @inject */
    public $entityManager;

    public function __construct(Container $container, SignForm $signForm)
    {
        parent::__construct($container);
        $this->signForm = $signForm;
    }

    public function actionResetPassword()
    {
    }

    public function createComponentResetPassword(): Form
    {
        $form = $this->signForm->resetPassword();
        $form->onSuccess[] = function (Form $form): void {
            $form->reset();
            $this->flashMessage('Vaše heslo bylo obnoveno');
        };
        return $form;
    }

    public function injectSignForm(SignForm $signForm): void
    {
        $this->injectUsingMethod = $signForm;
    }
}
