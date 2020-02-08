<?php declare(strict_types = 1);

namespace App\Presenters;

use Nette\Application\UI\Form;
use Nette\SmartObject;

class HomepagePresenter extends BasePresenter
{
    use SmartObject;
    public function createComponentResetPassword()
    {
        $form = new Form();
        $form->addProtection('Vaše relace vypršela. Prosím, zkuste to znovu.');
        $form->addText('email', 'E-mail')
            ->addRule(Form::EMAIL, 'neplatný formát emailu')
            ->setRequired('%label je povinný')
            ->setHtmlAttribute('placeholder', 'napište e-mail');
        $form->addSubmit('submit')
            ->getControlPrototype()
            ->setName('button')
            ->setHtml('Obnovit heslo');
        $form->onSuccess[] = function (Form $form, \stdClass $values): void {
            $form->reset();
            $this->flashMessage('Vaše heslo bylo obnoveno');
        };
        return $form;
    }
}
