<?php

namespace crewstyle\OlympusZeus\Models;

use crewstyle\OlympusZeus\Controllers\TermHook;

/**
 * Abstract class to define Term model.
 *
 * @package Olympus Zeus
 * @subpackage Models\Term
 * @author Achraf Chouk <achrafchouk@gmail.com>
 * @since 5.0.0
 *
 */

abstract class Term
{
    /**
     * @var array
     */
    protected $args;

    /**
     * @var TermHook
     */
    protected $hook;

    /**
     * @var string
     */
    protected $posttype;

    /**
     * @var string
     */
    protected $slug;

    /**
     * Gets the value of args.
     *
     * @return array
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * Sets the value of args.
     *
     * @param array $args the args
     *
     * @return self
     */
    protected function setArgs(array $args)
    {
        $this->args = $args;

        return $this;
    }

    /**
     * Gets the value of hook.
     *
     * @return TermHook
     */
    public function getHook()
    {
        return $this->hook;
    }

    /**
     * Sets the value of hook.
     *
     * @param TermHook $hook the hook
     *
     * @return self
     */
    protected function setHook(TermHook $hook)
    {
        $this->hook = $hook;

        return $this;
    }

    /**
     * Gets the value of posttype.
     *
     * @return string
     */
    public function getPosttype()
    {
        return $this->posttype;
    }

    /**
     * Sets the value of posttype.
     *
     * @param string $posttype the posttype
     *
     * @return self
     */
    protected function setPosttype($posttype)
    {
        $this->posttype = $posttype;

        return $this;
    }

    /**
     * Gets the value of slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Sets the value of slug.
     *
     * @param string $slug the slug
     *
     * @return self
     */
    protected function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }
}
