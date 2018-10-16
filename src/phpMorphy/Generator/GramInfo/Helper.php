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

class phpMorphy_Generator_GramInfo_Helper extends phpMorphy_Generator_HelperAbstract {
    /**
     * @return string
     */
    public function getParentClassName() {
        return phpMorphy_GramInfo_GramInfoAbstract::class;
    }

    /**
     * @return string
     */
    public function getClassName() {
        $storage_type = ucfirst($this->storage->getType());

        return "phpMorphy_GramInfo_$storage_type";
    }

    /**
     * @return string
     */
    public function prolog() {
        return $this->storage->prolog();
    }

    /**
     * @return string
     */
    public function getInfoHeaderSize() {
        return 20;
    }

    /**
     * @return string
     */
    public function getStartOffset() {
        return '0x100';
    }
}