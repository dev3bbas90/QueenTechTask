<?php
class file{
    private $file;
    private $start;
    private $paginate;
    public function __construct($file , $start , $paginate)
    {
        $this->file = $file;
        $this->start    =   $start ;
        $this->paginate =   $paginate   ??  10;
    }

    public function get_file_lines()
    {
        $start      =   $this->start;
        $paginate   =   $this->paginate ??  10;
        $file       =   dirname(__DIR__) . '/' . $this->file;

        // check if File Exsists 
        if(!$this->file || !file_exists( $file ) )
            return [
                'status'    => 'error',
                'code'      => '404',
                'message'   => "Sorry, File Not Found !!",
            ];
        $lines          =   file($file);   //file in to an array
        $lines_count    =   count($lines);

        $last_index     =   ($lines_count - $lines_count % $paginate) + 1;
        $start          =   $start >= 1 ? $start : 1;
        $start          =   $start < $lines_count ? $start : $last_index;
        
        $result         =   array_splice( $lines , $start - 1 , $paginate );
        // $result         =   implode('<br>' , $result);
        
        $max_line       =   $start + $paginate;
        $max_line       =   $max_line <= $lines_count ? $max_line : $lines_count;

        return [
            'start'     =>  $max_line,
            'previous'  =>  $start - $paginate >= 1 ? $start - $paginate : 0 ,
            'next'      =>  $max_line,
            'end'       =>  $last_index,
            'total'     =>  $lines_count,
            'status'    =>  'success',
            'code'      =>  '200',
            'data'      =>  $result ,
        ];
    }
}

callFileObject();
function callFileObject()
{
    $file = new file($_REQUEST['file'] , $_REQUEST['start'] , $_REQUEST['paginate']);
    echo json_encode($file->get_file_lines()) ;
    
}