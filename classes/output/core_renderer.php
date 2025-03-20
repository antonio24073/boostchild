<?php


class theme_boostchild_core_renderer extends core_renderer {

    /**
     * Fix to missing firstview_fakeblocks() function
     * https://moodle.org/mod/forum/discuss.php?d=434718
     * @return bool
     */
    public function firstview_fakeblocks(): bool {
        global $SESSION;
        $firstview = false;
        if ($this->page->cm) {
            if (!$this->page->blocks->region_has_fakeblocks('side-pre')) {
                return false;
            }
            if (!property_exists($SESSION, 'firstview_fakeblocks')) {
                $SESSION->firstview_fakeblocks = [];
            }
            if (array_key_exists($this->page->cm->id, $SESSION->firstview_fakeblocks)) {
                $firstview = false;
            } else {
                $SESSION->firstview_fakeblocks[$this->page->cm->id] = true;
                $firstview = true;
                if (count($SESSION->firstview_fakeblocks) > 100) {
                    array_shift($SESSION->firstview_fakeblocks);
                }
            }
        }
        return $firstview;

    }

    // /**
    //  * Outputs a heading
    //  * @param string $text The text of the heading
    //  * @param int $level The level of importance of the heading. Defaulting to 2
    //  * @param string $classes A space-separated list of CSS classes
    //  * @param string $id An optional ID
    //  * @return string the HTML to output.
    //  */
    public function heading($text, $level = 2, $classes = 'main', $id = null) {
        $content  = html_writer::start_tag('div', array('class'=>'headingcontainer'));
        $content .= html_writer::tag('div', 'I am some content to override the renderer', array('class'=>'blah'));
        $content .= parent::heading($text, $level, $classes, $id);
        $content .= html_writer::end_tag('div');
        return $content;
    }
}
require_once(__DIR__.'/core_course_renderer.php');


