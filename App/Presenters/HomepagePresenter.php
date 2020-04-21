<?php declare(strict_types = 1);

namespace App\Presenters;

use App\Components\SearchForm;
use Libs\Repository\SearchResult;
use Nette\Application\UI\Form;
use Nette\DI\Container;

class HomepagePresenter extends BasePresenter
{

    private SearchResult $searchResultRepository;

    private SearchForm $searchForm;

    public function __construct(Container $container, SearchResult $searchResultRepository, SearchForm $searchForm)
    {
        parent::__construct($container);
        $this->searchResultRepository = $searchResultRepository;
        $this->searchForm = $searchForm;
    }

    public function createComponentAresForm()
    {
        $form = $this->searchForm->createForm();
        $form->onSuccess[] = function (Form $form): void {
            $form->reset();
        };
        return $form;
    }

    public function renderDefault(): void
    {
        $this->template->searchResults = $this->searchResultRepository->findBy([], ['date' => 'DESC'], 5);
    }

}
