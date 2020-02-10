<?php declare(strict_types = 1);

namespace App\Components;

use App\Forms\BS4FormUtil;
use Nette\Application\UI\Form;
use Nette\SmartObject;

class SignForm
{
    use SmartObject;

    /** @var callable  */
    public $onSuccess;

    public function resetPassword(): Form
    {
        $form = new Form();
        //        $form->getElementPrototype()->class('ajax');
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
            $this->onSuccess($form);
        };
        BS4FormUtil::decorate($form);
        return $form;
    }
}
