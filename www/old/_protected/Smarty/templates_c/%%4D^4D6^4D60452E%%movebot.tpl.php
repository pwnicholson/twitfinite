<?php /* Smarty version 2.6.18, created on 2011-02-15 22:22:36
         compiled from main/admin/movebot.tpl */ ?>
<div class="span-19 last">
	
	<form method="post" action="<?php echo $this->_tpl_vars['root']; ?>
admin/movebot">

	<div class="span-19 last">
		<?php if ($this->_tpl_vars['err']['bot']): ?><div class="span-19 last err"><?php echo $this->_tpl_vars['err']['bot']; ?>
</div><?php endif; ?>
		<div class="span-3">
			<label for="bot">Move Bot:</label>
		</div>
		<div class="span-16 last">
			<select name="bot" id="bot">
				<option value="0">---</option>
			<?php unset($this->_sections['a']);
$this->_sections['a']['name'] = 'a';
$this->_sections['a']['loop'] = is_array($_loop=$this->_tpl_vars['bots']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
				<option value="<?php echo $this->_tpl_vars['bots'][$this->_sections['a']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['bots'][$this->_sections['a']['index']]['twitter_screenname']; ?>
 &mdash; <?php echo $this->_tpl_vars['bots'][$this->_sections['a']['index']]['firstname']; ?>
 <?php echo $this->_tpl_vars['bots'][$this->_sections['a']['index']]['lastname']; ?>
 (<?php echo $this->_tpl_vars['bots'][$this->_sections['a']['index']]['username']; ?>
)</option>
			<?php endfor; endif; ?>
			</select>
		</div>
	</div>
	<div class="span-19 last">
		<?php if ($this->_tpl_vars['err']['user']): ?><div class="span-19 last err"><?php echo $this->_tpl_vars['err']['user']; ?>
</div><?php endif; ?>
		<div class="span-3">
			<label for="user">To Account:</label>
		</div>
		<div class="span-16 last">
			<select name="user" id="user">
				<option value="0">---</option>
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
				<option value="<?php echo $this->_tpl_vars['users'][$this->_sections['a']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['users'][$this->_sections['a']['index']]['firstname']; ?>
 <?php echo $this->_tpl_vars['users'][$this->_sections['a']['index']]['lastname']; ?>
 (<?php echo $this->_tpl_vars['users'][$this->_sections['a']['index']]['username']; ?>
)</option>
			<?php endfor; endif; ?>
			</select>
		</div>
	</div>
	
	<div class="span-19 last">
		<div class="span-3">&nbsp;</div>
		<div class="span-16 last">
			<input type="submit" name="submit1" id="submit1" value="Move Bot" />
		</div>
	</div>
	
	</form>
	
</div>