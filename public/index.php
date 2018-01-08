<?php

interface MessageComposer {
  public function setFrom($_from);
  public function setTo($_to);
  public function setBody($_message);
}

class Message implements MessageComposer {

  private $to;
  private $from;
  private $body;

  /*setters start*/

  public function setTo($_to)
  {
    $this->to = $_to;
  }

  public function setFrom($_from)
  {
    $this->from = $_from;
  }

  public function setBody($_body)
  {
    $this->body = $_body;
  }
  /*setters end*/

  /*getters start*/
  public function getTo()
  {
    return isset($this->to) ? $this->to : 'default_to@mail.ru';
  }

  public function getFrom()
  {
    return isset($this->from) ? $this->from : 'default_from@mail.ru';
  }

  public function getBody()
  {
    return $this->body;
  }

  /*getters end*/

}

class Mail {

  public static function html($msg, $callback = null )
  {
    $message = new Message;
    $message->setBody($msg);
    if($callback) {
      $callback($message);
    }
    echo "SENDING MESSAGE FROM {$message->getFrom()} TO {$message->getTo()} <br>
    MESSAGE IS {$message->getBody()}<br>
    message body is TEXT/HTML";
  }

  public static function raw($msg, $callback = null)
  {
    $message = new Message;
    $message->setBody($msg);
    if($callback) {
      $callback($message);
    }
    $body = htmlentities($message->getBody());
    echo "SENDING MESSAGE FROM {$message->getFrom()} TO {$message->getTo()} <br>
    MESSAGE IS {$body}<br>
    message body is PLAIN/HTML";
  }
}

$x = 'I am global var from different tesaneliutyan tiruyt';


Mail::html('<b>HEllo with html</b> qez', function($m) use ($x) {
    $m->setTo('changed@mail.com');
    echo $x;
});
echo "<br><br><br>";
Mail::raw('<b>HEllo without html</b> qez');
