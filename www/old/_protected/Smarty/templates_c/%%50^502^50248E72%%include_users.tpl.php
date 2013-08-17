<?php /* Smarty version 2.6.18, created on 2010-10-31 23:14:06
         compiled from main/ajax/bot/include_users.tpl */ ?>
<select name="include_users" id="include_users" multiple="true" size="5" style="width: 13em;">
<?php unset($this->_sections['a']);
$this->_sections['a']['name'] = 'a';
$this->_sections['a']['loop'] = is_array($_loop=$this->_tpl_vars['include_users']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
	<option value="<?php echo $this->_tpl_vars['include_users'][$this->_sections['a']['index']]['twitter_screenname']; ?>
"><?php echo $this->_tpl_vars['include_users'][$this->_sections['a']['index']]['twitter_screenname']; ?>
</option>
<?php endfor; endif; ?>
</select>
<?php if ($this->_tpl_vars['include_users']): ?>
<input type="button" id="include_remove_user" name="include_remove_user" value="Remove Selected" onclick="RemoveIncludeUsers(); return false" />
<?php endif; ?>