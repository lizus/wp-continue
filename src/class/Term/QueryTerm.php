<?php
namespace LizusContinue\Term;

class QueryTerm extends \LizusVitara\Term\QueryTerm
{
    protected function get_item($id){
        $tid=$id;
        return compact('id','tid');
    }
}