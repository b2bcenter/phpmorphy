<?php
/*
* This file is part of phpMorphy project
*
* Copyright (c) 2007-2012 Kamaev Vladimir <heromantor@users.sourceforge.net>
*
*     This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU Lesser General Public
* License as published by the Free Software Foundation; either
* version 2 of the License, or (at your option) any later version.
*
*     This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
* Lesser General Public License for more details.
*
*     You should have received a copy of the GNU Lesser General Public
* License along with this library; if not, write to the
* Free Software Foundation, Inc., 59 Temple Place - Suite 330,
* Boston, MA 02111-1307, USA.
*/

class phpMorphy_Dict_Ancode {
    protected
        $id,
        $grammems,
        $pos,
        $is_predict;

    public function __construct($id, $pos, $isPredict, $grammems = null) {
        //self::checkAncodeId($id, "Invalid ancode_id specified in ancode ctor");

        $this->grammems = new phpMorphy_Util_Collection_ArrayBased();

        if(is_string($grammems)) {
            $this->setGrammemsFromString($grammems);
        } elseif(is_array($grammems)) {
            $this->grammems->import(new ArrayIterator($grammems));
        } elseif(!is_null($grammems)) {
            throw new phpMorphy_Exception('Invalid grammems given');
        }

        $this->setId($id);
        $this->pos = $pos;
        $this->is_predict = (bool)$isPredict;
    }
/*
    public static function checkAncodeId($id, $prefix) {
        if(strlen($id) != 2) {
            throw new Exception("$prefix: Ancode must be exact 2 bytes long, '$id' given");
        }
    }
*/

    public function getGrammems() {
        return $this->grammems->getData();
    }

    public function setGrammemsFromString($grammems, $separator = ',') {
        $this->grammems->import(new ArrayIterator(array_map('trim', explode(',', $grammems))));
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function addGrammem($grammem) {
        $this->grammems->append($grammem);
    }

    public function getId() { return $this->id; }
    public function getPartOfSpeech() { return $this->pos; }
    public function isPredict() { return $this->is_predict; }

    /*
    protected function createStorageCollection() {
        return new phpMorphy_Util_Collection_ArrayBased();
    }
    */

    public function __toString() {
        return phpMorphy_Dict_ModelsFormatter::create()->formatAncode($this);
    }
}