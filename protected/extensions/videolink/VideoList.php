<?php
/**
 *	解析 视频信息 类
 *
 *	支持 优酷, 土豆 酷6 56 新浪 qq播客 乐视 乐视
 **/


class VideoList{

	// 超时时间
	var $timeout = 5;

	/**
	 *	解析视频
	 *
	 *	1 参数 url 地址
	 *
	 *	返回值 数组 or false
	 **/
	function parse( $url ) {
		$arr = parse_url( $url );
		if ( empty( $arr['host'] ) ) {
			return false;
		}
		$host = strtolower( preg_replace( '/.*(?:$|\.)(\w+(?:\.(?:com|net|org|co|info)){0,1}\.[a-z]+)$/iU', '$1', $arr['host'] ) );
		if ( $host == 'youku.com' ) {
			return $this->youku( $url );
		}

		if ( $host == 'tudou.com' ) {
			return $this->tudou( $url );
		}

		if ( $host == 'ku6.com' ) {
			return $this->ku6( $url );
		}

		if ( $host == '56.com' ) {
			return $this->_56( $url );
		}

		if ( $host == 'sina.com.cn' ) {
			return $this->sina( $url );
		}

		if ( $host == 'qq.com' ) {
			return $this->qq( $url );
		}

		if ( $host == 'letv.com' ) {
			return $this->letv( $url );
		}

		if ( $host == 'sohu.com' ) {
			return $this->sohu( $url );
		}

		if ( $host == '163.com' ) {
			return $this->_163( $url );
		}
		return false;
	}



	/**
	 *	优酷的
	 *
	 *	1 参数 vid or url
	 *
	 *	返回值 false array
	 **/
	function youku( $url ) {
		//			$output = Yii::app()->curl->get($_POST['url']);
		//			$partern = "";
		Yii::import('ext.SimpleHTMLDOM.SimpleHTMLDOM');
		// Create DOM from URL or file
		$simpleHTML = new SimpleHTMLDOM;
		$html = $simpleHTML->file_get_html($url);
			
/*		$urlPatterns= array('playlist'=>array('pattern'=>"/\/playlist_show\/id_/i",'selector'=>'#list1_1 .items  li.v_title a'),
						'episode'=>array('pattern'=>"/\/show_page\/id_/i",'selector'=>'#episode li.ititle_w a'),
						'side_playlist'=>array('pattern'=>"/\/v_show\/id_/i",'selector'=>'#playlist_content li.item')
		);*/
		$urlPatterns = array('playlist'=>"/\/playlist_show\/id_/i",
							'episode'=>"/\/show_page\/id_/i",
							'side_playlist'=>"/\/v_show\/id_/i");
		$result = array();
		if(preg_match($urlPatterns['playlist'], $url)) {
			$result = $this->youku_playlist($html);
		}else if(preg_match($urlPatterns['episode'], $url)){
			$result = $this->youku_episode($html);
		}else if(preg_match($urlPatterns['side_playlist'], $url)){
			$result = $this->youku_side_playlist($html);
		}
		return $result;
	}

		function youku_playlist($html){
			$selector = "#list1_1 .items  li.v_title a";
			// Find all images
			foreach($html->find($selector) as $elem){
				$video = array();
				$video['title'] = $elem->getAttribute("title") ? $elem->getAttribute("title") : $elem->innertext;
				$pattern = "/id_(.*)\/?\.html/i";
				preg_match($pattern,$elem->href,$matches);
				if(isset($matches[1])){
					//		http://player.youku.com/player.php/sid/XNTk5MTQ3OTQ0/v.swf
					$video['url'] = "http://player.youku.com/player.php/sid/$matches[1]/v.swf";
				}else{
					continue;
				}
				$results[] = $video;
			}
			return $results;
		}

		function youku_side_playlist($html){
			//$selector = "#playlist_content li.item,listArea li.item";
			$items = $html->find("#playlist_content li.item");
			if(empty($items)) $items=$html->find('.listArea li.item');
			foreach( $items as $elem){
				$video = array();
				$video['title'] = $elem->getAttribute("title") ? $elem->getAttribute("title") : $elem->innertext;
				$id =  $elem->getAttribute('id');
				if(preg_match('/item_.*/is', $id)){
					$id = substr($id,5);
				}
					//		http://player.youku.com/player.php/sid/XNTk5MTQ3OTQ0/v.swf
				$video['url'] = "http://player.youku.com/player.php/sid/$id/v.swf";
				$results[] = $video;
			}
			return $results;
		}

		function youku_episode($html){
			$selector='#episode li.ititle_w a';
			foreach($html->find($selector) as $elem){
				$video = array();
				$video['title'] = $elem->getAttribute("title") ? $elem->getAttribute("title") : $elem->innertext;
				$pattern = "/id_(.*)\/?\.html/i";
				preg_match($pattern,$elem->href,$matches);
				if(isset($matches[1])){
					//		http://player.youku.com/player.php/sid/XNTk5MTQ3OTQ0/v.swf
					$video['url'] = "http://player.youku.com/player.php/sid/$matches[1]/v.swf";
				}else{
					continue;
				}
				$results[] = $video;
			}
			return $results;

		}
		/**
		 *	土豆的
		 *
		 *	1 参数 vid or url
		 *
		 *	返回值 false array
		 **/
		function tudou( $url ) {

			Yii::import('ext.SimpleHTMLDOM.SimpleHTMLDOM');
			// Create DOM from URL or file
			$simpleHTML = new SimpleHTMLDOM;
			$html = $simpleHTML->file_get_html($url);
			$selector = "#relatives h6 a";

			// Find all images
			foreach($html->find($selector) as $elem){
				$video = array();
				$video['title'] = $elem->getAttribute("title") ? $elem->getAttribute("title") : $elem->innertext;
				$video['url'] = $elem->getAttribute('href');
				$results[] = $video;
			}
			return $results;
		}


		/**
		 *	酷 6 的
		 *
		 *	1 参数 vid or url
		 *
		 *	很老的视频某些 没大图
		 *	返回值 false array
		 **/
		function ku6( $url ) {

		}


		/**
		 *	56 的
		 *
		 *	1 参数 vid or url
		 *
		 *	很老的视频某些 没大图
		 *	返回值 false array
		 **/
		function _56( $vid ) {
			
		}

		function _163($url){
			if(preg_match('/cuvocw/is', $url))
				$results = $this->_163_cuvocw($url);
			if(empty($results))
				$results = $this->_163_special($url);
			return $results;
		}

		public function _163_special($url){
			Yii::import('ext.SimpleHTMLDOM.SimpleHTMLDOM');
			// Create DOM from URL or file
			$simpleHTML = new SimpleHTMLDOM;
			$str = file_get_contents($url);
			$str=iconv("gbk","UTF-8",$str);
			$html = $simpleHTML->str_get_html($str);
			//$html = $simpleHTML->file_get_html($url,false,null,-1,-1,true, true, 'GBK');
			$selector2 = "#list2 .u-ctitle a";
			//		$selector1 = "#list1 .u-ctitle a";
			//			$elems = empty($html->find($selector2)) ? $html->find($selector1) : $html->find($selector2);
			// Find all images
			$results = array();
			foreach($html->find($selector2) as $elem){
				$video['title'] = $elem->innertext();
				$video['url'] = $elem->getAttribute('href');
				$results[] = $video;
			}
			return $results;
		}
		
		public function _163_cuvocw($url){
			Yii::import('ext.SimpleHTMLDOM.SimpleHTMLDOM');
			// Create DOM from URL or file
			$simpleHTML = new SimpleHTMLDOM;
			$str = file_get_contents($url);
			$str=iconv("gbk","UTF-8",$str);
			$html = $simpleHTML->str_get_html($str);
			//$html = $simpleHTML->file_get_html($url,false,null,-1,-1,true, true, 'GBK');
			$selector = "#lesson-list li h3 a";
			//		$selector1 = "#list1 .u-ctitle a";
			//			$elems = empty($html->find($selector2)) ? $html->find($selector1) : $html->find($selector2);
			// Find all images
			$results = array();
			foreach($html->find($selector) as $elem){
				$video['title'] = $elem->innertext();
				$video['url'] = $elem->getAttribute('href');
				$results[] = $video;
			}
			return $results;			
		}
		/**
		 *	sina 的
		 *
		 *	1 参数 vid or url
		 *
		 *	如果直接使用vid 获取不到 url 地址
		 *
		 *	返回值 false array
		 **/
		function sina( $url ) {
			Yii::import('ext.SimpleHTMLDOM.SimpleHTMLDOM');
			// Create DOM from URL or file
			$simpleHTML = new SimpleHTMLDOM;
			$html = $simpleHTML->file_get_html($url);
			//$html = $simpleHTML->file_get_html($url,false,null,-1,-1,true, true, 'GBK');
			$selector = ".part02 .container2 ul li a:nth-child(2)";
			//		$selector1 = "#list1 .u-ctitle a";
			//			$elems = empty($html->find($selector2)) ? $html->find($selector1) : $html->find($selector2);
			// Find all images
			$results = array();
			foreach($html->find($selector) as $elem){
				$video['title'] = $elem->getAttribute("title") ? $elem->getAttribute("title") : $elem->innertext;
				$video['url'] = $elem->getAttribute('href');
				$results[] = $video;
			}
			return $results;
		}

		/**
		 *	QQ 的
		 *
		 *	1 参数 vid or url
		 *
		 *	返回值 false array
		 **/
		function qq( $url ) {
			//			$output = Yii::app()->curl->get($_POST['url']);
			//			$partern = "";
			Yii::import('ext.SimpleHTMLDOM.SimpleHTMLDOM');
			// Create DOM from URL or file
			$simpleHTML = new SimpleHTMLDOM;
			$html = $simpleHTML->file_get_html($url);
			$selector = "#mod_videolist li a";

			// Find all images
			foreach($html->find($selector) as $elem){
				$video = array();
				$video['title'] = $elem->getAttribute("title") ? $elem->getAttribute("title") : $elem->innertext;
				$video['url'] = "v.qq.com".$elem->getAttribute('href');
				$results[] = $video;
			}
			return $results;
		}

		/**
		 *	letv 的
		 *
		 *	1 参数 vid or url
		 *
		 *	返回值 false array
		 **/
		function letv( $url ) {

		}

		/**
		 *	sohu 的
		 *
		 *	1 参数 vid or url
		 *
		 *	返回值 false array
		 **/
		function sohu( $vid ) {

		}

		/**
		 *	打开 url
		 *
		 *	1 参数 url 地址
		 *	2 参数 header 引用
		 *
		 *	返回值 字符串
		 **/
		function url( $url = '',  &$header = array() ) {
			$timeout = $this->timeout;
			$accept = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1478.0 Safari/537.36';

			$content = '';


			if ( function_exists( 'curl_init' ) ) {
				// curl 的
				$curl = curl_init( $url );
				curl_setopt( $curl, CURLOPT_DNS_CACHE_TIMEOUT, 86400 ) ;
				curl_setopt( $curl, CURLOPT_DNS_USE_GLOBAL_CACHE, true ) ;
				curl_setopt( $curl, CURLOPT_BINARYTRANSFER, true );
				curl_setopt( $curl, CURLOPT_ENCODING, 'gzip,deflate' );
				curl_setopt( $curl, CURLOPT_HEADER, true );
				curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
				curl_setopt( $curl, CURLOPT_USERAGENT, $accept );
				curl_setopt( $curl, CURLOPT_TIMEOUT, $timeout );
				$content = curl_exec ( $curl );
				curl_close( $curl );

			} elseif ( function_exists( 'file_get_contents' ) ) {
					
				// file_get_contents
				$head[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
				$head[] = "User-Agent: $accept";
				$head[] = "Accept-Language: zh-CN,zh;q=0.5";
				$head = implode( "\r\n", $head ). "\r\n\r\n";
					
				$context['http'] = array (
				'method' => "GET" ,  
				'header' => $head,
				'timeout' => $timeout,
				);
					
				$content = @file_get_contents( $url, false , stream_context_create( $context ) );
				if ( $gzip = $this->gzip( $content ) ) {
					$content = $gzip;
				}
				$content = implode( "\r\n", $http_response_header ). "\r\n\r\n" . $content;
					
			} elseif ( function_exists('fsockopen') || function_exists('pfsockopen') ) {
				// fsockopen or pfsockopen
				$url = parse_url( $url );
				if ( empty( $url['host'] ) ) {
					return false;
				}
				$url['port'] = empty( $url['port'] ) ? 80 : $url['port'];
					
				$host = $url['host'];
				$host .= $url['port'] == 80 ? '' : ':'. $port;
					
				$get = '';
				$get .= empty( $url['path'] ) ? '/' : $url['path'];
				$get .= empty( $url['query'] ) ? '' : '?'. $url['query'];
					
					
				$head[] = "GET $get HTTP/1.1";
				$head[] = "Host: $host";
				$head[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
				$head[] = "User-Agent: $accept";
				$head[] = "Accept-Language: zh-CN,zh;q=0.5";
				$head[] = "Connection: Close";
				$head = implode( "\r\n", $head ). "\r\n\r\n";

				$function = function_exists('fsockopen') ? 'fsockopen' : 'pfsockopen';
				if ( !$fp = @$function( $url['host'], $url['port'], $errno, $errstr, $timeout ) ) {
					return false;
				}
					
				if( !fputs( $fp, $head ) ) {
					return false;
				}
					
				while ( !feof( $fp ) ) {
					$content .= fgets( $fp, 1024 );
				}
				fclose( $fp );
					
				if ( $gzip = $this->gzip( $content ) ) {
					$content = $gzip;
				}
					
				$content = str_replace( "\r\n", "\n", $content );
				$content = explode( "\n\n", $content, 2 );
					
				if ( !empty( $content[1] ) && !strpos( $content[0], "\nContent-Length:" ) ) {
					$content[1] = preg_replace( '/^[0-9a-z\r\n]*(.+?)[0-9\r\n]*$/i', '$1', $content[1] );
				}
				$content = implode( "\n\n", $content );
			}

			// 分割 header  body
			$content = str_replace( "\r\n", "\n", $content );
			$content = explode( "\n\n", $content, 2 );

			// 解析 header
			$header = array();
			foreach ( explode( "\n", $content[0] ) as $k => $v ) {
				if ( $v ) {
					$v = explode( ':', $v, 2 );
					if( isset( $v[1] ) ) {
						if ( substr( $v[1],0 , 1 ) == ' ' ) {
							$v[1] = substr( $v[1], 1 );
						}
						$header[trim($v[0])] = $v[1];
					} elseif ( empty( $r['status'] ) && preg_match( '/^(HTTP|GET|POST)/', $v[0] ) ) {
						$header['status'] = $v[0];
					} else {
						$header[] = $v[0];
					}
				}
			}


			$body = empty( $content[1] ) ? '' : $content[1];
			return $body;
		}


		/**
		 *	gzip 解压缩
		 *
		 *	1 参数 data
		 *
		 *	返回值 false or string
		 **/
		function gzip( $data ) {
			$len = strlen ( $data );
			if ($len < 18 || strcmp ( substr ( $data, 0, 2 ), "\x1f\x8b" )) {
				return null; // Not GZIP format (See RFC 1952)
			}
			$method = ord ( substr ( $data, 2, 1 ) ); // Compression method
			$flags = ord ( substr ( $data, 3, 1 ) ); // Flags
			if ($flags & 31 != $flags) {
				// Reserved bits are set -- NOT ALLOWED by RFC 1952
				return null;
			}
			// NOTE: $mtime may be negative (PHP integer limitations)
			$mtime = unpack ( "V", substr ( $data, 4, 4 ) );
			$mtime = $mtime [1];
			$xfl = substr ( $data, 8, 1 );
			$os = substr ( $data, 8, 1 );
			$headerlen = 10;
			$extralen = 0;
			$extra = "";
			if ($flags & 4) {
				// 2-byte length prefixed EXTRA data in header
				if ($len - $headerlen - 2 < 8) {
					return false; // Invalid format
				}
				$extralen = unpack ( "v", substr ( $data, 8, 2 ) );
				$extralen = $extralen [1];
				if ($len - $headerlen - 2 - $extralen < 8) {
					return false; // Invalid format
				}
				$extra = substr ( $data, 10, $extralen );
				$headerlen += 2 + $extralen;
			}

			$filenamelen = 0;
			$filename = "";
			if ($flags & 8) {
				// C-style string file NAME data in header
				if ($len - $headerlen - 1 < 8) {
					return false; // Invalid format
				}
				$filenamelen = strpos ( substr ( $data, 8 + $extralen ), chr ( 0 ) );
				if ($filenamelen === false || $len - $headerlen - $filenamelen - 1 < 8) {
					return false; // Invalid format
				}
				$filename = substr ( $data, $headerlen, $filenamelen );
				$headerlen += $filenamelen + 1;
			}

			$commentlen = 0;
			$comment = "";
			if ($flags & 16) {
				// C-style string COMMENT data in header
				if ($len - $headerlen - 1 < 8) {
					return false; // Invalid format
				}
				$commentlen = strpos ( substr ( $data, 8 + $extralen + $filenamelen ), chr ( 0 ) );
				if ($commentlen === false || $len - $headerlen - $commentlen - 1 < 8) {
					return false; // Invalid header format
				}
				$comment = substr ( $data, $headerlen, $commentlen );
				$headerlen += $commentlen + 1;
			}

			$headercrc = "";
			if ($flags & 1) {
				// 2-bytes (lowest order) of CRC32 on header present
				if ($len - $headerlen - 2 < 8) {
					return false; // Invalid format
				}
				$calccrc = crc32 ( substr ( $data, 0, $headerlen ) ) & 0xffff;
				$headercrc = unpack ( "v", substr ( $data, $headerlen, 2 ) );
				$headercrc = $headercrc [1];
				if ($headercrc != $calccrc) {
					return false; // Bad header CRC
				}
				$headerlen += 2;
			}

			// GZIP FOOTER - These be negative due to PHP's limitations
			$datacrc = unpack ( "V", substr ( $data, - 8, 4 ) );
			$datacrc = $datacrc [1];
			$isize = unpack ( "V", substr ( $data, - 4 ) );
			$isize = $isize [1];

			// Perform the decompression:
			$bodylen = $len - $headerlen - 8;
			if ($bodylen < 1) {
				// This should never happen - IMPLEMENTATION BUG!
				return null;
			}
			$body = substr ( $data, $headerlen, $bodylen );
			$data = "";
			if ($bodylen > 0) {
				switch ($method) {
					case 8 :
						// Currently the only supported compression method:
						$data = gzinflate ( $body );
						break;
					default :
						// Unknown compression method
						return false;
				}
			} else {
				//...
			}

			if ($isize != strlen ( $data ) || crc32 ( $data ) != $datacrc) {
				// Bad format!  Length or CRC doesn't match!
				return false;
			}
			return $data;
		}


		/**
		 *	解析数组
		 *
		 *	1 参数 str
		 *	2 参数 arr 引用
		 *
		 *	返回值 无
		 **/
		function parse_xml( $xml ) {
			if ( preg_match_all("/\<(?<tag>[a-z]+)\>\s*\<\!\[CDATA\s*\[(.*)\]\]\>\s*\<\/\k<tag>\>/iU", $xml, $matches ) ) {
				$find = $replace = array();
				foreach ( $matches[0] as $k => $v ) {
					$find[] = $v;
					$replace[] = '<'. $matches['tag'][$k]  .'>' .htmlspecialchars( $matches[2][$k] , ENT_QUOTES ). '</' . $matches['tag'][$k].'>';
				}

				$xml = str_replace( $find, $replace, $xml );
			}
			if( !$xml = @simplexml_load_string( $xml ) ) {
				return false;
			}
			return $this->turn_array( $xml );
		}

		/**
		 *	解析数组
		 *
		 *	1 参数 str
		 *	2 参数 arr 引用
		 *
		 *	返回值 无
		 **/
		function parse_str( $str, &$arr ) {
			parse_str( $str, $arr );
			if ( get_magic_quotes_gpc() ) {
				$arr = $this->stripslashes_array( $arr );
			}
		}

		/**
		 *	stripslashes 取消转义 数组
		 *
		 *	1 参数 输入数组
		 *
		 *	返回值 处理后的数组
		 **/
		function stripslashes_array( $value ) {
			if ( is_array( $value ) ) {
				$value = array_map( array( $this, __FUNCTION__ ), $value );
			} elseif ( is_object( $value ) ) {
				$vars = get_object_vars( $value );
				foreach ( $vars as $key => $data ) {
					$value->{$key} = stripslashes_array( $data );
				}
			} else {
				$value = stripslashes( $value );
			}
			return $value;
		}

		/**
		 *	转换成 数组
		 *
		 *	1 参数 需要进行处理的 类 或者 数组 支持多维数组
		 *
		 *	返回值 处理后的数组
		 **/
		function turn_array( $arr = array() ) {
			$arr = (array) $arr;
			$r = array();
			foreach ( $arr as $k => $v ) {
				if( is_object( $v ) || is_array( $v ) ) {
					$r[$k] = $this->turn_array( $v );
				} else {
					$r[$k] = $v;
				}
			}
			return $r;
		}


		/**
		 *	删除 数组中 的空值
		 *
		 *	1 参数 数组
		 *	2 参数 是否回调删除多维数组
		 *
		 *	返回值 数组
		 **/
		function array_unempty( $a = array(), $call = false ) {

			foreach ( $a as $k => $v ) {
				if ( $call && is_array( $a ) && $a ) {
				 $a[$k] = $this->array_unempty( $a, $call );
				}
				if ( empty( $v ) ) {
					unset( $a[$k] );
				}
			}
			return $a;
		}


	}