<?php

class Make
{
    public static function Hash($pass)
    {
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    public static function Verify($pass, $hash)
    {
        if (password_verify($pass, $hash)) {
            return true;
        }
        return false;
    }
}