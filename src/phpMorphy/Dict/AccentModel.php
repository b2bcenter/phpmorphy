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

class phpMorphy_Dict_AccentModel extends phpMorphy_Util_Collection_ArrayBased/*_Typed*/ {
    protected
        $id;

    public function __construct($id) {
        parent::__construct(/*$this->createStorageCollection(), array('integer', 'NULL')*/);

        $this->setId($id);
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function append($offset) {
        if($offset === null) {
            $this->addEmptyAccent();
        } else {
            parent::append((int)$offset);
        }
    }

    public function addEmptyAccent() {
        parent::append(null);
    }

    public static function isEmptyAccent($accent) {
        return null === $accent;
    }

    public function getAccents() {
        return $this->getData();
    }

    /*
    protected function createStorageCollection() {
        return new phpMorphy_Util_Collection_ArrayBased();
    }
    */

    public function __toString() {
        return phpMorphy_Dict_ModelsFormatter::create()->formatAccentModel($this);
    }
}