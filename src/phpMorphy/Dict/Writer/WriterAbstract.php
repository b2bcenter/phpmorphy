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

abstract class phpMorphy_Dict_Writer_WriterAbstract implements phpMorphy_Dict_Writer_WriterInterface {
    private $observer;

    public function __construct() {
        $this->setObserver(new phpMorphy_Dict_Writer_Observer_Empty());
    }

    public function setObserver(phpMorphy_Dict_Writer_Observer_ObserverInterface $observer) {
        $this->observer = $observer;
    }

    public function hasObserver() {
        return isset($this->observer);
    }

    public function getObserver() {
        return $this->observer;
    }

    protected function log($message) {
        if($this->hasObserver()) {
            $this->getObserver()->onLog($message);
        }
    }
}