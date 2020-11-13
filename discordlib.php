<?php
   include dirname(__FILE__) . "/Utils/Client.php";
   include dirname(__FILE__) . "/Utils/Embed.php";

   $_START_TIME = microtime(True);
   function DS_SendBOTMessage(array $data)
   {
	  $embed_count = 0;
	  $execute = True;

      if(isset($data['main']) && $data['main'] != NULL && is_array($data['main']))
	  {
	     foreach($data['main'] as $key => $value)
		 {
	        if($key == end($data['main']))
		    {
			   break;
			}
			switch($key)
			{
			   case ($key == 'channel_id' || $key == 'webhook_authtoken'):
			         if(isset($data['main'][$key]) && $value != NULL)
					 {
						$webhook = new Discord\Client(('https://discord.com/api/webhooks/' . $data['main']['channel_id'] . '/' . $data['main']['webhook_authtoken']));
                        $embed = new Discord\Embed();
					 }
					 else
					 {
						$execute = False;
					    throw new \Exception('[Discord-API]: There must be a valid Webhook ID');
					 }
					 break;
		       case 'bot_username':
			         if(isset($data['main'][$key]) && $value != NULL)
					 {
			            $webhook->username($value);
					 }
					 break;
		       case 'bot_avatar':
			         if(isset($data['main'][$key]) && $value != NULL)
					 {
						$webhook->avatar($value);
					 }
					 break;
		       case 'tts':
			         $webhook->tts(boolval(($value == 'True' || $value == 'true' || $value == 'TRUE' || $value == 1)));
					 break;
			}
		 }
	  }
	  else
	  {
         $execute = False;
		 throw new \Exception('[Discord-API]: There must be a valid `main` Configuration array set...');
	  }
	  if(isset($data['general']) && $data['general'] != NULL && is_array($data['general']))
	  {
	     foreach($data['general'] as $key => $value)
		 {
	        if($key == end($data['general']))
		    {
			   break;
			}
			switch($key)
			{
		       case 'description':
			         if($value != NULL)
					 {
			            $embed->description($value);
		                $embed_count++;
					 }
					 break;
		       case 'title':
			         if($value != NULL)
					 {
                        $embed->title($value);
		                $embed_count++;
					 }
					 break;
		       case 'color':
			         if($value != NULL)
					 {
						if(strcmp($value, 'auto') == False || strcmp($value, 'default') == False)
						{
						   $embed->color($embed->COLOR_['cyan']);
						}
						else
						{
						   $embed->color($value[0] == '#' ? hexdec(str_replace('#', '', $value)) : $value);
						}
		                $embed_count++;
					 }
					 break;
		       case 'thumbnail':
			         if($value != NULL)
					 {
                        $embed->thumbnail($value);
		                $embed_count++;
					 }
					 break;
			   case 'image':
			         if($value != NULL)
					 {
                        $embed->image($value);
		                $embed_count++;
					 }
					 break;
			   case 'timestamp':
			         if($value != NULL)
					 {
						if(strcmp($value, 'auto') == False || strcmp($value, 'default') == False)
						{
						   $embed->timestamp(date("Y-m-d\TH:i:s." .round(microtime(True) * 1000). "\Z"));
						}
						else
                        {
                           $embed->timestamp($value);
						}
						$embed_count++;
					 }
					 break;
		       case 'message':
					 if($value != NULL)
	  			     {
	     		        $webhook->message($value);
	     		     }
	     		     else
	     		     {
	        		   if($embed_count <= 0)
		    		   {
			   		      $execute = False;
		       		      throw new \Exception('[Discord-API]: There must be a valid `Message`, `Embed` Arguments...(it is possible to use both of them at the same time)');
		    		   }
	     		     }
					 break;
			}
		 }
	  }
	  if(isset($data['author']) && $data['author'] != NULL && is_array($data['author']))
	  {
         $embed->author($data['author']['name'], (isset($data['author']['url']) ? $data['author']['url'] : NULL), (isset($data['author']['avatar_url']) ? $data['author']['avatar_url'] : NULL));
		 $embed_count++;
	  }
	  if(isset($data['footer']) && $data['footer'] != NULL && is_array($data['footer']))
	  {
         $embed->footer($data['footer']['text'], (isset($data['footer']['image_url']) ? $data['footer']['image_url'] : NULL));
		 $embed_count++;
	  }
	  if(isset($data['fields']) && $data['fields'] != NULL && is_array($data['fields']) && count($data['fields']) >= 1)
	  {
         if(count($data['fields']) <= 25)
	     {
            for($f = 0; $f < count($data['fields']); $f++)
            {
               $embed->field($data['fields'][$f]['name'], $data['fields'][$f]['value'], (isset($data['fields'][$f]['inline']) ? boolval($data['fields'][$f]['inline']) : False));
            }
         }
	     else
       	 {
	        throw new \Exception('[Discord-API]: Discord\'s Embed Fields Limit exceeded: ' .count($data['fields']). '/25');
	     }
         $embed_count++;
      }
	  if($embed_count >= 1)
	  {
		 $webhook->embed($embed);
	  }
	  if($execute == True)
	  {
         $webhook->send();
      }
   }

   function FormatData($data, $footer = '') // Thanks alot to Pastebin Community for thier Code Embbeding Template.
   {
	  if(strlen($data) >= 1)
	  {
		 $_Stylesheets = "body { font-family: monospace; padding: 0; margin: 0; }div.embedPastebin { padding: 0; color: #000; margin: 0; font-family: monospace; background: #F7F7F7; border: 1px solid ddd; border-radius:3px; }html.embedPBBody div.embedPastebin { border: none; }div.embedPastebin div.embedFooter { background: #F7F7F7; color: #333; font-size: 100%; padding: 6px 12px; border-bottom: 1px solid #ddd; text-transform:uppercase; }div.embedPastebin div.embedFooter a, div.embedPastebin div.embedFooter a:visited { color: #336699; text-decoration:none; }div.embedPastebin div.embedFooter a:hover { color: red; }.noLines ol { list-style-type: none; padding-left: 0.5em; }.embedPastebin{background-color:#F8F8F8;border:1px solid #ddd;font-size:12px;overflow:auto;margin: 0 0 0 0;padding:0 0 0 0;line-height:21px;}.embedPastebin div { line-height:21px; font-family:Consolas, Menlo, Monaco, Lucida Console,'Bitstream Vera Sans Mono','Courier','monospace','Courier New';} ol { margin:0; padding: 0 0 0 55px} ol li { border:0; margin:0;padding:0; }.text  {color:#ACACAC;max-height:200px;overflow-y:scroll;}.text .imp {font-weight: bold; color: red;}.text .ln-xtra, .text li.ln-xtra, .text div.ln-xtra {background:#FFFF88;}.text span.xtra { display:block; }.text .ln {width:1px;text-align:right;margin:0;padding:0 2px;vertical-align:top;}";
		 $_Footer = (strlen($footer) >= 1 && $footer != NULL ? $footer : 'Sent JSON Data Preview');
		 $_Elements = "<div class=\"embedPastebin\"><div class=\"embedFooter\">" .$_Footer. "</div><ol class=\"text\">";
		 $_Output = explode('\n', $data);
		 for($l = 0; $l < count($_Output); $l++)
		 {
			$_Output[$l] = str_replace('\r', ' ', $_Output[$l]);
			$_Stylesheets .= 'li.ln-xtra .de' .$l. ' {background:#F8F8CE;}.text .de' .$l. ' {-moz-user-select: text;-khtml-user-select: text;-webkit-user-select: text;-ms-user-select: text;user-select: text;margin:0; padding: 0 8px; background:none; vertical-align:top;color:#000;border-left: 1px solid #ddd; margin: 0 0 0 -7px; position: relative; background: #ffffff;}.embedPastebin ol li.li' .$l. ' { margin: 0; }.text li, .text .li' .$l. ' {-moz-user-select: -moz-none;-khtml-user-select: none;-webkit-user-select: none;-ms-user-select: none;user-select: none;}';
			$_Elements .= '<li class="li' .$l. '"><div class="de' .$l. '">' .$_Output[$l]. '</div></li>';
		 }
		 $_Elements .= '</ol></div>';
         $_Output = '<style>' .$_Stylesheets. '</style>' .$_Elements;
	  }
	  else
	  {
	     $_Output = '<p>Invalid data Length</p>';
	  }
	  return $_Output;
   }

   if($Data = json_decode(file_get_contents("php://input"), True))
   {
	  switch (json_last_error())
	  {
		 case JSON_ERROR_NONE:
		    DS_SendBOTMessage($Data);
            /* Some kind of Code Debugging... */
			echo FormatData(json_encode($Data, JSON_PRETTY_PRINT), ('Data sent successfully in <b>' .((microtime(True) - $_START_TIME)*1000). ' ms</b>'));
			break;
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
	  if(isset($json_err))
	  {
	     throw new \Exception('[Discord-API]: The server returned an error while fetching the requested data: ' . $json_err);
	  }
   }
   else
   {
	  if(file_get_contents("php://input"))
	  {
         throw new \Exception('[Discord-API]: Invalid Data Type... (Valid Type: JSON)');
	  }
	  else
	  {
		 throw new \Exception('[Discord-API]: Data Parameter must be set. (with a valid type: JSON)');
	  }
   }
   /*
      @04-04-2018 10:39 PM
	  * it token 435.46104431152 ms = 0.43546104431152 s = 0.01 min to execute successfully...
   */
?>
