<?php declare(strict_types = 1);

namespace App\Presenters;

use App\Components\BS4FormUtil;
use Libs\Api\Ares;
use Nette\Application\UI\Form;

class HomepagePresenter extends BasePresenter
{

    public function createComponentAresForm()
    {
        $form = new Form();
        //        $form->getElementPrototype()->class('ajax');
        $form->addProtection('Vaše relace vypršela. Prosím, zkuste to znovu.');
        $form->addText('ico', 'IČO')
            ->addRule(Form::INTEGER, 'neplatný formát')
            ->setRequired('%label je povinné')
            ->setHtmlAttribute('placeholder', 'zadejte IČO');
        $form->addSubmit('submit')
            ->getControlPrototype()
            ->setName('button')
            ->setHtml('Vyhledat');
        $form->onSuccess[] = function (Form $form): void {
            $ares = new Ares($form->getValues()['ico']);
//            dumpe($ares->getData());
        };
        BS4FormUtil::decorate($form);
        return $form;
    }
}
