<?php
require_once 'Framework/Model.php';

/**
 * Class defining the Unit model
 *
 * @author Sylvain Prigent
 */
class StUploader extends Model {
	
	/**
	 * get directory files
	 *
	 * @param string $dir
	 *        	directory to explore
	 * @return multitype: array
	 */
	public function getFiles($dir) {
		
		$files = array ();
		
		if (is_dir ( $dir )) {	
			$filesdir = scandir ( $dir );
			$i = 0;
			foreach ( $filesdir as $file ) {
				if ($file != "." && $file != ".." && ! is_dir ( $dir . "/" . $file )) {
					$files [$i] ["name"] = $file;
					$fp = fopen ( $dir . "/" . $file, "r" );
					$files [$i] ["size"] = $this->formatFileSize ( $this->my_filesize ( $fp ) );
					fclose ( $fp );
					$files [$i] ["mtime"] = filemtime($dir . "/" . $file);
					$i ++;
				}
			}
		}
		return $files;
	}
	public function getUsage($userdir) {
		$filesdir = scandir ( $userdir );
		
		$usage = 0;
		foreach ( $filesdir as $file ) {
			if ($file != "." && $file != ".." && ! is_dir ( $userdir . "/" . $file )) {
				$fp = fopen ( $userdir . "/" . $file, "r" );
				$usage += $this->my_filesize ( $fp );
				fclose ( $fp );
			}
		}
		
		return $usage;
	}
	public function outputFile($file, $name, $mime_type = '') {
		$fileChunkSize = 1024 * 30;
		
		// echo "file = " . $file . "<br/>";
		
		if (! is_readable ( $file ))
			die ( 'File not found or inaccessible!' );
		
		$fp = fopen ( $file, "rb" );
		$size = $this->my_filesize ( $fp );
		fclose ( $fp );
		// echo "file size = " . $size . "-<br/>";
		$name = rawurldecode ( $name );
		// return;
		
		$known_mime_types = array (
				"pdf" => "application/pdf",
				"txt" => "text/plain",
				"html" => "text/html",
				"htm" => "text/html",
				"exe" => "application/octet-stream",
				"zip" => "application/zip",
				"doc" => "application/msword",
				"xls" => "application/vnd.ms-excel",
				"ppt" => "application/vnd.ms-powerpoint",
				"gif" => "image/gif",
				"png" => "image/png",
				"jpeg" => "image/jpg",
				"jpg" => "image/jpg",
				"php" => "text/plain" 
		);
		
		if ($mime_type == '') {
			$file_extension = strtolower ( substr ( strrchr ( $file, "." ), 1 ) );
			if (array_key_exists ( $file_extension, $known_mime_types ))
				$mime_type = $known_mime_types [$file_extension];
			else
				$mime_type = "application/force-download";
		}
		
		@ob_end_clean ();
		
		if (ini_get ( 'zlib.output_compression' ))
			ini_set ( 'zlib.output_compression', 'Off' );
		
		header ( 'Content-Type: ' . $mime_type );
		header ( 'Content-Disposition: attachment; filename="' . $name . '"' );
		header ( "Content-Transfer-Encoding: binary" );
		header ( 'Accept-Ranges: bytes' );
		header ( "Cache-control: private" );
		header ( 'Pragma: private' );
		header ( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
		
		if (isset ( $_SERVER ['HTTP_RANGE'] )) {
			list ( $a, $range ) = explode ( "=", $_SERVER ['HTTP_RANGE'], 2 );
			list ( $range ) = explode ( ",", $range, 2 );
			list ( $range, $range_end ) = explode ( "-", $range );
			$range = intval ( $range );
			if (! $range_end)
				$range_end = $size - 1;
			else
				$range_end = intval ( $range_end );
			
			$new_length = $range_end - $range + 1;
			header ( "HTTP/1.1 206 Partial Content" );
			header ( "Content-Length: $new_length" );
			header ( "Content-Range: bytes $range-$range_end/$size" );
		} else {
			$new_length = $size;
			header ( "Content-Length: " . $size );
		}
		
		$chunksize = 1 * ($fileChunkSize);
		$bytes_send = 0;
		if ($file = fopen ( $file, 'rb' )) {
			if (isset ( $_SERVER ['HTTP_RANGE'] ))
				fseek ( $file, $range );
			
			while ( ! feof ( $file ) && (! connection_aborted ()) && ($bytes_send < $new_length) ) {
				$buffer = fread ( $file, $chunksize );
				print ($buffer) ;
				flush ();
				$bytes_send += strlen ( $buffer );
			}
			fclose ( $file );
		} else
			die ( 'Error - can not open file.' );
		
		die ();
	}
	public function formatFileSize($size) {
		if ($size < 1000) {
			return number_format ( $size, 2, ',', '' ) . " octets";
		} else if ($size >= 1000 && $size < 1000000) {
			return number_format ( $size / 1000, 2, ',', '' ) . " Ko";
		} else if ($size >= 1000000 && $size < 1000000000) {
			return number_format ( $size / 1000000, 2, ',', '' ) . " Mo";
		} else if ($size >= 1000000000 && $size < 1000000000000) {
			return number_format ( $size / 1000000000, 2, ',', '' ) . " Go";
		}
	}
	public function my_filesize($fp) {
		$return = false;
		if (is_resource ( $fp )) {
			// echo "is ressource";
			if (PHP_INT_SIZE < 8) {
				// echo "php 32bits";
				// 32bit
				if (0 === fseek ( $fp, 0, SEEK_END )) {
					$return = 0.0;
					$step = 0x7FFFFFFF;
					while ( $step > 0 ) {
						if (0 === fseek ( $fp, - $step, SEEK_CUR )) {
							$return += floatval ( $step );
						} else {
							$step >>= 1;
						}
					}
				}
			} elseif (0 === fseek ( $fp, 0, SEEK_END )) {
				//echo "php 64bits";
				// 64bit
				$return = ftell ( $fp );
			}
		}
		// echo "no ressource: " . $fp;
		return $return;
	}
}

