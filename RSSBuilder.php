<?php

namespace Cheukpang;


class RSSBuilder extends RSSBase
{
    /**
     * @var string $encoding
     * encoding of the XML file
     */
    private $encoding;
    /**
     * @var string $about
     * URL where the RSS document will be made available
     */
    private $about;
    /**
     * @var string $title
     * title of the rss stream
     */
    private $title;
    /**
     * @var string $description
     * description of the rss stream
     */
    private $description;
    /**
     * @var string $publisher
     * publisher of the rss stream
     */
    private $publisher;
    /**
     * @var string $creator
     * creator of the rss stream
     */
    private $creator;
    /**
     * @var string $date
     * creation date of the file (format: 2003-05-29T00:03:07+0200)
     */
    private $date;
    /**
     * @var string $language
     * iso format language
     */
    private $language;
    /**
     * @var string $rights
     * copyrights for the rss stream
     */
    private $rights;
    /**
     * @var string $image_link
     * URL to an small image
     */
    private $image_link;
    /**
     * @var string $coverage
     * spatial location (a place name or geographic coordinates),
     * temporal period (a period label, date, or date range) or
     * jurisdiction (such as a named administrative entity)
     */
    private $coverage;
    /**
     * @var string $contributor
     * person, an organization, or a service
     */
    private $contributor;
    /**
     * @var string $period
     * 'hourly' | 'daily' | 'weekly' | 'monthly' | 'yearly'
     */
    private $period;
    /**
     * @var int $frequency
     * every X hours/days/weeks/...
     */
    private $frequency;
    /**
     * @var string $base
     * base date to calculate from (format: 2003-05-29T00:03:07+0200)
     */
    private $base;
    /**
     * @var string $category
     * category (rss 2.0)
     */
    private $category;
    /**
     * @var int $cache
     * caching time in minutes (rss 2.0)
     */
    private $cache;
    /**
     * @var array $items
     * array wich all the rss items
     */
    private $items = [];
    /**
     * @var string $output
     * compiled outputstring
     */
    private $output;
    /**
     * @var bool $use_dc_data
     * use DC data
     */
    private $use_dc_data = false;
    /**
     * @var bool $use_sy_data
     * use SY data
     */
    private $use_sy_data = false;

    /**
     * RSSBuilder constructor.
     * @param string $encoding
     * @param string $about
     * @param string $title
     * @param string $description
     * @param string $image_link
     * @param string $category
     * @param string $cache
     */
    public function __construct(
        $encoding = '',
        $about = '',
        $title = '',
        $description = '',
        $image_link = '',
        $category = '',
        $cache = ''
    ) {
        $this->setEncoding($encoding);
        $this->setAbout($about);
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setImageLink($image_link);
        $this->setCategory($category);
        $this->setCache($cache);
    }

    public function addDCdata(
        $publisher = '',
        $creator = '',
        $date = '',
        $language = '',
        $rights = '',
        $coverage = '',
        $contributor = ''
    ) {
        $this->setPublisher($publisher);
        $this->setCreator($creator);
        $this->setDate($date);
        $this->setLanguage($language);
        $this->setRights($rights);
        $this->setCoverage($coverage);
        $this->setContributor($contributor);
        $this->use_dc_data = (boolean)true;
    }

    public function addSYdata($period = '', $frequency = '', $base = '')
    {
        $this->setPeriod($period);
        $this->setFrequency($frequency);
        $this->setBase($base);
        $this->use_sy_data = (boolean)true;
    }

    public function setEncoding($encoding = '')
    {
        if (!isset($this->encoding)) {
            $this->encoding = ((strlen(trim($encoding)) > 0) ? trim($encoding) : 'UTF-8');
        }
    }

    public function setAbout($about = '')
    {
        if (!isset($this->about) && strlen(trim($about)) > 0) {
            $this->about = trim($about);
        }
    }

    public function setTitle($title = '')
    {
        if (!isset($this->title) && strlen(trim($title)) > 0) {
            $this->title = trim($title);
        }
    }

    public function setDescription($description = '')
    {
        if (!isset($this->description) && strlen(trim($description)) > 0) {
            $this->description = trim($description);
        }
    }

    public function setPublisher($publisher = '')
    {
        if (!isset($this->publisher) && strlen(trim($publisher)) > 0) {
            $this->publisher = trim($publisher);
        }
    }

    public function setCreator($creator = '')
    {
        if (!isset($this->creator) && strlen(trim($creator)) > 0) {
            $this->creator = trim($creator);
        }
    }

    public function setDate($date = '')
    {
        if (!isset($this->date) && strlen(trim($date)) > 0) {
            $this->date = trim($date);
        }
    }

    public function setLanguage($language = '')
    {
        if (!isset($this->language) && $this->isValidLanguageCode($language) === true) {
            $this->language = trim($language);
        }
    }

    private function isValidLanguageCode($code = ''): bool
    {
        return (preg_match('(^([a-zA-Z]{2})$)', $code) > 0) ? true : false;
    }

    public function setRights($rights = '')
    {
        if (!isset($this->rights) && strlen(trim($rights)) > 0) {
            $this->rights = trim($rights);
        }
    }

    public function setCoverage($coverage = '')
    {
        if (!isset($this->coverage) && strlen(trim($coverage)) > 0) {
            $this->coverage = trim($coverage);
        }
    }

    public function setContributor($contributor = '')
    {
        if (!isset($this->contributor) && strlen(trim($contributor)) > 0) {
            $this->contributor = trim($contributor);
        }
    }

    public function setImageLink($image_link = '')
    {
        if (!isset($this->image_link) && strlen(trim($image_link)) > 0) {
            $this->image_link = trim($image_link);
        }
    }

    public function setPeriod($period = '')
    {
        if (!isset($this->period) && strlen(trim($period)) > 0) {
            switch ($period) {
                case 'hourly':
                case 'daily':
                case 'weekly':
                case 'monthly':
                case 'yearly':
                    $this->period = trim($period);
                    break;
                default:
                    $this->period = '';
                    break;
            }
        }
    }

    public function setFrequency($frequency = '')
    {
        if (!isset($this->frequency) && strlen(trim($frequency)) > 0) {
            $this->frequency = (int)$frequency;
        }
    }

    public function setBase($base = '')
    {
        if (!isset($this->base) && strlen(trim($base)) > 0) {
            $this->base = trim($base);
        }
    }

    public function setCategory($category = '')
    {
        if (strlen(trim($category)) > 0) {
            $this->category = trim($category);
        }
    }

    public function setCache($cache = '')
    {
        if (strlen(trim($cache)) > 0) {
            $this->cache = (int)$cache;
        }
    }

    public function getEncoding(): string
    {
        return $this->encoding;
    }

    public function getAbout(): string
    {
        return $this->about;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getPublisher(): string
    {
        return $this->publisher;
    }

    /**
     * @return string
     */
    public function getCreator(): string
    {
        return $this->creator;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getRights(): string
    {
        return $this->rights;
    }

    /**
     * @return string
     */
    public function getImageLink(): string
    {
        return $this->image_link;
    }

    /**
     * @return string
     */
    public function getCoverage(): string
    {
        return $this->coverage;
    }

    /**
     * @return string
     */
    public function getContributor(): string
    {
        return $this->contributor;
    }

    /**
     * @return string
     */
    public function getPeriod(): string
    {
        return $this->period;
    }

    /**
     * @return int
     */
    public function getFrequency(): int
    {
        return $this->frequency;
    }

    /**
     * @return string
     */
    public function getBase(): string
    {
        return $this->base;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @return int
     */
    public function getCache(): int
    {
        return $this->cache;
    }

    /**
     * @param string $about
     * @param string $title
     * @param string $link
     * @param string $description
     * @param string $subject
     * @param string $date
     * @param string $author
     * @param string $comments
     */
    public function addItem(
        $about = '',
        $title = '',
        $link = '',
        $description = '',
        $subject = '',
        $date = '',
        $author = '',
        $comments = ''
    ) {
        $item = new RSSItem(
            $about,
            $title,
            $link,
            $description,
            $subject,
            $date,
            $author = '',
            $comments = ''
        );
        $this->items[] = $item;
    }

    public function deleteItem($id = -1)
    {
        if (array_key_exists($id, $this->items)) {
            unset($this->items[$id]);

            return (boolean)true;
        } else {
            return (boolean)false;
        }
    }

    public function getItemList(): array
    {
        return array_keys($this->items);
    }

    public function getItems(): array
    {
        return $this->items;
    }

    function getItem($id = -1)
    {
        if (array_key_exists($id, $this->items)) {
            return $this->items[$id];
        } else {
            return false;
        }
    }

    private function createOutputV090()
    {
        // not implemented
        $this->createOutputV100();
    }

    private function createOutputV091()
    {
        $this->output = '<!DOCTYPE rss SYSTEM "http://my.netscape.com/publish/formats/rss-0.91.dtd">'."\n";
        $this->output .= '<rss version="0.91">'."\n";
        $this->output .= '<channel>'."\n";

        if (strlen($this->rights) > 0) {
            $this->output .= '<copyright>'.$this->rights.'</copyright>'."\n";
        }

        if (strlen($this->date) > 0) {
            $this->output .= '<pubDate>'.$this->date.'</pubDate>'."\n";
            $this->output .= '<lastBuildDate>'.$this->date.'</lastBuildDate>'."\n";
        }

        if (strlen($this->about) > 0) {
            $this->output .= '<docs>'.$this->about.'</docs>'."\n";
        }

        if (strlen($this->description) > 0) {
            $this->output .= '<description>'.$this->description.'</description>'."\n";
        }

        if (strlen($this->about) > 0) {
            $this->output .= '<link>'.$this->about.'</link>'."\n";
        }

        if (strlen($this->title) > 0) {
            $this->output .= '<title>'.$this->title.'</title>'."\n";
        }

        if (strlen($this->image_link) > 0) {
            $this->output .= '<image>'."\n";
            $this->output .= '<title>'.$this->title.'</title>'."\n";
            $this->output .= '<url>'.$this->image_link.'</url>'."\n";
            $this->output .= '<link>'.$this->about.'</link>'."\n";
            if (strlen($this->description) > 0) {
                $this->output .= '<description>'.$this->description.'</description>'."\n";
            }
            $this->output .= '</image>'."\n";
        }

        if (strlen($this->publisher) > 0) {
            $this->output .= '<managingEditor>'.$this->publisher.'</managingEditor>'."\n";
        }

        if (strlen($this->creator) > 0) {
            $this->output .= '<webMaster>'.$this->creator.'</webMaster>'."\n";
        }

        if (strlen($this->language) > 0) {
            $this->output .= '<language>'.$this->language.'</language>'."\n";
        }

        if (count($this->getItemList()) > 0) {
            foreach ($this->getItemList() AS $id) {
                $item =& $this->items[$id];

                if (strlen($item->getTitle()) > 0 && strlen($item->getLink()) > 0) {
                    $this->output .= '<item>'."\n";
                    $this->output .= '<title>'.$item->getTitle().'</title>'."\n";
                    $this->output .= '<link>'.$item->getLink().'</link>'."\n";
                    if (strlen($item->getDescription()) > 0) {
                        $this->output .= '<description>'.$item->getDescription().'</description>'."\n";
                    }
                    $this->output .= '</item>'."\n";
                }
            }
        }

        $this->output .= '</channel>'."\n";
        $this->output .= '</rss>'."\n";
    }

    private function createOutputV100()
    {
        $this->output = '<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" ';

        if ($this->use_dc_data === true) {
            $this->output .= 'xmlns:dc="http://purl.org/dc/elements/1.1/" ';
        }

        if ($this->use_sy_data === true) {
            $this->output .= 'xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" ';
        }

        $this->output .= 'xmlns="http://purl.org/rss/1.0/">'."\n";

        if (strlen($this->about) > 0) {
            $this->output .= '<channel rdf:about="'.$this->about.'">'."\n";
        } else {
            $this->output .= '<channel>'."\n";
        }

        if (strlen($this->title) > 0) {
            $this->output .= '<title>'.$this->title.'</title>'."\n";
        }

        if (strlen($this->about) > 0) {
            $this->output .= '</rdf:Seq></items>'."\n";
        }
        $this->output .= '</channel>'."\n";

        if (count($this->getItemList()) > 0) {
            foreach ($this->getItemList() as $id) {
                $item =& $this->items[$id];

                if (strlen($item->getTitle()) > 0 && strlen($item->getLink()) > 0) {
                    if (strlen($item->getAbout()) > 0) {
                        $this->output .= '<item rdf:about="'.$item->getAbout().'">'."\n";
                    } else {
                        $this->output .= '<item>'."\n";
                    }

                    $this->output .= '<title>'.$item->getTitle().'</title>'."\n";
                    $this->output .= '<link>'.$item->getLink().'</link>'."\n";

                    if (strlen($item->getDescription()) > 0) {
                        $this->output .= '<description>'.$item->getDescription().'</description>'."\n";
                    }

                    if ($this->use_dc_data === true && strlen($item->getSubject()) > 0) {
                        $this->output .= '<dc:subject>'.$item->getSubject().'</dc:subject>'."\n";
                    }

                    if ($this->use_dc_data === true && strlen($item->getDate()) > 0) {
                        $this->output .= '<dc:date>'.$item->getDate().'</dc:date>'."\n";
                    }

                    $this->output .= '</item>'."\n";
                }
            }
        }

        $this->output .= '</rdf:RDF>';
    }

    private function createOutputV200()
    {
        // not implemented
        $this->createOutputV100();
        //---------------------
        $this->output = '<rss version="2.0">'."\n";
        $this->output .= '<channel>'."\n";

        if (strlen($this->rights) > 0) {
            $this->output .= '<copyright>'.$this->rights.'</copyright>'."\n";
        }

        if (strlen($this->date) > 0) {
            $this->output .= '<pubDate>'.$this->date.'</pubDate>'."\n";
        }

        if (strlen($this->about) > 0) {
            $this->output .= '<docs>'.$this->about.'</docs>'."\n";
        }

        if (strlen($this->description) > 0) {
            $this->output .= '<description>'.$this->description.'</description>'."\n";
        }

        if (strlen($this->about) > 0) {
            $this->output .= '<link>'.$this->about.'</link>'."\n";
        }

        if (strlen($this->title) > 0) {
            $this->output .= '<title>'.$this->title.'</title>'."\n";
        }

        if (strlen($this->image_link) > 0) {
            $this->output .= '<image>'."\n";
            $this->output .= '<title>'.$this->title.'</title>'."\n";
            $this->output .= '<url>'.$this->image_link.'</url>'."\n";
            $this->output .= '<link>'.$this->about.'</link>'."\n";
            if (strlen($this->description) > 0) {
                $this->output .= '<description>'.$this->description.'</description>'."\n";
            }
            $this->output .= '</image>'."\n";
        }

        if (strlen($this->publisher) > 0) {
            $this->output .= '<managingEditor>'.$this->publisher.'</managingEditor>'."\n";
        }

        if (strlen($this->creator) > 0) {
            $this->output .= '<generator>'.$this->creator.'</generator>'."\n";
        }

        if (strlen($this->language) > 0) {
            $this->output .= '<language>'.$this->language.'</language>'."\n";
        }

        if (strlen($this->category) > 0) {
            $this->output .= '<category>'.$this->category.'</category>'."\n";
        }

        if (strlen($this->cache) > 0) {
            $this->output .= '<ttl>'.$this->cache.'</ttl>'."\n";
        }

        if (count($this->getItemList()) > 0) {
            foreach ($this->getItemList() as $id) {
                $item =& $this->items[$id];

                if (strlen($item->getTitle()) > 0 && strlen($item->getLink()) > 0) {
                    $this->output .= '<item>'."\n";
                    $this->output .= '<title>'.$item->getTitle().'</title>'."\n";
                    $this->output .= '<link>'.$item->getLink().'</link>'."\n";

                    if (strlen($item->getDescription()) > 0) {
                        $this->output .= '<description>'.$item->getDescription().'</description>'."\n";
                    }

                    if ($this->use_dc_data === true && strlen($item->getSubject()) > 0) {
                        $this->output .= '<category>'.$item->getSubject().'</category>'."\n";
                    }

                    if ($this->use_dc_data === true && strlen($item->getDate()) > 0) {
                        $this->output .= '<pubDate>'.$item->getDate().'</pubDate>'."\n";
                    }

                    if (strlen($item->getAbout()) > 0) {
                        $this->output .= '<guid>'.$item->getAbout().'</guid>'."\n";
                    }

                    if (strlen($item->getAuthor()) > 0) {
                        $this->output .= '<author>'.$item->getAuthor().'</author>'."\n";
                    }

                    if (strlen($item->getComments()) > 0) {
                        $this->output .= '<comments>'.$item->getComments().'</comments>'."\n";
                    }

                    $this->output .= '</item>'."\n";
                }
            }
        }

        $this->output .= '</channel>'."\n";
        $this->output .= '</rss>'."\n";
    }

    /**
     * @param string $version
     */
    private function createOutput($version = '')
    {
        if (strlen(trim($version)) === 0) {
            $version = '1.0';
        }

        switch ($version) {
            case '0.9':
                $this->createOutputV090();
                break;
            case '0.91':
                $this->createOutputV091();
                break;
            case '2.00':
                $this->createOutputV200();
                break;
            case '1.0':
            default:
                $this->createOutputV100();
                break;
        }
    }

    /**
     * @param string $version
     * @return string
     */
    public function getRSSOutput($version = '')
    {
        if (!isset($this->output)) {
            $this->createOutput($version);
        }

        return '<'.'?xml version="1.0" encoding="'.$this->encoding.'"?'.'>'."\n".
            '<!--  RSS generated by Cheukpang (http://www.zhuopeng-it.com) ['.date(
                'Y-m-d H:i:s'
            ).']  -->'."\n".$this->output;
    }

}