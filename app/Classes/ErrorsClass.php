<?php
namespace App\Classes;
use DB;
use Auth;
class ErrorsClass
{

    protected $table;
    protected $connection;

    public function __construct()
    {
        $this->table      = env('DB_LOG_TABLE', 'errorlog');
        $this->connection = env('DB_LOG_CONNECTION', env('DB_CONNECTION', 'mysql'));
    }  

    public function getErrors() {
        return false;
    }

    public function saveErrors($e) {

        $data = [
            'error_message'    => $e->getMessage(),
            'line_number'     => $e->getLine(),
            'file_name'     => $e->getFile(),
            'browser'       => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null,
            'operating_system'  => isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : null,
            'loggedin_id'     => Auth::id() > 0 ? Auth::id() : null,
            'ip_address' => isset($_SERVER['REMOTE_ADDR']) ? ip2long($_SERVER['REMOTE_ADDR']) : null,
            'created_at'  => date('Y-m-d H:i:s')
        ];

        DB::connection($this->connection)->table($this->table)->insert($data);
    }

}
