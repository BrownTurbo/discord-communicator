<?php
   $URL = 'http://localhost:8585/DirLinks/DiscordCommunicator/discordlib.php';
   $ch = curl_init($URL);
   $_Emojis = ["✌","😂","😝","😁","😱","👉","🙌","🍻","🔥","🌈","☀","🎈","🌹","💄","🎀","⚽","🎾","🏁","😡","👿","🐻","🐶","🐬","🐟","🍀","👀","🚗","🍎","💝","💙","👌","❤","😍","😉","😓","😳","💪","💩","🍸","🔑","💖","🌟","🎉","🌺","🎶","👠","🏈","⚾","🏆","👽","💀","🐵","🐮","🐩","🐎","💣","👃","👂","🍓","💘","💜","👊","💋","😘","😜","😵","🙏","👋","🚽","💃","💎","🚀","🌙","🎁","⛄","🌊","⛵","🏀","🎱","💰","👶","👸","🐰","🐷","🐍","🐫","🔫","👄","🚲","🍉","💛","💚"];
   $_Data = array(
         'main' => array(
		      'channel_id'   =>   '776673586660245584',
			  'webhook_authtoken'   =>   'PNijTpmIh2LLXYmKrbtJ15WoBuqwCCYmzFq2b7fcIAVJw7dCpSMeWpurmX5ni_wDF53E',
              'bot_username'   =>   '[BR]Moderator',
		      'bot_avatar'   =>   'https://cdn.discordapp.com/avatars/372276696763727872/b0a36c0f6e5ed186c00a45b4cba8f71f.webp?size=128',
              'tts'   =>  'False'
		 ),
         'general' => array(
		      'description'   =>   'Testoretoz',
		      'title'   =>   'Test...',
		      'color'   =>   '#ad4b09',
		      'thumbnail'   =>   'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQGmnrRD-rcF8bojIG4C-ZrDPqoR6EWJ630cLZdg-bmJJk5NwgjeQ',
			  'image'   =>   'https://png.icons8.com/ios/1600/discord-logo.png',
			  'message'   =>   'Hello, world! :alien:' . ($_Emojis[rand(0, rand(0, count($_Emojis)))]),
			  'timestamp'   =>   'default'
         ),
		 'author' => array(
              'name'   =>   '[BR]John_Magdy',
		      'url'   =>   'https://www.facebook.com/BR.Zorono',
		      'avatar_url'   =>   'https://graph.facebook.com/178950652664113/picture?type=small'
         ),
		 'footer' => array(
              'text'   =>   'Hello footer',
		      'image_url'   =>   'https://vignette.wikia.nocookie.net/theamazingworldofgumball/images/a/af/Discord_Logo.png/revision/latest?cb=20170105233205'
         ),
		 'fields' => array(
              array(
		          'name'   =>   'Field Name #1',
			      'value'   =>   'Field Value #1',
			      'inline'   =>   True
		      ),
		      array(
		          'name'   =>   'Field Name #2',
			      'value'   =>   'Field Value #2',
			      'inline'   =>   True
	     	 ),
	     	 array(
	     	      'name'   =>   'Field Name #3',
	     		  'value'   =>   'Field Value #3',
	     		  'inline'   =>   True
	     	 ),
	     	 array(
		          'name'   =>   'Field Name #4',
		     	  'value'   =>   'Field Value #4',
			      'inline'   =>   True
		     )
         )
   );
   $_ERR_CODES = array(
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
   $allowed_errorcodes = array(200, 201, 202, 204);
   curl_setopt_array($ch, array(
                CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_CONNECTTIMEOUT => 10,
				CURLOPT_CONNECTTIMEOUT_MS => 1500,
				CURLOPT_FORBID_REUSE => 1,
				CURLOPT_FRESH_CONNECT => 1,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_POSTFIELDS => json_encode($_Data),
				CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Content-Length: ' . strlen(json_encode($_Data))],
				CURLOPT_RETURNTRANSFER => True,
				CURLOPT_SSL_VERIFYHOST => 2,
				CURLOPT_SSL_VERIFYPEER => 1,
                CURLOPT_HTTP_VERSION => (explode('HTTP/', $_SERVER['SERVER_PROTOCOL'])[1] === 1.1 ? CURL_HTTP_VERSION_1_1 : CURL_HTTP_VERSION_1_0),
				CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT']
   ));
   $result = curl_exec($ch);
   if($errno = curl_errno($ch))
   {
	  if((curl_strerror($errno) == "Couldn't resolve host name") == False)
	  {
         throw new \Exception("[Discord-API]: cURL error (" .$errno. "): " .curl_strerror($errno));
      }
	  else
	  {
   	     throw new \Exception("[Discord-API]: cURL error (" .$errno. "): " .curl_strerror($errno). ': ' .mb_strimwidth(curl_getinfo($ch)['url'], 0, 60, "..."));
	  }
   }

   for($err = 0; $err < count($allowed_errorcodes); $err++)
   {
	  if($err >= count($allowed_errorcodes))
	  {
	     throw new \Exception('[Discord-API]: ' . curl_getinfo($ch, CURLINFO_HTTP_CODE) . ':' . (strlen($result) >= 1 ? $result : 'NULL'));
         break;
	  }
      if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == $allowed_errorcodes[$err])
      {
	     break;
      }
      else
      {
		 continue;
	  }
   }

   //echo (strpos($result, 'Data sent successfully') ? curl_getinfo($ch, CURLINFO_HTTP_CODE) . ': ' . (isset($_ERR_CODES[curl_getinfo($ch, CURLINFO_HTTP_CODE)]) ? $_ERR_CODES[curl_getinfo($ch, CURLINFO_HTTP_CODE)] : 'Unknown') : $result);
   echo $result;
   curl_close($ch);
?>
