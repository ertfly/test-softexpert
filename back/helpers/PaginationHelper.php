<?php

namespace Helpers;

class PaginationHelper
{
    private $total;
    private $perPage;
    private $page;
    private $rows;
    private $totalPages;

    public function __construct($total, $page, $perPage)
    {
        $this->total = $total;
        $this->perPage = $perPage;
        $this->page = ($page == 0 ? 1 : intval($page));
        $this->rows = array();
        $this->totalPages = ceil($this->total / ($this->perPage == 0 ? 1 : $this->perPage));
    }

    public function setRows(array $rows)
    {
        $this->rows = $rows;
        return $this;
    }

    public function getRows()
    {
        return $this->rows;
    }

    public function getOffset()
    {
        if (ceil($this->total / $this->perPage) > 1) {
            return (int) $this->perPage * ($this->page - 1);
        }
        return 0;
    }

    public function getOffsetMongo()
    {
        if ($this->page > 1) {
            return ($this->page * $this->perPage) - $this->perPage;
        }

        return 0;
    }

    public function getTotal()
    {
        return (int) $this->total;
    }

    public function getPage()
    {
        return intval($this->page);
    }

    public function getTotalPages()
    {
        return (int) $this->totalPages;
    }

    public function getJson()
    {
        $pages = array();

        if ($this->totalPages > 1 && $this->page > 1) {
            $pages[] = array(
                'pg' => 1,
                'content' => '<<',
                'active' => false
            );
        }

        if ($this->totalPages > 1 && $this->page > 1) {
            $pages[] = array(
                'pg' => (int)($this->page - 1),
                'content' => '<',
                'active' => false
            );
        }

        if ($this->page > 1 && $this->totalPages > ($this->page - 3) && ($this->page - 3) > 0) {
            $pages[] = array(
                'pg' => (int)($this->page - 3),
                'content' => str_pad(($this->page - 3), 2, '0', STR_PAD_LEFT),
                'active' => false
            );
        }

        if ($this->page > 1 && $this->totalPages > ($this->page - 2) && ($this->page - 2) > 0) {
            $pages[] = array(
                'pg' => (int)($this->page - 2),
                'content' => str_pad(($this->page - 2), 2, '0', STR_PAD_LEFT),
                'active' => false
            );
        }

        if ($this->page > 1 && $this->totalPages > ($this->page - 1) && ($this->page - 1) > 0) {
            $pages[] = array(
                'pg' => (int)($this->page - 1),
                'content' => str_pad(($this->page - 1), 2, '0', STR_PAD_LEFT),
                'active' => false
            );
        }

        if ($this->totalPages > 1) {
            $pages[] = array(
                'pg' => (int)$this->page,
                'content' => str_pad($this->page, 2, '0', STR_PAD_LEFT),
                'active' => true
            );
        }

        if ($this->totalPages >= ($this->page + 1)) {
            $pages[] = array(
                'pg' => (int)($this->page + 1),
                'content' => str_pad(($this->page + 1), 2, '0', STR_PAD_LEFT),
                'active' => false
            );
        }

        if ($this->totalPages >= ($this->page + 2)) {
            $pages[] = array(
                'pg' => (int)($this->page + 2),
                'content' => str_pad(($this->page + 2), 2, '0', STR_PAD_LEFT),
                'active' => false
            );
        }

        if ($this->totalPages >= ($this->page + 3)) {
            $pages[] = array(
                'pg' => (int)($this->page + 3),
                'content' => str_pad(($this->page + 3), 2, '0', STR_PAD_LEFT),
                'active' => false
            );
        }

        if ($this->totalPages > 1 && $this->page < $this->totalPages) {
            $pages[] = array(
                'pg' => (int)($this->page + 1),
                'content' => '>',
                'active' => false
            );
        }

        if ($this->totalPages > 1 && $this->page < $this->totalPages) {
            $pages[] = array(
                'pg' => (int)$this->totalPages,
                'content' => '>>',
                'active' => false
            );
        }

        return $pages;
    }
}
