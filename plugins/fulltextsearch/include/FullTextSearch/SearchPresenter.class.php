<?php
/**
 * Copyright (c) Enalean, 2012. All Rights Reserved.
 *
 * This file is a part of Tuleap.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/>.
 */
class FullTextSearch_SearchPresenter {
    private $terms;
    private $query_result;
    
    public function __construct($terms, $query_result) {
        $this->terms        = $terms;
        $this->query_result = $query_result;
    }
    
    public function terms() {
        return $this->terms;
    }
    
    public function result_count() {
        if (isset($this->query_result['hits']['total'])) {
            return $this->query_result['hits']['total'];
        }
        return 0;
    }
    
    public function search_results() {
        $results = array();
        if (isset($this->query_result['hits']['hits'])) {
            foreach ($this->query_result['hits']['hits'] as $hit) {
                var_dump($hit);
                $results[] = array(
                    'item_title' => $hit['fields']['title'],
                    'url'        => '/plugins/docman/?group_id='.$hit['fields']['group_id'].'&id='.$hit['fields']['id'].'&action=details');
            }
        }
        return $results;
    }
    
    public function elapsed_time() {
        if (isset($this->query_result['time'])) {
            return $this->query_result['time'];
        }
        return '';
    }

}

?>
