<?php 
echo $this->Html->script("jquery.1.7.2");
echo $this->Html->script("jquery.validate");
echo $this->Html->script("validationmessages");
echo $this->Html->script("common_functions");
echo $this->Html->script("admin/validate");
?>
<?php
echo $this->Html->link("Home","/admin/dashboard");
?>
&nbsp; | &nbsp;
<?
echo $this->Html->link("Logout","/admin/logout");
?>
&nbsp; | &nbsp;
<?
echo $this->Html->link("Change Password","/admin/changepassword");
?>
