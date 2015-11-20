<?php

namespace Zf2AdvancedCourse;

class Rot13
{
    /**
     * Encode a message via rot13
     * 
     * @param  string $message 
     * @return string
     */
    public function encode($message)
    {
        return str_rot13($message);
    }

    /**
     * "Decode" a rot13 message
     * 
     * @param  string $message 
     * @return string
     */
    public function decode($message)
    {
        return str_rot13($message);
    }
}
