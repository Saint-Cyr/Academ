<?php
// Fungus/ShortyBundle/Helper/CSVTypes.php
namespace AppBundle\Helper;

class CSVTypes {
    const RAETSEL             = 1;
    const SPRUECHE            = 2;

    public static function getTypes() {
        return array(
                self::RAETSEL            => 'Student',
                //self::SPRUECHE          => 'Sprueche',

        );
    }

    public static function getTypesAndIds() {
        $all=self::getTypes();
        $return=array();
        foreach($all as $key=>$value) {
            $return[]=array("id"=>$key,"title"=>$value);
        }
        return $return;
    }

    public static function getNameOfType($type) {
        $allTypes=self::getTypes();
        if (isset($allTypes[$type])) return $allTypes[$type];
        return " - Unknown Type -";
    }

    public static function getEntityClass($type) {
        switch ($type) {
            case self::RAETSEL:         return "AppBundle:Student";
            case self::SPRUECHE:        return "AppBundle:Spruch";
            default: return false;
        }
    }

    public static function existsType($type) {
        $allTypes=self::getTypes();
        if (isset($allTypes[$type])) return true;
        return false;
    }

}