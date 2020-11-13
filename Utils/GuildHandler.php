<?php
namespace Discord;

class Guild {
	public $Raw = array();
	protected $mVars = array('ch' => array());
	protected $_ERR_CODES = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing...',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        449 => 'Retry With',
        450 => 'Blocked by Windows Parental Controls',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        509 => 'Bandwidth Limit Exceeded',
        510 => 'Not Extended'
    );
	public function __construct($srvid)
	{
	   $this->mVars['srvid'] = $srvid;
	   $this->RetriveGuildData();
	   $this->RetriveServerData($this->RetriveInviteCode());
	}

	protected function RetriveGuildData()
    {
	   $this->mVars['ch']['widget'] = curl_init("https://discord.com/api/guilds/" .$this->mVars['srvid']. "/widget.json");
	   curl_setopt_array($this->mVars['ch']['widget'], array(
             CURLOPT_CUSTOMREQUEST => 'GET',
			 CURLOPT_CONNECTTIMEOUT => 10,
			 CURLOPT_CONNECTTIMEOUT_MS => 1500,
			 CURLOPT_FORBID_REUSE => 1,
			 CURLOPT_FRESH_CONNECT => 1,
			 CURLOPT_TIMEOUT => 30,
			 CURLOPT_RETURNTRANSFER => 1,
			 CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Access-Control-Allow-Origin: *'],
             CURLOPT_HTTP_VERSION => (explode('HTTP/', $_SERVER['SERVER_PROTOCOL'])[1] === 1.1 ? CURL_HTTP_VERSION_1_1 : CURL_HTTP_VERSION_1_0),
			 CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT']
	   ));
       $outp = curl_exec($this->mVars['ch']['widget']);

       if($errno = curl_errno($this->mVars['ch']['widget']))
       {
	      if((curl_strerror($errno) == "Couldn't resolve host name") == False)
	      {
             throw new \Exception("[Discord-API]: cURL error (" .$errno. "): " .curl_strerror($errno));
          }
	      else
	      {
   	         throw new \Exception("[Discord-API]: cURL error (" .$errno. "): " .curl_strerror($errno). ': ' .mb_strimwidth(curl_getinfo($this->mVars['ch']['widget'])['url'], 0, 60, "..."));
	      }
       }
       $_HTTP_CODE = curl_getinfo($this->mVars['ch']['widget'], CURLINFO_HTTP_CODE);
	   switch($_HTTP_CODE)
	   {
	      case ($_HTTP_CODE == 200 || $_HTTP_CODE == 201 || $_HTTP_CODE == 202 || $_HTTP_CODE == 204): {
	         if(strpos($outp, 'is not snowflake') == False || strpos($outp, 'Unauthorized') == False || strpos($outp, 'Widget Disabled') == False)
	         {
                $this->Raw['guild'] = json_decode($outp, True);
				if(json_last_error() != JSON_ERROR_NONE)
				{
				   switch (json_last_error())
				   {
   			          case JSON_ERROR_DEPTH:
    			         $json_err = 'Maximum stack depth exceeded';
   			             break;
    			      case JSON_ERROR_STATE_MISMATCH:
    			         $json_err = 'Underflow or the modes mismatch';
    			         break;
   			          case JSON_ERROR_CTRL_CHAR:
    			         $json_err = 'Unexpected control character found';
   			             break;
    		          case JSON_ERROR_SYNTAX:
       			         $json_err = 'Syntax error, malformed JSON';
   			             break;
   			          case JSON_ERROR_UTF8:
           		         $json_err = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                         break;
        			  default:
           		         $json_err = 'Unknown error';
        		         break;
    			   }
				   $error = '[Discord-API]: The server returned an error while fetching the requested data: ' .$json_err;
                   throw new \Exception($error);
				}
	         }
	         else
	         {
	            throw new \Exception('[Discord-API]: ' . $outp);
	         }
		  }
		  break;
		  default: {
		     throw new \Exception('[Discord-API]: ' . curl_getinfo($this->mVars['ch']['widget'], CURLINFO_HTTP_CODE) . ': ' . (isset($this->_ERR_CODES[curl_getinfo($this->mVars['ch']['widget'], CURLINFO_HTTP_CODE)]) ? $this->_ERR_CODES[curl_getinfo($this->mVars['ch']['widget'], CURLINFO_HTTP_CODE)] : 'Unknown ERROR'));
		  }
		  break;
	   }
       $this->CloseDataConnection();
	}

	protected function RetriveServerData($inv_code)
	{
	   $this->mVars['ch']['data'] = curl_init("https://discord.com/api/v8/invites/" .$inv_code. "?with_counts=true");
	   curl_setopt_array($this->mVars['ch']['data'], array(
             CURLOPT_CUSTOMREQUEST => 'GET',
			 CURLOPT_CONNECTTIMEOUT => 10,
			 CURLOPT_CONNECTTIMEOUT_MS => 1500,
			 CURLOPT_FORBID_REUSE => 1,
			 CURLOPT_FRESH_CONNECT => 1,
			 CURLOPT_TIMEOUT => 30,
			 CURLOPT_RETURNTRANSFER => 1,
			 CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Access-Control-Allow-Origin: *'],
             CURLOPT_HTTP_VERSION => (explode('HTTP/', $_SERVER['SERVER_PROTOCOL'])[1] === 1.1 ? CURL_HTTP_VERSION_1_1 : CURL_HTTP_VERSION_1_0),
			 CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT']
	   ));
       $outp = curl_exec($this->mVars['ch']['data']);

       if($errno = curl_errno($this->mVars['ch']['data']))
       {
	      if((curl_strerror($errno) == "Couldn't resolve host name") == False)
	      {
             throw new \Exception("[Discord-API]: cURL error (" .$errno. "): " .curl_strerror($errno));
          }
	      else
	      {
   	         throw new \Exception("[Discord-API]: cURL error (" .$errno. "): " .curl_strerror($errno). ': ' .curl_getinfo($this->mVars['ch']['data'])['url']);	// mb_strimwidth("https://discord.com/api/v8/invites/" .$inv_code. "?with_counts=true", 0, 60, "...")
	      }
       }
       $_HTTP_CODE = curl_getinfo($this->mVars['ch']['data'], CURLINFO_HTTP_CODE);
	   switch($_HTTP_CODE)
	   {
	      case ($_HTTP_CODE == 200 || $_HTTP_CODE == 201 || $_HTTP_CODE == 202 || $_HTTP_CODE == 204): {
	         if(strpos($outp, 'is not snowflake') == False || strpos($outp, 'Unauthorized') == False || strpos($outp, 'Widget Disabled') == False)
	         {
                $this->Raw['data'] = json_decode($outp, True);
				if(json_last_error() != JSON_ERROR_NONE)
				{
				   switch (json_last_error())
				   {
   			          case JSON_ERROR_DEPTH:
    			         $json_err = 'Maximum stack depth exceeded';
   			             break;
    			      case JSON_ERROR_STATE_MISMATCH:
    			         $json_err = 'Underflow or the modes mismatch';
    			         break;
   			          case JSON_ERROR_CTRL_CHAR:
    			         $json_err = 'Unexpected control character found';
   			             break;
    		          case JSON_ERROR_SYNTAX:
       			         $json_err = 'Syntax error, malformed JSON';
   			             break;
   			          case JSON_ERROR_UTF8:
           		         $json_err = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                         break;
        			  default:
           		         $json_err = 'Unknown error';
        		         break;
    			   }
				   $error = '[Discord-API]: The server returned an error while fetching the requested data: ' .$json_err;
                   throw new \Exception($error);
				}
	         }
	         else
	         {
	            throw new \Exception('[Discord-API]: ' . $outp);
	         }
		  }
		  break;
		  default: {
		     throw new \Exception('[Discord-API]: ' . curl_getinfo($this->mVars['ch']['data'], CURLINFO_HTTP_CODE) . ': ' . (isset($this->_ERR_CODES[curl_getinfo($this->mVars['ch']['data'], CURLINFO_HTTP_CODE)]) ? $this->_ERR_CODES[curl_getinfo($this->mVars['ch']['data'], CURLINFO_HTTP_CODE)] : 'Unknown ERROR'));
		  }
		  break;
	   }
       $this->CloseDataConnection(1);
	}

    protected function CloseDataConnection($mode = 0)
	{
	   switch($mode)
	   {
          case 0: {
		     curl_close($this->mVars['ch']['widget']);
			 break;
		  }
		  case 1: {
			 curl_close($this->mVars['ch']['data']);
			 break;
		  }
	   }
	}

	public function RetriveServerIconURL($ico_type = 'png')
	{
		$server_icon = 'https://cdn.discordapp.com/icons/' . $this->Raw['data']['guild']['id'] . '/' . $this->Raw['data']['guild']['icon'] . '.' . $ico_type;

		return (file_get_contents($server_icon) ? $server_icon : False);
	}

	protected function SplitInviteCode($inv_code)
	{
	   $ds_inv_handlers = array('discordapp.com/invite/', 'discord.com/invite/', 'discord.gg/');

	   for($v = 0; $v < count($ds_inv_handlers); $v++)
	   {
	      if(strpos($inv_code, $ds_inv_handlers[$v]))
		  {
		     $inviteC = str_replace(parse_url($inv_code, PHP_URL_SCHEME) . '://' . $ds_inv_handlers[$v], '', $inv_code);
			 break;
		  }
		  else
		  {
		     continue;
		  }
	   }
	   return $inviteC;
	}

	public function RetriveInviteCode($splitted = True)
	{
	   return (isset($this->Raw['guild']['instant_invite']) ? ($splitted ? $this->SplitInviteCode($this->Raw['guild']['instant_invite']) : $this->Raw['guild']['instant_invite']) : 'javascript:void(0);');
	}

	public function RetriveInviter($ico_type = NULL, $inv_code = NULL, $json_encoded = True, $split_invcode = False)
	{
	   if($ico_type == NULL) $ico_type = 'png';
	   if($inv_code == NULL)
	   {
	      $_DATA = array('name' => ($this->Raw["data"]["inviter"]["username"]. '#' .$this->Raw["data"]["inviter"]["discriminator"]),
					     'icon_url' => ('https://cdn.discordapp.com/avatars/' .$this->Raw["data"]["inviter"]["id"]. '/' .$this->Raw["data"]["inviter"]["avatar"]. '.' .$ico_type),
					     'instant_invite' => $this->RetriveInviteCode($split_invcode)
		  );
	   }
	   else
	   {
		  $this->mVars['ch']['data'] = curl_init("https://discord.com/api/v8/invites/" .$inv_code. "?with_counts=true");
		  curl_setopt_array($this->mVars['ch']['data'], array(
			    CURLOPT_CUSTOMREQUEST => 'GET',
			    CURLOPT_CONNECTTIMEOUT => 10,
			    CURLOPT_CONNECTTIMEOUT_MS => 1500,
			    CURLOPT_FORBID_REUSE => 1,
			    CURLOPT_FRESH_CONNECT => 1,
			    CURLOPT_TIMEOUT => 30,
			    CURLOPT_RETURNTRANSFER => 1,
			    CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Access-Control-Allow-Origin: *'],
                CURLOPT_HTTP_VERSION => (explode('HTTP/', $_SERVER['SERVER_PROTOCOL'])[1] === 1.1 ? CURL_HTTP_VERSION_1_1 : CURL_HTTP_VERSION_1_0),
			    CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT']
		  ));
		  $outp = curl_exec($this->mVars['ch']['data']);

		  if($errno = curl_errno($this->mVars['ch']['data']))
		  {
		     if((curl_strerror($errno) == "Couldn't resolve host name") == False)
		     {
			    throw new \Exception("[Discord-API]: cURL error (" .$errno. "): " .curl_strerror($errno));
		     }
		     else
		     {
				throw new \Exception("[Discord-API]: cURL error (" .$errno. "): " .curl_strerror($errno). ': ' .curl_getinfo($this->mVars['ch']['data'])['url']);	// mb_strimwidth("https://discord.com/api/v8/invites/" .$inv_code. "?with_counts=true", 0, 60, "...")
		     }
		  }
		  $_HTTP_CODE = curl_getinfo($this->mVars['ch']['data'], CURLINFO_HTTP_CODE);
		  switch($_HTTP_CODE)
		  {
		     case ($_HTTP_CODE == 200 || $_HTTP_CODE == 201 || $_HTTP_CODE == 202 || $_HTTP_CODE == 204): {
			    if(strpos($outp, 'is not snowflake') == False || strpos($outp, 'Unauthorized') == False || strpos($outp, 'Widget Disabled') == False)
			    {
				   $decoded_data = json_decode($outp, True);
				   $_DATA = array('name' => ($decoded_data["inviter"]["username"]. "#" .$decoded_data["inviter"]["discriminator"]),
				                  'icon_url' => ('https://cdn.discordapp.com/avatars/' .$decoded_data["inviter"]["id"]. '/' .$decoded_data["inviter"]["avatar"]. '.' .$ico_type),
				                  'instant_invite' => $split_invcode ? $this->SplitInviteCode('https://discord.com/invite/' .$inv_code) : ('https://discord.com/invite/' .$inv_code)
				   );
				   if(json_last_error() != JSON_ERROR_NONE)
				   {
					  switch (json_last_error())
					  {
						 case JSON_ERROR_DEPTH:
						     $json_err = 'Maximum stack depth exceeded';
							 break;
					     case JSON_ERROR_STATE_MISMATCH:
						     $json_err = 'Underflow or the modes mismatch';
						     break;
						 case JSON_ERROR_CTRL_CHAR:
						     $json_err = 'Unexpected control character found';
							 break;
					     case JSON_ERROR_SYNTAX:
							 $json_err = 'Syntax error, malformed JSON';
							 break;
						 case JSON_ERROR_UTF8:
							 $json_err = 'Malformed UTF-8 characters, possibly incorrectly encoded';
						     break;
					     default:
							 $json_err = 'Unknown error';
						     break;
					  }
					  $error = '[Discord-API]: The server returned an error while fetching the requested data: ' .$json_err;
					  throw new \Exception($error);
				   }
			    }
			    else
			    {
				   throw new \Exception('[Discord-API]: ' . $outp);
			    }
		     }
		     break;
		     default: {
				throw new \Exception('[Discord-API]: ' . curl_getinfo($this->mVars['ch']['data'], CURLINFO_HTTP_CODE) . ': ' . (isset($this->_ERR_CODES[curl_getinfo($this->mVars['ch']['data'], CURLINFO_HTTP_CODE)]) ? $this->_ERR_CODES[curl_getinfo($this->mVars['ch']['data'], CURLINFO_HTTP_CODE)] : 'Unknown ERROR'));
		     }
		     break;
		  }
		  $this->CloseDataConnection(1);
	   }
	   return ($json_encoded ? json_encode($_DATA) : $_DATA);
	}
}
?>
