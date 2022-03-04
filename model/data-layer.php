<?php

/**
 *accses datalayer needed for dating app
 */
class DataLayer
{


    /**
     * @return string[]
     */
    static function getIndoor()
    {
        return array('tv', 'puzzles', 'movies', 'reading', 'cooking', 'playing cards', 'board games', 'video games');
    }

    /**
     * @return string[]
     */
    static function getOutdoor()
    {
        return array('hiking', 'walking', 'biking', 'climbing', 'swimming', 'collecting');
    }
}
