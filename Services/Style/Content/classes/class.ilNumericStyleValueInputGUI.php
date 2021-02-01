<?php
/*
    +-----------------------------------------------------------------------------+
    | ILIAS open source                                                           |
    +-----------------------------------------------------------------------------+
    | Copyright (c) 1998-2007 ILIAS open source, University of Cologne            |
    |                                                                             |
    | This program is free software; you can redistribute it and/or               |
    | modify it under the terms of the GNU General Public License                 |
    | as published by the Free Software Foundation; either version 2              |
    | of the License, or (at your option) any later version.                      |
    |                                                                             |
    | This program is distributed in the hope that it will be useful,             |
    | but WITHOUT ANY WARRANTY; without even the implied warranty of              |
    | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the               |
    | GNU General Public License for more details.                                |
    |                                                                             |
    | You should have received a copy of the GNU General Public License           |
    | along with this program; if not, write to the Free Software                 |
    | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA. |
    +-----------------------------------------------------------------------------+
*/

/**
* This class represents a numeric style property in a property form.
*
* @author Alex Killing <alex.killing@gmx.de>
* @version $Id$
* @ingroup	ServicesForm
*/
class ilNumericStyleValueInputGUI extends ilFormPropertyGUI
{
    /**
     * @var ilObjUser
     */
    protected $user;

    protected $value;
    protected $allowpercentage = true;
    
    /**
    * Constructor
    *
    * @param	string	$a_title	Title
    * @param	string	$a_postvar	Post Variable
    */
    public function __construct($a_title = "", $a_postvar = "")
    {
        global $DIC;

        $this->lng = $DIC->language();
        $this->user = $DIC->user();
        parent::__construct($a_title, $a_postvar);
        $this->setType("style_numeric");
    }

    /**
    * Set Value.
    *
    * @param	string	$a_value	Value
    */
    public function setValue($a_value)
    {
        $this->value = $a_value;
    }

    /**
    * Get Value.
    *
    * @return	string	Value
    */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
    * Set Allow Percentage.
    *
    * @param	boolean	$a_allowpercentage	Allow Percentage
    */
    public function setAllowPercentage($a_allowpercentage)
    {
        $this->allowpercentage = $a_allowpercentage;
    }

    /**
    * Get Allow Percentage.
    *
    * @return	boolean	Allow Percentage
    */
    public function getAllowPercentage()
    {
        return $this->allowpercentage;
    }

    /**
    * Check input, strip slashes etc. set alert, if input is not ok.
    *
    * @return	boolean		Input ok, true/false
    */
    public function checkInput()
    {
        $lng = $this->lng;
        
        $num_value = $_POST[$this->getPostVar()]["num_value"] =
            trim(ilUtil::stripSlashes($_POST[$this->getPostVar()]["num_value"]));
        $num_unit = $_POST[$this->getPostVar()]["num_unit"] =
            trim(ilUtil::stripSlashes($_POST[$this->getPostVar()]["num_unit"]));
            
        if ($this->getRequired() && trim($num_value) == "") {
            $this->setAlert($lng->txt("msg_input_is_required"));

            return false;
        }
        
        if (!is_numeric($num_value) && $num_value != "") {
            $this->setAlert($lng->txt("sty_msg_input_must_be_numeric"));

            return false;
        }
        
        if (trim($num_value) != "") {
            $this->setValue($num_value . $num_unit);
        }
        
        return true;
    }

    /**
    * Insert property html
    */
    public function insert(&$a_tpl)
    {
        $tpl = new ilTemplate("tpl.prop_style_numeric.html", true, true, "Services/Style/Content");
        
        $tpl->setVariable("POSTVAR", $this->getPostVar());
        
        $unit_options = ilObjStyleSheet::_getStyleParameterNumericUnits(!$this->getAllowPercentage());
        
        $value = strtolower(trim($this->getValue()));

        $current_unit = "";
        foreach ($unit_options as $u) {
            if (substr($value, strlen($value) - strlen($u)) == $u) {
                $current_unit = $u;
            }
        }
        $tpl->setVariable(
            "VAL_NUM",
            substr($value, 0, strlen($value) - strlen($current_unit))
        );
        if ($current_unit == "") {
            $current_unit = "px";
        }
        
        foreach ($unit_options as $option) {
            $tpl->setCurrentBlock("unit_option");
            $tpl->setVariable("VAL_UNIT", $option);
            $tpl->setVariable("TXT_UNIT", $option);
            if ($current_unit == $option) {
                $tpl->setVariable("UNIT_SELECTED", 'selected="selected"');
            }
            $tpl->parseCurrentBlock();
        }

        $a_tpl->setCurrentBlock("prop_generic");
        $a_tpl->setVariable("PROP_GENERIC", $tpl->get());
        $a_tpl->parseCurrentBlock();
    }

    /**
    * Set value by array
    *
    * @param	array	$a_values	value array
    */
    public function setValueByArray($a_values)
    {
        $ilUser = $this->user;
        
        $this->setValue($a_values[$this->getPostVar()]["num_value"] .
            $a_values[$this->getPostVar()]["num_unit"]);
    }
}