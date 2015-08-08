<?php

namespace Devsense\PHP\Editor\Extension
{
    class BladeCodeSense implements IPhpEditorCodeSense
    {
        const FileSuffix = ".blade.php";

        static function IsApplicable($fname)
        {
            return substr($fname, - strlen(self::FileSuffix)) == self::FileSuffix;
        }

        /**
         * Gets additional tooltip text for given code element.
         *
         * @param NodeInfo $node Code element information.
         */
        function GetToolTip(NodeInfo $node)
        {
            if ($node->Usage == "StaticTypeMember" && $node->ElementName[0] == '_' && in_array("BladeFunctions", $node->MemberOf))
            {
                $fnc = substr($node->ElementName, 1);
                return "@$fnc is very useful";
            }
            
            return null;
        }

        /**
         * Gets URL pointing to help for given node.
         *
         * @param NodeInfo $node 
         */
        function GetHelpUrl(NodeInfo $node)
        {
	        return null;
        }
    }
}