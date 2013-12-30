<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Title:新浪博客编辑器PHP版封装类
* coder:gently
* Date:2007年11月9日
* Power by ZendStudio.Net
* [url=http://www.zendstudio.net/]http://www.zendstudio.net/[/url]
* 您可以任意使用和传播，但请保留本段信息！
* 2009-03-11 流星雨修改
*/
class Sinaeditor {
 
public $basePath;
public $width;
public $height;
public $eName;
public $value;
public $autoSave;
 
function __construct($name) {
  $this->eName = $name['name']; //原帖中这块有问题
  $this->basePath = base_url(); //主要是更改这段了
  $this->autoSave = false;
  $this->height = 460;
  $this->width = 630;
}
function create() {
  $ReadCookie=$this->autoSave?1:0;
  $info = "<textarea name=\"{$this->eName}\" id=\"{$this->eName}\" 
style=\"display:none;\">{$this->value}</textarea>" . 
        "<IFRAME src=\"{$this->basePath}/Edit/editor.html?id={$this->eName}&ReadCookie={$ReadCookie}\" 
frameBorder=\"0\" marginHeight=\"0\" marginWidth=\"0\" scrolling=\"No\" width=\"{$this->width}\" 
height=\"{$this->height}\"></IFRAME>"; //好长的一段字符,大家将就看吧.
  return $info; 
//这块是返回信息，我总觉得，在类中调中print 和 echo 太霸道了.
//所以更改了一下.变成反回值.类中直接使出也不适合MVC嘛
}
}
/* End of file sinaEditor.php */
 