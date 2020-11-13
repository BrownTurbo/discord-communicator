<?php
   include dirname(__FILE__) . "../Utils/Client.php";
   include dirname(__FILE__) . "../Utils/Embed.php";

   $_START_TIME = microtime(True);
   function DS_SendBOTMessage($data = array())
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
			   case 'webhook_id':
			         if(isset($data['main'][$key]) && $value != NULL)
					 {
						$webhook = new Client(('https://discord.com/api/webhooks/' . $value));
                        $embed = new Embed();
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
						   if($value[0] == '#')
						   {
						      $embed->color(hexdec(str_replace('#', '', $value)));
						   }
						   else
						   {
							  $embed->color($value);
						   }
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
	  if(isset($data['fields']) && $data['fields'] != NULL && is_array($data['fields']))
	  {
         for($f = 0; $f < count($data['fields']); $f++)
         {
            if(count($data['fields']) >= 1)
            {
               $embed->field($data['fields'][$f]['name'], $data['fields'][$f]['value'], (isset($data['fields'][$f]['inline']) ? boolval($data['fields'][$f]['inline']) : False));
            }
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
   $Data = array(
         'main' => array(
		      'webhook_id'   =>   '418539901924147200/35JHEf2f5UOyM0-GoxdRKT_GT3NsAfbc1Y4YUSnEj3WvSvZwv2EF7cFC-Ow2kdI00p5h',
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
			  'message'   =>   'Hello, world! :alien:',
			  'timestamp'   =>   'default'
         ),
		 'author' => array(
              'name'   =>   '[BR]John_Magdy',
		      'url'   =>   'https://www.facebook.com/BR.Zoro',
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
   DS_SendBOTMessage($Data);
   /* Some kind of Code Debugging... */
   echo '<p><b>Sent JSON Data Preview:</b></p><pre style="background-color:#ccc;font-family:Courier New,Courier,monospace;margin:12px;padding:5px;max-height:200px;overflow-y:scroll">' .json_encode($Data, JSON_PRETTY_PRINT). '</pre>';
   echo '<b /><p style="text-align:center;">Data sent successfully in <b>' .((microtime(True) - $_START_TIME)*1000). ' ms (' .(((microtime(True) - $_START_TIME)*1000) / 1000). ' s)<b/></p>';
   /*
      @29-03-2018 3:18 PM
	  * it token 547.41787910461 ms = 0.54741787910461 s = 0.01 min to execute successfully...
   */
?>
