<?php

/**
 * Client generates the payload and sends the webhook payload to Discord
 */

namespace Discord;
class Client
{
  protected $Client = array();

  public function __construct($url)
  {
    $this->Client['url'] = $url;
  }

  public function tts($tts) {
    $this->Client['tts'] = $tts;
    return $this;
  }

  public function username($username)
  {
    $this->Client['username'] = $username;
    return $this;
  }

  public function avatar($new_avatar)
  {
    $this->Client['avatar'] = $new_avatar;
    return $this;
  }

  public function message($new_message)
  {
    $this->Client['message'] = $new_message;
    return $this;
  }

  public function embed($embed) {
    $this->Client['embeds'][] = $embed->toArray();
    return $this;
  }

  public function send()
  {
	$allowed_errorcodes = array(200, 201, 202, 204);
    $payload = json_encode(array(
      'username' => $this->Client['username'],
      'avatar_url' => $this->Client['avatar'],
      'content' => $this->Client['message'],
      'embeds' => $this->Client['embeds'],
      'tts' => $this->Client['tts']
    ));

    $ch = curl_init($this->Client['url']);
    curl_setopt_array($ch, array(
                CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_CONNECTTIMEOUT => 10,
				CURLOPT_CONNECTTIMEOUT_MS => 1500,
				CURLOPT_FORBID_REUSE => 1,
				CURLOPT_FRESH_CONNECT => 1,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_POSTFIELDS => $payload,
				CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Content-Length: ' . strlen($payload)],
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

    curl_close($ch);
    return $this;
  }
}
 ?>
