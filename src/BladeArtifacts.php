<?php

namespace Devsense\PHP\Editor\Extension
{
    class BladeArtifacts implements IEditorBlocks
    {
        const FileSuffix = ".blade.php";

        static function IsApplicable($fname)
        {
            return substr($fname, - strlen(self::FileSuffix)) == self::FileSuffix;
        }

        /**
         * Gets additional mapping of language blocks.
         *
         * @param string $source Source code text.
         * @return EditorBlock[]
         */
        function GetBlocks($source)
        {
            return array_merge(self::GetEnclosedBlocks($source), self::GetTaggedBlocks($source));
        }

        /**
         * @return EditorBlock[]
         */
        private static function GetEnclosedBlocks($source)
        {
            $blocks = [];

            // @{{ }}       // BladeText
            // {{{ }}}      // PHP
            // {{-- --}}    // BladeComment
            // {{ }}        // PHP
            // {!! !!}      // PHP

            $pos = 0;
            while (($pos = strpos($source, "{", $pos)) !== false && $pos < strlen($source) - 4)
            {
                $block = null;
                if ($source[$pos + 1] == '{')
                {
                    if ($pos > 0 && $source[$pos - 1] == '@') { $block = self::OnBladeText($source, $pos - 1); }
                    else if ($source[$pos + 2] == '{') { $block = self::OnEscapedTags($source, $pos); }
                    else if ($source[$pos + 2] == '-' && $source[$pos + 3] == '-') { $block = self::OnBladeComment($source, $pos); }
                    else { $block = self::OnContent($source, $pos); }
                }
                else if ($source[$pos + 1] == '!' && $source[$pos + 2] == '!') { $block = self::OnRawTags($source, $pos); }

                if ($block)
                {
                    $pos = $block->Start + $block->Length;
                    $blocks[] = $block;
                }
                else
                {
                    $pos ++;
                }
            }
	        return $blocks;
        }

        private static function OnBladeText($source, $at)    // @{{ }}
        {
            if (($to = strpos($source, "}}", $at + 3)))
            {
                return new EditorBlock("\\Devsense\\PHP\\Editor\\Extension\\BladeText", $at, $to - $at + 2, '\n', '\n');
            }
            return null;
        }

        private static function OnBladeComment($source, $at) // {{-- --}}
        {
            if (($to = strpos($source, "--}}", $at + 4)))
            {
                return new EditorBlock("\\Devsense\\PHP\\Editor\\Extension\\BladeComment", $at, $to - $at + 4, '\n', '\n');
            }
            return null;
        }

        private static function OnEscapedTags($source, $at)  // {{{ }}}
        {
            if (($to = strpos($source, "}}}", $at + 3)))
            {
                return new EditorBlock("php", $at + 3, $to - $at - 3, "\n<?=\n", "\n?>\n");
            }
            return null;
        }

        private static function OnRawTags($source, $at)  // {!! !!}
        {
            if (($to = strpos($source, "!!}", $at + 3)))
            {
                return new EditorBlock("php", $at + 3, $to - $at - 3, "\n<?=\n", "\n?>\n");
            }
            return null;
        }

        private static function OnContent($source, $at)  // {{ }}
        {
            if (($to = strpos($source, "}}", $at + 2)))
            {
                return new EditorBlock("php", $at + 2, $to - $at - 2, "\n<?=\n", "\n?>\n");
            }
            return null;
        }

        /**
         * @return EditorBlock[]
         */
        private static function GetTaggedBlocks($source)
        {
            $blocks = [];

            // @keyword (PHP)

            if (preg_match_all('/\B@(\w+)([ \t]*)(\( ( (?>[^()]+) | (?3) )* \))?/x', $source, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER))
            {
                foreach ($matches as $m)
                {
                    $at = $m[0][1];   // position of @keyword
                    
                    //if (isset($m[3]))   // position of (PHP)
                    {
                        $blocks[] = new EditorBlock("php", $at + 1, strlen($m[0][0]) - 1, "\n<?php\nBladeFunctions::_", "\n;?>\n");
                    }

                    //$blocks[] = new EditorBlock("\\Devsense\\PHP\\Editor\\Extension\\BladeKeywords", $keywordAt, $keywordTo - $keywordAt, '\n', '\n');
                }
            }

            //var_dump($blocks);
            
            //
            return $blocks;
        }
    
        /**
         * Gets list of keywords that when appear or disappear in code, triggers update of artifacts.
         *
         * @return string[] List of keywords that typically opens and closes language block. (e.g. ['{{', '}}', '{#', '#}'])
         */
        function GetTriggers()
        {
	        return ['@', '{{', '}}', '{!!', '!!}', '{{--', '--}}'];
        }
    }
}