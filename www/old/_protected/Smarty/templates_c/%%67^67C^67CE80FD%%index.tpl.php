<?php /* Smarty version 2.6.18, created on 2010-09-19 00:51:10
         compiled from main/retweet/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'main/retweet/index.tpl', 14, false),)), $this); ?>

<div class="container">
	<div class="span-19 last">
		<div class="span-4 b">Bot Name</div>
		<div class="span-3 b">Updates</div>
		<div class="span-3 b">Tweeters</div>
		<div class="span-3 b">Friends</div>
		<div class="span-3 b">Followers</div>
		<div class="span-3 b last">&nbsp;</div>
	</div>
<?php unset($this->_sections['a']);
$this->_sections['a']['name'] = 'a';
$this->_sections['a']['loop'] = is_array($_loop=$this->_tpl_vars['groups']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['a']['show'] = true;
$this->_sections['a']['max'] = $this->_sections['a']['loop'];
$this->_sections['a']['step'] = 1;
$this->_sections['a']['start'] = $this->_sections['a']['step'] > 0 ? 0 : $this->_sections['a']['loop']-1;
if ($this->_sections['a']['show']) {
    $this->_sections['a']['total'] = $this->_sections['a']['loop'];
    if ($this->_sections['a']['total'] == 0)
        $this->_sections['a']['show'] = false;
} else
    $this->_sections['a']['total'] = 0;
if ($this->_sections['a']['show']):

            for ($this->_sections['a']['index'] = $this->_sections['a']['start'], $this->_sections['a']['iteration'] = 1;
                 $this->_sections['a']['iteration'] <= $this->_sections['a']['total'];
                 $this->_sections['a']['index'] += $this->_sections['a']['step'], $this->_sections['a']['iteration']++):
$this->_sections['a']['rownum'] = $this->_sections['a']['iteration'];
$this->_sections['a']['index_prev'] = $this->_sections['a']['index'] - $this->_sections['a']['step'];
$this->_sections['a']['index_next'] = $this->_sections['a']['index'] + $this->_sections['a']['step'];
$this->_sections['a']['first']      = ($this->_sections['a']['iteration'] == 1);
$this->_sections['a']['last']       = ($this->_sections['a']['iteration'] == $this->_sections['a']['total']);
?>
	<div class="span-19 last">
		<div class="span-4"><a href="<?php echo $this->_tpl_vars['root']; ?>
bot/<?php echo $this->_tpl_vars['groups'][$this->_sections['a']['index']]['group_id']; ?>
"><?php echo $this->_tpl_vars['groups'][$this->_sections['a']['index']]['twitter_screenname']; ?>
</a></div>
		<div class="span-3"><?php echo ((is_array($_tmp=@$this->_tpl_vars['groups'][$this->_sections['a']['index']]['statuses_count'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</div>
		<div class="span-3"><?php echo ((is_array($_tmp=@$this->_tpl_vars['groups'][$this->_sections['a']['index']]['screenname_count'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</div>
		<div class="span-3"><?php echo ((is_array($_tmp=@$this->_tpl_vars['groups'][$this->_sections['a']['index']]['friends_count'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</div>
		<div class="span-3"><?php echo ((is_array($_tmp=@$this->_tpl_vars['groups'][$this->_sections['a']['index']]['followers_count'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</div>
		<div class="span-3 last">&nbsp;</div>
	</div>
<?php endfor; else: ?>
		<div class="span-19 last"><i>No bots!</i></div>
<?php endif; ?>
	<div class="span-19 last">&nbsp;</div>
	<div class="span-19 last"><a href="<?php echo $this->_tpl_vars['root']; ?>
bot/add">+ New Bot</a></div>
</div>