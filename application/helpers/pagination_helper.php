<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*pagination
        url = the page that has the pagination - needs to be revised for search results
        total = total number of records
        page = current page
        total_pages = total / offset;
*/

if (! function_exists('pagination'))
{
    function pagination ($params = array())
    {
                $total_pages = ceil($params['total'] / $params['offset']);
        
        if ($total_pages <= 0) return;
        
        $str = '';
                $str .= '<div class="pagination">';
                $str .= '       <ul>';
                
                if ($params['page'] > 1)
                        $str .= '               <li class="prev"><a href="' . $params['url'] . '?page=' . ($params['page'] - 1) . '&offset=' . $params['offset'] . '">&larr; Previous</a></li>';
                else
                        $str .= '               <li class="prev disabled"><a href="#">&larr; Previous</a></li>';
                
                for ($i = 1; $i <= $total_pages; $i++) {
                        $str .= '               <li';
                        if ($i == intval($params['page'])) $str .= ' class="active"';
                        $str .= '><a href="' . $params['url'] . '?page=' . $i . '&offset=' . $params['offset'] . '">' . $i .'</a></li>';
                }

                if ($params['page'] < $total_pages)
                        $str .= '               <li class="next"><a href="' . $params['url'] . '?page=' . ($params['page'] + 1) . '&offset=' . $params['offset'] . '">Next &rarr;</a></li>';
                else
                        $str .= '               <li class="next disabled"><a href="#">Next &rarr;</a></li>';
                        
                $str .= '       </ul>';
                $str .= '</div>';
        
        return $str;

    }   
}