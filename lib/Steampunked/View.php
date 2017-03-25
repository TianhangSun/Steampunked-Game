<?php
namespace Steampunked;

/**
 * Base class for all views
 */
class View {

    /**
     * Create the HTML for the page header
     * @return string HTML for the standard page header
     */
    public function header() {
        $html = <<<HTML
<nav>
    <ul class="left">
        <li><a href="./">Steampunked Game</a></li>
</ul>
HTML;

        if(count($this->links) > 0) {
            $html .= '<ul class="right">';
            foreach($this->links as $link) {
                $html .= '<li><a href="' .
                    $link['href'] . '">' .
                    $link['text'] . '</a></li>';
            }
            $html .= '</ul>';
        }
        $additional = $this->headerAdditional();
        $html .= <<<HTML
</nav>
<header class="main">
    <h1>$this->title</h1>
        $additional
    </header>
HTML;
        return $html;
    }

    /**
     * Create the HTML for the page footer
     * @return string HTML for the standard page footer
     */


    /**
     * Create the HTML for the contents of the head tag
     * @return string HTML for the page head
     */
    public function head() {
        return <<<HTML
<meta charset="utf-8">
<title>$this->title</title>
<link href="lib/css/main-css.less" type="text/css" rel="stylesheet" />
    <meta charset="UTF-8">
HTML;
    }

    /**
     * Set the page title
     * @param $title New page title
     */
    public function setTitle($title) {
        $this->title = $title;
    }
    /**
     * Add a link that will appear on the nav bar
     * @param $href What to link to
     * @param $text
     */
    public function addLink($href, $text) {
        $this->links[] = array("href" => $href, "text" => $text);
    }
    /**
     * Add content to the header
     * @return string Any additional comment to put in the header
     */
    /**
     * Override in derived class to add content to the header.
     * @return string Any additional comment to put in the header
     */
    protected function headerAdditional() {
        return '';
    }
    /**
     * Protect a page for staff only access
     *
     * If access is denied, call getProtectRedirect
     * for the redirect page
     * @param $site The Site object
     * @param $user The current User object
     * @return bool true if page is accessible
     */
    public function protect($site, $user) {

        if($user === null) {
            $this->protectRedirect = $site->getRoot() . "/";
            return false;

        }
        else {
            if ($user->getRole() == 'A') {
                return true;
            } else {
                //    $this->protectRedirect = $site->getRoot() . "/";
                //  echo $user->isGamer();
                $this->protectRedirect = $site->getRoot() . "/";
                return false;
            }
        }

      // $this->protectRedirect = $site->getRoot() . "/";
        //return false;
    }
    public function getCurrentUserId($site,$id,$user)

    {
        if($user==null)
        {
            $this->protectRedirect = $site->getRoot() . "/";
            return false;
        }
            if ($user->getId() == $id || $user->getRole() == 'A') {
                return true;

            }
        else {
            $this->protectRedirect = $site->getRoot() . "/";
            return false;
        }
    }

    /**
     * Get any redirect page
     */
    public function getProtectRedirect() {
        return $this->protectRedirect;
    }

    /// Page protection redirect
    private $protectRedirect = null;
    private $title = "";	///< The page title
    private $links = array();	///< Links to add to the nav bar
}