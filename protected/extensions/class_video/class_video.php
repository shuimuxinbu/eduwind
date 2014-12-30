<?php
/**
*	解析 视频信息 类
*
*	支持 优酷, 土豆 酷6 56 新浪 qq播客 乐视 乐视
**/



$all['url'] = 'parse';
$all['youku'] = 'youku';
$all['tudou'] = 'tudou';
$all['ku6'] = 'ku6';
$all['56'] = '_56';
$all['sina'] = 'sina';
$all['qq'] = 'qq';
$all['letv'] = 'letv';
$all['sohu'] = 'sohu';

$value = empty( $_GET['value'] ) ? '' : (string) $_GET['value'];
$type = empty( $_GET['type'] ) || !is_string( $_GET['type'] ) || empty( $all[$_GET['type']] ) ? 'url' : $_GET['type'];
?>
<!DOCTYPE html>
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>PHP 解析视频信息</title>
</head>
<body>
<?php
$select = '<select name="type">';
foreach ( $all as $k => $v ) {
	$selected = $type == $k ? 'selected="selected"' : '';
	$select .= '<option value="'. $k .'" '. $selected.'>'. $k .'</option>';
}
$select .= '</select>';
echo '<form method="get">url 或 vid: <input name="value" type="text" value="' . htmlspecialchars( $value, ENT_QUOTES ) . '" />'. $select .'<input type="submit" ></form>';
if ( !$value ) {
	die;
}

$class_video = new class_video;

echo '<pre>';
echo "\n\n\n";
print_r( call_user_func_array( array( $class_video, $all[$type] ), array( $value ) ) );
echo "\n\n\n";

?>
</body>
</html>

<?php
/**
*	解析 视频信息 类
*
*	支持 优酷, 土豆 酷6 56 新浪 qq播客 乐视 乐视
**/


class class_video{
	
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
		
		return false;
	}
	
	
	
	/**
	*	优酷的
	*
	*	1 参数 vid or url
	*
	*	返回值 false array
	**/
	function youku( $vid ) {	
		if ( !$vid ) {
			return false;
		}
		
		if ( !preg_match( '/^[0-9a-z_-]+$/i', $vid ) ) {
			if ( !preg_match( '/^http\:\/\/v\.youku\.com\/v_show\/id_([0-9a-z_-]+)/i', $vid, $match ) && !preg_match( '/^http\:\/\/player\.youku\.com\/player\.php[0-9a-z\/_-]*\/sid\/([0-9a-z_-]+)/i', $vid, $match ) ) {
				return false;
			}
			$vid = $match[1];
		}
		
		$url = 'http://v.youku.com/player/getPlayList/VideoIDS/' . $vid;
		if ( !$json = $this->url( $url ) ) {
			return false;
		}
		if ( !$json = @json_decode( $json, true ) ) {
			return false;
		}
		if ( empty( $json['data'][0] ) ) {
			return false;
		}
		$json = $json['data'][0];

		$r['vid'] = $json['vidEncoded'];
		$r['url'] = 'http://v.youku.com/v_show/id_'. $json['vidEncoded'] .'.html?f=http://www.lianyue.org/';
		$r['swf'] = 'http://player.youku.com/player.php/sid/'. $json['vidEncoded'] .'/lianyue.swf';
		$r['title'] = $json['title'];
		$r['img']['large'] = $json['logo'];
		$r['img']['small'] = str_replace( '.com/11', '.com/01', $json['logo'] );
		$r['time'] = $json['seconds'];
		$r['tag'] = $json['tags'];
		return $r;
	}

	
	/**
	*	土豆的
	*
	*	1 参数 vid or url
	*
	*	返回值 false array
	**/
	function tudou( $vid ) {
		if ( !$vid ) {
			return false;
		}
		if ( !preg_match( '/^[0-9a-z_-]+$/i', $vid ) ) {
			if ( !preg_match( '/^http\:\/\/www\.tudou\.com\/programs\/view\/([0-9a-z_-]+)/i', $vid, $match ) && !preg_match( '/^http\:\/\/www\.tudou\.com\/v\/([0-9a-z_-]+)/i', $vid, $match ) && !preg_match( '/^http\:\/\/www\.tudou\.com\/(?:listplay|albumplay)\/[0-9a-z_-]+\/([0-9a-z_-]+)/i', $vid, $match ) && !preg_match( '/^http\:\/\/www\.tudou\.com\/(?:a|l)\/[0-9a-z_-]+\/.+iid\=(\d+)/i', $vid, $match ) ) {
				return false;
			}
			$vid = $match[1];
		}
		
		
		$url = 'http://www.tudou.com/v/'. $vid .'/v.swf';
		$this->url( $url, $header );
		if( empty( $header['Location'] ) ) {
			return false;
		}
		$parse = parse_url( $header['Location'] );
		if ( empty( $parse['query'] ) ) {
			return false;
		}
		$this->parse_str( $parse['query'], $arr );
		if ( empty( $arr['snap_pic'] ) ) {
			return false;
		}
		$r['vid'] = $arr['code'];
		$r['url'] = 'http://www.tudou.com/programs/view/'. $arr['code'] .'/?FR=http://www.lianyue.org/';
		$r['swf'] = 'http://www.tudou.com/v/'. $arr['code'] .'/lianyue.swf';
		$r['title'] = $arr['title'];
		$r['img']['large'] = $arr['snap_pic'];
		$r['img']['small'] = str_replace( array( '/w.jpg', 'ykimg.com/11' ), array( '/p.jpg', 'ykimg.com/01' ), $arr['snap_pic'] );
		$r['time'] = $arr['totalTime'] / 1000;
		$r['tag'] = empty( $arr['tag'] ) || $arr['tag'] == 'null' ? array() : $this->array_unempty( explode( ',', $arr['tag'] ) );
		return $r;
	}

	
	/**
	*	酷 6 的
	*
	*	1 参数 vid or url
	*
	*	很老的视频某些 没大图
	*	返回值 false array
	**/
	function ku6( $vid ) {
		if ( !$vid ) {
			return false;
		}
		if ( !preg_match( '/^[0-9a-z_-]+\.{0,2}$/i', $vid ) ) {
			if ( !preg_match( '/^http\:\/\/v\.ku6\.com\/show\/([0-9a-z_-]+)/i', $vid, $match ) && !preg_match( '/^http\:\/\/player\.ku6\.com\/refer\/([0-9a-z_-]+)/i', $vid, $match ) && !preg_match( '/^http\:\/\/v\.ku6\.com\/special\/show_\d+\/([0-9a-z_-]+)/i', $vid, $match ) ) {
				return false;
			}
			$vid = $match[1];
		}
		$vid = preg_replace( '/^([0-9a-z_-]+)\.*$/i', '$1..', $vid );
		if ( !$json = $this->url( 'http://v.ku6.com/fetchVideo4Player/'. $vid .'.html' ) ) {
			return false;
		}
		if ( !$json = @json_decode( $json, true ) ) {
			return false;
		}
		if ( empty( $json['data']['picpath'] ) ) {
			return false;
		}
		
		$json = $json['data'];
		$json['vtime'] = explode( ',', $json['vtime'] );
		$r['vid'] = $vid;
		$r['url'] = 'http://v.ku6.com/show/'. $vid .'.html?ref=http://www.lianyue.org/';
		$r['swf'] = 'http://player.ku6.com/refer/'. $vid .'./lianyue.swf';
		$r['title'] = $json['t'];
		$r['img']['large'] = $json['bigpicpath'];
		$r['img']['small'] = $json['picpath'];
		$r['time'] = reset( $json['vtime'] );
		$r['tag'] = empty( $json['tag'] ) ? array() : $this->array_unempty( explode( ' ', $json['tag'] ) );
		return $r;
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
		if ( !$vid ) {
			return false;
		}
		if ( !preg_match( '/^[0-9a-z_-]+$/i', $vid ) ) {
			if ( !preg_match( '/^http\:\/\/www\.56\.com\/[0-9a-z]+\/v_([0-9a-z_-]+)/i', $vid, $match ) && !preg_match( '/^http\:\/\/player\.56\.com\/v_([0-9a-z_-]+)/i', $vid, $match ) && !preg_match( '/^http\:\/\/www\.56\.com\/[0-9a-z]+\/play_album-aid-\d+_vid-([0-9a-z_-]+)/i', $vid, $match ) ) {
				return false;
			}
			$vid = $match[1];
		}
		if ( !$json = $this->url( 'http://vxml.56.com/json/'. $vid .'/?src=out' ) ) {
			return false;
		}
		if ( !$json = @json_decode( $json, true ) ) {
			return false;
		}
		if ( empty( $json['info']['img'] ) ) {
			return false;
		}
		$json = $json['info'];
		$r['vid'] = $json['textid'];
		$r['url'] = 'http://www.56.com/u/v_'. $json['textid'] .'.html?ref=lianyue.org';
		$r['swf'] = 'http://player.56.com/v_'. $json['textid'] .'.swf?ref=lianyue';
		$r['title'] = $json['Subject'];
		$r['img']['large'] = $json['bimg'];
		$r['img']['small'] = $json['img'];
		$r['time'] = $json['duration']/1000;
		$r['tag'] = empty( $json['tag'] ) ? array() : $this->array_unempty( explode( ',', $json['tag'] ) ); 
		return $r;
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
	function sina( $vid ) {
		if ( !$vid ) {
			return false;
		}
		$uid = 0;
		$url = '';
		$token = '';
		if ( !preg_match( '/^[0-9]+$/i', $vid ) ) {
			if ( preg_match( '/^http\:\/\/video\.sina\.com\.cn\/p\/news\/s\/v\/\d{4}-\d{2}-\d{2}\/\d+\.html/i', $vid, $match ) ) {
				if ( !( $html = $this->url( $vid ) ) || !preg_match( '/swfOutsideUrl\s*:\s*\'(.+?)\'\s*,/i', $html, $match ) ) {
					return false;
				}
				$url = $vid;
				$vid = $match[1];
			}
			if ( preg_match( '/^http\:\/\/video\.sina\.com\.cn\/v\/b\/(\d+)-(\d+)/i', $vid, $match ) || preg_match( '/^http\:\/\/you\.video\.sina\.com\.cn\/api\/sinawebApi\/outplayrefer\.php\/vid=(\d+)_(\d+)_([0-9a-zA-Z+%]+)/i', $vid, $match ) ) {
				$vid = $match[1];
				$uid = $match[2];
				$token = empty( $match[3] ) ? '' : $match[3];
				if ( $uid != 1 ) {
					$url = 'http://video.sina.com.cn/v/b/'. $vid .'-'. $uid .'.html?ref=lianyue.org';
				}
			} else {
				return false;
			}
		}
		if ( !$url && $token ) {
			$token = str_replace( '+', '%2B', $token );
			if ( $xml = $this->url( 'http://video.sina.com.cn/api/sinaVideoInfo.php?pid=1012&token=' . $token ) ) {
				$xml = $this->parse_xml( $xml );
				if ( !empty( $xml['url'] ) ) {
					$url = $xml['url'];
				}
			}
		}
		
		if( !$xml = $this->url( 'http://v.iask.com/v_play.php?vid=' . $vid ) ) {
			return false;
		}
		
		if( !$xml = $this->parse_xml( $xml ) ) {
			return false;
		}
		
		if( !$img = $this->url( 'http://interface.video.sina.com.cn/interface/common/getVideoImage.php?vid=' . $vid ) ) {
			return false;
		}
		
		$this->parse_str( $img, $img );
		if ( empty( $img['imgurl'] ) ) {
			return false;
		}
		$r['vid'] = $xml['ext'];

		$r['url'] = $url;
		$r['swf'] = 'http://you.video.sina.com.cn/api/sinawebApi/outplayrefer.php/vid=' . $xml['ext'] . '_' . $uid . '_' . $token;
		$r['title'] = $xml['vname'];
		$r['img']['large'] = $img['imgurl'];
		$r['img']['small'] = str_replace( '2.jpg', '1.jpg', $img['imgurl'] );
		$r['time'] = $xml['timelength'] / 1000;
		$r['tag'] = empty( $xml['vtags'] ) ? array() : $this->array_unempty( explode( ' ', $xml['vtags'] ) );
		return $r;
	}
	
	/**
	*	QQ 的
	*
	*	1 参数 vid or url
	*
	*	返回值 false array
	**/
	function qq( $vid ) {
		if ( !$vid ) {
			return false;
		}
		
		if ( !preg_match( '/^[0-9a-z_-]+$/i', $vid ) ) {
			if ( !preg_match( '/^http\:\/\/v\.qq\.com\/cover\/[0-9a-z_-]{1}\/[0-9a-z_-]+\.html\?[0-9a-z&=_-]*vid=([0-9a-z_-]+)/i', $vid, $match ) && !preg_match( '/^http\:\/\/v\.qq\.com\/cover\/[0-9a-z_-]{1}\/[0-9a-z_-]+\/([0-9a-z_-]+)\.html/i', $vid, $match ) && !preg_match( '/^http\:\/\/static\.video\.qq\.com\/TPout\.swf\?[0-9a-z&=_-]*vid=(\w+)/i', $vid, $match ) ) {
				return false;
			}
			$vid = $match[1];
		}
		
		if( !$xml = $this->url( 'http://vv.video.qq.com/getinfo?otype=xml&vids=' . $vid ) ) {
			return false;
		}
		if( !$xml = $this->parse_xml( $xml ) ) {
			return false;
		}
		if ( empty( $xml['vl']['vi'] ) ) {
			return false;
		}
		$xml = $xml['vl']['vi'];
		
		
		$num = 0xFFFFFFFF + 1;
		$m = 10000 * 10000;
		$res = 0;
		
		$i = 0;
		while ( $i < strlen ( $vid ) ) {
			$temp = ord ( substr ( $vid, $i, 1 ) );
			$res = $res * 32 + $res + $temp;
			while ( $res >= $num ) {
				$res -= $num;
			}
			$i++;
		}
		while ( $res >= $m ) {
			$res -= $m;
		}
		$r['vid'] = $xml['vid'];
		$r['url'] = 'http://v.qq.com/page/t/u/h/'. $xml['vid'] .'.html?ref=lianyue.org';
		$r['swf'] = 'http://static.video.qq.com/TPout.swf?vid='. $xml['vid'] .'&ref=lianyue.org';
		$r['title'] = $xml['ti'];
		$r['img']['large'] = 'http://vpic.video.qq.com/'. $res .'/'. $xml['vid'] .'.png';
		$r['img']['small'] = 'http://vpic.video.qq.com/'. $res .'/'. $xml['vid'] .'_160_90_2.jpg';
		$r['time'] = $xml['td'];
		$r['tag'] = array();
		return $r ;
	}
	
	/**
	*	letv 的
	*
	*	1 参数 vid or url
	*
	*	返回值 false array
	**/
	function letv( $vid ) {
		if ( !$vid ) {
			return false;
		}
		
		if ( !preg_match( '/^[0-9]+$/i', $vid ) ) {
			if ( !preg_match( '/^http\:\/\/www\.letv\.com\/ptv\/vplay\/(\d+)/i', $vid, $match ) && !preg_match( '/^http\:\/\/i\d+\.imgs\.letv\.com\/player\/swfPlayer\.swf\?[0-9a-z&=_-]*id=(\d+)/i', $vid, $match ) && !preg_match( '/^http\:\/\/www\.letv\.com\/player\/x(\d+)/i', $vid, $match ) ) {
				return false;
			}
			$vid = $match[1];
		}
		if ( !$html = $this->url( 'http://www.letv.com/ptv/vplay/'. $vid .'.html' ) ) {
			return false;
		}
		if ( !preg_match( '/\<script.*?__INFO__\s*\\=\{(.+?)\<\/script\>/is', $html, $match ) ) {
			return false;
		}
		
		$html = $match[1];
		
		$r['vid'] = preg_replace( '/.+vid\s*\:\s*(\d+)\s*,.+/is', '$1', $html );
		$r['url'] = 'http://www.letv.com/ptv/vplay/' . $r['vid'] . '.html';
		$r['swf'] = 'http://i7.imgs.letv.com/player/swfPlayer.swf?id='. $r['vid'];
		$r['img']['large'] = '';
		$r['img']['small'] = preg_replace( '/^.+pic\s*\:\s*["\'](http.+?)["\']\s*,.+$/is', '$1', $html );
		$r['time'] = 0;
		$r['tag'] = array();
		return $r;
	}
	
	/**
	*	sohu 的
	*
	*	1 参数 vid or url
	*
	*	返回值 false array
	**/
	function sohu( $vid ) {
		if ( !$vid ) {
			return false;
		}
		if ( !preg_match( '/^[0-9]+$/i', $vid ) ) {
			if ( !preg_match( '/^http\:\/\/my\.tv\.sohu\.com\/us\/\d+\/(\d+)/i', $vid, $match ) && !preg_match( '/^http\:\/\/my\.tv\.sohu\.com\/u\/vw\/(\d+)/i', $vid, $match ) && !preg_match( '/^http\:\/\/share\.vrs\.sohu\.com\/my\/v\.swf.*&id=(\d+)/i', $vid, $match ) && !preg_match( '/^http\:\/\/share\.vrs\.sohu\.com\/(\d+)/i', $vid, $match ) ) {
				return false;
			}
			$vid = $match[1];
		}
		if ( !$json = $this->url( 'http://my.tv.sohu.com/videinfo.jhtml?m=viewnew&vid=' . $vid ) ) {
			return false;
		}
		
		if ( !$json = @json_decode( $json, true ) ) {
			return false;
		}
		
		if ( empty( $json['url'] ) ) {
			return false;
		}
		$r['vid'] = $vid;
		$r['url'] = $json['url'] . '?ref=lianyue.org';
		$r['swf'] = 'http://share.vrs.sohu.com/my/v.swf&ref=lianyue.org&id=' . $vid;
		$r['img']['large'] = $json['data']['coverImg'];
		$r['img']['small'] = str_replace( array( 'b.jpg', '_0.jpg' ), array( '.jpg', '_1.jpg' ), $json['data']['coverImg'] );
		$r['time'] = $json['data']['totalDuration'];
		$r['tag'] = empty( $json['data']['tag'] ) ? array() : explode( ' ', $json['data']['tag'] );
		return $r;
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