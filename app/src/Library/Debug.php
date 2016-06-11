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
 * @example (new \Skeleton\Library\Debug($param))->setJsonFormat(true)->displayScreen();
 * 
 * @author Renato Rodrigues de Araujo <renato.r.araujo@gmail.com>
 * @version 1.2.0
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
        
        return $this;
    }

    /**
     * Method to define the path to log
     * @param string $path
     */
    public function setLogPath($path)
    {
        $this->logPath = $path;
        return $this;
    }

    /**
     * Method to define the name of log
     * @param string $name
     */
    public function setLogName($name)
    {
        $this->logName = $name;
        return $this;
    }

    /**
     * Method to define the json format for the output
     * @param boolean $jsonFormat
     */
    public function setJsonFormat()
    {
        $this->jsonFormat = true;
        return $this;
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
    public function displayScreen($endApplication = true)
    {
        if($this->jsonFormat) {
            $this->display .= "<pre>{$this->convertToJson(true)}</pre>";
        } else {
            foreach ($this->arr_arguments as $key => $value) {
                $this->display .= '<br/><br/><b style="color:red;">Argument ' . ($key + 1) . '</b><br />';
                $this->display .= '<pre>' . $this->bufferDump($value) . '</pre>';
            }
        }
        
        if($endApplication) {
            $display = die($this->display);
        } else {
            $display = $this->display;
        }
        
        return $display;
    }
    
    public function displayTerminal()
    {

        $this->display .= "\n";
        
        foreach ($this->arr_arguments as $key => $value) {
            $this->display .= $this->bufferDump($value);
        }
        
        return die($this->display);
    }
    
    /**
     * Method to convert the result of debug as Json
     * @param boolean $pretty To print in pretty format or not
     * @return string Json formatted string
     */
    protected function convertToJson($pretty = false)
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
    protected function bufferDump($dump)
    {
        ob_start();
        var_dump($dump);
        $dumpContent = ob_get_contents();
        ob_end_clean();
        
        return $dumpContent;
    }
}