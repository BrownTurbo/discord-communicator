<?php

/**
 * Embed is an embed object to be included in a webhook message
 */

namespace Discord; 
class Embed
{
  protected $Embed = array('type' => 'rich');
  public $COLOR_ = array(
      'default'   =>   0,
      'aqua'   =>   1752220,
      'green'   =>   3066993,
      'blue'   =>   3447003,
      'purple'   =>   10181046,
      'gold'   =>   15844367,
      'orange'   =>   15105570,
      'red'   =>   15158332,
      'grey'   =>   9807270,
      'navy'   =>   3426654,
	  'cyan'   =>   1277892,
	  'brown'   =>   11356937,
	  'dark_navy'   =>   2899536,
      'dark_grey'   =>   9936031,	  
      'dark_aqua'   =>   1146986,
      'dark_green'   =>   2067276,
      'dark_blue'   =>   2123412,
      'dark_purple'   =>   7419530,
      'dark_gold'   =>   12745742,
      'dark_orange'   =>   11027200,
      'dark_red'   =>   10038562,
      'light_grey'   =>   12370112
  );
  
  public function title($title, $url = '') {
    $this->Embed['title'] = $title;
    $this->Embed['url'] = $url;

    return $this;
  }

  public function description($description) {
    $this->Embed['description'] = $description;

    return $this;
  }

  public function timestamp($timestamp) {
    $this->Embed['timestamp'] = $timestamp; // \DateTime::createFromFormat('YYYY-MM-DDTHH:MM:SS.MSSZ', $timestamp)

    return $this;
  }

  public function color($color) {
    $this->Embed['color'] = $color;

    return $this;
  }

  public function url($url) {
    $this->Embed['url'] = $url;

    return $this;
  }

  public function footer($text, $icon_url = '')
  {
    $this->Embed['footer'] = [
      'text' => $text,
      'icon_url' => $icon_url,
    ];
    return $this;
  }

  public function image($url)
  {
    $this->Embed['image'] = [
      'url' => $url,
    ];
    return $this;
  }

  public function thumbnail($url)
  {
    $this->Embed['thumbnail'] = [
      'url' => $url,
    ];
    return $this;
  }

  public function author($name, $url = '', $icon_url = '')
  {
    $this->Embed['author'] = [
      'name' => $name,
      'url' => $url,
      'icon_url' => $icon_url,
    ];
    return $this;
  }

  public function field($name, $value, $inline = True)
  {
    $this->Embed['fields'][] = [
      'name' => $name,
      'value' => $value,
      'inline' => boolval($inline),
    ];
    return $this;
  }
  
  public function toArray()
  {
    return [
      'title' => $this->Embed['title'],
      'type' => $this->Embed['type'],
      'description' => $this->Embed['description'],
      'url' => $this->Embed['url'],
      'color' => $this->Embed['color'],
      'footer' => $this->Embed['footer'],
      'image' => $this->Embed['image'],
      'thumbnail' => $this->Embed['thumbnail'],
	  'timestamp' => $this->Embed['timestamp'],
      'author' => $this->Embed['author'],
      'fields' => $this->Embed['fields'],
    ];
  }
}
?>