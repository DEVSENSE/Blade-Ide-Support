<?php

namespace Devsense\PHP\Editor\Extension
{
    /**
     * Provides colorization information for specific blade artifacts.
     */
    class BladeComment implements IEditorClassifier
    {
        /**
         * Gets colors (classifications) of specific words to be automatically colored in source.
         *
         * @return EditorWordColor[] Classification words.
         */
        function GetColors()
        {
            // note: empty string applies for all the text within classifier
            return [new EditorWordColor("", "comment")];
        }
    }

    /**
     * Provides colorization information for specific blade artifacts.
     */
    class BladeText implements IEditorClassifier
    {
        /**
         * Gets colors (classifications) of specific words to be automatically colored in source.
         *
         * @return EditorWordColor[] Classification words.
         */
        function GetColors()
        {
            // note: empty string applies for all the text within classifier
            return [new EditorWordColor("", "string")];
        }
    }

    ///**
    // * Provides colorization information for specific blade artifacts.
    // */
    //class BladeKeywords implements IEditorClassifier
    //{
    //    /**
    //     * Gets colors (classifications) of specific words to be automatically colored in source.
    //     *
    //     * @return EditorWordColor[] Classification words.
    //     */
    //    function GetColors()
    //    {
    //        return [new EditorWordColor("", "keyword")];
    //            //new EditorWordColor("if", "keyword"),
    //            //new EditorWordColor("for", "keyword"),
    //            //new EditorWordColor("foreach", "keyword"),
    //            //new EditorWordColor("unless", "keyword"),
    //            //new EditorWordColor("include", "keyword"),
    //            //new EditorWordColor("overwrite", "keyword"),
    //            //new EditorWordColor("lang", "keyword"),
    //            //new EditorWordColor("choice", "keyword"),
    //            //new EditorWordColor("extends", "keyword"),
    //            //new EditorWordColor("section", "keyword"),
    //            //new EditorWordColor("endif", "keyword"),
    //            //new EditorWordColor("elseif", "keyword"),
    //            //new EditorWordColor("endunless", "keyword"),
    //            //new EditorWordColor("endforeach", "keyword"),
    //            //new EditorWordColor("endfor", "keyword"),
    //            //new EditorWordColor("forelse", "keyword"),
    //            //new EditorWordColor("empty", "keyword"),
    //            //new EditorWordColor("yield", "keyword"),
    //            //new EditorWordColor("show", "keyword"),
    //            //new EditorWordColor("endforelse", "keyword"),
    //            //new EditorWordColor("stop", "keyword")
    //            //];
    //    }
    //}
}