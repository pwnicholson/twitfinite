<?php /* Smarty version 2.6.18, created on 2010-09-19 17:44:33
         compiled from main/home/directory.tpl */ ?>
<div class="span-19 last">
	<div class="span-19 last">
		Here is the current directory listing of all bots powered by ReTweetBot.com.  Feel free to peruse the bots
		and see if there are any that you might find interesting.
	</div>
	
	<div class="span-19 last"><br/></div>

	<?php unset($this->_sections['a']);
$this->_sections['a']['name'] = 'a';
$this->_sections['a']['loop'] = is_array($_loop=$this->_tpl_vars['directory']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		<div class="span-19 last"><h2><a href="http://twitter.com/<?php echo $this->_tpl_vars['directory'][$this->_sections['a']['index']]['twitter_screenname']; ?>
" target="_blank">@<?php echo $this->_tpl_vars['directory'][$this->_sections['a']['index']]['twitter_screenname']; ?>
</a></h2></div>
		<div class="span-19 last">
		<?php if ($this->_tpl_vars['directory'][$this->_sections['a']['index']]['descr']): ?>
			<?php echo $this->_tpl_vars['directory'][$this->_sections['a']['index']]['descr']; ?>

		<?php else: ?>
			There is no description for this bot.
		<?php endif; ?>
		</div>
		<div class="span-19 last"><br/><br/></div>
	</div>
	<?php endfor; else: ?>
	<div class="span-19 last i">None</div>
	<?php endif; ?>
</div>