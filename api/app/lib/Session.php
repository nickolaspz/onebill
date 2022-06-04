<?php

class Session
{
    var $Session;

    public function __construct()
    {
        session_start();
        $this->Session = $_SESSION;
    }

    public function write($key, $val)
    {
        $insertArray = $this->_createInsertArray($key, $val);
        $_SESSION = array_replace_recursive($_SESSION, $insertArray);
        $this->Session = $_SESSION;
    }

    public function read($key)
    {
        if ($key == null) {
            return $this->_getEntireSession();
        }

        $path = $this->_createInsertArray($key);
        return $this->recursive_array_intersect_key($_SESSION, $path);

        // return (isset($_SESSION[$key])) ? $_SESSION[$key] : false;
    }

    public function recursive_array_intersect_key(array $array1, array $array2) {
        $array1 = array_intersect_key($array1, $array2);
        foreach ($array1 as $key => &$value) {
            if (is_array($value) && is_array($array2[$key])) {
                $value = $this->recursive_array_intersect_key($value, $array2[$key]);
            }
        }
        return $array1;
    }

    public function delete($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            $this->Session = $_SESSION;
            return true;
        }
        return false;
    }

    public function destroy()
    {
        return session_destroy();
    }

    private function _createInsertArray($keys, $val = null)
    {
        $keys = explode('.', $keys);
        $lastKey = end($keys);
        $firstKey = $keys[0];

        if ($firstKey == $lastKey) {
            $array[$firstKey] = $val;
            return $array;
        }

        unset($keys[0]);

        $b = array();
        $c =& $b;

        foreach ($keys as $key) {
            if ($key == $lastKey) {
                $c[$key] = $val;
            } else {
                $c[$key] = array();
            }
            $c =& $c[$key];
        }

        $array[$firstKey] = $b;
        return $array;
    }

    private function _getEntireSession()
    {
        $session = [];
        foreach ($_SESSION as $key => $val) {
            $session[$key] = $val;
        }
        return $session;
    }
}
