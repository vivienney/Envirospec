<?php

class SearchResults extends Page
{


    public function getCMSFields()
    {

        $fields = parent::getCMSFields();
        $fields->removeByName('Content');

        return $fields;
    }

    private static $has_many = array(
        'Products' => 'Product'
    );

}

class SearchResults_Controller extends Page_Controller
{


    protected $articleList;

    public function index(SS_HTTPRequest $request)
    {

        $this->articleList = new PaginatedList(
            Product::get()->sort('ID', 'ASC'),
            $this->request
        );

        // ========================================
        // Keyword Filter
        // ========================================
        if ($search = $request->getVar('Keyword')) {
            $this->articleList = $this->articleList->filter(array(
                'Title:PartialMatch' => $search
            ));
        }

        // ========================================
        // Manufacturer Filter
        // ========================================
        if ($search = $request->getVar('Manufacturer')) {
            $this->articleList = $this->articleList->filter(array(
                'ManufacturerID' => $search
            ));
        }

        $this->articleList = PaginatedList::create(
            $this->articleList,
            $this->getRequest()
        );

        return array(
            'Results' => $this->articleList
        );
    }

    public function SearchName()
    {

        if ($search = $this->getRequest()->getVar('Keyword')) {
            return $search;
        } else if ($search = $this->getRequest()->getVar('Manufacturer')) {
            return dataObject::get_by_id('Companies', $search)->Title;
        }
    }

}