<?php

namespace Cheukpang;


class RSSItem extends RSSBase
{

    /**
     * @var string $about
     * URL
     */
    private $about;

    /**
     * @var string $title
     * headline
     */
    private $title;

    /**
     * @var string $link
     * URL to the full item
     */
    private $link;

    /**
     * @var string $description
     * optional description
     */
    private $description;

    /**
     * @var string $subject
     * optional subject (category)
     */
    private $subject;

    /**
     * @var string $date
     * optional date
     */
    private $date;

    /**
     * @var string $author
     * author of item
     */
    private $author;

    /**
     * @var string $comments
     * url to comments page (rss 2.0)
     */
    private $comments;

    /**
     * RSSItem constructor.
     * @param string $about
     * @param string $title
     * @param string $link
     * @param string $description
     * @param string $subject
     * @param string $date
     * @param string $author
     * @param string $comments
     * @see setAbout(), setTitle(), setLink(), setDescription(), setSubject(), setDate(), setAuthor(), setComments()
     */
    public function __construct(
        $about = '',
        $title = '',
        $link = '',
        $description = '',
        $subject = '',
        $date = '',
        $author = '',
        $comments = ''
    ) {
        $this->setAbout($about);
        $this->setTitle($title);
        $this->setLink($link);
        $this->setDescription($description);
        $this->setSubject($subject);
        $this->setDate($date);
        $this->setAuthor($author);
        $this->setComments($comments);
    }

    /**
     * @param string $about
     * Sets $about variable
     * @see $about
     */
    public function setAbout($about = '')
    {
        if (!isset($this->about) && strlen(trim($about)) > 0) {
            $this->about = trim($about);
        }
    }

    /**
     * @param string $title
     * Sets $title variable
     * @see $title
     */
    public function setTitle($title = '')
    {
        if (!isset($this->title) && strlen(trim($title)) > 0) {
            $this->title = trim($title);
        }
    }

    /**
     * @param string $link
     * Sets $link variable
     * @see $link
     */
    public function setLink($link = '')
    {
        if (!isset($this->link) && strlen(trim($link)) > 0) {
            $this->link = trim($link);
        }
    }

    /**
     * @param string $description
     * Sets $description variable
     * @see $description
     */
    public function setDescription($description = '')
    {
        if (!isset($this->description) && strlen(trim($description)) > 0) {
            $this->description = trim($description);
        }
    }

    /**
     * @param string $subject
     * Sets $subject variable
     * @see $subject
     */
    public function setSubject($subject = '')
    {
        if (!isset($this->subject) && strlen(trim($subject)) > 0) {
            $this->subject = trim($subject);
        }
    }

    /**
     * @param string $date
     * Sets $date variable
     * @see $date
     */
    public function setDate($date = '')
    {
        if (!isset($this->date) && strlen(trim($date)) > 0) {
            $this->date = trim($date);
        }
    }

    /**
     * @param string $author
     * Sets $author variable
     * @see $author
     */
    public function setAuthor($author = '')
    {
        if (!isset($this->author) && strlen(trim($author)) > 0) {
            $this->author = trim($author);
        }
    }

    /**
     * @param string $comments
     * Sets $comments variable
     * @see $comments
     */
    public function setComments($comments = '')
    {
        if (!isset($this->comments) && strlen(trim($comments)) > 0) {
            $this->comments = trim($comments);
        }
    }

    public function getAbout(): string
    {
        return $this->about;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getComments(): string
    {
        return $this->comments;
    }
}