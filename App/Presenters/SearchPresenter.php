<?php declare(strict_types = 1);

namespace App\Presenters;

use Libs\Repository\SearchResult;
use Nette\ComponentModel\IComponent;
use Nette\DI\Container;
use Ublaboo\DataGrid\DataGrid;

class SearchPresenter extends BasePresenter
{

    /**
     * @var \Libs\Repository\SearchResult
     */
    private SearchResult $searchResult;

    public function __construct(Container $container, SearchResult $searchResult)
    {
        parent::__construct($container);
        $this->searchResult = $searchResult;
    }

    public function createComponentGrid(): ?IComponent
    {
        $grid = new DataGrid();

        $grid->setDataSource($this->searchResult->createQueryBuilder('q'));
        $grid->addColumnDateTime('date', 'Datum')->setSortable();
        $grid->addColumnText('ico', 'IČO')->setSortable()->setFilterText();
        $grid->addColumnText('companyName', 'Firma')->setSortable()->setFilterText();
        $grid->setItemsDetail(APP_DIR . "/Themes/{$this->getTheme()}/Templates/Search/detail.latte");

        $grid->setDefaultSort(['date' => 'ASC']);
        $grid->setItemsPerPageList([3]);
        return $grid;
    }
}
