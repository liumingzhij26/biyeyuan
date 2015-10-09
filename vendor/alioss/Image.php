<?php
namespace alioss;

class Image
{

    static public $instance;

    /**
     * @return Image
     */
    static public function Instance()
    {
        $class = get_called_class();
        if (empty(self::$instance[$class])) {
            self::$instance[$class] = new $class();
        }
        return self::$instance[$class];
    }


}
