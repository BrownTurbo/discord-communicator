<?php
/*$Bookmars = array(
   'https://discord.com/api/guilds/635473329129521152/widget.json',
   'https://discord.com/api/servers/635473329129521152/embed.json',
   'https://discord.com/api/v6/invite/u4YUjeVXZT?with_counts=true',
   'https://discord.com/api/v6/users/284447705101631489/profile',
   'https://discord.com/api/v6/users/@me/devices',
   'https://discord.com/api/v6/channels/352358201825427456/messages',
   'https://discord.com/api/v6/guilds/635473329129521152/members/272141618474385409',
   'https://discord.com/api/users/@me/guilds',
   'https://discord.com/api/guilds/635473329129521152/channels',
   'https://discord.com/api/users/@me',
   'https://discord.com/api/users/@me/connections',
   'https://discord.com/api/users/@me/email',
   'https://discord.com/api/users/@me',
   'https://discord.com/api/channels/352358201825427456/messages',
   'https://discord.com/api/v6/users/@me/guilds',
   'https://discord.com/api/guilds/635473329129521152/members'
);
$ch = curl_init();
$f = fopen('request.txt', 'w+');
curl_setopt_array($ch, array(
    CURLOPT_URL            => $Bookmars[$_GET['id']],
    CURLOPT_HTTPHEADER     => array('Authorization: Mzk4MjMxODg2OTczMTA4MjI1.DS-CXQ.0hI03oTa1_nZxKADNpq77K98Bfk'),
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_FOLLOWLOCATION => 1,
    CURLOPT_VERBOSE        => 1,
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_STDERR         => $f,
    CURLOPT_HTTP_VERSION => (explode('HTTP/', $_SERVER['SERVER_PROTOCOL'])[1] === 1.1 ? CURL_HTTP_VERSION_1_1 : CURL_HTTP_VERSION_1_0),
	CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT']
));
$response = curl_exec($ch);
echo curl_getinfo($ch)['url'];
fwrite($f, ('[' .curl_getinfo($ch)['url']. ']: ' .$response. '\r\n'));
fclose($f); curl_close($ch);
*/
// https://canary.discord.com/api/webhooks/776673586660245584/PNijTpmIh2LLXYmKrbtJ15WoBuqwCCYmzFq2b7fcIAVJw7dCpSMeWpurmX5ni_wDF53E
// https://canary.discord.com/api/guilds/635473329129521152/widget.json
// https://discord.gg/u4YUjeVXZT
// BOT Client ID: 398231886973108225
// BOT Client Secret: hn_a0Qff79yIn49SPHBa64qzMQh2ml5y

include dirname(__FILE__) . "/Utils/GuildHandler.php";
$GuildHandler = new Discord\Guild($_GET['srvid']);
$guild = $GuildHandler->Raw['guild'];
$data = $GuildHandler->Raw['data'];

echo '<pre style="background-color:#ccc;font-family:Courier New,Courier,monospace;margin:12px;padding:5px;max-height:200px;overflow-y:scroll">
Guild Name: ' .$guild["name"]. ' or ' .$data["guild"]["name"]. '<br/>
Guild Members: ' .$data["approximate_presence_count"]. '/' .$data["approximate_member_count"]. '<br/>
Guild Invite Link: ' .$GuildHandler->RetriveInviteCode(False). '<br />
Guild Icon URL: ' .$GuildHandler->RetriveServerIconURL(). '<br />
Guild ID: ' .$GuildHandler->Raw['data']['guild']['id']. '<br />
Inviter: "Name" = ' .$GuildHandler->RetriveInviter(NULL, NULL, False)['name']. ' "Icon URL" = ' .$GuildHandler->RetriveInviter(NULL, NULL, False)['icon_url']. '<br />
Inviter(by inv-code): "Name" = ' .$GuildHandler->RetriveInviter('png', 'u4YUjeVXZT', False)['name']. ' "Icon URL" = ' .$GuildHandler->RetriveInviter('png', 'u4YUjeVXZT', False)['icon_url']. '</pre>';

?>
