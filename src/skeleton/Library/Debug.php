<?php
namespace Skeleton\Library;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Debug object to use for logging or debug on screen the application
 * 
 * @namespace Skeleton\Library
 * 
 * @uses Monolog\Logger
 * @uses Monolog\Handler\StreamHandler
 * 
 * @author Renato Rodrigues de Araujo <renato.r.araujo@gmail.com>
 * @version 1.0.0
 *
 */
class Debug
{

    protected $display;

    protected $logPath;

    protected $logName;

    protected $arr_arguments = [];

    protected $jsonFormat = false;

    /**
     * Constructor method of debug.
     * @example new Debug($params, $param, $par
     */
    public function __construct()
    {
        $backtrace = debug_backtrace();
        $path = array_shift($backtrace);
        
        $this->display = "{$path['file']} on line {$path['line']} ";
        
        $this->arr_arguments = $path['args'];
    }

    /**
     * Method to define the path to log
     * @param string $path
     */
    public function setLogPath($path)
    {
        $this->logPath = $path;
    }

    /**
     * Method to define the name of log
     * @param string $name
     */
    public function setLogName($name)
    {
        $this->logName = $name;
    }

    /**
     * Method to define the json format for the output
     * @param boolean $jsonFormat
     */
    public function setJsonFormat($jsonFormat)
    {
        $this->jsonFormat = $jsonFormat;
    }

    /**
     * Method to save in log the debug content 
     * @return \Monolog\Boolean
     */
    public function displayLog()
    {
        $this->display .= $this->convertToJson();
        
        $log = new Logger($this->logName);
        $log->pushHandler(new StreamHandler($this->logPath));
        return $log->debug($this->display);
    }

    /**
     * Method to display the debug content on screen
     */
    public function displayScreen()
    {
        if($this->jsonFormat) {
            $this->display .= "<pre>{$this->convertToJson(true)}</pre>";
        } else {
            foreach ($this->arr_arguments as $key => $value) {
                $this->display .= '<br/><br/><b style="color:red;">Argument ' . ($key + 1) . '</b><br />';
                $this->display .= '<pre>' . $this->bufferDump($value) . '</pre>';
            }
        }
        
        return die($this->display);
    }
    
    /**
     * Method to convert the result of debug as Json
     * @param boolean $pretty To print in pretty format or not
     * @return string Json formatted string
     */
    public function convertToJson($pretty = false)
    {
        $arr_json = [];
        foreach ($this->arr_arguments as $key => $value) {
            array_push($arr_json, [
                "Argument " . ($key + 1) => $value
            ]);
        }
        
        return json_encode($arr_json, ((!$pretty) ?: JSON_PRETTY_PRINT));
    }

    /**
     * Method to buffer the dump to print only when display function get called
     * @param mixed $dump Type to buffer
     * @return string
     */
    public function bufferDump($dump)
    {
        ob_start();
        var_dump($dump);
        $dumpContent = ob_get_contents();
        ob_end_clean();
        
        return $dumpContent;
    }
}