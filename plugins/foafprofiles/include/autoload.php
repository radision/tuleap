<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
function autoloadbdd1c5d062c5d2da55f0f7c1dfea26fd($class) {
    static $classes = null;
    if ($classes === null) {
        $classes = array(
            'foafprofilesplugin' => '/foafprofilesPlugin.class.php'
        );
    }
    $cn = strtolower($class);
    if (isset($classes[$cn])) {
        require dirname(__FILE__) . $classes[$cn];
    }
}
spl_autoload_register('autoloadbdd1c5d062c5d2da55f0f7c1dfea26fd');
// @codeCoverageIgnoreEnd