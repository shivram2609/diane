<aside class="left-container">
<div class="left-bar">
	<h2>Messages</h2>
	<ul>
		<li class="<?php echo (($this->params['controller'] == 'messages' && $this->params['action'] == 'composemessage') || isset($trashstatus)) ? 'selected':''; ?>"><a href="<?php echo $this->Html->url("/compose"); ?>" title="Inbox">Compose</a></li>
		<li class="<?php echo (($this->params['controller'] == 'messages' && $this->params['action'] == 'inbox') || isset($trashstatus)) ? 'selected':''; ?>"><a href="<?php echo $this->Html->url("/inbox"); ?>" title="Inbox">Inbox</a></li>
		<li class="<?php echo (($this->params['controller'] == 'messages' && $this->params['action'] == 'sentmessage') || isset($trashstatus)) ? 'selected':''; ?>"><a href="<?php echo $this->Html->url("/sent-message"); ?>" title="Sent">Sent</a></li>
		<li class="<?php echo (($this->params['controller'] == 'messages' && $this->params['action'] == 'trashmessage')|| isset($removestatus)) ? 'selected':''; ?>"><a href="<?php echo $this->Html->url("/trash"); ?>" title="Trash">Trash</a></li>
	</ul>
	</div>
</aside>
