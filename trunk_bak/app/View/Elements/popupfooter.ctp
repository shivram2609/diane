<?php echo $this->Html->script(array('jquery.1.8.2','jquery.validate','validationmessages','functionality','jquery.form')); ?>
<?php if ($this->Session->read("FB.Me.id") || $this->params['action'] == 'login' || $this->params['action'] == 'signup'  ) { ?>
<?php echo $this->Facebook->init(); ?> 
<?php } ?>
