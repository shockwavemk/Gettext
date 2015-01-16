<?php
namespace Gettext;

/**
 * Class to manage a translation string
 */
class Translation
{
    protected $context;
    protected $original;
    protected $translation = '';
    protected $plural;
    protected $pluralTranslation = array();
    protected $references = array();
    protected $comments = array();
    protected $extractedComments = array();
    protected $flags = array();

    /**
     * Construct
     *
     * @param string $context  The context of the translation
     * @param string $original The original string
     * @param string $plural   The original plural string
     */
    public function __construct($context = '', $original = '', $plural = '')
    {
        $this->setContext($context);
        $this->setOriginal($original);
        $this->setPlural($plural);
    }

    /**
     * Checks whether the translation matches with the arguments
     *
     * @param string $context
     * @param string $original
     * @param string $plural
     *
     * @return boolean
     */
    public function is($context, $original = '', $plural = '')
    {
        return (($this->context === $context) && ($this->original === $original) && ($this->plural === $plural)) ? true : false;
    }

    /**
     * Sets the original string
     *
     * @param string $original
     */
    public function setOriginal($original)
    {
        $this->original = (string) $original;
    }

    /**
     * Gets the original string
     *
     * @return string
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * Checks if the original string is empty or not
     *
     * @return boolean
     */
    public function hasOriginal()
    {
        return ($this->original !== '') ? true : false;
    }

    /**
     * Sets the translation string
     *
     * @param string $translation
     */
    public function setTranslation($translation)
    {
        $this->translation = (string) $translation;
    }

    /**
     * Gets the translation string
     *
     * @return string
     */
    public function getTranslation()
    {
        return $this->translation;
    }

    /**
     * Checks if the translation string is empty or not
     *
     * @return boolean
     */
    public function hasTranslation()
    {
        return ($this->translation !== '') ? true : false;
    }

    /**
     * Sets the plural translation string
     *
     * @param string $plural
     */
    public function setPlural($plural)
    {
        $this->plural = (string) $plural;
    }

    /**
     * Gets the plural translation string
     *
     * @return string
     */
    public function getPlural()
    {
        return $this->plural;
    }

    /**
     * Checks if the plural translation string is empty or not
     *
     * @return boolean
     */
    public function hasPlural()
    {
        return ($this->plural !== '') ? true : false;
    }

    /**
     * Set a new plural translation
     *
     * @param string       $plural The plural string to add
     * @param null|integer $key    The key of the plural translation.
     */
    public function setPluralTranslation($plural, $key = null)
    {
        if ($key === null) {
            $this->pluralTranslation[] = $plural;
        } else {
            $this->pluralTranslation[$key] = $plural;
        }
    }

    /**
     * Gets one or all plural translations
     *
     * @param integer|null $key The key to return. If is null, return all translations
     *
     * @return string|array
     */
    public function getPluralTranslation($key = null)
    {
        if ($key === null) {
            return $this->pluralTranslation;
        }

        return isset($this->pluralTranslation[$key]) ? (string) $this->pluralTranslation[$key] : '';
    }

    /**
     * Checks if there any plural translation
     *
     * @return boolean
     */
    public function hasPluralTranslation()
    {
        return isset($this->pluralTranslation[0]);
    }

    /**
     * Sets the context of this translation
     *
     * @param string $context
     */
    public function setContext($context)
    {
        $this->context = (string) $context;
    }

    /**
     * Gets the context of this translation
     *
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Checks if the context is empty or not
     *
     * @return boolean
     */
    public function hasContext()
    {
        return (isset($this->context) && ($this->context !== '')) ? true : false;
    }

    /**
     * Adds a new reference for this translation
     *
     * @param string       $filename The file path where the translation has been found
     * @param null|integer $line     The line number where the translation has been found
     */
    public function addReference($filename, $line = null)
    {
        $key = "{$filename}:{$line}";
        $this->references[$key] = array($filename, $line);
    }

    /**
     * Checks if the translation has any reference
     *
     * @return boolean
     */
    public function hasReferences()
    {
        return !empty($this->references);
    }

    /**
     * Clear all references
     */
    public function wipeReferences()
    {
        $this->references = array();
    }

    /**
     * Return all references for this translation
     *
     * @return array
     */
    public function getReferences()
    {
        return array_values($this->references);
    }

    /**
     * Adds a new comment for this translation
     *
     * @param string $comment
     */
    public function addComment($comment)
    {
        $this->comments[] = $comment;
    }

    /**
     * Checks if the translation has any comment
     *
     * @return boolean
     */
    public function hasComments()
    {
        return isset($this->comments[0]);
    }

    /**
     * Returns all comments for this translation
     *
     * @return array
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Adds a new extracted comment for this translation
     *
     * @param string $comment
     */
    public function addExtractedComment($comment)
    {
        $this->extractedComments[] = $comment;
    }

    /**
     * Checks if the translation has any extracted comment
     *
     * @return boolean
     */
    public function hasExtractedComments()
    {
        return isset($this->extractedComments[0]);
    }

    /**
     * Returns all extracted comments for this translation
     *
     * @return array
     */
    public function getExtractedComments()
    {
        return $this->extractedComments;
    }

    /**
     * Adds a new flat for this translation
     *
     * @param string $flag
     */
    public function addFlag($flag)
    {
        $this->flags[] = $flag;
    }

    /**
     * Checks if the translation has any flag
     *
     * @return boolean
     */
    public function hasFlags()
    {
        return isset($this->flags[0]);
    }

    /**
     * Returns all extracted flags for this translation
     *
     * @return array
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * Merges this translation with other translation
     *
     * @param Translation $translation The translation to merge with
     * @param boolean     $references  Merge references?
     * @param boolean     $comments    Merge comments?
     */
    public function mergeWith(Translation $translation, $references = true, $comments = true)
    {
        if (!$this->hasTranslation()) {
            $this->setTranslation($translation->getTranslation());
        }

        if (!$this->hasPluralTranslation() && $translation->hasPluralTranslation()) {
            $this->pluralTranslation = $translation->getPluralTranslation();
        }

        if ($references) {
            foreach ($translation->getReferences() as $reference) {
                $this->addReference($reference[0], $reference[1]);
            }
        }

        if ($comments) {
            $this->comments = array_unique(array_merge($translation->getComments(), $this->comments));
            $this->extractedComments = array_unique(array_merge($translation->getExtractedComments(), $this->extractedComments));
            $this->flags = array_unique(array_merge($translation->getFlags(), $this->flags));
        }
    }
}
