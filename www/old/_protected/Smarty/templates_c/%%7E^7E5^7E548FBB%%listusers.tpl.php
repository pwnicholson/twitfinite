<?php /* Smarty version 2.6.18, created on 2012-06-04 22:59:04
         compiled from main/admin/listusers.tpl */ ?>
<div class="span-19 last">

	<div class="span-19 last">
		<div class="span-4 b">Full Name</div>
		<div class="span-3 b">Username</div>
		<div class="span-12 b last"># Bots</div>
	</div>
	
	<?php unset($this->_sections['a']);
$this->_sections['a']['name'] = 'a';
$this->_sections['a']['loop'] = is_array($_loop=$this->_tpl_vars['users']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
retweet/account/<?php echo $this->_tpl_vars['users'][$this->_sections['a']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['users'][$this->_sections['a']['index']]['firstname']; ?>
 <?php echo $this->_tpl_vars['users'][$this->_sections['a']['index']]['lastname']; ?>
</a></div>
		<div class="span-3"><a href="<?php echo $this->_tpl_vars['root']; ?>
retweet/account/<?php echo $this->_tpl_vars['users'][$this->_sections['a']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['users'][$this->_sections['a']['index']]['username']; ?>
</a></div>
		<div class="span-12 last"><?php echo $this->_tpl_vars['users'][$this->_sections['a']['index']]['bot_count']; ?>
</div>
	</div>
	<?php endfor; endif; ?>

</div>