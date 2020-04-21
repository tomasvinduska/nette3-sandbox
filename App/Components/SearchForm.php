<?php declare(strict_types = 1);

namespace App\Components;

use Libs\Api\Ares;
use Libs\Entity\SearchResults;
use Libs\Repository\Address;
use Libs\Repository\City;
use Libs\Repository\Country;
use Libs\Repository\SearchResult;
use Nette\Application\UI\Form;
use Nette\SmartObject;

class SearchForm
{

    use SmartObject;

    private Address $addressRepository;

    private City $cityRepository;

    private Country $countryRepository;

    private SearchResult $searchResultRepository;

    public $onSuccess;

    public function __construct(Address $address, City $city, Country $country, SearchResult $searchResult)
    {
        $this->addressRepository = $address;
        $this->cityRepository = $city;
        $this->countryRepository = $country;
        $this->searchResultRepository = $searchResult;
    }

    public function createForm()
    {
        $form = new Form();
        $form->getElementPrototype()->class('ajax');
        $form->addProtection('Vaše relace vypršela. Prosím, zkuste to znovu.');
        $form->addText('ico', 'IČO')
            ->addRule(Form::NUMERIC, 'neplatný formát')
            ->setRequired('%label je povinné')
            ->setHtmlAttribute('placeholder', 'zadejte IČO');
        $form->addSubmit('submit')
            ->getControlPrototype()
            ->setName('button')
            ->setHtml('Vyhledat');
        $form->onSuccess[] = [$this, 'saveForm'];
        BS4FormUtil::decorate($form);
        return $form;
    }

    public function saveForm(Form $form): void
    {
        $ico = $form->getValues()['ico'];
        $ares = new Ares($ico);
        $data = $ares->getData();
        if ($data === false) {
            $form->getPresenter()->flashMessage('nepodarilo se nacist data', 'danger');
        } else {
            $searchResult = $this->searchResultRepository->findOneBy(['ico' => $ico]);
            if ($searchResult === null) {
                $searchResult = new SearchResults();
                $searchResult->setIco($ico)->setCompanyName($data['name']);

                $country = $this->getCountry($data['country']);
                $city = $this->getCity($data['city'], $country);
                $address = $this->getAddress($data['street'], $data['postal'], $data['district'], $city);
                $searchResult->setAddress($address);
            }
            $searchResult->setDate(new \DateTime());
            $this->searchResultRepository->save($searchResult);

            $form->getPresenter()->flashMessage('ulozeno');
        }
        $this->onSuccess($form);
        $form->getPresenter()->redrawControl(null);
    }

    private function getCountry(string $name)
    {
        $country = $this->countryRepository->findOneBy(['country' => $name]);
        if ($country === null) {
            $country = $this->countryRepository->create($name);
        }
        return $country;
    }

    private function getCity(string $name, \Libs\Entity\Country $country)
    {
        $city = $this->cityRepository->findOneBy(['city' => $name, 'country' => $country]);
        if ($city === null) {
            $city = $this->cityRepository->create($name, $country);
        }
        return $city;
    }

    private function getAddress(string $street, string $postal, string $district, \Libs\Entity\City $city)
    {
        $address = $this->addressRepository->findOneBy(['address' => $street, 'postalCode' => $postal, 'city' => $city, 'district' => $district]);
        if ($address === null) {
            $address = $this->addressRepository->create($street, $postal, $district, $city);
        }
        return $address;
    }

}
