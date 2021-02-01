<?php

/* Copyright (c) 2016 Timon Amstutz <timon.amstutz@ilub.unibe.ch> Extended GPL, see docs/LICENSE */

namespace ILIAS\UI\Interfaces;

use ILIAS\UI\Component as C;

/**
 * Some Random Comment
 */
interface ProperEntry
{
    /**
     * ---
     *
     * description:
     *   purpose: >
     *       Description of Purpose
     *   composition: >
     *       Description of Composition
     *       with line break
     *   effect: Effect Description on one line
     *   rivals:
     *       icon: >
     *           Icon Description
     *
     * background: >
     *     "Some wild background with quotes"
     *
     *     and links <a href='http:test'>test</a>
     *
     * context:
     *   - Some Context
     * featurewiki:
     *       - http://www.ilias.de/docu/goto_docu_wiki_wpage_3208_1357.html
     *
     * rules:
     *   usage:
     *       1: Usage Rule 1
     *       2: Usage Rule 2
     *       3: >
     *         Usage Rule 3 multi line
     *   style:
     *       4: Style Rule
     * ---
     *
     * @return  \ILIAS\UI\Crawler\Fixture\ProperEntry
     */
    public function properEntry();
}
