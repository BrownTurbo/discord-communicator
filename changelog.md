# v4.0.0

* Removed Data Preview page parameter from the Lib's cURL Module.
* Updated the `Sent Data Preview`'s Embedded Template. (Thanks to @Pastebin for thier Original Embedded Code template, forked by me.)
* Created a simple Discord Server's Widget Generator Module. (it is mainly runniny by Server ID, Thanks to @Discord for thier Original Widget template, forked by me.)

Screenshots:
![](https://github.com/JohnMagdy/discord-communicator/blob/master/widget-result.JPG)

Usage(Widget Generator):
```
   include dirname(__FILE__) . "/GuildHandler.php";
   $GuildHandler = new Discord\Guild($_GET['id']);
   $guild = $GuildHandler->Raw['guild'];
   $data = $GuildHandler->Raw['data'];

   echo '<pre style="background-color:#ccc;font-family:Courier New,Courier,monospace;margin:12px;padding:5px;max-height:200px;overflow-y:scroll">
            Guild Name: ' .$guild["name"]. ' or ' .$data["guild"]["name"]. '<br/>
            Guild Members: ' .$data["approximate_presence_count"]. '/' .$data["approximate_member_count"]. '<br/>
            Guild Invite Link: ' .$GuildHandler->RetriveInviteCode(False). '<br />
            Guild Icon URL: ' .$GuildHandler->RetriveServerIconURL(). '<br />
            Guild ID: ' .$GuildHandler->Raw['data']['guild']['id']. '<br />
            Inviter: "Name" = ' .$GuildHandler->RetriveInviter()['name']. ' "Icon URL" = ' .$GuildHandler->RetriveInviter()['icon_url']. '<br />
            Inviter(by inv-code): "Name" = ' .$GuildHandler->RetriveInviter('png', '4Y23mKU')['name']. ' "Icon URL" = ' .$GuildHandler->RetriveInviter('png', '4Y23mKU')['icon_url].
   '</pre>';
```
- For more Information feel free to check the example file: https://github.com/JohnMagdy/discord-communicator/blob/master/widget.php