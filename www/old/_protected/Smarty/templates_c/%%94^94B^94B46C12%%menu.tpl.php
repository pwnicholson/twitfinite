<?php /* Smarty version 2.6.18, created on 2010-09-19 00:51:15
         compiled from main/bot/menu.tpl */ ?>
<script language="javascript">
var bot_id = <?php echo $this->_tpl_vars['bot_id']; ?>
;
</script>

<div class="span-19 last">
<div id="navcontainer-hor">
<ul>
<li><a <?php if ($this->_tpl_vars['url'][0] == 'bot' && ! $this->_tpl_vars['url'][2]): ?>class="current"<?php endif; ?> href="<?php echo $this->_tpl_vars['root']; ?>
bot/<?php echo $this->_tpl_vars['bot_id']; ?>
">Summary</a></li>
<li><a <?php if ($this->_tpl_vars['url'][0] == 'bot' && $this->_tpl_vars['url'][2] == 'edit'): ?>class="current"<?php endif; ?> href="<?php echo $this->_tpl_vars['root']; ?>
bot/<?php echo $this->_tpl_vars['bot_id']; ?>
/edit">Edit Bot/Features</a></li>
<li><a <?php if ($this->_tpl_vars['url'][0] == 'bot' && $this->_tpl_vars['url'][2] == 'userlists'): ?>class="current"<?php endif; ?> href="<?php echo $this->_tpl_vars['root']; ?>
bot/<?php echo $this->_tpl_vars['bot_id']; ?>
/userlists">User Lists</a></li>
<li><a <?php if ($this->_tpl_vars['url'][0] == 'bot' && $this->_tpl_vars['url'][2] == 'statistics'): ?>class="current"<?php endif; ?> href="<?php echo $this->_tpl_vars['root']; ?>
bot/<?php echo $this->_tpl_vars['bot_id']; ?>
/statistics">Statistics</a></li>
</ul>
</div>
</div>