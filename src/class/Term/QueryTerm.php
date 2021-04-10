<?php
namespace LizusContinue\Term;

class QueryTerm extends \LizusVitara\Term\QueryTerm
{
    protected function get_item($id){
        return compact('id');
    }
}