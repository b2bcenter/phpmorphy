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


interface phpMorphy_WordForm_WordFormInterface {
    /**
     * @return string
     */
    public function getWord();

    /**
     * @return string
     */
    public function getPartOfSpeech();

    /**
     * @return string[]
     */
    public function getGrammems();

    /**
     * @return string
     */
    public function getCommonPrefix();

    /**
     * @return string
     */
    public function getFormPrefix();

    /**
     * @return string
     */
    public function getSuffix();

    /**
     * @return string
     */
    public function getBase();

    /**
     * @return string
     */
    public function getFormGrammems();

    /**
     * @return string
     */
    public function getCommonGrammems();

    /**
     * @return string
     */
    public function getPrefix();

    /**
     * @param string[]|int[]|string|int $grammems
     * @return bool
     */
    public function hasGrammems($grammems);

    /**
     * @abstract
     * @param string $base
     * @return void
     */
    public function setBase($base);

    /**
     * @abstract
     * @param string $common_prefix
     * @return void
     */
    public function setCommonPrefix($common_prefix);

    /**
     * @abstract
     * @param string $prefix
     * @return void
     */
    public function setFormPrefix($prefix);

    /**
     * @abstract
     * @param string $suffix
     * @return void
     */
    public function setSuffix($suffix);

    /**
     * @abstract
     * @param string $partOfSpeech
     * @return void
     */
    public function setPartOfSpeech($partOfSpeech);

    /**
     * @abstract
     * @param string[] $grammems
     * @return void
     */
    public function setFormGrammems(array $grammems);

    /**
     * @abstract
     * @param string[] $grammems
     * @return void
     */
    public function setCommonGrammems(array $grammems);
}