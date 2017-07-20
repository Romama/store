<?php

class Logger
{
	const L_ALL = 0;

	const L_DEBUG = 1;

	const L_TRACE = 2;

	const L_INFO = 3;

	const L_NOTICE = 4;

	const L_WARNING = 5;

	const L_FATAL = 6;

	private static $ARR_DESC = array (0 => 'ALL', 1 => 'DEBUG', 2 => 'TRACE', 3 => 'INFO',
			4 => 'NOTICE', 5 => 'WARNING', 6 => 'FATAL' );

	private static $LOG_LEVEL = self::L_DEBUG;

	private static $ARR_BASIC = array ();

	private static $FILE = array ();

	private static $FORCE_FLUSH = true;
	
	private static $OS_CL = "<br>\n";

    private static $LOG_TO_SERVER = true;

    private static $BUCK;

    private static $KEY;

	public static function flush()
	{

		foreach ( self::$FILE as $file )
		{
			fflush ( $file );
		}
	}

	public static function addBasic($key, $value)
	{

		self::$ARR_BASIC [$key] = $value;
	}

	public static function s3Init($bucket, $key, $level, $arrBasic = null, $forceFlush = false)
	{
        self::$LOG_TO_SERVER = true;

		if (! isset ( self::$ARR_DESC [$level] ))
		{
			trigger_error ( "invalid level:$level" );
			return;
		}

        self::$LOG_LEVEL = $level;
        self::$BUCK = $bucket;
        self::$KEY = $key;

		if (! empty ( $arrBasic ))
		{
			self::$ARR_BASIC = $arrBasic;
		}

		self::$FORCE_FLUSH = $forceFlush;
	}

	public static function localInit($filename, $level, $arrBasic = null, $forceFlush = false, $os=0)
    {
        self::$LOG_TO_SERVER = false;
        if (! isset ( self::$ARR_DESC [$level] ))
        {
            trigger_error ( "invalid level:$level" );
            return;
        }
        if($os==1){
            self::$OS_CL='\r';
        }
        self::$LOG_LEVEL = $level;
        $dir = dirname ( $filename );
        if (! file_exists ( $dir ))
        {
            if (! mkdir ( $dir, 0755, true ))
            {
                trigger_error ( "create log file $filename failed, no permmission" );
                return;
            }
        }
        self::$FILE [0] = fopen ( $filename, 'a+' );
        if (empty ( self::$FILE [0] ))
        {
            trigger_error ( "create log file $filename failed, no disk space for permission" );
            self::$FILE = array ();
            return;
        }
        self::$FILE [1] = fopen ( $filename . '.wf', 'a+' );
        if (empty ( self::$FILE [1] ))
        {
            trigger_error ( "create log file $filename.wf failed, no disk space for permission" );
            self::$FILE = array ();
            return;
        }

        if (! empty ( $arrBasic ))
        {
            self::$ARR_BASIC = $arrBasic;
        }

        self::$FORCE_FLUSH = $forceFlush;
    }

	private static function checkPrintable(&$data, $key)
	{

		if (! is_string ( $data ))
		{
			return;
		}

		if (preg_match ( '/[\x00-\x08\x0B\x0C\x0E-\x1F\x80-\xFF]/', $data ))
		{
			$data = base64_encode ( $data );
		}
	}

    public static function showLog()
    {
        $s3 = Phalcon\DI::getDefault()->get('s3');
        $fileName = 's3://' . self::$BUCK . '/' . self::$KEY;
        if ($stream = fopen($fileName, 'r')) {
            // While the stream is still open
            while (!feof($stream)) {
                // Read 1024 bytes from the stream
                echo fread($stream, 1024);
            }
            // Be sure to close the stream resource when you're done with it
            fclose($stream);
        } else {
            echo "Open s3 log file error";
        }

    }

	private static function log($level, $arrArg)
    {
        date_default_timezone_set('Asia/Chongqing');

        if ($level < self::$LOG_LEVEL || empty ($arrArg)) {
            return;
        }

        $arrMicro = explode(" ", microtime());
        $content = '[' . date('Ymd H:i:s ');
        $content .= sprintf("%06d", intval(1000000 * $arrMicro [0]));
        $content .= '][';
        $content .= self::$ARR_DESC [$level];
        $content .= "]";
        foreach (self::$ARR_BASIC as $key => $value) {
            $content .= "[$key:$value]";
        }

        $arrTrace = debug_backtrace();
        if (isset ($arrTrace [1])) {
            $line = $arrTrace [1] ['line'];
            $file = $arrTrace [1] ['file'];
            $content .= "[$file:$line]";
        }

        foreach ($arrArg as $idx => $arg) {

            if (is_array($arg)) {
                array_walk_recursive($arg, array('Logger', 'checkPrintable'));

                $data = var_export($arg, true);

                $arrArg [$idx] = $data;
            }
        }
        $content .= call_user_func_array('sprintf', $arrArg);
        $content .= self::$OS_CL;

        if(self::$LOG_TO_SERVER){
            $s3= Phalcon\DI::getDefault()->get('s3');
            $fileName = 's3://'.self::$BUCK.'/'.self::$KEY;

            if (file_exists($fileName)) {
                $file = fopen($fileName, 'a');
                fputs($file, $content);
                if (self::$FORCE_FLUSH) {
                    fflush($file);
                }
                fclose($file);
            }
        }else{
            $file = self::$FILE [0];
            fputs ( $file, $content );
            if (self::$FORCE_FLUSH)
            {
                fflush ( $file );
            }

            if ($level <= self::L_NOTICE)
            {
                return;
            }

            $file = self::$FILE [1];
            fputs ( $file, $content );
            if (self::$FORCE_FLUSH)
            {
                fflush ( $file );
            }
        }

    }

	public static function debug()
	{

		$arrArg = func_get_args ();
		self::log ( self::L_DEBUG, $arrArg );
	}

	public static function trace()
	{

		$arrArg = func_get_args ();
		self::log ( self::L_TRACE, $arrArg );
	}

	public static function info()
	{

		$arrArg = func_get_args ();
		self::log ( self::L_INFO, $arrArg );
	}

	public static function notice()
	{

		$arrArg = func_get_args ();
		self::log ( self::L_NOTICE, $arrArg );
	}

	public static function warning()
	{

		$arrArg = func_get_args ();
		self::log ( self::L_WARNING, $arrArg );
	}

	public static function fatal()
	{

		$arrArg = func_get_args ();
		self::log ( self::L_FATAL, $arrArg );
	}
}
/* vim: set ts=4 sw=4 sts=4 tw=100 noet: */
